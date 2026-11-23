# Integrations

- `msstc4php/vo-base-doctrine ^1.3` (abstract types) and `msstc4php/vo-identifiers ^1.0` (`dev-main as 1.0.0` in `composer-ci.json`,
  which also aliases `msstc4php/vo-gs1` `dev-main as 1.0.0` because vo-identifiers requires vo-gs1 `^1.0`). Release order: vo-gs1 1.0 →
  vo-identifiers 1.0 → this bridge; `composer.json` (and the lowest-deps job) resolves only once both are tagged. No direct `vo-base`
  requirement: the types use no `Payload` class. `msstc4php/vo-gs1` and `msstc4php/vo-base` are listed as VCS repositories. All reached
  through their GitHub repositories.
- Types: one per string value object of vo-identifiers (37 per branch); the table (name, class, column length, derivation) is in the README.
