<?php

declare(strict_types=1);

namespace MSSTC4PHP\ValueObject\Identifiers\Doctrine\Odm;

use MSSTC4PHP\ValueObject\Doctrine\Odm\AbstractStringVoType;
use MSSTC4PHP\ValueObject\Identifiers\Transport\IataAirportCode;
use Override;

final class IataAirportCodeType extends AbstractStringVoType
{
    public const string NAME = 'id_iata_airport_code';

    #[Override]
    protected function valueObjectClass(): string
    {
        return IataAirportCode::class;
    }
}
