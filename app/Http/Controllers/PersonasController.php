<?php

namespace App\Http\Controllers;

use App\Models\personas;
use Illuminate\Http\Request;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Auth;

class PersonasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $personas = Personas::all();
    return view("eventos/index", ['personas' => $personas]);
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
        $datosPersona=request()->all();
        print_r($datosPersona);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $data['personas']=personas::all();
        return response()->json($data['personas']);
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
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    
public function addName(Request $request)
{
    if (!Auth::user()->isAdmin() && !Auth::user()->esJefeDeArea()) {
        abort(403, 'Unauthorized action.');
    }

    $faker = Faker::create();
    $personas = new personas();
    $personas->nombreCompleto = $request->input('nombreCompleto');
    $personas->color = $faker->hexColor;
    $personas->save();

    return redirect()->back()->with('success', 'Name added successfully.');
}
    
}
