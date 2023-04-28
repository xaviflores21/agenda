<?php

namespace App\Http\Controllers;

use App\Models\Personas;
use App\Models\Horarios;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;

class PersonasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $personas = Personas::with('horarios')->get();
    $horarios = Horarios::all();
    return view("eventos.personal", compact('personas','horarios'));
}
public function horariosIndex()
{
    $personas = Personas::with('horarios')->get();
    return view("eventos.horarios", compact('personas'));
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
        $validatedData = $request->validate([
            'nombreCompleto' => 'required|string|max:255',
            'color' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:255',
            'horario_id' => 'required|integer|exists:horarios,id', // Ensure that the selected horario_id exists in the horarios table
        ]);
    
        $persona = new Personas();
        $persona->nombreCompleto = $validatedData['nombreCompleto'];
        $persona->color = $validatedData['color'];
        $persona->telefono = $validatedData['telefono'];
        $persona->estado = 'C';
        $persona->save();
    
        $horario = Horarios::find($validatedData['horario_id']); // Find the Horario with the selected horario_id
        $fecha=now();
        $horarioString=$horario->horarioInicio . '-' .$horario->horarioFinal;
        $persona->horarios()->attach($horario, ['fecha' => $fecha, 
                                                'horarios' => $horarioString,
                                                'nombreCompleto'=>$persona->nombreCompleto]); // Add the Horario to the Persona's horarios
    
        return redirect()->back()->with('success', 'Record added successfully.');
    }
    


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $data['personas']=personas::where('estado', 'C')
        ->orWhere('estado', 'M')
        ->get();
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
    $personas = personas::find($id);

    // Create a new entry with the updated fields
    $newPersonas = new personas();
    $newPersonas->idAnterior = $personas->id;
    $newPersonas->nombreCompleto = $request->input('nombreCompleto');
    $newPersonas->color = $request->input('color');
    $newPersonas->horarioInicio = $request->input('horarioInicio');
    $newPersonas->horarioFinal = $request->input('horarioFinal');
    $newPersonas->estado='M';
    $newPersonas->lunes = $request->has('lunes');
    $newPersonas->martes = $request->has('martes');
    $newPersonas->miercoles = $request->has('miercoles');
    $newPersonas->jueves = $request->has('jueves');
    $newPersonas->viernes = $request->has('viernes');
    $newPersonas->sabado = $request->has('sabado');
    $newPersonas->domingo = $request->has('domingo');
    $newPersonas->save();

    // Change the estado of the original entry to "M"
    $personas->estado='E';
    $personas->save();

    return redirect()->back()->with('success', 'Record updated successfully.');
}



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
{
    $personas = personas::findOrFail($id);

    // Update the observacion field of the pivot records between the persona and horarios tables
    foreach ($personas->horarios as $horario) {
        $horario->pivot->observacion = 'Record deleted';
        $horario->pivot->save();
    }

    // Update the estado field of the horarios records
    $personas->horarios()->update(['estado' => 'E']);

    // Update the estado field of the persona record
    $personas->estado = 'E';
    $personas->save();

    return redirect()->back()->with('success', 'Record deleted successfully.');
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
        $personas->horarioInicio = $request->input('horarioInicio');
        $personas->horarioFinal = $request->input('horarioFinal');
        $personas->save();
    
        return redirect()->back()->with('success', 'Name added successfully.');
    }
    public function mostrarEventos()
{   
    
    $personas = Personas::where('estado', 'C')->orWhere('estado', 'M')->get();

    $events = [];

    $nextSunday = Carbon::now()->startOfWeek(Carbon::SUNDAY);
    info($nextSunday);
    $nextSaturday =Carbon::now()->next(Carbon::SATURDAY);

    info($nextSaturday);
    
        for ($date = $nextSunday; $date <= $nextSaturday; $date->addDay()) {
            foreach ($personas as $persona) {
                $event = [
                'title' => $persona->nombreCompleto,
                'start' => $date->copy()->format('Y-m-d').' '.$persona->horarioInicio,
                'end' => $date->copy()->format('Y-m-d').' '.$persona->horarioFinal,
                'color' => $persona->color,
                ];

                $events[] = $event;
            }
        }
        $nextSunday->addWeek();
        $nextSaturday->addWeek();
    


    return response()->json($events);
}


    
}
