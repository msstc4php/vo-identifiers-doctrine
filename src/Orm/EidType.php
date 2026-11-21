<?php

declare(strict_types=1);

namespace MSSTC4PHP\ValueObject\Identifiers\Doctrine\Orm;

use MSSTC4PHP\ValueObject\Doctrine\Orm\AbstractStringVoType;
use MSSTC4PHP\ValueObject\Identifiers\Telecom\Eid;
use Override;

final class EidType extends AbstractStringVoType
{
    public const string NAME = 'id_eid';

    #[Override]
    protected function valueObjectClass(): string
    {
        return Eid::class;
    }

    #[Override]
    protected function columnLength(): int
    {
        return Eid::MAX_LENGTH;
    }
}
