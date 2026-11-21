<?php

declare(strict_types=1);

namespace MSSTC4PHP\ValueObject\Identifiers\Doctrine\Orm;

use MSSTC4PHP\ValueObject\Doctrine\Orm\AbstractStringVoType;
use MSSTC4PHP\ValueObject\Identifiers\Transport\S10ItemIdentifier;
use Override;

final class S10ItemIdentifierType extends AbstractStringVoType
{
    public const string NAME = 'id_s10_item_identifier';

    #[Override]
    protected function valueObjectClass(): string
    {
        return S10ItemIdentifier::class;
    }

    #[Override]
    protected function columnLength(): int
    {
        return 13;
    }
}
