<?php

namespace App\Http\Controllers;

use App\Models\Personas;
use App\Models\Horarios;
use App\Models\ReportePersonas;
use App\Models\ReporteHorario;
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
    $horarioModificacion = Horarios::where('estado', 'C')->orWhere('estado', 'M')->get();
    return view("eventos.personal", compact('personas','horarios','horarioModificacion'));
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

        $newReportePersonas = new ReportePersonas();
        $newReportePersonas->idPersona=$persona->id;
        $newReportePersonas->nombreCompletoPersona= $persona->nombreCompleto;
        $newReportePersonas->telefono=$persona->telefono;
        $newReportePersonas->color=$persona->color;
        $newReportePersonas->estadoPersona='C';
        $newReportePersonas->save();

        $horario = Horarios::find($validatedData['horario_id']); // Find the Horario with the selected horario_id
        $fecha=now();
        $horarioString=$horario->horarioInicio . ' - ' .$horario->horarioFinal;
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
        $horario = Horario::findOrFail($horario_id);
        return view('horarios.edit', compact('horario'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    $validatedData = $request->validate([
        'nombreCompleto' => 'required|string|max:255',
        'color' => 'required|string|max:255',
        'telefono' => 'nullable|string|max:255',
        'horario_id' => 'required|integer|exists:horarios,id',
        'horario_ids' => 'nullable|integer|exists:horarios,id',
    ]);

    $persona = Personas::find($id);
    $persona->nombreCompleto = $validatedData['nombreCompleto'];
    $persona->color = $validatedData['color'];
    $persona->telefono = $validatedData['telefono'];
    $persona->estado = 'M';
    $persona->save();
    $newReportePersonas = new ReportePersonas();
    $newReportePersonas->idPersona=$persona->id;
    $newReportePersonas->nombreCompletoPersona= $persona->nombreCompleto;
    $newReportePersonas->telefono=$persona->telefono;
    $newReportePersonas->color=$persona->color;
    $newReportePersonas->estadoPersona='M';
    $newReportePersonas->save();
    $observacion = "Horario modificado de horario_id : " . $validatedData['horario_id'];;
    

    $fecha=now();
    $horario = Horarios::find($validatedData['horario_ids']);
    $horarioString=$horario->horarioInicio . ' - ' .$horario->horarioFinal;
    $persona->horarios()->sync([$horario->id => ['fecha' => $fecha, 
                                                'horarios' => $horarioString,
                                                'nombreCompleto'=>$persona->nombreCompleto,
                                                'observacion'=>$observacion]]);


            $newHorario = new ReporteHorario();
            $newHorario->idHorarios = $horario->id;
            $newHorario->horarioInicio = $horario->horarioInicio;
            $newHorario->horarioFinal = $horario->horarioFinal;
            $newHorario->lunes = $horario->lunes;
            $newHorario->martes = $horario->martes;
            $newHorario->miercoles = $horario->miercoles;
            $newHorario->jueves = $horario->jueves;
            $newHorario->viernes = $horario->viernes;
            $newHorario->sabado = $horario->sabado;
            $newHorario->domingo = $horario->domingo;
            $newHorario->estadoHorarios = 'M';
            $newHorario->save();               

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
    

    // Update the estado field of the persona record
    $personas->estado = 'E';
    $personas->save();
    $newReportePersonas = new ReportePersonas();
    $newReportePersonas->idPersona=$personas->id;
    $newReportePersonas->nombreCompletoPersona= $personas->nombreCompleto;
    $newReportePersonas->telefono=$personas->telefono;
    $newReportePersonas->color=$personas->color;
    $newReportePersonas->estadoPersona='E';
    $newReportePersonas->save();
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
public function addHorario(Request $request)
{
    $validatedData = $request->validate([
        'horarioInicio' => 'required|date_format:H:i',
        'horarioFinal' => 'required|date_format:H:i|after:horarioInicio',
        'lunes' => 'nullable|boolean',
        'martes' => 'nullable|boolean',
        'miercoles' => 'nullable|boolean',
        'jueves' => 'nullable|boolean',
        'viernes' => 'nullable|boolean',
        'sabado' => 'nullable|boolean',
        'domingo' => 'nullable|boolean'
    ]);

    $horario = new Horarios();
    $horario->horarioInicio = $validatedData['horarioInicio'];
    $horario->horarioFinal = $validatedData['horarioFinal'];
    $horario->lunes = $request->has('lunes') ? 1 : 0;
    $horario->martes = $request->has('martes') ? 1 : 0;
    $horario->miercoles = $request->has('miercoles') ? 1 : 0;
    $horario->jueves = $request->has('jueves') ? 1 : 0;
    $horario->viernes = $request->has('viernes') ? 1 : 0;
    $horario->sabado = $request->has('sabado') ? 1 : 0;
    $horario->domingo = $request->has('domingo') ? 1 : 0;   
    $horario->estado = 'C';
    $horario->save();

    $newHorario = new ReporteHorario();
    $newHorario->idHorarios = $horario->id;
    $newHorario->horarioInicio = $horario->horarioInicio;
    $newHorario->horarioFinal = $horario->horarioFinal;
    $newHorario->lunes = $horario->lunes;
    $newHorario->martes = $horario->martes;
    $newHorario->miercoles = $horario->miercoles;
    $newHorario->jueves = $horario->jueves;
    $newHorario->viernes = $horario->viernes;
    $newHorario->sabado = $horario->sabado;
    $newHorario->domingo = $horario->domingo;
    $newHorario->estadoHorarios = 'C';
    $newHorario->save();
    
    return redirect()->back()->with('success', 'Horario added successfully.');
}


public function destroyHorario(Request $request)
{
    
    $horario_id = $request->input('horario_id');
    $horarios = Horarios::findOrFail($horario_id);
  

    $observacion = "Horario eliminado";
    $horarios->personas()->wherePivot('horarios_id', $horario_id)->update(['observacion' => $observacion]);


    $horarios->estado="E";
    $horarios->save();




    $newHorario = new ReporteHorario();
    $newHorario->idHorarios = $horarios->id;
    $newHorario->horarioInicio = $horarios->horarioInicio;
    $newHorario->horarioFinal = $horarios->horarioFinal;
    $newHorario->lunes = $horarios->lunes;
    $newHorario->martes = $horarios->martes;
    $newHorario->miercoles = $horarios->miercoles;
    $newHorario->jueves = $horarios->jueves;
    $newHorario->viernes = $horarios->viernes;
    $newHorario->sabado = $horarios->sabado;
    $newHorario->domingo = $horarios->domingo;
    $newHorario->estadoHorarios = 'E';
    $newHorario->save();
    return redirect()->back()->with('success', 'Record deleted successfully.');
}

public function updateHorarios(Request $request, $id)
{
    $validatedData = $request->validate([
        'horarioInicio' => 'required|date_format:H:i',
        'horarioFinal' => 'required|date_format:H:i|after:horarioInicio',
        'lunes' => 'nullable|boolean',
        'martes' => 'nullable|boolean',
        'miercoles' => 'nullable|boolean',
        'jueves' => 'nullable|boolean',
        'viernes' => 'nullable|boolean',
        'sabado' => 'nullable|boolean',
        'domingo' => 'nullable|boolean'
    ]);
    $horario = Horario::findOrFail($id); // Find the horario with the given id
    
    // Update the fields in the horario object with the new values from the request
    $horario->horarioInicio = $validatedData['horarioInicio'];
    $horario->horarioFinal = $validatedData['horarioFinal'];
    $horario->lunes = $request->has('lunes') ? 1 : 0;
    $horario->martes = $request->has('martes') ? 1 : 0;
    $horario->miercoles = $request->has('miercoles') ? 1 : 0;
    $horario->jueves = $request->has('jueves') ? 1 : 0;
    $horario->viernes = $request->has('viernes') ? 1 : 0;
    $horario->sabado = $request->has('sabado') ? 1 : 0;
    $horario->domingo = $request->has('domingo') ? 1 : 0;   
    $horario->estado="M";
    
    // Save the changes to the database
    $horario->save();
    
    // Return a success message to the user
    return response()->json(['message' => 'Horario updated successfully']);
}


}
