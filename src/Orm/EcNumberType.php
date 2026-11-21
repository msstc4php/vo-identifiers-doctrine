<?php

declare(strict_types=1);

namespace MSSTC4PHP\ValueObject\Identifiers\Doctrine\Orm;

use MSSTC4PHP\ValueObject\Doctrine\Orm\AbstractStringVoType;
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

    #[Override]
    protected function columnLength(): int
    {
        return 9;
    }
}
