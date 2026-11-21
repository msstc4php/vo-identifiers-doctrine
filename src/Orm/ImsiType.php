<?php

declare(strict_types=1);

namespace MSSTC4PHP\ValueObject\Identifiers\Doctrine\Orm;

use MSSTC4PHP\ValueObject\Doctrine\Orm\AbstractStringVoType;
use MSSTC4PHP\ValueObject\Identifiers\Telecom\Imsi;
use Override;

final class ImsiType extends AbstractStringVoType
{
    public const string NAME = 'id_imsi';

    #[Override]
    protected function valueObjectClass(): string
    {
        return Imsi::class;
    }

    #[Override]
    protected function columnLength(): int
    {
        return Imsi::MAX_LENGTH;
    }
}
