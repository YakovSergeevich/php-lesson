<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
//use OpenApi\Annotations as OA;
/**
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 */
class Product implements \JsonSerializable
{

    public const STATUS_ACTIVE = true;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"elastica"})
     */
    private $id;

    /**
     * @ORM\Column(name="product_sku",type="string")
     * @Groups({"elastica"})
     */
    private string $sku;

    /**
     * @ORM\Column(name="name",type="string", length=10000)
     * @var string
     * @Groups({"elastica"})
     */
    private $name;

    /**
     * @ORM\Column(name="price",type="float")
     * @Groups({"elastica"})
     */
    private $price;

    /**
     * @ORM\Column(name="description",type="string", length=10000)
     * @Groups({"elastica"})
     */
    private $description;

    /**
     * @ORM\Column(name="category_id",type="integer")
     * @Groups({"elastica"})
     */
    private int $category_id;

    /**
     * @ORM\Column(name="active",type="boolean")
     * @Groups({"elastica"})
     */
    private $active;

//потом можно сюда внести те поля которые в любом случае будут обновляться, а в других методах добавить переменных для сохраннения если это надо


    /**
     * Product constructor.
     * @param string $name
     * @param string $product_sku
     * @param float $price
     * @param string $description
     * @param int $category
     */
    private function __construct(string $name, string $product_sku, float $price, string $description, int $category)
    {
        $this->name = $name;
        $this->sku = $product_sku;
        $this->price = $price;
        $this->description = $description;
        $this->category_id = $category;
        $this->active = self::STATUS_ACTIVE;
    }

    /**
     * @param string $name
     * @param string $product_sku
     * @param float $price
     * @param string $description
     * @param int $category
     * @return static
     */
    public static function create(string $name, string $product_sku, float $price, string $description, int $category): self
    {
        return new self ($name, $product_sku, $price, $description, $category);
    }


    /**
     * @param string $name
     * @param string $product_sku
     * @param float $price
     * @param string $description
     * @param int $category
     */
    public function update(string $name, string $product_sku, float $price, string $description, int $category): void
    {
        $this->name = $name;
        $this->sku = $product_sku;
        $this->price = $price;
        $this->description = $description;
        $this->category_id = $category;

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSku(): ?string
    {
        return $this->sku;
    }

    public function setSku(string $sku): self
    {
        $this->sku = $sku;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCategory(): ?int
    {
        return $this->category_id;
    }

    public function setCategory(int $category): self
    {
        $this->category_id = $category;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'sku' => $this->getSku(),
            'cost' => $this->getPrice(),
            'description' => $this->getDescription(),

        ];
    }


    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function jsonSerialize(): array
    {
        return get_object_vars($this);

    }

//    /**
//     * @ORM\PostRemove()
//     */
//    public function postRemove()
//    {
//       dump($this->client);
//    }

}
