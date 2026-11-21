<?php

declare(strict_types=1);

namespace MSSTC4PHP\ValueObject\Identifiers\Doctrine\Tests\Unit\Orm;

use Doctrine\DBAL\Types\Type;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Orm\TypeRegistrar;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(TypeRegistrar::class)]
final class TypeRegistrarTest extends TestCase
{
    public function testRegistersEveryTypeAndIsIdempotent(): void
    {
        TypeRegistrar::registerAll();
        TypeRegistrar::registerAll();

        foreach (TypeRegistrar::types() as $name => $class) {
            self::assertTrue(Type::hasType($name), \sprintf('Type "%s" was not registered.', $name));
            self::assertInstanceOf($class, Type::getType($name));
        }

        self::assertCount(0, \array_diff_key(TypeRegistrar::types(), Type::getTypesMap()));
    }

    public function testNamesFollowThePrefixConvention(): void
    {
        foreach (\array_keys(TypeRegistrar::types()) as $name) {
            self::assertMatchesRegularExpression('/^id_[a-z0-9]+(?:_[a-z0-9]+)*$/', $name);
        }

        self::assertContainsOnlyString(\array_keys(TypeRegistrar::types()));
    }
}
