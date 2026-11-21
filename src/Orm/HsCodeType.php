<?php

declare(strict_types=1);

namespace MSSTC4PHP\ValueObject\Identifiers\Doctrine\Orm;

use MSSTC4PHP\ValueObject\Doctrine\Orm\AbstractStringVoType;
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

    #[Override]
    protected function columnLength(): int
    {
        return HsCode::MAX_LENGTH;
    }
}
