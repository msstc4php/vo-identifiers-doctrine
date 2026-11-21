<?php

declare(strict_types=1);

namespace MSSTC4PHP\ValueObject\Identifiers\Doctrine\Tests\Unit\Odm;

use Doctrine\ODM\MongoDB\Types\Type;
use InvalidArgumentException;
use MSSTC4PHP\ValueObject\Contract\StringConvertible;
use MSSTC4PHP\ValueObject\Exception\InvalidValueObjectException;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Odm\AirWaybillNumberType;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Odm\ArkType;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Odm\CasRegistryNumberType;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Odm\ContainerNumberType;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Odm\DataIdentifierFieldType;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Odm\DataIdentifierStringType;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Odm\DoiType;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Odm\EcNumberType;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Odm\EidType;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Odm\EnergyIdentificationCodeType;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Odm\HsCodeType;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Odm\IataAirportCodeType;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Odm\IcaoAirportCodeType;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Odm\IccidType;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Odm\ImeisvType;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Odm\ImeiType;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Odm\ImoNumberType;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Odm\ImsiType;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Odm\IsanType;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Odm\IsbnType;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Odm\IsmnType;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Odm\IsniType;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Odm\Iso15459IdentifierType;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Odm\IsrcType;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Odm\IssnType;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Odm\IswcType;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Odm\MmsiType;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Odm\MpanType;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Odm\OrcidType;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Odm\RorType;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Odm\S10ItemIdentifierType;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Odm\TariffCodeType;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Odm\TypeRegistrar;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Odm\UicVehicleNumberType;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Odm\UnLocodeType;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Odm\UnNumberType;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Odm\VinType;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Odm\WmiType;
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
    #[Override]
    protected function setUp(): void
    {
        TypeRegistrar::registerAll();
    }

    #[DataProviderExternal(Samples::class, 'stringPairs')]
    public function testRoundTripsTheCanonicalForm(string $name, StringConvertible $vo): void
    {
        $type = Type::getType($name);

        $stored = $type->convertToDatabaseValue($vo);
        self::assertSame((string) $vo, $stored);

        $restored = $type->convertToPHPValue($stored);
        self::assertInstanceOf($vo::class, $restored);
        self::assertSame((string) $vo, (string) $restored);
    }

    #[DataProviderExternal(Samples::class, 'stringNames')]
    public function testNullRoundTrips(string $name): void
    {
        $type = Type::getType($name);

        self::assertNull($type->convertToDatabaseValue(null));
        self::assertNull($type->convertToPHPValue(null));
    }

    #[DataProviderExternal(Samples::class, 'stringInvalids')]
    public function testInvalidStoredValueThrowsWithoutEchoingIt(string $name, string $invalid): void
    {
        try {
            Type::getType($name)->convertToPHPValue($invalid);
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
            Type::getType($name)->convertToDatabaseValue($foreign);
            self::fail('A value object of another class was written.');
        } catch (InvalidArgumentException $exception) {
            self::assertSame(\sprintf('Expected %s, got %s.', $vo::class, $foreign::class), $exception->getMessage());
        }
    }

    #[DataProviderExternal(Samples::class, 'stringNames')]
    public function testRefusesAPlainStringOnWrite(string $name): void
    {
        $this->expectException(InvalidArgumentException::class);

        Type::getType($name)->convertToDatabaseValue('9780306406157');
    }

    #[DataProviderExternal(Samples::class, 'stringNames')]
    public function testRefusesANonStringColumnValue(string $name): void
    {
        $this->expectException(InvalidArgumentException::class);

        Type::getType($name)->convertToPHPValue(123);
    }
}
