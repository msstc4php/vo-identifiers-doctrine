<?php

declare(strict_types=1);

namespace MSSTC4PHP\ValueObject\Identifiers\Doctrine\Odm;

use MSSTC4PHP\ValueObject\Doctrine\Odm\AbstractStringVoType;
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
}
