<?php

declare(strict_types=1);

namespace MSSTC4PHP\ValueObject\Identifiers\Doctrine\Tests\Integration;

use Composer\InstalledVersions;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AttributeDriver;
use Doctrine\ORM\Tools\SchemaTool;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Orm\CasRegistryNumberType;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Orm\DataIdentifierStringType;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Orm\DoiType;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Orm\ImeiType;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Orm\TypeRegistrar;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Tests\Support\Orm\Item;
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
final class OrmRoundTripTest extends TestCase
{
    private Connection $connection;

    private EntityManager $entityManager;

    #[Override]
    protected function setUp(): void
    {
        TypeRegistrar::registerAll();

        $this->connection = DriverManager::getConnection(['driver' => 'pdo_sqlite', 'memory' => true]);
        $config = new Configuration();
        $config->setMetadataDriverImpl(new AttributeDriver([__DIR__ . '/../Support/Orm']));
        $config->setProxyDir(\sys_get_temp_dir() . '/id-proxies');
        $config->setProxyNamespace('IdProxies');
        // ORM 3.3 (the lowest supported) has no native lazy objects and falls back to its own proxies.
        if (\version_compare(InstalledVersions::getVersion('doctrine/orm') ?? '0', '3.4.0', '>=')) {
            $config->enableNativeLazyObjects(true);
        }

        $this->entityManager = new EntityManager($this->connection, $config);
        new SchemaTool($this->entityManager)->createSchema([$this->entityManager->getClassMetadata(Item::class)]);
    }

    public function testSchemaDeclaresTheColumnLengthsOfTheClasses(): void
    {
        $sql = \implode("\n", new SchemaTool($this->entityManager)->getCreateSchemaSql(
            [$this->entityManager->getClassMetadata(Item::class)],
        ));

        self::assertStringContainsString('label CLOB NOT NULL', $sql);
        self::assertStringContainsString('substance VARCHAR(12) DEFAULT NULL', $sql);
        self::assertStringContainsString('device VARCHAR(15) DEFAULT NULL', $sql);
        self::assertStringContainsString('paper CLOB DEFAULT NULL', $sql);
    }

    public function testMh1082EnvelopeWithControlCharactersSurvivesAFlushAndReload(): void
    {
        $envelope = Samples::mh1082Envelope();
        $this->entityManager->persist(new Item($envelope));
        $this->entityManager->flush();
        $this->entityManager->clear();

        $item = $this->entityManager->getRepository(Item::class)->findOneBy([]);

        $stored = $this->connection->fetchOne('SELECT label FROM item');
        self::assertIsString($stored);
        self::assertSame((string) $envelope, $stored);
        self::assertStringContainsString("\x1E", $stored);
        self::assertStringContainsString("\x1D", $stored);
        self::assertStringContainsString("\x04", $stored);
        self::assertInstanceOf(Item::class, $item);
        self::assertTrue($envelope->equals($item->label));
        self::assertCount(3, $item->label->fields());
        self::assertNull($item->substance);
    }

    public function testHyphenatedCasNumberImeiAndUnicodeDoiAreStoredCanonically(): void
    {
        $doi = Doi::from('10.1000/ünï-文字');
        $this->entityManager->persist(new Item(
            Samples::mh1082Envelope(),
            CasRegistryNumber::from('7732185'),
            Imei::from('49 015420 323751'),
            $doi,
        ));
        $this->entityManager->flush();
        $this->entityManager->clear();

        $row = $this->connection->fetchAssociative('SELECT substance, device, paper FROM item');
        $item = $this->entityManager->getRepository(Item::class)->findOneBy([]);

        self::assertSame(['substance' => '7732-18-5', 'device' => '49015420323751', 'paper' => '10.1000/ünï-文字'], $row);
        self::assertInstanceOf(Item::class, $item);
        self::assertSame('7732-18-5', (string) $item->substance);
        self::assertSame('49015420323751', (string) $item->device);
        self::assertNotNull($item->paper);
        self::assertTrue($doi->equals($item->paper));
        self::assertSame('ünï-文字', $item->paper->suffix());
    }
}
