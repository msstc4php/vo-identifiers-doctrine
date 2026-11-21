<?php

declare(strict_types=1);

namespace MSSTC4PHP\ValueObject\Identifiers\Doctrine\Odm;

use MSSTC4PHP\ValueObject\Doctrine\Odm\AbstractStringVoType;
use MSSTC4PHP\ValueObject\Identifiers\Transport\ContainerNumber;
use Override;

final class ContainerNumberType extends AbstractStringVoType
{
    public const string NAME = 'id_container_number';

    #[Override]
    protected function valueObjectClass(): string
    {
        return ContainerNumber::class;
    }
}
