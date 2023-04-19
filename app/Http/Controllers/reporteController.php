<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Evento;
use App\Models\User;
use App\Models\reporte;
use App\Models\personas;
class reporteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->middleware('auth');
        $reportes = reporte::all();

        // Return the data to the view
        return view('reporte', compact('reportes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Get the currently logged-in user
        $user = Auth::user();
    
        // Retrieve the event data using the Evento model
        $evento = Evento::findOrFail($request->input('id'));
        $userData = User::select('idUser', 'userNombre')->findOrFail($user->id);
        // Save the event data to the 'Reporte' table
        $reporteData = [
            'idUser' => $userData->idUser,
            'userNombre' => $userData->userNombre,
            'idEvento' => $evento->id,
            'encargadaEvento' => $evento->encargada,
            'cliente' => $evento->cliente,
            'habitacion' => $evento->habitacion,
            'servicio' => $evento->servicio,
            'color' => $evento->color,
            'estado' => $evento->estado,
            'textColor' => $evento->textColor,
            'start' => $evento->start,
            'end' => $evento->end,
        ];
    
        reporte::insert($reporteData);
    
        return response()->json($reporteData);
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
    public function getReporteData(Request $request)
    {
        // Fetch the data from the Reporte model
        $reportes = Reporte::all();

        // Return the data as a JSON response
        return response()->json($reportes);
    }
    public function EnviarReporteInformacion(Request $request)
{
    // Get the currently logged-in user
    $user = Auth::user();
    
    // Retrieve the event data from the request
    $evento = $request->input('objEvento');
    $estado = $request->input('estado');
    
    // Save the event data to the 'Reporte' table
    $reporteData = [
        'idUser' => $user->id,
        'userNombre' => $user->name,
        'idEvento' => $evento['id'],
        'encargadaEvento' => $evento['title'],
        'cliente' => $evento['cliente'],
        'habitacion' => $evento['habitacion'],
        'servicio' => $evento['servicio'],
        'color' => $evento['color'],
        'estado' => $estado,
        'textColor' => $evento['textColor'],
        'start' => $evento['start'],
        'end' => $evento['end'],
    ];

    Reporte::insert($reporteData);

    return response()->json($reporteData);
}
}
