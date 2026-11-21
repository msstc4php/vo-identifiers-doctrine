<?php

declare(strict_types=1);

namespace MSSTC4PHP\ValueObject\Identifiers\Doctrine\Orm;

use MSSTC4PHP\ValueObject\Doctrine\Orm\AbstractStringVoType;
use MSSTC4PHP\ValueObject\Identifiers\Transport\Mmsi;
use Override;

final class MmsiType extends AbstractStringVoType
{
    public const string NAME = 'id_mmsi';

    #[Override]
    protected function valueObjectClass(): string
    {
        return Mmsi::class;
    }

    #[Override]
    protected function columnLength(): int
    {
        return Mmsi::MAX_LENGTH;
    }
}
