@extends('layouts.app')

@section('content')
<table class="table">
<form action="{{ route('reporteUsuarios.index') }}" method="get" class="d-flex justify-content-end">
  <div class="row">
    <div class="col-md-8">
      <div class="input-group">
        <select class="form-control" name="search_by" style="width: 20%;">
          <option value="all">Todos los campos</option>
          <option value="id">#</option>
          <option value="usuario_id">Usuario ID</option>
          <option value="usuario">Usuario</option>
          <option value="email">Email</option>
          <option value="rol">Rol</option>
          <option value="estado">Estado</option>
        </select>
        <input type="text" class="form-control" placeholder="Buscar..." name="search" style="width: 60%;">
        <div class="input-group-append">
          <button class="btn btn-secondary" type="submit">
            <i class="fa fa-search"></i>Buscar
          </button>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="d-flex justify-content-end">
        <a href="{{ route('reporteUsuarios.index') }}" class="btn btn-secondary mr-2">Reordenar</a>
        <a href="{{url('/')}}" class="btn btn-secondary">Menu principal</a>
      </div>
    </div>
  </div>
</form>



<br>
  <thead>
    <tr>
    <th>
        <a href="{{ route('reporteUsuarios.index', ['sort' => 'id', 'sort_direction' => ($sort == 'id' && $sortDirection == 'asc') ? 'desc' : 'asc']) }}">#</a>
        @if ($sort == 'id')
        @if ($sortDirection == 'asc')
        <i class="fa fa-sort-up"></i>
        @else
        <i class="fa fa-sort-down"></i>
        @endif
        @endif
      </th>
      <th>
        <a href="{{ route('reporteUsuarios.index', ['sort' => 'usuario_id', 'sort_direction' => ($sort == 'usuario_id' && $sortDirection == 'asc') ? 'desc' : 'asc']) }}">Usuario ID</a>
        @if ($sort == 'usuario_id')
          @if ($sortDirection == 'asc')
            <i class="fa fa-sort-up"></i>
          @else
            <i class="fa fa-sort-down"></i>
          @endif
        @endif
      </th>
      <th>
        <a href="{{ route('reporteUsuarios.index', ['sort' => 'usuario', 'sort_direction' => ($sort == 'usuario' && $sortDirection == 'asc') ? 'desc' : 'asc']) }}">Nombre del usuario</a>
        @if ($sort == 'usuario')
          @if ($sortDirection == 'asc')
            <i class="fa fa-sort-up"></i>
          @else
            <i class="fa fa-sort-down"></i>
          @endif
        @endif
      </th>
      <th>
        <a href="{{ route('reporteUsuarios.index', ['sort' => 'email', 'sort_direction' => ($sort == 'email' && $sortDirection == 'asc') ? 'desc' : 'asc']) }}">Email del usuario</a>
        @if ($sort == 'email')
        @if ($sortDirection == 'asc')
        <i class="fa fa-sort-up"></i>
        @else
        <i class="fa fa-sort-down"></i>
        @endif
        @endif
      </th>
      <th>
        <a href="{{ route('reporteUsuarios.index', ['sort' => 'rol', 'sort_direction' => ($sort == 'rol' && $sortDirection == 'asc') ? 'desc' : 'asc']) }}">Rol</a>
        @if ($sort == 'rol')
        @if ($sortDirection == 'asc')
        <i class="fa fa-sort-up"></i>
        @else
        <i class="fa fa-sort-down"></i>
        @endif
        @endif
      </th>
      <th>
        <a href="{{ route('reporteUsuarios.index', ['sort' => 'estado', 'sort_direction' => ($sort == 'estado' && $sortDirection == 'asc') ? 'desc' : 'asc']) }}">Estado</a>
        @if ($sort == 'estado')
        @if ($sortDirection == 'asc')
        <i class="fa fa-sort-up"></i>
        @else
        <i class="fa fa-sort-down"></i>
        @endif
        @endif
      </th>
        
    </tr>
  </thead>
  <tbody>
    <tr>
    </tr>
    @foreach($reporteUsuarios as $reporte)
    <tr>
      <td>{{ $reporte->id }}</td>
     
      <td>{{ $reporte->usuario_id }}</td>
      <td>{{ $reporte->usuario }}</td>
      <td>{{ $reporte->email }}</td>
      <td>{{ $reporte->rol }}</td>
      <td>{{ $reporte->estado }}</td>
      <!-- <td>
              <button class="btn btn-primary" id="submitButton" data-bs-toggle="modal" data-bs-target="#editModal{{$reporte->id}}" data-id="{{ $reporte->id }}" data-usuario_id="{{ $reporte->usuario_id }}" data-usuario="{{ $reporte->usuario }}" data-email="{{ $reporte->email }}" data-rol="{{ $reporte->rol }}" data-estado="{{ $reporte->estado }}">Modificar</button>
              <form action="{{ route('reporteUsuarios.destroy', $reporte->id) }}" method="POST" style="display: inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Borrar</button>
              </form>
        </td> -->
    </tr>
    @endforeach
  </tbody>
</table>
@endsection
