<?php

declare(strict_types=1);

namespace App\Model\Product\Command\Add;

use App\Infrastructure\Doctrine\Flusher\Flusher;
use App\Model\Category\Entity\Category;
use App\Model\Product\Entity\Product;
use App\Model\Product\Entity\ProductRepository;
use App\Model\Product\Type\DescriptionType;
use App\Model\Product\Type\NameType;
use App\Model\Product\Type\PriceType;
use App\Model\Type\UuidType;
use LogicException;

class Handler
{
    private ProductRepository $repository;
    private Flusher $flusher;

    public function __construct(ProductRepository $repository, Flusher $flusher)
    {
        $this->repository = $repository;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $product = new Product(
            UuidType::generate(),
            new NameType($command->name),
            new DescriptionType($command->description),
            new PriceType($command->price),
            $command->category
        );

        if ($this->repository->has($product)) {
            throw new LogicException('Product already set!');
        }

        $this->repository->addProduct($product);

        $this->flusher->flush();
    }
}