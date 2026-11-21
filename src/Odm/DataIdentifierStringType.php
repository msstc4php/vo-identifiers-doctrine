<?php

declare(strict_types=1);

namespace MSSTC4PHP\ValueObject\Identifiers\Doctrine\Odm;

use MSSTC4PHP\ValueObject\Doctrine\Odm\AbstractStringVoType;
use MSSTC4PHP\ValueObject\Identifiers\Transport\DataIdentifierString;
use Override;

final class DataIdentifierStringType extends AbstractStringVoType
{
    public const string NAME = 'id_data_identifier_string';

    #[Override]
    protected function valueObjectClass(): string
    {
        return DataIdentifierString::class;
    }
}
