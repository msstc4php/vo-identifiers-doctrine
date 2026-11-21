<?php

declare(strict_types=1);

namespace MSSTC4PHP\ValueObject\Identifiers\Doctrine\Odm;

use MSSTC4PHP\ValueObject\Doctrine\Odm\AbstractStringVoType;
use MSSTC4PHP\ValueObject\Identifiers\Publication\Isan;
use Override;

final class IsanType extends AbstractStringVoType
{
    public const string NAME = 'id_isan';

    #[Override]
    protected function valueObjectClass(): string
    {
        return Isan::class;
    }
}
