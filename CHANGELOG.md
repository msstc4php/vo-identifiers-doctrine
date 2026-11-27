# Changelog

## [1.1.0] - 2026-11-27

### Changed

- Allows `msstc4php/vo-identifiers` `^1.0 || ^2.0`. Type names, classes and column lengths are unchanged; vo-identifiers
  2.0 removed the deprecated `Transport\MmsiType` alias, so an `enumType: MmsiType::class` mapping must name
  `Transport\MmsiStationType` (see the vo-identifiers 2.0.0 "Upgrading from 1.x" block). `Isan` rows: 2.0's `equals()`
  treats a `0000-0000` version as none, the stored strings stay as written, so equality lookups still compare the text.

## [1.0.0] - 2026-11-23

First stable release: from here on a breaking change needs 2.0.

Backward compatibility (README "Backward compatibility"): 1.x covers the type names and classes, their `NAME` constants,
the column lengths (the value objects' `MAX_LENGTH`, frozen by vo-identifiers 1.x), the text-or-`VARCHAR` choice and the
stored strings. Message wording and `@internal` code are not covered.

### Changed

- Requires `msstc4php/vo-identifiers ^1.0` (was `^0.2`) and `msstc4php/vo-base-doctrine ^1.3` (was `^1.2`). No change in
  this package's types: names, column lengths and stored forms are those of 0.2.
- The vo-identifiers enum `Transport\MmsiType` is now `Transport\MmsiStationType`, so the bridge's `MmsiType` (the type of
  `Mmsi`, `id_mmsi`) no longer shares its short name. Enums get no Doctrine type; map them with `enumType`. vo-identifiers
  keeps `Transport\MmsiType` as a deprecated alias until 2.0, so `enumType: MmsiType::class` mappings of 0.x still load.
- `id_iso15459_identifier` reads and writes the `-` and `/` that vo-identifiers 1.0 accepts in an `Iso15459Identifier`
  (a TEXT column, no schema change).

### Upgrading from 0.2

- No code or schema change in this package. Values stored by 0.2 read unchanged. Follow the vo-identifiers 1.0.0
  "Upgrading from 0.2" list for the value objects (`MmsiType` → `MmsiStationType` in `enumType` mappings: the old name is a
  deprecated alias until vo-identifiers 2.0, so rename at your pace).

## [0.2.0] - 2026-11-23

### Changed

- Requires `msstc4php/vo-identifiers ^0.2` (was `^0.1`): vo-identifiers 0.2.0 relies on vo-base `^1.3` to validate identifiers again on `unserialize()`. No change in this package's code.

## [0.1.0] - 2026-11-22

### Added

- Package scaffold, CI and tool configuration from `vo-finance-doctrine`: empty `Orm\TypeRegistrar` and `Odm\TypeRegistrar`
  (type names `id_<snake_name>`); the types follow with the value objects of `vo-identifiers`.
- ORM and ODM types for every string value object of `vo-identifiers` (37 per branch): publication, transport, telecom,
  substance, trade and energy identifiers. Names are `id_<snake_name>`; the ORM column length is the longest stored form
  the class accepts, and the five classes without a bound (`Ark`, `Doi`, `DataIdentifierField`, `DataIdentifierString`,
  `Iso15459Identifier`) are CLOB/TEXT columns. `Orm\TypeRegistrar` and `Odm\TypeRegistrar` register them.
- The type table (name, value object, column length, derivation) is in the README.
- Contract test: every non-abstract value object of the package has exactly one type per branch.
- ORM round trip of an MH10.8.2 envelope with RS/GS/EOT characters, a hyphenated CAS number, a 14-digit IMEI and a DOI
  with Unicode in the suffix; the ODM round trip runs when MongoDB is reachable at `MONGODB_URI`.
- The ORM column length is the value object's `MAX_LENGTH` (vo-identifiers), no longer a copied number; tests assert it per
  type, assert that the samples cover every registered type, that each name is `id_` plus the snake case of the value object's
  short name, and pin the read of an empty value, a wrong check digit and a legacy non-canonical form.
