# Changelog

## [Unreleased]

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
