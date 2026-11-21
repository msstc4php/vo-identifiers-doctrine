<?php

declare(strict_types=1);

namespace MSSTC4PHP\ValueObject\Identifiers\Doctrine\Tests\Support\Odm;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Odm\CasRegistryNumberType;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Odm\DataIdentifierStringType;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Odm\DoiType;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Odm\ImeiType;
use MSSTC4PHP\ValueObject\Identifiers\Publication\Doi;
use MSSTC4PHP\ValueObject\Identifiers\Substance\CasRegistryNumber;
use MSSTC4PHP\ValueObject\Identifiers\Telecom\Imei;
use MSSTC4PHP\ValueObject\Identifiers\Transport\DataIdentifierString;

#[ODM\Document(collection: 'item')]
class Item
{
    #[ODM\Id]
    public ?string $id = null;

    public function __construct(
        #[ODM\Field(type: DataIdentifierStringType::NAME)]
        public DataIdentifierString $label,
        #[ODM\Field(type: CasRegistryNumberType::NAME, nullable: true)]
        public ?CasRegistryNumber $substance = null,
        #[ODM\Field(type: ImeiType::NAME, nullable: true)]
        public ?Imei $device = null,
        #[ODM\Field(type: DoiType::NAME, nullable: true)]
        public ?Doi $paper = null,
    ) {
    }
}
