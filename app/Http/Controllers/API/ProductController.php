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


        $path=null;
        $data= $request->except('_token','img');
        if($request->file('img')){
            $image = $request->file('img');
            $filename = $image->getClientOriginalName();
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            $name = time().(int) rand(10, 1000000).'.'.$ext;
            $path = 'img/products/_'.$name;
            \Storage::disk('public')->put($path, file_get_contents($image->getRealPath()));
            $data['img'] = $path;

        }
        Product::create($data);



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
        $request->validate([
            'name' => 'required|string|unique:products,name,' . $id,
            'catego_id' => 'required',
            'show'      => 'required' ,
            'price'     => 'required|integer'
        ]);
        $product = Product::find($id);
        $path=null;
        $data= $request->except('_token','img');
        if($request->img){
            $image = $request->file('img');
            $filename = $image->getClientOriginalName();
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            $name = time().(int) rand(10, 1000000).'.'.$ext;
            $path = 'img/products/_'.$name;
            \Storage::disk('public')->put($path, file_get_contents($image->getRealPath()));
            $data['img'] = $path;

        }

        $product->update($data);
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
