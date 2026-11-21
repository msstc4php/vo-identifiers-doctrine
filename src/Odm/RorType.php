<?php

declare(strict_types=1);

namespace MSSTC4PHP\ValueObject\Identifiers\Doctrine\Odm;

use MSSTC4PHP\ValueObject\Doctrine\Odm\AbstractStringVoType;
use MSSTC4PHP\ValueObject\Identifiers\Publication\Ror;
use Override;

final class RorType extends AbstractStringVoType
{
    public const string NAME = 'id_ror';

    #[Override]
    protected function valueObjectClass(): string
    {
        return Ror::class;
    }
}
