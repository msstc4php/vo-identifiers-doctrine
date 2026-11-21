<?php

declare(strict_types=1);

namespace MSSTC4PHP\ValueObject\Identifiers\Doctrine\Orm;

use MSSTC4PHP\ValueObject\Doctrine\Orm\AbstractTextVoType;
use MSSTC4PHP\ValueObject\Identifiers\Publication\Ark;
use Override;

final class ArkType extends AbstractTextVoType
{
    public const string NAME = 'id_ark';

    #[Override]
    protected function valueObjectClass(): string
    {
        return Ark::class;
    }
}
