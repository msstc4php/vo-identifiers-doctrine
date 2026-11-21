<?php

declare(strict_types=1);

namespace MSSTC4PHP\ValueObject\Identifiers\Doctrine\Odm;

use MSSTC4PHP\ValueObject\Doctrine\Odm\AbstractStringVoType;
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
}
