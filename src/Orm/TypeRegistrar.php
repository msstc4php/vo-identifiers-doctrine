<?php

declare(strict_types=1);

namespace MSSTC4PHP\ValueObject\Identifiers\Doctrine\Orm;

use Doctrine\DBAL\Types\Type;

/**
 * Registers every identifier value-object type. Call once at bootstrap for bare Doctrine; under Symfony map {@see types()}
 * under `doctrine.dbal.types` instead. Registration is idempotent, so it is safe in long-running workers.
 */
final class TypeRegistrar
{
    /**
     * @var array<non-empty-string, class-string<Type>>
     */
    private const array TYPES = [];

    public static function registerAll(): void
    {
        foreach (self::types() as $name => $class) {
            if (!Type::hasType($name)) {
                Type::addType($name, $class);
            }
        }
    }

    /**
     * @return array<non-empty-string, class-string<Type>>
     */
    public static function types(): array
    {
        return self::TYPES;
    }
}
