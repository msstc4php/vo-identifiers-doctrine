# Known issues

- Until `vo-identifiers` is tagged `v0.1.0`, `composer.json` (`^0.1`) does not resolve; only the `composer-ci.json` install
  (`dev-main as 0.1.0`) works, so the jobs that install from `composer.json` stay red. Neither GitHub repository exists yet (the
  owner creates `msstc4php/vo-identifiers` and `msstc4php/vo-identifiers-doctrine`); nothing is pushed.
- With no type registered, `TypeRegistrarTest` and the registrars' mutants have nothing to exercise; the first types fill them.
