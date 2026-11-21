<?php

declare(strict_types=1);

namespace MSSTC4PHP\ValueObject\Identifiers\Doctrine\Odm;

use MSSTC4PHP\ValueObject\Doctrine\Odm\AbstractStringVoType;
use MSSTC4PHP\ValueObject\Identifiers\Energy\Mpan;
use Override;

final class MpanType extends AbstractStringVoType
{
    public const string NAME = 'id_mpan';

    #[Override]
    protected function valueObjectClass(): string
    {
        return Mpan::class;
    }
}
