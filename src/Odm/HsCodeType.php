<?php

declare(strict_types=1);

namespace MSSTC4PHP\ValueObject\Identifiers\Doctrine\Odm;

use MSSTC4PHP\ValueObject\Doctrine\Odm\AbstractStringVoType;
use MSSTC4PHP\ValueObject\Identifiers\Trade\HsCode;
use Override;

final class HsCodeType extends AbstractStringVoType
{
    public const string NAME = 'id_hs_code';

    #[Override]
    protected function valueObjectClass(): string
    {
        return HsCode::class;
    }
}
