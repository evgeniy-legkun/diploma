<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    const CREATED_STATUS = 1;
    const ACCEPTED_STATUS = 2;
    const CANCELED_STATUS = 3;
    const DELIVERED_STATUS = 4;

    protected $table = 'transactions';

    protected $fillable = [
        'from_warehouse_id' ,
        'to_warehouse_id',
        'user_id',
        'status_code'
    ];

    public function courier()
    {
        return $this->belongsTo(User::class);
    }

    public function fromWarehouse()
    {
        return $this->belongsTo(Warehouse::class, 'from_warehouse_id');
    }

    public function toWarehouse()
    {
        return $this->belongsTo(Warehouse::class,'to_warehouse_id');
    }

    public function materials()
    {
        return $this->belongsToMany(
            Material::class,
            'transaction_materials',
            'transaction_id',
            'material_id'
        )->withPivot('quantity');
    }
}
