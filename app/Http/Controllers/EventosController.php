<?php

namespace App\Http\Controllers;

use App\Models\evento;
use Illuminate\Http\Request;

class EventosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view("eventos/index");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $datosEvento=request()->except(['_token','_method']);
        evento::insert($datosEvento);
        print_r($datosEvento);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $data['eventos']=evento::all();
        return response()->json($data['eventos']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $datosEvento=request()->except(['_token','_method']);
        $respuesta=evento::where('id',"=",$id)->update($datosEvento);
        return response()->json($respuesta);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $eventos=evento::findOrFail($id);
        evento::destroy($id);
        return response()->json($id);
    }
}
