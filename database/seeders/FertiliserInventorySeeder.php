<?php

namespace Database\Seeders;

use App\Models\FertiliserInventory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FertiliserInventorySeeder extends Seeder
{
    /**
     * From the CSV File provided
     *
     * @var array
     */
    private array $stockMovementsHistory=[
        [
            'type' => FertiliserInventory::TYPE_PURCHASE,
            'quantity' => 10,
            'unit_price' => 5,
            'created_at' => "2020-06-05",
            'updated_at' => "2020-06-05",
        ], [
            'type' => FertiliserInventory::TYPE_PURCHASE,
            'quantity' => 30,
            'unit_price' => 4.5,
            'created_at' => "2020-06-07",
            'updated_at' => "2020-06-07",
        ], [
            'type' => FertiliserInventory::TYPE_APPLICATION,
            'quantity' => "-20",
            'created_at' => "2020-06-08",
            'updated_at' => "2020-06-08",
        ], [
            'type' => FertiliserInventory::TYPE_PURCHASE,
            'quantity' => 10,
            'unit_price' => 5,
            'created_at' => "2020-06-09",
            'updated_at' => "2020-06-09",
        ], [
            'type' => FertiliserInventory::TYPE_PURCHASE,
            'quantity' => 34,
            'unit_price' => 4.5,
            'created_at' => "2020-06-10",
            'updated_at' => "2020-06-10",
        ], [
            'type' => FertiliserInventory::TYPE_APPLICATION,
            'quantity' => "-25",
            'created_at' => "2020-06-15",
            'updated_at' => "2020-06-15",
        ], [
            'type' => FertiliserInventory::TYPE_APPLICATION,
            'quantity' => "-37",
            'created_at' => "2020-06-23",
            'updated_at' => "2020-06-23",
        ], [
            'type' => FertiliserInventory::TYPE_PURCHASE,
            'quantity' => 47,
            'unit_price' => 4.3,
            'created_at' => "2020-07-10",
            'updated_at' => "2020-07-10",
        ], [
            'type' => FertiliserInventory::TYPE_APPLICATION,
            'quantity' => "-38",
            'created_at' => "2020-07-12",
            'updated_at' => "2020-07-12",
        ], [
            'type' => FertiliserInventory::TYPE_PURCHASE,
            'quantity' => 10,
            'unit_price' => 5,
            'created_at' => "2020-07-13",
            'updated_at' => "2020-07-13",
        ], [
            'type' => FertiliserInventory::TYPE_PURCHASE,
            'quantity' => 50,
            'unit_price' => 4.2,
            'created_at' => "2020-07-25",
            'updated_at' => "2020-07-25",
        ], [
            'type' => FertiliserInventory::TYPE_APPLICATION,
            'quantity' => "-28",
            'created_at' => "2020-07-26",
            'updated_at' => "2020-07-26",
        ], [
            'type' => FertiliserInventory::TYPE_PURCHASE,
            'quantity' => 10,
            'unit_price' => 5,
            'created_at' => "2020-07-31",
            'updated_at' => "2020-07-31",
        ], [
            'type' => FertiliserInventory::TYPE_PURCHASE,
            'quantity' => 15,
            'unit_price' => 5,
            'created_at' => "2020-08-14",
            'updated_at' => "2020-08-14",
        ], [
            'type' => FertiliserInventory::TYPE_PURCHASE,
            'quantity' => 3,
            'unit_price' => 6,
            'created_at' => "2020-08-17",
            'updated_at' => "2020-08-17",
        ], [
            'type' => FertiliserInventory::TYPE_PURCHASE,
            'quantity' => 2,
            'unit_price' => 7,
            'created_at' => "2020-08-29",
            'updated_at' => "2020-08-29",
        ], [
            'type' => FertiliserInventory::TYPE_APPLICATION,
            'quantity' => "-30",
            'created_at' => "2020-08-31",
            'updated_at' => "2020-08-31",
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->stockMovementsHistory as $history) {
            DB::table('fertiliser_inventories')->insert($history);
        }
    }
}
