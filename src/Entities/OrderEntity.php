<?php

namespace App\Entities;

class OrderEntity implements \JsonSerializable
{
    protected ?int $id;
    protected string $created_at;
    protected array $items = [];

    public function __construct(array $data = [])
    {
        $this->id = $data['id'] ?? null;

        // ensure it's always a string
        $this->created_at = (string)($data['created_at'] ?? date('Y-m-d H:i:s'));

        // map items to OrderItemEntity objects
        if (!empty($data['items'])) {
            foreach ($data['items'] as $item) {
                $this->items[] = $item instanceof OrderItemEntity
                    ? $item
                    : new OrderItemEntity($item);
            }
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function setItems(array $items): void
    {
        $this->items = $items;
    }

    public function addItem(OrderItemEntity $item): void
    {
        $this->items[] = $item;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'created_at' => $this->created_at,
            'items' => $this->items,
        ];
    }
}
