<?php

declare(strict_types=1);

namespace MSSTC4PHP\ValueObject\Identifiers\Doctrine\Orm;

use MSSTC4PHP\ValueObject\Doctrine\Orm\AbstractStringVoType;
use MSSTC4PHP\ValueObject\Identifiers\Telecom\Iccid;
use Override;

final class IccidType extends AbstractStringVoType
{
    public const string NAME = 'id_iccid';

    #[Override]
    protected function valueObjectClass(): string
    {
        return Iccid::class;
    }

    #[Override]
    protected function columnLength(): int
    {
        return 20;
    }
}
