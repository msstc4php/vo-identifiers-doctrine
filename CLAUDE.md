# CLAUDE.md

Guidance for Claude Code in this repository. Deep references live under `.claude/docs/`.

## What this is

`msstc4php/vo-identifiers-doctrine`: Doctrine ORM and MongoDB ODM types for `msstc4php/vo-identifiers` (publication, transport,
telecom, substance, trade and energy identifiers). Built on the abstract types of `msstc4php/vo-base-doctrine`.
PHP >= 8.4. No Symfony dependency; `Orm` and `Odm` never see each other (`deptrac.yaml`). One ORM and one ODM
type per string value object (37 per branch), registered in both `TypeRegistrar`s.

## Common commands

Local install against the sibling checkouts (`../vo-base`, `../vo-base-doctrine`, `../vo-gs1`, `../vo-identifiers`):
`COMPOSER=composer-local.json composer update --ignore-platform-req=php`. In CI the install is `composer-ci.json`.

`composer-local.json` is gitignored. Create it from `composer-ci.json`: replace the four VCS repositories with path
repositories (`{"type": "path", "url": "../vo-base", "options": {"symlink": true}}`, same for `../vo-base-doctrine`,
`../vo-gs1` and `../vo-identifiers`) and require `msstc4php/vo-base-doctrine` and `msstc4php/vo-base` as `dev-main as 1.3.0` and
`msstc4php/vo-gs1` as `dev-main as 0.1.0` and `msstc4php/vo-identifiers` as `dev-main as 0.2.0`.

- `COMPOSER=composer-local.json make check`, `make test`, `make infection`, `make fix`.
- The ODM integration tests need MongoDB (`MONGODB_URI`, default `mongodb://127.0.0.1:27017`) and skip themselves
  otherwise.

## Standard

Tool configuration is byte-identical to the `php84` templates of `msstc4symfony/bundle-standard`; CI's `templates` job
enforces it. Do not edit `.php-cs-fixer.dist.php`, `rector.php`, `phpstan*.neon`, `phpunit.xml.dist`,
`infection.json5`, `Makefile` or `.gitignore` here. The hex layout of that standard does not apply.

## Adding a class of `vo-identifiers`

Every non-abstract value object that is a `ValueObject` needs one ORM and one ODM type named `id_<snake_name>` (snake case
of the class short name; column length = the class's maximum length; above 4000 characters, or with no bound in the
library, the text type), registered in both `TypeRegistrar`s. Then add a sample to the test support, a contract test that
every value object has a type, and a row to the README table. Classes that are not `ValueObject` (enums, DTOs,
`Internal\`) get no type.
