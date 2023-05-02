<?php

namespace App\Http\Controllers;

use App\Models\Personas;
use App\Models\Horarios;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
class HorariosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $personas=Personas::all();
        $horarios = Horarios::all();
        return view("eventos.personal", compact('horarios','personas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $horarios = Horarios::all(['id', 'horarioInicio', 'horarioFinal']);

        return view('create', compact('horarios'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'horarioInicio' => 'required|date_format:H:i',
            'horarioFinal' => 'required|date_format:H:i|after:horarioInicio',
            'lunes' => 'required|boolean',
            'martes' => 'required|boolean',
            'miercoles' => 'required|boolean',
            'jueves' => 'required|boolean',
            'viernes' => 'required|boolean',
            'sabado' => 'required|boolean',
            'domingo' => 'required|boolean',
        ]);
    
        // Create a new horario record
        $horario = Horario::create($validatedData);
    
        // Return a response indicating success
        return response()->json(['message' => 'Horario created successfully', 'data' => $horario], 201);
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
}
