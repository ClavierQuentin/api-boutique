<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date_order',
        'user_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'date_order' => 'date',
        'user_id' => 'integer',
    ];


    public function items()
    {
        return $this->belongsToMany(Item::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
