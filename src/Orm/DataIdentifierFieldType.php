<?php

declare(strict_types=1);

namespace MSSTC4PHP\ValueObject\Identifiers\Doctrine\Orm;

use MSSTC4PHP\ValueObject\Doctrine\Orm\AbstractTextVoType;
use MSSTC4PHP\ValueObject\Identifiers\Transport\DataIdentifierField;
use Override;

final class DataIdentifierFieldType extends AbstractTextVoType
{
    public const string NAME = 'id_data_identifier_field';

    #[Override]
    protected function valueObjectClass(): string
    {
        return DataIdentifierField::class;
    }
}
