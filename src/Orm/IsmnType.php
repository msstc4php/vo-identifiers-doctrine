<?php

declare(strict_types=1);

namespace MSSTC4PHP\ValueObject\Identifiers\Doctrine\Orm;

use MSSTC4PHP\ValueObject\Doctrine\Orm\AbstractStringVoType;
use MSSTC4PHP\ValueObject\Identifiers\Publication\Ismn;
use Override;

final class IsmnType extends AbstractStringVoType
{
    public const string NAME = 'id_ismn';

    #[Override]
    protected function valueObjectClass(): string
    {
        return Ismn::class;
    }

    #[Override]
    protected function columnLength(): int
    {
        return Ismn::MAX_LENGTH;
    }
}
