<?php

declare(strict_types=1);

namespace MSSTC4PHP\ValueObject\Identifiers\Doctrine\Tests\Support\Orm;

use Doctrine\ORM\Mapping as ORM;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Orm\CasRegistryNumberType;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Orm\DataIdentifierStringType;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Orm\DoiType;
use MSSTC4PHP\ValueObject\Identifiers\Doctrine\Orm\ImeiType;
use MSSTC4PHP\ValueObject\Identifiers\Publication\Doi;
use MSSTC4PHP\ValueObject\Identifiers\Substance\CasRegistryNumber;
use MSSTC4PHP\ValueObject\Identifiers\Telecom\Imei;
use MSSTC4PHP\ValueObject\Identifiers\Transport\DataIdentifierString;

#[ORM\Entity]
#[ORM\Table(name: 'item')]
class Item
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    public ?int $id = null;

    public function __construct(
        #[ORM\Column(type: DataIdentifierStringType::NAME)]
        public DataIdentifierString $label,
        #[ORM\Column(type: CasRegistryNumberType::NAME, nullable: true)]
        public ?CasRegistryNumber $substance = null,
        #[ORM\Column(type: ImeiType::NAME, nullable: true)]
        public ?Imei $device = null,
        #[ORM\Column(type: DoiType::NAME, nullable: true)]
        public ?Doi $paper = null,
    ) {
    }
}
