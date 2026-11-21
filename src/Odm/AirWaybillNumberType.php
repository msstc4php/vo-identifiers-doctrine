<?php

declare(strict_types=1);

namespace MSSTC4PHP\ValueObject\Identifiers\Doctrine\Odm;

use MSSTC4PHP\ValueObject\Doctrine\Odm\AbstractStringVoType;
use MSSTC4PHP\ValueObject\Identifiers\Transport\AirWaybillNumber;
use Override;

final class AirWaybillNumberType extends AbstractStringVoType
{
    public const string NAME = 'id_air_waybill_number';

    #[Override]
    protected function valueObjectClass(): string
    {
        return AirWaybillNumber::class;
    }
}
