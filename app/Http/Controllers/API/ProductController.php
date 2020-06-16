<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Product::with('catego')->latest()->paginate(7);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name' => 'required|string|unique:products',
            'catego_id' => 'required',
            'show'      => 'required',
            'price'     => 'required|integer'

        ]);



        if($request->img ){
            $name = time().'.' . explode('/', explode(':', substr($request->img, 0, strpos($request->img, ';')))[1])[1];

            \Image::make($request->img)->save(public_path('img/products/').$name);
            $request->merge(['img' => $name]);


        }

            Product::create([
                'name'         => $request['name'],
                'catego_id'    => $request['catego_id'],
                'description'  => $request['description'],
                'show'         => $request['show'],
                'img'          => $request['img'],
                'price'        => $request['price'],
            ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $product = Product::find($id);
        $request->validate([
            'name' => 'required|string|unique:products,name,' . $id,
            'catego_id' => 'required',
            'show'      => 'required' ,
            'price'     => 'required|integer'
        ]);
        $product->update($request->all());
        return ['message' => 'its update'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $product = Product::find($id);
        $product->delete();
        return ['message' => 'its update'];
    }
}
