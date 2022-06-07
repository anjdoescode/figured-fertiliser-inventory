<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FertiliserInventory extends Model
{
    const TYPE_PURCHASE = "Purchase";
    const TYPE_APPLICATION = "Application";

    protected $fillable = [
        'type',
        'quantity',
        'unit_price'
    ];
}
