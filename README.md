# msstc4php/vo-identifiers-doctrine

Doctrine ORM (DBAL) and MongoDB ODM types for [`msstc4php/vo-identifiers`](https://github.com/msstc4php/vo-identifiers), built on
[`msstc4php/vo-base-doctrine`](https://github.com/msstc4php/vo-base-doctrine). PHP >= 8.4, no Symfony dependency.

## Status

Stable since 1.0.0: from here on a breaking change needs 2.0. One ORM and one ODM type per string value object of
`vo-identifiers` (37 per branch), registered by `Orm\TypeRegistrar` and `Odm\TypeRegistrar`. Enums
(`Transport\MmsiStationType`, `Energy\EicObjectType`) and `Internal\` helpers get no type: map an enum with Doctrine's own
`enumType` (ORM `#[Column(enumType: MmsiStationType::class)]`, ODM `#[Field(enumType: ...)]`), which stores the backed
value (`'group_ship'`, `'X'`); a 0.x mapping on `Transport\MmsiType` loads through vo-identifiers' deprecated alias until 2.0. The ODM round trips need MongoDB and run in CI's MongoDB service.

## Backward compatibility

Covered by 1.x: the type names (`id_<snake_name>`), the type classes and their `NAME` constants, the column lengths (each is
the value object's `MAX_LENGTH`, frozen by `vo-identifiers` 1.x, so no minor needs a schema migration), the text-or-`VARCHAR`
choice per type, and the stored string (the value object's canonical form, frozen by `vo-identifiers` 1.x). A type for a
class that `vo-identifiers` adds in a minor is added in a minor. Not covered: exception message wording, and everything
marked `@internal`.

## Install

Register the GitHub repositories:

```json
{
    "repositories": [
        { "type": "vcs", "url": "https://github.com/msstc4php/vo-base" },
        { "type": "vcs", "url": "https://github.com/msstc4php/vo-base-doctrine" },
        { "type": "vcs", "url": "https://github.com/msstc4php/vo-gs1" },
        { "type": "vcs", "url": "https://github.com/msstc4php/vo-identifiers" },
        { "type": "vcs", "url": "https://github.com/msstc4php/vo-identifiers-doctrine" }
    ],
    "require": {
        "msstc4php/vo-identifiers-doctrine": "^1.0"
    }
}
```

Runtime requirements: PHP >= 8.4, `msstc4php/vo-identifiers ^1.0`, `msstc4php/vo-base-doctrine ^1.3`; `doctrine/dbal` (ORM) or
`doctrine/mongodb-odm` (ODM) is yours.

## Usage

Bare Doctrine: call `Orm\TypeRegistrar::registerAll()` (or `Odm\TypeRegistrar::registerAll()`) once at bootstrap.
Symfony: map `TypeRegistrar::types()` under `doctrine.dbal.types` (ORM) or the top-level `doctrine_mongodb.types` (ODM).

## Type names and lengths

Every name is `id_` plus the snake_case of the class short name (`ContainerNumber` is `id_container_number`,
`Iso15459Identifier` is `id_iso15459_identifier`). The ORM column is `VARCHAR(n)`, `n` being the characters of the longest
stored form the class accepts: the type returns the value object's `MAX_LENGTH` constant, so the column follows the class. A class with no upper bound (`Ark`, `Doi`, `DataIdentifierField`, `DataIdentifierString`,
`Iso15459Identifier`) maps to vo-base-doctrine's `AbstractTextVoType`, a CLOB/TEXT column; a TEXT column cannot carry a
plain index on every platform (MySQL needs a prefix length), so index a derived key instead. Where only a narrower subset is
stored, a custom type with a `VARCHAR` column is fine: an `Iso15459Identifier` carried in a `J` licence-plate field is at most
35 characters (MH10.8.2), so a column of licence plates only can be `VARCHAR(35)`; `Iso15459Identifier` itself has no cap. The ODM field is a BSON
string without a length.

`n` counts characters, not bytes. Only `Doi`, `Ark` and the data-identifier classes can hold non-ASCII text, and they are
text columns.

On write a type accepts only its own value-object class: an `Isbn` given to `id_mmsi` throws `InvalidArgumentException`.
A stored value that no longer parses (malformed, empty, or a wrong check digit) throws the value object's own exception on
read, not a DBAL `ConversionException`, and the message does not contain the value. A stored value in a non-canonical form
the class still accepts (a hyphenated ISBN, a compact ISSN, an IMEI with spaces, a CAS number with leading zeros) is read
and normalised; the next write stores the canonical form.

Values are stored as the value object holds them (canonical form): ISSN and ORCID with their hyphens, a CAS number as
`7732-18-5`, an IMEI without spaces, an MH10.8.2 message with its RS, GS and EOT control characters. Subscriber identities
(`id_imsi`, `id_iccid`, `id_eid`, `id_imei`, `id_imeisv`) are stored in full, unmasked (`masked()` is for display).

**Forms that `equals()` merges.** `Imei` (14 or 15 digits), `Isbn` (ISBN-10 or ISBN-13) and `Isan` (with or without check
characters) compare equal across forms, but the column holds the form given, so a UNIQUE index or a string lookup sees two
values. Normalise before writing (`Imei::withCheckDigit()` or its first 14 digits, `Isbn::toIsbn13()`) when the column must
deduplicate.

**Registry tables.** The types store identifiers only; the one embedded table (AIM IAC register, edition 2026-06-16, in
`vo-identifiers`) decodes and never refuses, and a new edition ships as a minor release of `vo-identifiers`, with no schema change.

**Collation.** `Doi`, `Ark` and the data identifiers are case-sensitive. Under a case-insensitive collation two values that
differ only in case collide in a unique index; give such columns a binary collation (MySQL `utf8mb4_bin`).

| Type name | Value object | Column length | Length derived from |
|---|---|---|---|
| `id_air_waybill_number` | `Transport\AirWaybillNumber` | 11 | 3 + 8 digits, stored compact |
| `id_ark` | `Publication\Ark` | CLOB/TEXT | the name part has no cap |
| `id_cas_registry_number` | `Substance\CasRegistryNumber` | 12 | 2 to 7 digits + `-NN-N`, 12 characters with hyphens |
| `id_container_number` | `Transport\ContainerNumber` | 11 | 4 letters + 7 digits |
| `id_data_identifier_field` | `Transport\DataIdentifierField` | CLOB/TEXT | the data has no cap |
| `id_data_identifier_string` | `Transport\DataIdentifierString` | CLOB/TEXT | any number of fields, no cap |
| `id_doi` | `Publication\Doi` | CLOB/TEXT | the suffix has no cap |
| `id_ec_number` | `Substance\EcNumber` | 9 | `NNN-NNN-N`, 9 characters |
| `id_eid` | `Telecom\Eid` | 32 | 32 digits |
| `id_energy_identification_code` | `Energy\EnergyIdentificationCode` | 16 | fixed 16 characters |
| `id_hs_code` | `Trade\HsCode` | 6 | 6 digits, stored without separators |
| `id_iata_airport_code` | `Transport\IataAirportCode` | 3 | 3 letters |
| `id_icao_airport_code` | `Transport\IcaoAirportCode` | 4 | 4 letters |
| `id_iccid` | `Telecom\Iccid` | 20 | `89` + 4 to 18 digits, at most 20 |
| `id_imei` | `Telecom\Imei` | 15 | 14 or 15 digits |
| `id_imeisv` | `Telecom\Imeisv` | 16 | 16 digits |
| `id_imo_number` | `Transport\ImoNumber` | 10 | `IMO` + 7 digits |
| `id_imsi` | `Telecom\Imsi` | 15 | 6 to 15 digits |
| `id_isan` | `Publication\Isan` | 26 | ISO 15706-1: 16 hex root and episode, optionally 8 version and 2 check characters, stored compact: 26 |
| `id_isbn` | `Publication\Isbn` | 13 | ISBN-13, 13 digits (ISBN-10 stores 10) |
| `id_ismn` | `Publication\Ismn` | 13 | 13 digits, 979-0 form |
| `id_isni` | `Publication\Isni` | 16 | 16 characters |
| `id_iso15459_identifier` | `Transport\Iso15459Identifier` | CLOB/TEXT | `[A-Z0-9][A-Z0-9/-]{2,}`, no upper bound |
| `id_isrc` | `Publication\Isrc` | 12 | 12 characters, stored compact |
| `id_issn` | `Publication\Issn` | 9 | `NNNN-NNNC`, 9 characters with the hyphen |
| `id_iswc` | `Publication\Iswc` | 11 | `T` + 10 digits |
| `id_mmsi` | `Transport\Mmsi` | 9 | 9 digits |
| `id_mpan` | `Energy\Mpan` | 21 | 13 or 21 digits, at most 21 |
| `id_orcid` | `Publication\Orcid` | 19 | 4 groups of 4 with hyphens, 19 characters |
| `id_ror` | `Publication\Ror` | 9 | `0` + 6 + 2 check, 9 characters |
| `id_s10_item_identifier` | `Transport\S10ItemIdentifier` | 13 | 2 + 9 + 2 characters |
| `id_tariff_code` | `Trade\TariffCode` | 10 | 8 or 10 digits, stored without separators |
| `id_uic_vehicle_number` | `Transport\UicVehicleNumber` | 12 | 12 digits, stored compact |
| `id_un_locode` | `Transport\UnLocode` | 5 | 2 + 3 characters |
| `id_un_number` | `Substance\UnNumber` | 6 | `UN` + 4 digits |
| `id_vin` | `Transport\Vin` | 17 | 17 characters |
| `id_wmi` | `Transport\Wmi` | 3 | 3 characters |

## License

MIT, see [`LICENSE`](LICENSE).
