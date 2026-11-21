<?php

declare(strict_types=1);

namespace MSSTC4PHP\ValueObject\Identifiers\Doctrine\Odm;

use MSSTC4PHP\ValueObject\Doctrine\Odm\AbstractStringVoType;
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
}
