<?php

declare(strict_types=1);

namespace MSSTC4PHP\ValueObject\Identifiers\Doctrine\Orm;

use MSSTC4PHP\ValueObject\Doctrine\Orm\AbstractStringVoType;
use MSSTC4PHP\ValueObject\Identifiers\Publication\Isni;
use Override;

final class IsniType extends AbstractStringVoType
{
    public const string NAME = 'id_isni';

    #[Override]
    protected function valueObjectClass(): string
    {
        return Isni::class;
    }

    #[Override]
    protected function columnLength(): int
    {
        return 16;
    }
}
