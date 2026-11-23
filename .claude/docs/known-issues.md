# Known issues

- `composer.json` requires `vo-identifiers ^1.0`, which needs `vo-gs1 ^1.0`: until both are tagged only the `composer-ci.json` install
  (`dev-main as 1.0.0` for both) resolves, so the jobs that install from `composer.json` stay red until the release.
- Covered MSI is 100 % with the types (it was 66.67 % on the empty registrars).
- `DataIdentifierField` implements `ValueObject` and `StringConvertible`, so it is a value object and has a type, although it is a part of a message; the completeness test would fail without it.
- The ODM round trip needs MongoDB; it is skipped when none answers at `MONGODB_URI`.
- **The ODM round-trip tests have never run locally** (no MongoDB in the sandbox, `OdmRoundTripTest` skips itself). CI runs them against a
  MongoDB service; confirm that job is green on the commit tagged 1.0.0 (audit S9), as the storage format is frozen from then on.
- `Imei::equals()` (14/15 digits), `Isbn::equals()` (ISBN-10/13) and `Isan::equals()` (with/without check characters) span forms while the stored string keeps the form given: a UNIQUE column
  or string-keyed index sees two values. The types store the form as given on purpose (canonical form of the value object); callers normalise.
- Subscriber identities (`id_imsi`, `id_iccid`, `id_eid`, `id_imei`, `id_imeisv`) are stored unmasked; `masked()` is display only.
- **Column lengths come from `Vo::MAX_LENGTH`** (vo-identifiers, wave 3 review CR-009); the length-boundary tests (longest form, one
  character more is a format error) live in vo-identifiers `IdentifierContractTest`. `Tests\Support\Samples::strings()` must list every
  registered type in registrar order (`testTheSamplesCoverEveryRegisteredType`).
- Reading a legacy non-canonical stored form succeeds and normalises (the types call `Vo::from()`); a UNIQUE column can then hold the
  legacy and the canonical spelling of one value until rewritten.
