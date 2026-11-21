<?php

declare(strict_types=1);

namespace MSSTC4PHP\ValueObject\Identifiers\Doctrine\Orm;

use MSSTC4PHP\ValueObject\Doctrine\Orm\AbstractStringVoType;
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

    #[Override]
    protected function columnLength(): int
    {
        return IataAirportCode::MAX_LENGTH;
    }
}
