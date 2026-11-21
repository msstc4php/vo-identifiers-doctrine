<?php

declare(strict_types=1);

namespace MSSTC4PHP\ValueObject\Identifiers\Doctrine\Orm;

use MSSTC4PHP\ValueObject\Doctrine\Orm\AbstractStringVoType;
use MSSTC4PHP\ValueObject\Identifiers\Transport\Wmi;
use Override;

final class WmiType extends AbstractStringVoType
{
    public const string NAME = 'id_wmi';

    #[Override]
    protected function valueObjectClass(): string
    {
        return Wmi::class;
    }

    #[Override]
    protected function columnLength(): int
    {
        return 3;
    }
}
