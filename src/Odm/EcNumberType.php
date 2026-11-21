<?php

declare(strict_types=1);

namespace MSSTC4PHP\ValueObject\Identifiers\Doctrine\Odm;

use MSSTC4PHP\ValueObject\Doctrine\Odm\AbstractStringVoType;
use MSSTC4PHP\ValueObject\Identifiers\Substance\EcNumber;
use Override;

final class EcNumberType extends AbstractStringVoType
{
    public const string NAME = 'id_ec_number';

    #[Override]
    protected function valueObjectClass(): string
    {
        return EcNumber::class;
    }
}
