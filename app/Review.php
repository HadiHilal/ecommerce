<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Review extends Model
{

     use HasApiTokens, Notifiable;
     /**
      * The attributes that are mass assignable.
      *
      * @var array
      */
     protected $fillable = [
        'count', 'product_id' , 'user_id' , 'comment'
     ];
     public function user()
     {
         return $this->belongsTo(User::class , 'user_id' );
     }

     public function product()
     {
         return $this->belongsTo(Product::class , 'product_id');
     }

}
