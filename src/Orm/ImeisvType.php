<?php

declare(strict_types=1);

namespace MSSTC4PHP\ValueObject\Identifiers\Doctrine\Orm;

use MSSTC4PHP\ValueObject\Doctrine\Orm\AbstractStringVoType;
use MSSTC4PHP\ValueObject\Identifiers\Telecom\Imeisv;
use Override;

final class ImeisvType extends AbstractStringVoType
{
    public const string NAME = 'id_imeisv';

    #[Override]
    protected function valueObjectClass(): string
    {
        return Imeisv::class;
    }

    #[Override]
    protected function columnLength(): int
    {
        return 16;
    }
}
