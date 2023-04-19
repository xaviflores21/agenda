<?php

namespace App\Http\Controllers;

use App\Models\evento;
use App\Models\personas;
use Illuminate\Http\Request;

class EventosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $personas = Personas::all();
        return view('eventos/index', compact('personas'));
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
        $evento = new Evento;
        $evento->title = $request->title;
        $evento->cliente = $request->cliente;
        $evento->habitacion = $request->habitacion;
        $evento->servicio = $request->servicio;
        $evento->color = $request->color;
        $evento->estado = $request->estado;
        $evento->textColor = $request->textColor;
        $evento->start = $request->start;
        $evento->end = $request->end;
        $evento->save();
      
        return response()->json(['id' => $evento->id]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $data['eventos'] = evento::where('estado', 'C')
        ->orWhere('estado', 'M')
        ->get();
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
    $evento = Evento::findOrFail($id);
    $evento->title = $request->title;
    $evento->cliente = $request->cliente;
    $evento->habitacion = $request->habitacion;
    $evento->servicio = $request->servicio;
    $evento->color = $request->color;
    $evento->estado = 'M';
    $evento->textColor = $request->textColor;
    $evento->start = $request->start;
    $evento->end = $request->end;
    $evento->save();

    return response()->json($evento);
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $evento = evento::findOrFail($id);
        $evento->estado = 'E';
        $evento->save();
        return response()->json($evento);
        }
}
