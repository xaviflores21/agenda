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
    public function index(Request $request)
    {
        $this->middleware('auth');
        
        $query = reporte::query();
    
        // If search term is provided, filter the results
        if ($request->has('search') && $request->has('search_by')) {
            $searchTerm = $request->input('search');
            $searchBy = $request->input('search_by');
          
            if ($searchBy == 'all') {
                $query->where(function($q) use ($searchTerm) {
                    $q->where('id', 'like', '%'.$searchTerm.'%')
                      ->orWhere('userNombre', 'like', '%'.$searchTerm.'%')
                      ->orWhere('idEvento', 'like', '%'.$searchTerm.'%')
                      ->orWhere('encargadaEvento', 'like', '%'.$searchTerm.'%')
                      ->orWhere('cliente', 'like', '%'.$searchTerm.'%')
                      ->orWhere('habitacion', 'like', '%'.$searchTerm.'%')
                      ->orWhere('servicio', 'like', '%'.$searchTerm.'%')
                      ->orWhere('start', 'like', '%'.$searchTerm.'%')
                      ->orWhere('end', 'like', '%'.$searchTerm.'%')
                      ->orWhere('estado', 'like', '%'.$searchTerm.'%');
                });
            } else  if ($searchBy == 'id') {
                $query->where('id', $searchTerm);
            }else  if ($searchBy == 'idEvento') {
                $query->where('idEvento', $searchTerm);
            } else {
                $query->where($searchBy, 'like', '%'.$searchTerm.'%');
            }
        }
    
        // Get the sort parameter from the request
        $sort = $request->input('sort');
    
        // Determine the column to sort by based on the sort parameter
     
      switch ($sort) {
        case 'id':
            $query->orderBy('id', $request->input('sort_direction', 'asc'));
            break;
        case 'userNombre':
            $query->orderBy('userNombre', $request->input('sort_direction', 'asc'));
            break;
        case 'idEvento':
            $query->orderBy('idEvento', $request->input('sort_direction', 'asc'));
            break;
        case 'encargadaEvento':
            $query->orderBy('encargadaEvento', $request->input('sort_direction', 'asc'));
            break;
        case 'cliente':
            $query->orderBy('cliente', $request->input('sort_direction', 'asc'));
            break;
        case 'habitacion':
            $query->orderBy('habitacion', $request->input('sort_direction', 'asc'));
            break;
        case 'servicio':
            $query->orderBy('servicio', $request->input('sort_direction', 'asc'));
            break;
        case 'start':
            $query->orderBy('start', $request->input('sort_direction', 'asc'));
            break;
        case 'end':
            $query->orderBy('end', $request->input('sort_direction', 'asc'));
            break;
        case 'estado':
            $query->orderBy('estado', $request->input('sort_direction', 'asc'));
            break;
        default:
            $query->orderBy('id', $request->input('sort_direction', 'asc'));
            break;
    }
    

    $sortDirection = $request->input('sort_direction', 'asc');
    if (!empty($sort)) {
        $query->orderBy($sort, $sortDirection);
    }
    
    
        // Get the results
        $reportes = $query->get();
    
        // Return the data to the view
        return view('eventos.reporte', compact('reportes','sort','sortDirection'));
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
