<?php

declare(strict_types=1);

namespace MSSTC4PHP\ValueObject\Identifiers\Doctrine\Orm;

use MSSTC4PHP\ValueObject\Doctrine\Orm\AbstractStringVoType;
use MSSTC4PHP\ValueObject\Identifiers\Trade\TariffCode;
use Override;

final class TariffCodeType extends AbstractStringVoType
{
    public const string NAME = 'id_tariff_code';

    #[Override]
    protected function valueObjectClass(): string
    {
        return TariffCode::class;
    }

    #[Override]
    protected function columnLength(): int
    {
        return 10;
    }
}
