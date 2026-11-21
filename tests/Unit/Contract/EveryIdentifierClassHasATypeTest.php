<?php

declare(strict_types=1);

namespace MSSTC4PHP\ValueObject\Identifiers\Doctrine\Tests\Unit\Contract;

use Doctrine\DBAL\Types\Type as OrmType;
use Doctrine\ODM\MongoDB\Types\Type as OdmType;
use FilesystemIterator;
use MSSTC4PHP\ValueObject\Contract\StringConvertible;
use MSSTC4PHP\ValueObject\Contract\ValueObject;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Odm\TypeRegistrar as OdmRegistrar;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Orm\TypeRegistrar as OrmRegistrar;
use MSSTC4PHP\ValueObject\Identifiers\Energy\EicObjectType;
use MSSTC4PHP\ValueObject\Identifiers\Publication\Isbn;
use MSSTC4PHP\ValueObject\Identifiers\Publication\PublicationIdentifierFactory;
use MSSTC4PHP\ValueObject\Identifiers\Transport\MmsiType;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use ReflectionClass;
use ReflectionMethod;
use SplFileInfo;

#[CoversNothing]
final class EveryIdentifierClassHasATypeTest extends TestCase
{
    /**
     * @return iterable<string, array{'orm'|'odm'}>
     */
    public static function branches(): iterable
    {
        yield 'orm' => ['orm'];
        yield 'odm' => ['odm'];
    }

    /**
     * @param 'orm'|'odm' $branch
     */
    #[DataProvider('branches')]
    public function testEveryValueObjectHasExactlyOneType(string $branch): void
    {
        $mapped = [];
        foreach ($this->typeValueObjectClasses($branch) as $name => $class) {
            $mapped[$class][] = $name;
        }

        foreach ($this->valueObjectClasses() as $class) {
            self::assertCount(1, $mapped[$class] ?? [], \sprintf('%s needs exactly one %s type.', $class, $branch));
        }
    }

    /**
     * @param 'orm'|'odm' $branch
     */
    #[DataProvider('branches')]
    public function testNoTypeMapsAClassOutsideThePackage(string $branch): void
    {
        $expected = $this->valueObjectClasses();

        foreach ($this->typeValueObjectClasses($branch) as $name => $class) {
            self::assertContains(
                $class,
                $expected,
                \sprintf('Type "%s" maps %s, which is not a identifier value object.', $name, $class),
            );
        }
    }

    public function testBothBranchesRegisterTheSameNames(): void
    {
        self::assertSame(\array_keys(OrmRegistrar::types()), \array_keys(OdmRegistrar::types()));
    }

    public function testDiscoveryFindsTheStringValueObjectsOnly(): void
    {
        $classes = $this->valueObjectClasses();

        self::assertContains(Isbn::class, $classes);
        self::assertCount(37, $classes);
        foreach ($classes as $class) {
            self::assertStringNotContainsString('\\Internal\\', $class);
            self::assertStringNotContainsString('Exception', $class);
        }
    }

    /**
     * Enums and the factories are not value objects: they are never a column and get no type.
     */
    public function testEnumsAndFactoriesAreNotValueObjectsAndGetNoType(): void
    {
        $mapped = \array_merge(\array_values($this->typeValueObjectClasses('orm')), \array_values($this->typeValueObjectClasses('odm')));

        foreach ([EicObjectType::class, MmsiType::class, PublicationIdentifierFactory::class] as $part) {
            self::assertFalse(new ReflectionClass($part)->implementsInterface(ValueObject::class), $part);
            self::assertNotContains($part, $mapped, $part);
        }
    }

    /**
     * @return list<class-string> the non-abstract value objects outside Internal, all of them string value objects
     */
    private function valueObjectClasses(): array
    {
        $classes = [];
        foreach ($this->sourceClasses() as $reflection) {
            if (!$reflection->implementsInterface(ValueObject::class)) {
                continue;
            }

            self::assertTrue(
                $reflection->implementsInterface(StringConvertible::class),
                \sprintf('%s is a value object without a string form; it needs a codec-style type.', $reflection->getName()),
            );
            $classes[] = $reflection->getName();
        }

        \sort($classes);

        return $classes;
    }

    /**
     * @return iterable<int, ReflectionClass<object>>
     */
    private function sourceClasses(): iterable
    {
        $isbnFile = new ReflectionClass(Isbn::class)->getFileName();
        self::assertIsString($isbnFile);
        $source = \dirname($isbnFile, 2);
        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source, FilesystemIterator::SKIP_DOTS));

        foreach ($files as $file) {
            self::assertInstanceOf(SplFileInfo::class, $file);
            $path = $file->getPathname();
            if (!\str_ends_with($path, '.php')) {
                continue;
            }

            $class = 'MSSTC4PHP\\ValueObject\\Identifiers\\' . \str_replace(
                '/',
                '\\',
                \substr($path, \strlen($source) + 1, -4),
            );
            if (\str_starts_with($class, 'MSSTC4PHP\\ValueObject\\Identifiers\\Internal\\') || !\class_exists($class)) {
                continue;
            }

            $reflection = new ReflectionClass($class);
            if ($reflection->isAbstract() || $reflection->isEnum()) {
                continue;
            }

            yield $reflection;
        }
    }

    /**
     * @param 'orm'|'odm' $branch
     *
     * @return array<string, class-string>
     */
    private function typeValueObjectClasses(string $branch): array
    {
        $classes = [];
        if ($branch === 'orm') {
            OrmRegistrar::registerAll();
            foreach (OrmRegistrar::types() as $name => $_) {
                $classes[$name] = $this->mappedClass(OrmType::getType($name));
            }

            return $classes;
        }

        OdmRegistrar::registerAll();
        foreach (OdmRegistrar::types() as $name => $_) {
            $classes[$name] = $this->mappedClass(OdmType::getType($name));
        }

        return $classes;
    }

    /**
     * @return class-string
     */
    private function mappedClass(object $type): string
    {
        $class = new ReflectionMethod($type, 'valueObjectClass')->invoke($type);

        self::assertIsString($class);
        self::assertTrue(\class_exists($class));

        return $class;
    }
}
