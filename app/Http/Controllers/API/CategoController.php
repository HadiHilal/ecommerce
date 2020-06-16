<?php

namespace App\Http\Controllers\API;

use App\Catego;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoController extends Controller
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
        return Catego::latest()->paginate(5);
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
            'name' => 'required|unique:categos'
        ]);

        return Catego::create([
            'name' => $request['name']

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
        $catego = Catego::find($id);
        $request->validate([
            'name' => 'required|unique:categos,name,' . $id,
        ]);

        $catego->update($request->all());
        return ['message' => 'its updated'];
    }

    /**
     * Remove the specified resource from storage.x
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $catego = Catego::find($id);
        $catego->delete();
        return ['message' => 'its deleted'];
    }
}
