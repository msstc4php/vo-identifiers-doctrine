<?php

declare(strict_types=1);

namespace MSSTC4PHP\ValueObject\Identifiers\Doctrine\Orm;

use MSSTC4PHP\ValueObject\Doctrine\Orm\AbstractStringVoType;
use MSSTC4PHP\ValueObject\Identifiers\Transport\Vin;
use Override;

final class VinType extends AbstractStringVoType
{
    public const string NAME = 'id_vin';

    #[Override]
    protected function valueObjectClass(): string
    {
        return Vin::class;
    }

    #[Override]
    protected function columnLength(): int
    {
        return 17;
    }
}
