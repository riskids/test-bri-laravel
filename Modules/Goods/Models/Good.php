<?php

namespace Modules\Goods\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Good extends BaseModel
{
    use SoftDeletes;

    protected $table = 'goods';

    protected $fillable = [
        'name',
        'sku',
        'quantity',
        'price',
        'cost_price',
        'min_stock',
        'description'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'cost_price' => 'decimal:2'
    ];

    public function inventoryMoves(): HasMany
    {
        return $this->hasMany(\Modules\Goods\Models\InventoryMove::class, 'good_id');
    }

    public function adjustments(): HasMany
    {
        return $this->hasMany(\Modules\Goods\Models\Adjustment::class, 'good_id');
    }
}
