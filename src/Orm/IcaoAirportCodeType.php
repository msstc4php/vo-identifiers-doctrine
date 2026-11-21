<?php

declare(strict_types=1);

namespace MSSTC4PHP\ValueObject\Identifiers\Doctrine\Orm;

use MSSTC4PHP\ValueObject\Doctrine\Orm\AbstractStringVoType;
use MSSTC4PHP\ValueObject\Identifiers\Transport\IcaoAirportCode;
use Override;

final class IcaoAirportCodeType extends AbstractStringVoType
{
    public const string NAME = 'id_icao_airport_code';

    #[Override]
    protected function valueObjectClass(): string
    {
        return IcaoAirportCode::class;
    }

    #[Override]
    protected function columnLength(): int
    {
        return IcaoAirportCode::MAX_LENGTH;
    }
}
