<?php

declare(strict_types=1);

namespace MSSTC4PHP\ValueObject\Identifiers\Doctrine\Orm;

use MSSTC4PHP\ValueObject\Doctrine\Orm\AbstractStringVoType;
use MSSTC4PHP\ValueObject\Identifiers\Publication\Isbn;
use Override;

final class IsbnType extends AbstractStringVoType
{
    public const string NAME = 'id_isbn';

    #[Override]
    protected function valueObjectClass(): string
    {
        return Isbn::class;
    }

    #[Override]
    protected function columnLength(): int
    {
        return 13;
    }
}
