<?php

declare(strict_types=1);

namespace MSSTC4PHP\ValueObject\Identifiers\Doctrine\Orm;

use MSSTC4PHP\ValueObject\Doctrine\Orm\AbstractStringVoType;
use MSSTC4PHP\ValueObject\Identifiers\Transport\UnLocode;
use Override;

final class UnLocodeType extends AbstractStringVoType
{
    public const string NAME = 'id_un_locode';

    #[Override]
    protected function valueObjectClass(): string
    {
        return UnLocode::class;
    }

    #[Override]
    protected function columnLength(): int
    {
        return 5;
    }
}
