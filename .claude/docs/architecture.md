# Architecture

Two independent branches, no shared code (`deptrac.yaml`: `Orm` and `Odm` have no rules, so neither may see the other).

- `src/Orm/*Type.php`: `final` subclasses of `MSSTC4PHP\ValueObject\Doctrine\Orm\AbstractStringVoType` (value object class and
  column length); above 4000 characters the text type is used, as in `vo-gs1-doctrine`.
- `src/Odm/*Type.php`: the same over `Odm\AbstractStringVoType`; no column length.
- `Orm\TypeRegistrar` / `Odm\TypeRegistrar`: `registerAll()` (idempotent) and `types()` (name => class). Together they register the 37 types
  (one per string value object, `DataIdentifierField` included); five are text types: `Ark`, `Doi`, `DataIdentifierField`,
  `DataIdentifierString`, `Iso15459Identifier`.
