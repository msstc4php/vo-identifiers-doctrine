<?php

declare(strict_types=1);

namespace MSSTC4PHP\ValueObject\Identifiers\Doctrine\Orm;

use MSSTC4PHP\ValueObject\Doctrine\Orm\AbstractStringVoType;
use MSSTC4PHP\ValueObject\Identifiers\Substance\CasRegistryNumber;
use Override;

final class CasRegistryNumberType extends AbstractStringVoType
{
    public const string NAME = 'id_cas_registry_number';

    #[Override]
    protected function valueObjectClass(): string
    {
        return CasRegistryNumber::class;
    }

    #[Override]
    protected function columnLength(): int
    {
        return CasRegistryNumber::MAX_LENGTH;
    }
}
