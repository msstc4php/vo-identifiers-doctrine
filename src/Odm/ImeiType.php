<?php

declare(strict_types=1);

namespace MSSTC4PHP\ValueObject\Identifiers\Doctrine\Odm;

use MSSTC4PHP\ValueObject\Doctrine\Odm\AbstractStringVoType;
use MSSTC4PHP\ValueObject\Identifiers\Telecom\Imei;
use Override;

final class ImeiType extends AbstractStringVoType
{
    public const string NAME = 'id_imei';

    #[Override]
    protected function valueObjectClass(): string
    {
        return Imei::class;
    }
}
