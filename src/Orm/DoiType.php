<?php

declare(strict_types=1);

namespace MSSTC4PHP\ValueObject\Identifiers\Doctrine\Orm;

use MSSTC4PHP\ValueObject\Doctrine\Orm\AbstractTextVoType;
use MSSTC4PHP\ValueObject\Identifiers\Publication\Doi;
use Override;

final class DoiType extends AbstractTextVoType
{
    public const string NAME = 'id_doi';

    #[Override]
    protected function valueObjectClass(): string
    {
        return Doi::class;
    }
}
