<?php

declare(strict_types=1);

namespace MSSTC4PHP\ValueObject\Identifiers\Doctrine\Orm;

use MSSTC4PHP\ValueObject\Doctrine\Orm\AbstractStringVoType;
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

    #[Override]
    protected function columnLength(): int
    {
        return Ror::MAX_LENGTH;
    }
}
