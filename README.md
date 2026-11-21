# msstc4php/vo-identifiers-doctrine

Doctrine ORM (DBAL) and MongoDB ODM types for [`msstc4php/vo-identifiers`](https://github.com/msstc4php/vo-identifiers), built on
[`msstc4php/vo-base-doctrine`](https://github.com/msstc4php/vo-base-doctrine). PHP >= 8.4, no Symfony dependency.

## Status

Scaffold: `Orm\TypeRegistrar` and `Odm\TypeRegistrar` exist and register no type yet. One type per string value object of
`vo-identifiers` follows, named `id_<snake_name>` (`id_isbn`, `id_container_number`, `id_imei`), with the column length of the
longest value the class accepts.

## Install

Not on Packagist yet; register the GitHub repositories:

```json
{
    "repositories": [
        { "type": "vcs", "url": "https://github.com/msstc4php/vo-base" },
        { "type": "vcs", "url": "https://github.com/msstc4php/vo-base-doctrine" },
        { "type": "vcs", "url": "https://github.com/msstc4php/vo-gs1" },
        { "type": "vcs", "url": "https://github.com/msstc4php/vo-identifiers" },
        { "type": "vcs", "url": "https://github.com/msstc4php/vo-identifiers-doctrine" }
    ],
    "require": {
        "msstc4php/vo-identifiers-doctrine": "^0.1"
    }
}
```

Runtime requirements: `msstc4php/vo-identifiers`, `msstc4php/vo-base-doctrine ^1.2`; `doctrine/dbal` (ORM) or
`doctrine/mongodb-odm` (ODM) is yours.

## Usage

Bare Doctrine: call `Orm\TypeRegistrar::registerAll()` (or `Odm\TypeRegistrar::registerAll()`) once at bootstrap.
Symfony: map `TypeRegistrar::types()` under `doctrine.dbal.types` (ORM) or `doctrine_mongodb.odm.types` (ODM).

## License

MIT, see [`LICENSE`](LICENSE).
