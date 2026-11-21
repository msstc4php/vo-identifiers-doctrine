<?php

declare(strict_types=1);

namespace MSSTC4PHP\ValueObject\Identifiers\Doctrine\Orm;

use MSSTC4PHP\ValueObject\Doctrine\Orm\AbstractStringVoType;
use MSSTC4PHP\ValueObject\Identifiers\Substance\UnNumber;
use Override;

final class UnNumberType extends AbstractStringVoType
{
    public const string NAME = 'id_un_number';

    #[Override]
    protected function valueObjectClass(): string
    {
        return UnNumber::class;
    }

    #[Override]
    protected function columnLength(): int
    {
        return UnNumber::MAX_LENGTH;
    }
}
