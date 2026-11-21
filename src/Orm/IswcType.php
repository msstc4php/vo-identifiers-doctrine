<?php

declare(strict_types=1);

namespace MSSTC4PHP\ValueObject\Identifiers\Doctrine\Orm;

use MSSTC4PHP\ValueObject\Doctrine\Orm\AbstractStringVoType;
use MSSTC4PHP\ValueObject\Identifiers\Publication\Iswc;
use Override;

final class IswcType extends AbstractStringVoType
{
    public const string NAME = 'id_iswc';

    #[Override]
    protected function valueObjectClass(): string
    {
        return Iswc::class;
    }

    #[Override]
    protected function columnLength(): int
    {
        return Iswc::MAX_LENGTH;
    }
}
