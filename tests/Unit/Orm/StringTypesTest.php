<?php

declare(strict_types=1);

namespace MSSTC4PHP\ValueObject\Identifiers\Doctrine\Tests\Unit\Orm;

use Doctrine\DBAL\Platforms\SQLitePlatform;
use Doctrine\DBAL\Types\Type;
use InvalidArgumentException;
use MSSTC4PHP\ValueObject\Contract\StringConvertible;
use MSSTC4PHP\ValueObject\Exception\InvalidValueObjectException;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Orm\AirWaybillNumberType;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Orm\ArkType;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Orm\CasRegistryNumberType;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Orm\ContainerNumberType;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Orm\DataIdentifierFieldType;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Orm\DataIdentifierStringType;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Orm\DoiType;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Orm\EcNumberType;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Orm\EidType;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Orm\EnergyIdentificationCodeType;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Orm\HsCodeType;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Orm\IataAirportCodeType;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Orm\IcaoAirportCodeType;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Orm\IccidType;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Orm\ImeisvType;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Orm\ImeiType;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Orm\ImoNumberType;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Orm\ImsiType;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Orm\IsanType;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Orm\IsbnType;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Orm\IsmnType;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Orm\IsniType;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Orm\Iso15459IdentifierType;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Orm\IsrcType;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Orm\IssnType;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Orm\IswcType;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Orm\MmsiType;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Orm\MpanType;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Orm\OrcidType;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Orm\RorType;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Orm\S10ItemIdentifierType;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Orm\TariffCodeType;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Orm\TypeRegistrar;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Orm\UicVehicleNumberType;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Orm\UnLocodeType;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Orm\UnNumberType;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Orm\VinType;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Orm\WmiType;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Tests\Support\Samples;
use MSSTC4PHP\ValueObject\Identifiers\Publication\Isbn;
use MSSTC4PHP\ValueObject\Identifiers\Transport\Mmsi;
use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionMethod;

#[CoversClass(ArkType::class)]
#[CoversClass(DoiType::class)]
#[CoversClass(IsanType::class)]
#[CoversClass(IsbnType::class)]
#[CoversClass(IsmnType::class)]
#[CoversClass(IsniType::class)]
#[CoversClass(IsrcType::class)]
#[CoversClass(IssnType::class)]
#[CoversClass(IswcType::class)]
#[CoversClass(OrcidType::class)]
#[CoversClass(RorType::class)]
#[CoversClass(AirWaybillNumberType::class)]
#[CoversClass(ContainerNumberType::class)]
#[CoversClass(DataIdentifierFieldType::class)]
#[CoversClass(DataIdentifierStringType::class)]
#[CoversClass(IataAirportCodeType::class)]
#[CoversClass(IcaoAirportCodeType::class)]
#[CoversClass(ImoNumberType::class)]
#[CoversClass(Iso15459IdentifierType::class)]
#[CoversClass(MmsiType::class)]
#[CoversClass(S10ItemIdentifierType::class)]
#[CoversClass(UicVehicleNumberType::class)]
#[CoversClass(UnLocodeType::class)]
#[CoversClass(VinType::class)]
#[CoversClass(WmiType::class)]
#[CoversClass(EidType::class)]
#[CoversClass(IccidType::class)]
#[CoversClass(ImeiType::class)]
#[CoversClass(ImeisvType::class)]
#[CoversClass(ImsiType::class)]
#[CoversClass(CasRegistryNumberType::class)]
#[CoversClass(EcNumberType::class)]
#[CoversClass(UnNumberType::class)]
#[CoversClass(HsCodeType::class)]
#[CoversClass(TariffCodeType::class)]
#[CoversClass(EnergyIdentificationCodeType::class)]
#[CoversClass(MpanType::class)]
#[UsesClass(TypeRegistrar::class)]
final class StringTypesTest extends TestCase
{
    private const string BAD_STORED_PART = 'zz9qq';

    private SQLitePlatform $platform;

    #[Override]
    protected function setUp(): void
    {
        TypeRegistrar::registerAll();
        $this->platform = new SQLitePlatform();
    }

    #[DataProviderExternal(Samples::class, 'strings')]
    public function testRoundTripsTheCanonicalForm(string $name, StringConvertible $vo): void
    {
        $type = Type::getType($name);

        $stored = $type->convertToDatabaseValue($vo, $this->platform);
        self::assertSame((string) $vo, $stored);

        $restored = $type->convertToPHPValue($stored, $this->platform);
        self::assertInstanceOf($vo::class, $restored);
        self::assertSame((string) $vo, (string) $restored);
    }

    public function testTheSamplesCoverEveryRegisteredType(): void
    {
        $names = [];
        foreach (Samples::strings() as [$name]) {
            $names[] = $name;
        }

        self::assertSame(\array_keys(TypeRegistrar::types()), $names);
    }

    /**
     * @param class-string<StringConvertible> $class
     * @param non-empty-string $longest
     */
    #[DataProviderExternal(Samples::class, 'bounded')]
    public function testTheColumnIsTheValueObjectsMaxLength(string $name, string $class, string $longest): void
    {
        $maxLength = new ReflectionClass($class)->getConstant('MAX_LENGTH');
        self::assertIsInt($maxLength);

        self::assertSame(\sprintf('VARCHAR(%d)', $maxLength), Type::getType($name)->getSQLDeclaration([], $this->platform));
        $stored = Type::getType($name)->convertToDatabaseValue($class::from($longest), $this->platform);
        self::assertIsString($stored);
        self::assertSame($maxLength, \mb_strlen($stored));
    }

    #[DataProviderExternal(Samples::class, 'textNames')]
    public function testAnUnboundedTypeIsAClob(string $name): void
    {
        self::assertSame($this->platform->getClobTypeDeclarationSQL([]), Type::getType($name)->getSQLDeclaration([], $this->platform));
    }

    /**
     * @return iterable<string, array{non-empty-string, class-string}>
     */
    public static function registered(): iterable
    {
        foreach (TypeRegistrar::types() as $name => $class) {
            yield $name => [$name, $class];
        }
    }

    /**
     * @param class-string $class
     */
    #[DataProvider('registered')]
    public function testTheNameIsIdPlusTheSnakeCaseShortNameOfTheValueObject(string $name, string $class): void
    {
        TypeRegistrar::registerAll();
        $type = Type::getType($name);
        $valueObject = new ReflectionMethod($type, 'valueObjectClass')->invoke($type);
        self::assertIsString($valueObject);
        self::assertTrue(\class_exists($valueObject));
        $shortName = new ReflectionClass($valueObject)->getShortName();

        self::assertSame('id_' . \strtolower((string) \preg_replace('/(?<!^)[A-Z]/', '_$0', $shortName)), $name);
        self::assertSame($name, \constant($class . '::NAME'));
    }

    #[DataProviderExternal(Samples::class, 'stringNames')]
    public function testNullRoundTrips(string $name): void
    {
        $type = Type::getType($name);

        self::assertNull($type->convertToDatabaseValue(null, $this->platform));
        self::assertNull($type->convertToPHPValue(null, $this->platform));
    }

    #[DataProviderExternal(Samples::class, 'badStored')]
    public function testAnInvalidStoredValueThrowsWithoutEchoingIt(string $name, string $invalid): void
    {
        try {
            Type::getType($name)->convertToPHPValue($invalid, $this->platform);
            self::fail('An invalid stored value was accepted.');
        } catch (InvalidValueObjectException $exception) {
            self::assertStringNotContainsString(self::BAD_STORED_PART, $exception->getMessage());
        }
    }

    #[DataProviderExternal(Samples::class, 'wrongCheck')]
    public function testAStoredValueWithAWrongCheckThrows(string $name, string $invalid, string $reason): void
    {
        try {
            Type::getType($name)->convertToPHPValue($invalid, $this->platform);
            self::fail('A stored value with a wrong check was accepted.');
        } catch (InvalidValueObjectException $exception) {
            self::assertStringEndsWith(' ' . $reason, $exception->getMessage());
            self::assertStringNotContainsString($invalid, $exception->getMessage());
        }
    }

    #[DataProviderExternal(Samples::class, 'legacyForms')]
    public function testALegacyStoredFormIsReadAndNormalised(string $name, string $stored, string $canonical): void
    {
        $type = Type::getType($name);

        $restored = $type->convertToPHPValue($stored, $this->platform);

        self::assertInstanceOf(StringConvertible::class, $restored);
        self::assertSame($canonical, (string) $restored);
        self::assertSame($canonical, $type->convertToDatabaseValue($restored, $this->platform));
    }

    #[DataProviderExternal(Samples::class, 'strings')]
    public function testRefusesAValueObjectOfAnotherClassOnWrite(string $name, StringConvertible $vo): void
    {
        $foreign = $vo instanceof Isbn ? Mmsi::from('366123456') : Isbn::from('9780306406157');

        try {
            Type::getType($name)->convertToDatabaseValue($foreign, $this->platform);
            self::fail('A value object of another class was written.');
        } catch (InvalidArgumentException $exception) {
            self::assertSame(\sprintf('Expected %s, got %s.', $vo::class, $foreign::class), $exception->getMessage());
        }
    }

    #[DataProviderExternal(Samples::class, 'stringNames')]
    public function testRefusesAPlainStringOnWrite(string $name): void
    {
        $this->expectException(InvalidArgumentException::class);

        Type::getType($name)->convertToDatabaseValue('9780306406157', $this->platform);
    }

    #[DataProviderExternal(Samples::class, 'stringNames')]
    public function testRefusesANonStringColumnValue(string $name): void
    {
        $this->expectException(InvalidArgumentException::class);

        Type::getType($name)->convertToPHPValue(123, $this->platform);
    }
}
