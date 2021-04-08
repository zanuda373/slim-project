<?php

declare(strict_types=1);

namespace App\Model\Tag\Entity;

use App\Model\Tag\Type\NameType;
use App\Model\Type\UuidType;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use DomainException;

/**
 * Class Tag
 * @package App\Model\Tag\Entity
 * @ORM\Entity
 * @ORM\Table
 */
class Tag
{
    /**
     * @var UuidType
     * @ORM\Column(type="uuid_type")
     * @ORM\Id
     */
    private UuidType $id;

    /**
     * @var NameType
     * @ORM\Column(type="tag_name_type")
     */
    private NameType $name;

    /**
     * @var Collection
     * @ORM\ManyToMany(targetEntity="App\Model\Product\Entity\Product", mappedBy="tags")
     */
    private Collection $products;

    public function __construct(NameType $name)
    {
        $this->id = UuidType::generate();
        $this->name = $name;
        $this->products = new ArrayCollection();
    }

    public function getId(): UuidType
    {
        return $this->id;
    }

    public function getName(): NameType
    {
        return $this->name;
    }

    public function changeName(NameType $anotherName): void
    {
        if (!$this->name->isEqualTo($anotherName)) {
            throw new DomainException('Same name.');
        }
        $this->name = $anotherName;
    }

    public function getProducts(): array
    {
        return $this->products->toArray();
    }
}