<?php

declare(strict_types=1);

namespace MSSTC4PHP\ValueObject\Identifiers\Doctrine\Odm;

use MSSTC4PHP\ValueObject\Doctrine\Odm\AbstractStringVoType;
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
}
