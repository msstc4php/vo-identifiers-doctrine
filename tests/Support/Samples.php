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
 * Per type name: a canonical sample, the longest stored form of a bounded type, and stored values that must be refused.
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
     * One canonical sample per type name.
     *
     * @return iterable<string, array{non-empty-string, StringConvertible}>
     */
    public static function strings(): iterable
    {
        yield 'ark' => ['id_ark', Ark::from('ark:12025/654xz321')];
        yield 'doi' => ['id_doi', Doi::from('10.1000/xyz-123')];
        yield 'isan' => ['id_isan', Isan::from('B159D8FA01240000K9F3A02459')];
        yield 'isbn' => ['id_isbn', Isbn::from('9780306406157')];
        yield 'ismn' => ['id_ismn', Ismn::from('9790345246805')];
        yield 'isni' => ['id_isni', Isni::from('1422458635730476')];
        yield 'isrc' => ['id_isrc', Isrc::from('AA6QZ2000047')];
        yield 'issn' => ['id_issn', Issn::from('0317-8471')];
        yield 'iswc' => ['id_iswc', Iswc::from('T0345246801')];
        yield 'orcid' => ['id_orcid', Orcid::from('0000-0002-1825-0097')];
        yield 'ror' => ['id_ror', Ror::from('02mhbdp94')];
        yield 'air waybill number' => ['id_air_waybill_number', AirWaybillNumber::from('02012345675')];
        yield 'container number' => ['id_container_number', ContainerNumber::from('CSQU3054383')];
        yield 'data identifier field' => ['id_data_identifier_field', DataIdentifierField::from('25SLN12345')];
        yield 'data identifier string' => ['id_data_identifier_string', self::mh1082Envelope()];
        yield 'iata airport code' => ['id_iata_airport_code', IataAirportCode::from('SYD')];
        yield 'icao airport code' => ['id_icao_airport_code', IcaoAirportCode::from('EDDF')];
        yield 'imo number' => ['id_imo_number', ImoNumber::from('IMO8712345')];
        yield 'iso15459 identifier' => ['id_iso15459_identifier', Iso15459Identifier::from('LN12345')];
        yield 'mmsi' => ['id_mmsi', Mmsi::from('366123456')];
        yield 's10 item identifier' => ['id_s10_item_identifier', S10ItemIdentifier::from('RA473124829CH')];
        yield 'uic vehicle number' => ['id_uic_vehicle_number', UicVehicleNumber::from('338447961008')];
        yield 'un locode' => ['id_un_locode', UnLocode::from('DEHAM')];
        yield 'vin' => ['id_vin', Vin::from('1G4AH59H45G118341')];
        yield 'wmi' => ['id_wmi', Wmi::from('1G4')];
        yield 'eid' => ['id_eid', Eid::from('35209900176148100000000000000078')];
        yield 'iccid' => ['id_iccid', Iccid::from('89444444444444444440')];
        yield 'imei' => ['id_imei', Imei::from('490154203237518')];
        yield 'imeisv' => ['id_imeisv', Imeisv::from('2605317931138301')];
        yield 'imsi' => ['id_imsi', Imsi::from('310150123456789')];
        yield 'cas registry number' => ['id_cas_registry_number', CasRegistryNumber::from('7732-18-5')];
        yield 'ec number' => ['id_ec_number', EcNumber::from('100-000-1')];
        yield 'un number' => ['id_un_number', UnNumber::from('UN1203')];
        yield 'hs code' => ['id_hs_code', HsCode::from('010121')];
        yield 'tariff code' => ['id_tariff_code', TariffCode::from('0101210000')];
        yield 'energy identification code' => ['id_energy_identification_code', EnergyIdentificationCode::from('11XRWENET12345-2')];
        yield 'mpan' => ['id_mpan', Mpan::from('123456789012345678901')];
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
     * @return iterable<string, array{non-empty-string}>
     */
    public static function textNames(): iterable
    {
        foreach (self::TEXT_TYPES as $name) {
            yield $name => [$name];
        }
    }

    /**
     * Per bounded type: its value-object class and a value of the longest stored form, which has `MAX_LENGTH` characters.
     *
     * @return iterable<string, array{non-empty-string, class-string<StringConvertible>, non-empty-string}>
     */
    public static function bounded(): iterable
    {
        yield 'isan' => ['id_isan', Isan::class, 'B159D8FA01240000K9F3A02459'];
        yield 'isbn' => ['id_isbn', Isbn::class, '9780306406157'];
        yield 'ismn' => ['id_ismn', Ismn::class, '9790345246805'];
        yield 'isni' => ['id_isni', Isni::class, '1422458635730476'];
        yield 'isrc' => ['id_isrc', Isrc::class, 'AA6QZ2000047'];
        yield 'issn' => ['id_issn', Issn::class, '0317-8471'];
        yield 'iswc' => ['id_iswc', Iswc::class, 'T0345246801'];
        yield 'orcid' => ['id_orcid', Orcid::class, '0000-0002-1825-0097'];
        yield 'ror' => ['id_ror', Ror::class, '02mhbdp94'];
        yield 'air waybill number' => ['id_air_waybill_number', AirWaybillNumber::class, '02012345675'];
        yield 'container number' => ['id_container_number', ContainerNumber::class, 'CSQU3054383'];
        yield 'iata airport code' => ['id_iata_airport_code', IataAirportCode::class, 'SYD'];
        yield 'icao airport code' => ['id_icao_airport_code', IcaoAirportCode::class, 'EDDF'];
        yield 'imo number' => ['id_imo_number', ImoNumber::class, 'IMO8712345'];
        yield 'mmsi' => ['id_mmsi', Mmsi::class, '366123456'];
        yield 's10 item identifier' => ['id_s10_item_identifier', S10ItemIdentifier::class, 'RA473124829CH'];
        yield 'uic vehicle number' => ['id_uic_vehicle_number', UicVehicleNumber::class, '338447961008'];
        yield 'un locode' => ['id_un_locode', UnLocode::class, 'DEHAM'];
        yield 'vin' => ['id_vin', Vin::class, '1G4AH59H45G118341'];
        yield 'wmi' => ['id_wmi', Wmi::class, '1G4'];
        yield 'eid' => ['id_eid', Eid::class, '35209900176148100000000000000078'];
        yield 'iccid' => ['id_iccid', Iccid::class, '89444444444444444440'];
        yield 'imei' => ['id_imei', Imei::class, '490154203237518'];
        yield 'imeisv' => ['id_imeisv', Imeisv::class, '2605317931138301'];
        yield 'imsi' => ['id_imsi', Imsi::class, '310150123456789'];
        yield 'cas registry number' => ['id_cas_registry_number', CasRegistryNumber::class, '1234567-89-5'];
        yield 'ec number' => ['id_ec_number', EcNumber::class, '100-000-1'];
        yield 'un number' => ['id_un_number', UnNumber::class, 'UN1203'];
        yield 'hs code' => ['id_hs_code', HsCode::class, '010121'];
        yield 'tariff code' => ['id_tariff_code', TariffCode::class, '0101210000'];
        yield 'energy identification code' => ['id_energy_identification_code', EnergyIdentificationCode::class, '11XRWENET12345-2'];
        yield 'mpan' => ['id_mpan', Mpan::class, '123456789012345678901'];
    }

    /**
     * Stored values every type refuses: a format error and the empty string.
     *
     * @return iterable<string, array{non-empty-string, string}>
     */
    public static function badStored(): iterable
    {
        foreach (self::strings() as $label => [$name]) {
            yield $label . ', malformed' => [$name, self::BAD_STORED];
            yield $label . ', empty' => [$name, ''];
        }
    }

    /**
     * Well-formed stored values with a wrong check digit or character (realistic corruption), and the message reason.
     *
     * @return iterable<string, array{non-empty-string, non-empty-string, non-empty-string}>
     */
    public static function wrongCheck(): iterable
    {
        $digit = 'has a wrong check digit.';
        $character = 'has a wrong check character.';

        yield 'isan' => ['id_isan', 'B159D8FA01240000K9F3A02450', $character];
        yield 'isbn' => ['id_isbn', '9780306406150', $digit];
        yield 'ismn' => ['id_ismn', '9790345246800', $digit];
        yield 'isni' => ['id_isni', '1422458635730470', $character];
        yield 'issn' => ['id_issn', '0317-8470', $digit];
        yield 'orcid' => ['id_orcid', '0000-0002-1825-0090', $character];
        yield 'ror' => ['id_ror', '02mhbdp90', $digit];
        yield 'air waybill number' => ['id_air_waybill_number', '02012345670', $digit];
        yield 's10 item identifier' => ['id_s10_item_identifier', 'RA473124820CH', $digit];
        yield 'uic vehicle number' => ['id_uic_vehicle_number', '338447961000', $digit];
        yield 'eid' => ['id_eid', '35209900176148100000000000000070', $digit];
        yield 'iccid' => ['id_iccid', '89444444444444444441', $digit];
        yield 'imei' => ['id_imei', '490154203237510', $digit];
        yield 'cas registry number' => ['id_cas_registry_number', '1234567-89-0', $digit];
        yield 'ec number' => ['id_ec_number', '100-000-0', $digit];
        yield 'energy identification code' => ['id_energy_identification_code', '11XRWENET12345-0', $character];
    }

    /**
     * Stored values in a legacy, non-canonical form that the value object still accepts: they are read and normalised,
     * so the next write stores the canonical form.
     *
     * @return iterable<string, array{non-empty-string, non-empty-string, non-empty-string}>
     */
    public static function legacyForms(): iterable
    {
        yield 'hyphenated ISBN-13' => ['id_isbn', '978-0-306-40615-7', '9780306406157'];
        yield 'compact ISSN' => ['id_issn', '03178471', '0317-8471'];
        yield 'IMEI with spaces' => ['id_imei', '49 015420 323751 8', '490154203237518'];
        yield 'CAS with leading zeros' => ['id_cas_registry_number', '0050-00-0', '50-00-0'];
    }
}
