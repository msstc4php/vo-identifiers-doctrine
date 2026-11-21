<?php

declare(strict_types=1);

namespace MSSTC4PHP\ValueObject\Identifiers\Doctrine\Tests\Support;

use MSSTC4PHP\ValueObject\Contract\StringConvertible;
use MSSTC4PHP\ValueObject\Identifiers\Energy\EnergyIdentificationCode;
use MSSTC4PHP\ValueObject\Identifiers\Energy\Mpan;
use MSSTC4PHP\ValueObject\Identifiers\Publication\Ark;
use MSSTC4PHP\ValueObject\Identifiers\Publication\Doi;
use MSSTC4PHP\ValueObject\Identifiers\Publication\Isan;
use MSSTC4PHP\ValueObject\Identifiers\Publication\Isbn;
use MSSTC4PHP\ValueObject\Identifiers\Publication\Ismn;
use MSSTC4PHP\ValueObject\Identifiers\Publication\Isni;
use MSSTC4PHP\ValueObject\Identifiers\Publication\Isrc;
use MSSTC4PHP\ValueObject\Identifiers\Publication\Issn;
use MSSTC4PHP\ValueObject\Identifiers\Publication\Iswc;
use MSSTC4PHP\ValueObject\Identifiers\Publication\Orcid;
use MSSTC4PHP\ValueObject\Identifiers\Publication\Ror;
use MSSTC4PHP\ValueObject\Identifiers\Substance\CasRegistryNumber;
use MSSTC4PHP\ValueObject\Identifiers\Substance\EcNumber;
use MSSTC4PHP\ValueObject\Identifiers\Substance\UnNumber;
use MSSTC4PHP\ValueObject\Identifiers\Telecom\Eid;
use MSSTC4PHP\ValueObject\Identifiers\Telecom\Iccid;
use MSSTC4PHP\ValueObject\Identifiers\Telecom\Imei;
use MSSTC4PHP\ValueObject\Identifiers\Telecom\Imeisv;
use MSSTC4PHP\ValueObject\Identifiers\Telecom\Imsi;
use MSSTC4PHP\ValueObject\Identifiers\Trade\HsCode;
use MSSTC4PHP\ValueObject\Identifiers\Trade\TariffCode;
use MSSTC4PHP\ValueObject\Identifiers\Transport\AirWaybillNumber;
use MSSTC4PHP\ValueObject\Identifiers\Transport\ContainerNumber;
use MSSTC4PHP\ValueObject\Identifiers\Transport\DataIdentifierField;
use MSSTC4PHP\ValueObject\Identifiers\Transport\DataIdentifierString;
use MSSTC4PHP\ValueObject\Identifiers\Transport\IataAirportCode;
use MSSTC4PHP\ValueObject\Identifiers\Transport\IcaoAirportCode;
use MSSTC4PHP\ValueObject\Identifiers\Transport\ImoNumber;
use MSSTC4PHP\ValueObject\Identifiers\Transport\Iso15459Identifier;
use MSSTC4PHP\ValueObject\Identifiers\Transport\Mmsi;
use MSSTC4PHP\ValueObject\Identifiers\Transport\S10ItemIdentifier;
use MSSTC4PHP\ValueObject\Identifiers\Transport\UicVehicleNumber;
use MSSTC4PHP\ValueObject\Identifiers\Transport\UnLocode;
use MSSTC4PHP\ValueObject\Identifiers\Transport\Vin;
use MSSTC4PHP\ValueObject\Identifiers\Transport\Wmi;

/**
 * A canonical sample, the column length and a stored value that must be refused, per type name.
 */
final class Samples
{
    public const string BAD_STORED = 'zz9qq!';

    /** @var non-empty-list<non-empty-string> types without a bounded length map to CLOB/TEXT */
    public const array TEXT_TYPES = [
        'id_ark',
        'id_doi',
        'id_data_identifier_field',
        'id_data_identifier_string',
        'id_iso15459_identifier',
    ];

    /**
     * An MH10.8.2 envelope with its RS, GS and EOT control characters.
     */
    public static function mh1082Envelope(): DataIdentifierString
    {
        return DataIdentifierString::from("[)>\x1E06\x1D25SLN12345\x1DS000001\x1D1PABC-1\x1E\x04");
    }

    /**
     * Per type: the type name, a canonical sample, the column length (0 for a text type), an invalid stored value and
     * whether the sample has the longest accepted length (then one more character must be refused).
     *
     * @return iterable<string, array{non-empty-string, StringConvertible, non-negative-int, non-empty-string, bool}>
     */
    public static function strings(): iterable
    {
        yield 'ark' => ['id_ark', Ark::from('ark:12025/654xz321'), 0, self::BAD_STORED, false];
        yield 'doi' => ['id_doi', Doi::from('10.1000/xyz-123'), 0, self::BAD_STORED, false];
        yield 'isan' => ['id_isan', Isan::from('B159D8FA01240000K9F3A02459'), 26, self::BAD_STORED, true];
        yield 'isbn' => ['id_isbn', Isbn::from('9780306406157'), 13, self::BAD_STORED, true];
        yield 'ismn' => ['id_ismn', Ismn::from('9790345246805'), 13, self::BAD_STORED, true];
        yield 'isni' => ['id_isni', Isni::from('1422458635730476'), 16, self::BAD_STORED, true];
        yield 'isrc' => ['id_isrc', Isrc::from('AA6QZ2000047'), 12, self::BAD_STORED, true];
        yield 'issn' => ['id_issn', Issn::from('0317-8471'), 9, self::BAD_STORED, true];
        yield 'iswc' => ['id_iswc', Iswc::from('T0345246801'), 11, self::BAD_STORED, true];
        yield 'orcid' => ['id_orcid', Orcid::from('0000-0002-1825-0097'), 19, self::BAD_STORED, true];
        yield 'ror' => ['id_ror', Ror::from('02mhbdp94'), 9, self::BAD_STORED, true];
        yield 'air waybill number' => ['id_air_waybill_number', AirWaybillNumber::from('02012345675'), 11, self::BAD_STORED, true];
        yield 'container number' => ['id_container_number', ContainerNumber::from('CSQU3054383'), 11, self::BAD_STORED, true];
        yield 'data identifier field' => ['id_data_identifier_field', DataIdentifierField::from('25SLN12345'), 0, self::BAD_STORED, false];
        yield 'data identifier string' => ['id_data_identifier_string', self::mh1082Envelope(), 0, self::BAD_STORED, false];
        yield 'iata airport code' => ['id_iata_airport_code', IataAirportCode::from('SYD'), 3, self::BAD_STORED, true];
        yield 'icao airport code' => ['id_icao_airport_code', IcaoAirportCode::from('EDDF'), 4, self::BAD_STORED, true];
        yield 'imo number' => ['id_imo_number', ImoNumber::from('IMO8712345'), 10, self::BAD_STORED, true];
        yield 'iso15459 identifier' => ['id_iso15459_identifier', Iso15459Identifier::from('LN12345'), 0, self::BAD_STORED, false];
        yield 'mmsi' => ['id_mmsi', Mmsi::from('366123456'), 9, self::BAD_STORED, true];
        yield 's10 item identifier' => ['id_s10_item_identifier', S10ItemIdentifier::from('RA473124829CH'), 13, self::BAD_STORED, true];
        yield 'uic vehicle number' => ['id_uic_vehicle_number', UicVehicleNumber::from('338447961008'), 12, self::BAD_STORED, true];
        yield 'un locode' => ['id_un_locode', UnLocode::from('DEHAM'), 5, self::BAD_STORED, true];
        yield 'vin' => ['id_vin', Vin::from('1G4AH59H45G118341'), 17, self::BAD_STORED, true];
        yield 'wmi' => ['id_wmi', Wmi::from('1G4'), 3, self::BAD_STORED, true];
        yield 'eid' => ['id_eid', Eid::from('35209900176148100000000000000078'), 32, self::BAD_STORED, true];
        yield 'iccid' => ['id_iccid', Iccid::from('89444444444444444440'), 20, self::BAD_STORED, true];
        yield 'imei' => ['id_imei', Imei::from('490154203237518'), 15, self::BAD_STORED, true];
        yield 'imeisv' => ['id_imeisv', Imeisv::from('2605317931138301'), 16, self::BAD_STORED, true];
        yield 'imsi' => ['id_imsi', Imsi::from('310150123456789'), 15, self::BAD_STORED, true];
        yield 'cas registry number' => ['id_cas_registry_number', CasRegistryNumber::from('7732-18-5'), 12, self::BAD_STORED, false];
        yield 'cas registry number longest' => ['id_cas_registry_number', CasRegistryNumber::from('1234567-89-5'), 12, self::BAD_STORED, true];
        yield 'ec number' => ['id_ec_number', EcNumber::from('100-000-1'), 9, self::BAD_STORED, true];
        yield 'un number' => ['id_un_number', UnNumber::from('UN1203'), 6, self::BAD_STORED, true];
        yield 'hs code' => ['id_hs_code', HsCode::from('010121'), 6, self::BAD_STORED, true];
        yield 'tariff code' => ['id_tariff_code', TariffCode::from('0101210000'), 10, self::BAD_STORED, true];
        yield 'energy identification code' => ['id_energy_identification_code', EnergyIdentificationCode::from('11XRWENET12345-2'), 16, self::BAD_STORED, true];
        yield 'mpan' => ['id_mpan', Mpan::from('123456789012345678901'), 21, self::BAD_STORED, true];
    }

    /**
     * @return iterable<string, array{non-empty-string}>
     */
    public static function stringNames(): iterable
    {
        foreach (self::strings() as $label => [$name]) {
            yield $label => [$name];
        }
    }

    /**
     * @return iterable<string, array{non-empty-string, StringConvertible}>
     */
    public static function stringPairs(): iterable
    {
        foreach (self::strings() as $label => [$name, $vo]) {
            yield $label => [$name, $vo];
        }
    }

    /**
     * @return iterable<string, array{non-empty-string, StringConvertible, non-negative-int, bool}>
     */
    public static function stringLengths(): iterable
    {
        foreach (self::strings() as $label => [$name, $vo, $length, , $atMax]) {
            yield $label => [$name, $vo, $length, $atMax];
        }
    }

    /**
     * @return iterable<string, array{non-empty-string, non-empty-string}>
     */
    public static function stringInvalids(): iterable
    {
        foreach (self::strings() as $label => [$name, , , $invalid]) {
            yield $label => [$name, $invalid];
        }
    }
}
