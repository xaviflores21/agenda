<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evento;
use App\Models\User;
use App\Models\Reporte;
use App\Models\Personas;
use App\Models\ReporteUsuarios;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
class ReporteUsuariosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->middleware('auth');
        
        $query = ReporteUsuarios::query();
    
        // If search term is provided, filter the results
        if ($request->has('search') && $request->has('search_by')) {
            $searchTerm = $request->input('search');
            $searchBy = $request->input('search_by');
          
            if ($searchBy == 'all') {
                $query->where(function($q) use ($searchTerm) {
                    $q->where('id', 'like', '%'.$searchTerm.'%')
                      ->orWhere('usuario_id', 'like', '%'.$searchTerm.'%')
                      ->orWhere('usuario', 'like', '%'.$searchTerm.'%')
                      ->orWhere('email', 'like', '%'.$searchTerm.'%')
                      ->orWhere('rol', 'like', '%'.$searchTerm.'%')
                      ->orWhere('estado', 'like', '%'.$searchTerm.'%');
                });
            } else  if ($searchBy == 'id') {
                $query->where('id', $searchTerm);
            }else  if ($searchBy == 'usuario_id') {
                $query->where('usuario_id', $searchTerm);
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
        case 'usuario':
            $query->orderBy('usuario', $request->input('sort_direction', 'asc'));
            break;
        case 'email':
            $query->orderBy('email', $request->input('sort_direction', 'asc'));
            break;
        case 'rol':
            $query->orderBy('rol', $request->input('sort_direction', 'asc'));
            break;
        case 'estado':
            $query->orderBy('estado', $request->input('sort_direction', 'asc'));
            break;
      
    }
    

    $sortDirection = $request->input('sort_direction', 'asc');
    if (!empty($sort)) {
        $query->orderBy($sort, $sortDirection);
    }
    
    
        // Get the results
        $reporteUsuarios = $query->get();
    
        // Return the data to the view
        return view('eventos.reporteUsuarios', compact('reporteUsuarios','sort','sortDirection'));
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
    
    }
    
    
}
