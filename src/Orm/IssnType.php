<?php

declare(strict_types=1);

namespace MSSTC4PHP\ValueObject\Identifiers\Doctrine\Orm;

use MSSTC4PHP\ValueObject\Doctrine\Orm\AbstractStringVoType;
use MSSTC4PHP\ValueObject\Identifiers\Publication\Issn;
use Override;

final class IssnType extends AbstractStringVoType
{
    public const string NAME = 'id_issn';

    #[Override]
    protected function valueObjectClass(): string
    {
        return Issn::class;
    }

    #[Override]
    protected function columnLength(): int
    {
        return 9;
    }
}
