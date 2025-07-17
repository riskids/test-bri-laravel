<?php

namespace Modules\Goods\Models;

use App\Models\BaseModel;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InventoryMove extends BaseModel
{
    protected $table = 'inventory_moves';

    protected $fillable = [
        'good_id',
        'user_id',
        'quantity',
        'type',
        'notes',
        'date'
    ];

    protected $casts = [
        'date' => 'datetime'
    ];

    public function good(): BelongsTo
    {
        return $this->belongsTo(Good::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
