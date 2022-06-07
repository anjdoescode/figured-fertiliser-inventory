<?php

namespace Tests\Unit;

use App\Http\Services\FertiliserInventoryService;
use App\Models\FertiliserInventory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FertiliserInventoryServiceTest extends TestCase
{
    use RefreshDatabase;

    protected FertiliserInventoryService $fertiliserInventoryService;

    protected array $restockMovements = [
        [
            'type' => FertiliserInventory::TYPE_PURCHASE,
            'quantity' => 1,
            'unit_price' => 10
        ], [
            'type' => FertiliserInventory::TYPE_PURCHASE,
            'quantity' => 2,
            'unit_price' => 20
        ], [
            'type' => FertiliserInventory::TYPE_PURCHASE,
            'quantity' => 2,
            'unit_price' => 15
        ]
    ];

    function setUp(): void
    {
        parent::setUp();

        $this->fertiliserInventoryService = new FertiliserInventoryService();
    }

    public function test_inventory_can_have_no_stock()
    {
        $this->assertEquals(0, $this->fertiliserInventoryService->stock());
    }

    public function test_it_can_check_if_in_stock()
    {
        $this->assertFalse($this->fertiliserInventoryService->inStock(3));
    }

    public function test_it_can_get_empty_movement_records()
    {
        $noMovements = $this->fertiliserInventoryService->stockMovements();

        $this->assertEmpty($noMovements);
    }

    public function test_it_can_record_stock_movements_and_get_them()
    {
        $restock = $this->fertiliserInventoryService->recordStockMovement([
            'type' => FertiliserInventory::TYPE_PURCHASE,
            'quantity' => 1,
            'unit_price' => 10
        ]);

        $this->assertTrue(isset($restock->id));

        $movements = $this->fertiliserInventoryService->stockMovements();

        $this->assertGreaterThanOrEqual(1, $movements->count());
    }

    public function test_it_can_calculate_requested_stock_valuation_using_existing_and_non_existent_stock_id()
    {
        // restock
        $movements = [];
        foreach ($this->restockMovements as $movement) {
            $movements[] = $this->fertiliserInventoryService->recordStockMovement($movement);
        }

        // requested stock
        $requestedStock = $this->fertiliserInventoryService->recordStockMovement([
            'type' => FertiliserInventory::TYPE_APPLICATION,
            'quantity' => -2
        ]);
        $movements[] = $requestedStock;

        // get valuation using existing stock id
        $valuation = $this->fertiliserInventoryService->getStockDecreaseValue($movements, $requestedStock->id);

        // Stocks on hand:
        // 1 unit @ $10
        // 2 unit @ $20
        // 2 unit @ $15
        // Expected valuation: 1 * $10 + 1 * $20 = $30
        $this->assertEquals("$30.00", $valuation);

        // Remaining stock: 3
        $this->assertEquals(3, $this->fertiliserInventoryService->stock());

        // get valuation using non-existent stock id
        $valuationUsingNonExistentId = $this->fertiliserInventoryService->getStockDecreaseValue($movements, 999);

        $this->assertEquals("$30.00", $valuationUsingNonExistentId);
    }

    public function test_stock_request_returns_false_if_there_is_not_enough_stocks()
    {
        $stockRequest = $this->fertiliserInventoryService->requestStock(10);

        $this->assertFalse($stockRequest);
    }

    public function test_successful_stock_request_returns_quantity_and_valuation()
    {
        $this->artisan('db:seed');

        $stockRequest = $this->fertiliserInventoryService->requestStock(2);

        $this->assertNotFalse($stockRequest);
        $this->assertArrayHasKey('quantity', $stockRequest);
        $this->assertArrayHasKey('value', $stockRequest);
    }
}
