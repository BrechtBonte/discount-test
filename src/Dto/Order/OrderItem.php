<?php
declare(strict_types=1);

namespace App\Dto\Order;

use App\Domain\MoneyAmount;
use Assert\Assert;

final class OrderItem
{
    public function __construct(
        private string $productId,
        private int $quantity,
        private MoneyAmount $unitPriceAmount,
        private MoneyAmount $totalAmount,
    ) {
    }

    public static function createFromArray(array $data): self
    {
        Assert::lazy()
            ->that($data['product-id'] ?? null, 'product-id')->string()
            ->that($data['quantity'] ?? null, 'quantity')->string()->integerish()
            ->that($data['unit-price'] ?? null, 'unit-price')->numeric()
            ->that($data['total'] ?? null, 'total')->numeric()
            ->verifyNow();

        return new self(
            $data['product-id'],
            (int)$data['quantity'],
            MoneyAmount::fromString($data['unit-price']),
            MoneyAmount::fromString($data['total']),
        );
    }

    public function getProductId(): string
    {
        return $this->productId;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getUnitPriceAmount(): MoneyAmount
    {
        return $this->unitPriceAmount;
    }

    public function getTotalAmount(): MoneyAmount
    {
        return $this->totalAmount;
    }
}
