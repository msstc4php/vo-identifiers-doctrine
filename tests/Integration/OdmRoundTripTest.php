<?php

declare(strict_types=1);

namespace MSSTC4PHP\ValueObject\Identifiers\Doctrine\Tests\Integration;

use Doctrine\ODM\MongoDB\Configuration;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Mapping\Driver\AttributeDriver;
use MongoDB\Client;
use MongoDB\Driver\Exception\Exception as MongoException;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Odm\CasRegistryNumberType;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Odm\DataIdentifierStringType;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Odm\DoiType;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Odm\ImeiType;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Odm\TypeRegistrar;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Tests\Support\Odm\Item;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Tests\Support\Samples;
use MSSTC4PHP\ValueObject\Identifiers\Publication\Doi;
use MSSTC4PHP\ValueObject\Identifiers\Substance\CasRegistryNumber;
use MSSTC4PHP\ValueObject\Identifiers\Telecom\Imei;
use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(DataIdentifierStringType::class)]
#[CoversClass(CasRegistryNumberType::class)]
#[CoversClass(ImeiType::class)]
#[CoversClass(DoiType::class)]
#[UsesClass(TypeRegistrar::class)]
final class OdmRoundTripTest extends TestCase
{
    private const string DATABASE = 'vo_identifiers_doctrine_test';

    private DocumentManager $documentManager;

    private Client $client;

    private bool $connected = false;

    #[Override]
    protected function setUp(): void
    {
        $uri = \getenv('MONGODB_URI');
        $server = $uri !== false && $uri !== '' ? $uri : 'mongodb://127.0.0.1:27017';
        $this->client = new Client($server, ['serverSelectionTimeoutMS' => 1000]);

        try {
            $this->client->selectDatabase('admin')->command(['ping' => 1]);
        } catch (MongoException) {
            self::markTestSkipped('MongoDB is not reachable; set MONGODB_URI to run the ODM integration test.');
        }

        $this->connected = true;
        TypeRegistrar::registerAll();
        $this->client->dropDatabase(self::DATABASE);

        $config = new Configuration();
        $config->setDefaultDB(self::DATABASE);
        $config->setMetadataDriverImpl(new AttributeDriver([__DIR__ . '/../Support/Odm']));
        $config->setProxyDir(\sys_get_temp_dir() . '/id-proxies');
        $config->setProxyNamespace('IdProxies');
        $config->setHydratorDir(\sys_get_temp_dir() . '/id-hydrators');
        $config->setHydratorNamespace('IdHydrators');
        $config->setAutoGenerateProxyClasses(Configuration::AUTOGENERATE_EVAL);
        $config->setAutoGenerateHydratorClasses(Configuration::AUTOGENERATE_EVAL);

        $this->documentManager = DocumentManager::create($this->client, $config);
    }

    #[Override]
    protected function tearDown(): void
    {
        if ($this->connected) {
            $this->client->dropDatabase(self::DATABASE);
        }
    }

    public function testMh1082EnvelopeWithControlCharactersSurvivesAFlushAndReload(): void
    {
        $envelope = Samples::mh1082Envelope();
        $this->documentManager->persist(new Item($envelope));
        $this->documentManager->flush();
        $this->documentManager->clear();

        $item = $this->documentManager->getRepository(Item::class)->findOneBy([]);
        $raw = $this->client->selectCollection(self::DATABASE, 'item')->findOne([], ['typeMap' => ['root' => 'array', 'document' => 'array']]);

        self::assertIsArray($raw);
        self::assertSame((string) $envelope, $raw['label']);
        self::assertInstanceOf(Item::class, $item);
        self::assertTrue($envelope->equals($item->label));
        self::assertCount(3, $item->label->fields());
        self::assertNull($item->substance);
    }

    public function testHyphenatedCasNumberImeiAndUnicodeDoiAreStoredCanonically(): void
    {
        $doi = Doi::from('10.1000/ünï-文字');
        $this->documentManager->persist(new Item(
            Samples::mh1082Envelope(),
            CasRegistryNumber::from('7732185'),
            Imei::from('49 015420 323751'),
            $doi,
        ));
        $this->documentManager->flush();
        $this->documentManager->clear();

        $raw = $this->client->selectCollection(self::DATABASE, 'item')->findOne([], ['typeMap' => ['root' => 'array', 'document' => 'array']]);
        $item = $this->documentManager->getRepository(Item::class)->findOneBy([]);

        self::assertIsArray($raw);
        self::assertSame('7732-18-5', $raw['substance']);
        self::assertSame('49015420323751', $raw['device']);
        self::assertSame('10.1000/ünï-文字', $raw['paper']);
        self::assertInstanceOf(Item::class, $item);
        self::assertSame('7732-18-5', (string) $item->substance);
        self::assertSame('49015420323751', (string) $item->device);
        self::assertNotNull($item->paper);
        self::assertTrue($doi->equals($item->paper));
        self::assertSame('ünï-文字', $item->paper->suffix());
    }
}
