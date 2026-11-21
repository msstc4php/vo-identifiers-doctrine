# Conventions

- Type names `id_<snake_name>` from the class short name (`id_isbn`, `id_container_number`, `id_imei`); `TypeRegistrarTest`
  checks the pattern. A short name shared by two classes of vo-identifiers would need a regional prefix.
- ODM types cannot be built directly (see `vo-base-doctrine`): tests go through `Type::getType($name)` after `registerAll()`.
- Sample, contract and integration tests follow the layout of `vo-finance-doctrine` (`tests/Support/Samples.php`,
  `tests/Support/{Orm,Odm}/`, `tests/Unit/Contract/`). `Samples::strings()` holds one row per type with an at-max sample (one more character must be refused); text types carry length 0.
- A `ValueObject` that is not a string (enum, DTO) or an `Internal\` helper gets no type; the contract test fails on a missing or extra one.
  Classes that cache state derived in `parse()` (vo-identifiers: `Internal\ReparsesOnUnserialize`) round-trip through their `value` alone, so the types need nothing special.
