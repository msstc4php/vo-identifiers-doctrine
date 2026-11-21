# Known issues

- Until `vo-identifiers` is tagged `v0.1.0`, `composer.json` (`^0.1`) does not resolve; only the `composer-ci.json` install
  (`dev-main as 0.1.0`) works, so the jobs that install from `composer.json` stay red. Neither GitHub repository exists yet (the
  owner creates `msstc4php/vo-identifiers` and `msstc4php/vo-identifiers-doctrine`); nothing is pushed.
- Covered MSI is 100 % with the types (it was 66.67 % on the empty registrars).
- `DataIdentifierField` implements `ValueObject` and `StringConvertible`, so it is a value object and has a type, although it is a part of a message; the completeness test would fail without it.
- The ODM round trip needs MongoDB; it is skipped when none answers at `MONGODB_URI`.
