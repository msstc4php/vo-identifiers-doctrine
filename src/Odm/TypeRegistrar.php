<?php

declare(strict_types=1);

namespace MSSTC4PHP\ValueObject\Identifiers\Doctrine\Odm;

use Doctrine\ODM\MongoDB\Types\Type;

/**
 * Registers every identifier value-object type. Call once at bootstrap for bare Doctrine; under Symfony map {@see types()}
 * under `doctrine_mongodb.odm.types` instead. Registration is idempotent, so it is safe in long-running workers.
 */
final class TypeRegistrar
{
    /**
     * @var array<non-empty-string, class-string<Type>>
     */
    private const array TYPES = [
        ArkType::NAME => ArkType::class,
        DoiType::NAME => DoiType::class,
        IsanType::NAME => IsanType::class,
        IsbnType::NAME => IsbnType::class,
        IsmnType::NAME => IsmnType::class,
        IsniType::NAME => IsniType::class,
        IsrcType::NAME => IsrcType::class,
        IssnType::NAME => IssnType::class,
        IswcType::NAME => IswcType::class,
        OrcidType::NAME => OrcidType::class,
        RorType::NAME => RorType::class,
        AirWaybillNumberType::NAME => AirWaybillNumberType::class,
        ContainerNumberType::NAME => ContainerNumberType::class,
        DataIdentifierFieldType::NAME => DataIdentifierFieldType::class,
        DataIdentifierStringType::NAME => DataIdentifierStringType::class,
        IataAirportCodeType::NAME => IataAirportCodeType::class,
        IcaoAirportCodeType::NAME => IcaoAirportCodeType::class,
        ImoNumberType::NAME => ImoNumberType::class,
        Iso15459IdentifierType::NAME => Iso15459IdentifierType::class,
        MmsiType::NAME => MmsiType::class,
        S10ItemIdentifierType::NAME => S10ItemIdentifierType::class,
        UicVehicleNumberType::NAME => UicVehicleNumberType::class,
        UnLocodeType::NAME => UnLocodeType::class,
        VinType::NAME => VinType::class,
        WmiType::NAME => WmiType::class,
        EidType::NAME => EidType::class,
        IccidType::NAME => IccidType::class,
        ImeiType::NAME => ImeiType::class,
        ImeisvType::NAME => ImeisvType::class,
        ImsiType::NAME => ImsiType::class,
        CasRegistryNumberType::NAME => CasRegistryNumberType::class,
        EcNumberType::NAME => EcNumberType::class,
        UnNumberType::NAME => UnNumberType::class,
        HsCodeType::NAME => HsCodeType::class,
        TariffCodeType::NAME => TariffCodeType::class,
        EnergyIdentificationCodeType::NAME => EnergyIdentificationCodeType::class,
        MpanType::NAME => MpanType::class,
    ];

    public static function registerAll(): void
    {
        foreach (self::types() as $name => $class) {
            if (!Type::hasType($name)) {
                Type::addType($name, $class);
            }
        }
    }

    /**
     * @return array<non-empty-string, class-string<Type>>
     */
    public static function types(): array
    {
        return self::TYPES;
    }
}
