<?php

declare(strict_types=1);

namespace MSSTC4PHP\ValueObject\Identifiers\Doctrine\Odm;

use MSSTC4PHP\ValueObject\Doctrine\Odm\AbstractStringVoType;
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
}
