# Known issues

- Until `vo-identifiers` is tagged `v0.1.0`, `composer.json` (`^0.1`) does not resolve; only the `composer-ci.json` install
  (`dev-main as 0.1.0`) works, so the jobs that install from `composer.json` stay red. Neither GitHub repository exists yet (the
  owner creates `msstc4php/vo-identifiers` and `msstc4php/vo-identifiers-doctrine`); nothing is pushed.
- Covered MSI is 66.67 % on the empty registrars (`Foreach_` in both `registerAll()` cannot be killed with no type), so CI's `--min-covered-msi=75` fails until Task 6 adds types (ruling 8). Nothing is pushed before the repositories exist.
