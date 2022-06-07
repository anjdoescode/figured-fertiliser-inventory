<?php

namespace App\Http\Services;

use App\Models\FertiliserInventory;
use Illuminate\Database\Eloquent\Collection;

class FertiliserInventoryService
{
    protected FertiliserInventory $fertiliserInventory;

    public function __construct()
    {
        $this->fertiliserInventory = new FertiliserInventory();
    }

    /**
     * Returns total stocks available
     *
     * @return int
     */
    public function stock(): int
    {
        return $this->fertiliserInventory->sum('quantity');
    }

    /**
     * Process request of stocks
     *
     * @param $quantity
     * @return bool|array
     */
    public function requestStock($quantity): bool|array
    {
        if (!self::inStock($quantity))
            return false;

        $movement = self::recordStockMovement([
            'type' => FertiliserInventory::TYPE_APPLICATION,
            'quantity' => -1 * abs($quantity)
        ]);

        $valuation = self::getStockDecreaseValue(self::stockMovements(), $movement->id);

        return ['quantity' => $quantity, 'value' => $valuation];
    }

    /**
     * Checks if there is enough stocks
     *
     * @param int $quantity
     * @return bool
     */
    public function inStock(int $quantity = 1): bool
    {
        $stock = $this->stock();

        return $stock > 0 && $stock >= $quantity;
    }

    /**
     * Records stock movement
     *
     * @param $arguments
     * @return mixed
     */
    public function recordStockMovement($arguments): mixed
    {
        return $this->fertiliserInventory->create($arguments);
    }

    /**
     * Returns set of inventory movements
     *
     * @param string $order
     * @return Collection
     */
    public function stockMovements(string $order = 'asc'): Collection
    {
        return $this->fertiliserInventory->orderBy('created_at', $order)->get();
    }

    /**
     * Returns value of stock requested in $ currency
     *
     * @param $movements
     * @param null $id
     * @return string
     */
    public function getStockDecreaseValue($movements, $id = null): string
    {
        $stockDecreaseValues = [];
        $stocksOnHand = [];

        foreach ($movements as $movement) {
            if ($movement->quantity > 0) {
                // store stock purchases in stocks on hand
                $stocksOnHand[$movement->id] = $movement;
            } else {
                // process stock decrease
                $stockDecreaseQty = abs($movement->quantity);
                $stockDecreaseValue = 0;

                while ($stockDecreaseQty > 0) {
                    // loop through stocks on hand starting from the oldest stock
                    $oldestStock = reset($stocksOnHand);

                    // if purchase quantity is not enough
                    if ($stockDecreaseQty > $oldestStock->quantity) {
                        // consider stock fully consumed
                        $stockDecreaseQty -= $oldestStock->quantity;
                        // increase total value of consumed stock
                        $stockDecreaseValue = bcadd($stockDecreaseValue, bcmul($oldestStock->quantity, $oldestStock->unit_price, 2), 2);
                        // then move on to the next
                        unset($stocksOnHand[$oldestStock->id]);
                    } else {
                        // update remaining stock after subtracting consumed stock
                        $stocksOnHand[$oldestStock->id]['quantity'] -= $stockDecreaseQty;
                        // increase total value of consumed stock
                        $stockDecreaseValue = bcadd($stockDecreaseValue, bcmul($stockDecreaseQty, $oldestStock->unit_price, 2), 2);
                        // consumed stock is fully applied
                        $stockDecreaseQty = 0;
                    }
                }

                $stockDecreaseValues[$movement->id] = $stockDecreaseValue;
            }
        }

        if (is_null($id) || !isset($stockDecreaseValues[$id])) {
            // get latest stock decrease valuation
            $valuation = end($stockDecreaseValues);
        } else {
            $valuation = $stockDecreaseValues[$id];
        }

        return "$" . $valuation;
    }
}
