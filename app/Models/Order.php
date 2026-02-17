<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;


class Order extends Model
{
    use HasFactory, LogsActivity;
    protected $guarded = [];

    protected $casts = [
        'order_date' => 'date',
    ];

    public function customer(){
        return $this->belongsTo(Customer::class,'customer_id','id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Activity log configuration (optional)
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['invoice_no', 'payment_status', 'order_status'])
            ->logOnlyDirty();
    }

    public function payments()
    {
        // Ensure the model name and foreign key match your database
        return $this->hasMany(OrderPayment::class, 'order_id', 'id')->latest();
    }
    
}
