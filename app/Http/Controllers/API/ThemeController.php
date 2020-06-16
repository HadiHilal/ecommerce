<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Product;
use App\Catego;
use Illuminate\Http\Request;

class ThemeController extends Controller
{
    function getcatego(){
        return Catego::get();
    }

   function getproduct(){
       return Product::with('catego')->where('show', '=', 1)->latest()->paginate(24);
   }
}
