<?php

declare(strict_types=1);

namespace MSSTC4PHP\ValueObject\Identifiers\Doctrine\Odm;

use MSSTC4PHP\ValueObject\Doctrine\Odm\AbstractStringVoType;
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
}
