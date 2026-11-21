<?php

declare(strict_types=1);

namespace MSSTC4PHP\ValueObject\Identifiers\Doctrine\Orm;

use MSSTC4PHP\ValueObject\Doctrine\Orm\AbstractStringVoType;
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

    #[Override]
    protected function columnLength(): int
    {
        return ContainerNumber::MAX_LENGTH;
    }
}
