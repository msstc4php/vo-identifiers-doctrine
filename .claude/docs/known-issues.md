# Known issues

- Until `vo-identifiers` is tagged `v0.1.0`, `composer.json` (`^0.1`) does not resolve; only the `composer-ci.json` install
  (`dev-main as 0.1.0`) works, so the jobs that install from `composer.json` stay red. Neither GitHub repository exists yet (the
  owner creates `msstc4php/vo-identifiers` and `msstc4php/vo-identifiers-doctrine`); nothing is pushed.
- Covered MSI is 100 % with the types (it was 66.67 % on the empty registrars).
- `DataIdentifierField` implements `ValueObject` and `StringConvertible`, so it is a value object and has a type, although it is a part of a message; the completeness test would fail without it.
- The ODM round trip needs MongoDB; it is skipped when none answers at `MONGODB_URI`.
- **The ODM round-trip tests have never run locally** (no MongoDB in the sandbox, `OdmRoundTripTest` skips itself). CI is their first run: a red
  ODM job is a real first result, not necessarily a regression.
- `Imei::equals()` (14/15 digits) and `Isbn::equals()` (ISBN-10/13) span forms while the stored string keeps the form given: a UNIQUE column
  or string-keyed index sees two values. The types store the form as given on purpose (canonical form of the value object); callers normalise.
- Subscriber identities (`id_imsi`, `id_iccid`, `id_eid`, `id_imei`, `id_imeisv`) are stored unmasked; `masked()` is display only.
