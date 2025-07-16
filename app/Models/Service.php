<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
   public function orders()
{
    return $this->hasMany(Order::class, 'service_id');
}

    public function order_completed()
    {
        return $this->orders()->where('status', 'completed')->count();
    }
}
