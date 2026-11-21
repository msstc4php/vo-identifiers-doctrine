<?php

declare(strict_types=1);

namespace MSSTC4PHP\ValueObject\Identifiers\Doctrine\Orm;

use MSSTC4PHP\ValueObject\Doctrine\Orm\AbstractStringVoType;
use MSSTC4PHP\ValueObject\Identifiers\Publication\Orcid;
use Override;

final class OrcidType extends AbstractStringVoType
{
    public const string NAME = 'id_orcid';

    #[Override]
    protected function valueObjectClass(): string
    {
        return Orcid::class;
    }

    #[Override]
    protected function columnLength(): int
    {
        return Orcid::MAX_LENGTH;
    }
}
