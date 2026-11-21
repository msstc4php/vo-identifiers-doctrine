<?php

declare(strict_types=1);

namespace MSSTC4PHP\ValueObject\Identifiers\Doctrine\Odm;

use MSSTC4PHP\ValueObject\Doctrine\Odm\AbstractStringVoType;
use MSSTC4PHP\ValueObject\Identifiers\Transport\Iso15459Identifier;
use Override;

final class Iso15459IdentifierType extends AbstractStringVoType
{
    public const string NAME = 'id_iso15459_identifier';

    #[Override]
    protected function valueObjectClass(): string
    {
        return Iso15459Identifier::class;
    }
}
