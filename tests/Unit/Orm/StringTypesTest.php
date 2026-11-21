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
use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

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
    private SQLitePlatform $platform;

    #[Override]
    protected function setUp(): void
    {
        TypeRegistrar::registerAll();
        $this->platform = new SQLitePlatform();
    }

    #[DataProviderExternal(Samples::class, 'stringPairs')]
    public function testRoundTripsTheCanonicalForm(string $name, StringConvertible $vo): void
    {
        $type = Type::getType($name);

        $stored = $type->convertToDatabaseValue($vo, $this->platform);
        self::assertSame((string) $vo, $stored);

        $restored = $type->convertToPHPValue($stored, $this->platform);
        self::assertInstanceOf($vo::class, $restored);
        self::assertSame((string) $vo, (string) $restored);
    }

    #[DataProviderExternal(Samples::class, 'stringLengths')]
    public function testColumnFitsTheLongestAcceptedForm(string $name, StringConvertible $vo, int $length, bool $atMax): void
    {
        $isText = \in_array($name, Samples::TEXT_TYPES, true);
        self::assertSame(
            $isText ? $this->platform->getClobTypeDeclarationSQL([]) : \sprintf('VARCHAR(%d)', $length),
            Type::getType($name)->getSQLDeclaration([], $this->platform),
        );
        if ($length > 0) {
            self::assertLessThanOrEqual($length, \mb_strlen((string) $vo));
        }

        if (!$atMax) {
            return;
        }

        self::assertSame($length, \mb_strlen((string) $vo));
        $this->expectException(InvalidValueObjectException::class);
        $vo::from($vo . \mb_substr((string) $vo, -1));
    }

    #[DataProviderExternal(Samples::class, 'stringNames')]
    public function testNullRoundTrips(string $name): void
    {
        $type = Type::getType($name);

        self::assertNull($type->convertToDatabaseValue(null, $this->platform));
        self::assertNull($type->convertToPHPValue(null, $this->platform));
    }

    #[DataProviderExternal(Samples::class, 'stringInvalids')]
    public function testInvalidStoredValueThrowsWithoutEchoingIt(string $name, string $invalid): void
    {
        try {
            Type::getType($name)->convertToPHPValue($invalid, $this->platform);
            self::fail('An invalid stored value was accepted.');
        } catch (InvalidValueObjectException $exception) {
            self::assertStringNotContainsString($invalid, $exception->getMessage());
        }
    }

    #[DataProviderExternal(Samples::class, 'stringPairs')]
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
