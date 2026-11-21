<?php

declare(strict_types=1);

namespace MSSTC4PHP\ValueObject\Identifiers\Doctrine\Odm;

use MSSTC4PHP\ValueObject\Doctrine\Odm\AbstractStringVoType;
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
}
