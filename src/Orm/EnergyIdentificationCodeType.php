<?php

declare(strict_types=1);

namespace MSSTC4PHP\ValueObject\Identifiers\Doctrine\Orm;

use MSSTC4PHP\ValueObject\Doctrine\Orm\AbstractStringVoType;
use MSSTC4PHP\ValueObject\Identifiers\Energy\EnergyIdentificationCode;
use Override;

final class EnergyIdentificationCodeType extends AbstractStringVoType
{
    public const string NAME = 'id_energy_identification_code';

    #[Override]
    protected function valueObjectClass(): string
    {
        return EnergyIdentificationCode::class;
    }

    #[Override]
    protected function columnLength(): int
    {
        return 16;
    }
}
