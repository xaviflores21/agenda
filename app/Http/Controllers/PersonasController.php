<?php

namespace App\Http\Controllers;

use App\Models\Personas;
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
    $personas = Personas::all();
    return view("eventos.personal", ['personas' => $personas]);
}
public function horariosIndex()
{
    $personas = Personas::all();
    return view('eventos.horarios',['personas' => $personas]);
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
        $personas = new Personas();
        $personas->nombreCompleto = $request->input('nombreCompleto');
        $personas->color = $request->input('color');
        $personas->horarioInicio = $request->input('horarioInicio');
        $personas->horarioFinal = $request->input('horarioFinal');
        $personas->estado = 'C';
        $personas->save();
    
        $personas->idAnterior = $personas->id ;
        $personas->save();
    
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
