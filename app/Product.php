<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Product extends Model
{
    //
    use HasApiTokens, Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'catego_id', 'description', 'img', 'show', 'price'
    ];
    public function catego()
    {
        return $this->belongsTo(Catego::class);
    }

    function order()
    {
        return $this->hasMany(Order::class , 'product_id');
    }
    function review()
    {
        return $this->hasMany(Review::class);
    }
}
