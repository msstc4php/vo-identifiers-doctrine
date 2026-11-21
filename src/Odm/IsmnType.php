<?php

declare(strict_types=1);

namespace MSSTC4PHP\ValueObject\Identifiers\Doctrine\Odm;

use MSSTC4PHP\ValueObject\Doctrine\Odm\AbstractStringVoType;
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
}
