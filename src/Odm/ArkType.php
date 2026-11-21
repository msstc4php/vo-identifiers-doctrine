<?php

declare(strict_types=1);

namespace MSSTC4PHP\ValueObject\Identifiers\Doctrine\Odm;

use MSSTC4PHP\ValueObject\Doctrine\Odm\AbstractStringVoType;
use MSSTC4PHP\ValueObject\Identifiers\Publication\Ark;
use Override;

final class ArkType extends AbstractStringVoType
{
    public const string NAME = 'id_ark';

    #[Override]
    protected function valueObjectClass(): string
    {
        return Ark::class;
    }
}
