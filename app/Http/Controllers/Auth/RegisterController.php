<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\ReporteUsuarios;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;
    protected function registered(Request $request, $user)
    {
     /*   Auth::logout();
        return redirect()->route('login')->with('success', 'Registration successful. Please log in to continue.');
        Estas lineas de arriba son para cuando un registro sea exitoso vuelve a la pagina principal
        */
        return redirect('/');
    }
    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required','string'], // each role should be a string
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
{
    // Check if there is already an admin user
    $adminCount = User::where('role', 'admin')->count();

    if ($adminCount > 0 && $data['role'] === 'admin') {
        throw ValidationException::withMessages(['role' => 'Only one admin is allowed']);
    }

    // If there is no admin user, allow registration
    if ($adminCount === 0) {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role']
        ]);
        
        // Create a new reporteUsuario entry
        $ReporteUsuarios = new ReporteUsuarios();
        $ReporteUsuarios->usuario_id = $user->id;
        $ReporteUsuarios->usuario = $user->name;
        $ReporteUsuarios->email = $user->email;
        $ReporteUsuarios->rol = $user->role;
        $ReporteUsuarios->estado='C';
        $ReporteUsuarios->save();

        return $user;
    }

    // If there is an admin user, check if the current user is an admin
    $user = Auth::user();
    if (!$user || (!$user->isAdmin() && !$user->esJefeDeArea())) {
        abort(403, 'Unauthorized action.');
    }

    $newUser = User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password']),
        'role' => $data['role']
    ]);
    
    // Create a new reporteUsuario entry
    $ReporteUsuarios = new ReporteUsuarios();
    $ReporteUsuarios->usuario_id = $newUser->id;
    $ReporteUsuarios->usuario = $newUser->name;
    $ReporteUsuarios->email = $newUser->email;
    $ReporteUsuarios->rol = $newUser->role;
    $ReporteUsuarios->estado='C';
    $ReporteUsuarios->save();

    return $user;
}

    
    
    
}
