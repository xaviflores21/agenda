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
          <option value="idPersona">Personal ID</option>
          <option value="nombreCompletoPersona">Personal</option>
          <option value="telefono">Telefono</option>
          <option value="color">Color</option>
          <option value="estadoPersona">Estado</option>
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
        <a href="{{ route('reportePersona.index') }}" class="btn btn-secondary mr-2">Reordenar</a>
        <a href="{{url('/')}}" class="btn btn-secondary">Menu principal</a>
      </div>
    </div>
  </div>
</form>



<br>
  <thead>
    <tr>
    <th>
        <a href="{{ route('reportePersona.index', ['sort' => 'id', 'sort_direction' => ($sort == 'id' && $sortDirection == 'asc') ? 'desc' : 'asc']) }}">#</a>
        @if ($sort == 'id')
        @if ($sortDirection == 'asc')
        <i class="fa fa-sort-up"></i>
        @else
        <i class="fa fa-sort-down"></i>
        @endif
        @endif
      </th>
      <th>
        <a href="{{ route('reportePersona.index', ['sort' => 'idPersona', 'sort_direction' => ($sort == 'idPersona' && $sortDirection == 'asc') ? 'desc' : 'asc']) }}">Personal ID</a>
        @if ($sort == 'idPersona')
          @if ($sortDirection == 'asc')
            <i class="fa fa-sort-up"></i>
          @else
            <i class="fa fa-sort-down"></i>
          @endif
        @endif
      </th>
      <th>
        <a href="{{ route('reportePersona.index', ['sort' => 'nombreCompletoPersona', 'sort_direction' => ($sort == 'nombreCompletoPersona' && $sortDirection == 'asc') ? 'desc' : 'asc']) }}">Personal</a>
        @if ($sort == 'nombreCompletoPersona')
          @if ($sortDirection == 'asc')
            <i class="fa fa-sort-up"></i>
          @else
            <i class="fa fa-sort-down"></i>
          @endif
        @endif
      </th>
      <th>
        <a href="{{ route('reportePersona.index', ['sort' => 'telefono', 'sort_direction' => ($sort == 'telefono' && $sortDirection == 'asc') ? 'desc' : 'asc']) }}">Telefono</a>
        @if ($sort == 'telefono')
        @if ($sortDirection == 'asc')
        <i class="fa fa-sort-up"></i>
        @else
        <i class="fa fa-sort-down"></i>
        @endif
        @endif
      </th>
      <th>
        <a href="{{ route('reportePersona.index', ['sort' => 'color', 'sort_direction' => ($sort == 'color' && $sortDirection == 'asc') ? 'desc' : 'asc']) }}">Color</a>
        @if ($sort == 'color')
        @if ($sortDirection == 'asc')
        <i class="fa fa-sort-up"></i>
        @else
        <i class="fa fa-sort-down"></i>
        @endif
        @endif
      </th>
      <th>
        <a href="{{ route('reportePersona.index', ['sort' => 'estadoPersona', 'sort_direction' => ($sort == 'estadoPersona' && $sortDirection == 'asc') ? 'desc' : 'asc']) }}">Estado</a>
        @if ($sort == 'estadoPersona')
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
    @foreach($reportePersona as $reporte)
    <tr>
      <td>{{ $reporte->id }}</td>
     
      <td>{{ $reporte->idPersona }}</td>
      <td>{{ $reporte->nombreCompletoPersona }}</td>
      <td>{{ $reporte->telefono }}</td>
      <td>{{ $reporte->color }}</td>
      <td>{{ $reporte->estadoPersona }}</td>
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
