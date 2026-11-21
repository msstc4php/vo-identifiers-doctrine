<?php

declare(strict_types=1);

namespace MSSTC4PHP\ValueObject\Identifiers\Doctrine\Odm;

use MSSTC4PHP\ValueObject\Doctrine\Odm\AbstractStringVoType;
use MSSTC4PHP\ValueObject\Identifiers\Transport\UicVehicleNumber;
use Override;

final class UicVehicleNumberType extends AbstractStringVoType
{
    public const string NAME = 'id_uic_vehicle_number';

    #[Override]
    protected function valueObjectClass(): string
    {
        return UicVehicleNumber::class;
    }
}
