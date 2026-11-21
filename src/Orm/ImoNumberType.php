<?php

declare(strict_types=1);

namespace MSSTC4PHP\ValueObject\Identifiers\Doctrine\Orm;

use MSSTC4PHP\ValueObject\Doctrine\Orm\AbstractStringVoType;
use MSSTC4PHP\ValueObject\Identifiers\Transport\ImoNumber;
use Override;

final class ImoNumberType extends AbstractStringVoType
{
    public const string NAME = 'id_imo_number';

    #[Override]
    protected function valueObjectClass(): string
    {
        return ImoNumber::class;
    }

    #[Override]
    protected function columnLength(): int
    {
        return ImoNumber::MAX_LENGTH;
    }
}
