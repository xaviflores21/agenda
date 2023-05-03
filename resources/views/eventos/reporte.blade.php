@extends('layouts.app')

@section('content')
<table class="table">
<form action="{{ route('reporte.index') }}" method="get" class="d-flex justify-content-end">
  <div class="row">
    <div class="col-md-8">
      <div class="input-group">
        <select class="form-control" name="search_by" style="width: 20%;">
          <option value="all">Todos los campos</option>
          <option value="id">ID</option>
          <option value="userNombre">Usuario</option>
          <option value="idEvento">idEvento</option>
          <option value="encargadaEvento">Encargada</option>
          <option value="cliente">Cliente</option>
          <option value="habitacion">Habitación</option>
          <option value="servicio">Servicio</option>
          <option value="start">Inicio</option>
          <option value="end">Fin</option>
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
        <a href="{{ route('reporte.index') }}" class="btn btn-secondary mr-2">Reordenar</a>
        <a href="{{url('/')}}" class="btn btn-secondary">Menu principal</a>
      </div>
    </div>
  </div>
</form>



<br>
  <thead>
    <tr>
    <th>
        <a href="{{ route('reporte.index', ['sort' => 'id', 'sort_direction' => ($sort == 'id' && $sortDirection == 'asc') ? 'desc' : 'asc']) }}">#</a>
        @if ($sort == 'id')
        @if ($sortDirection == 'asc')
        <i class="fa fa-sort-up"></i>
        @else
        <i class="fa fa-sort-down"></i>
        @endif
        @endif
      </th>
      <th>
        <a href="{{ route('reporte.index', ['sort' => 'userNombre', 'sort_direction' => ($sort == 'userNombre' && $sortDirection == 'asc') ? 'desc' : 'asc']) }}">Usuario</a>
        @if ($sort == 'userNombre')
          @if ($sortDirection == 'asc')
            <i class="fa fa-sort-up"></i>
          @else
            <i class="fa fa-sort-down"></i>
          @endif
        @endif
      </th>
      <th>
        <a href="{{ route('reporte.index', ['sort' => 'idEvento', 'sort_direction' => ($sort == 'idEvento' && $sortDirection == 'asc') ? 'desc' : 'asc']) }}">ID Eventos</a>
        @if ($sort == 'idEvento')
        @if ($sortDirection == 'asc')
        <i class="fa fa-sort-up"></i>
        @else
        <i class="fa fa-sort-down"></i>
        @endif
        @endif
      </th>
      <th>
        <a href="{{ route('reporte.index', ['sort' => 'encargadaEvento', 'sort_direction' => ($sort == 'encargadaEvento' && $sortDirection == 'asc') ? 'desc' : 'asc']) }}">Encargada</a>
        @if ($sort == 'encargadaEvento')
        @if ($sortDirection == 'asc')
        <i class="fa fa-sort-up"></i>
        @else
        <i class="fa fa-sort-down"></i>
        @endif
        @endif
      </th>
      <th>
        <a href="{{ route('reporte.index', ['sort' => 'cliente', 'sort_direction' => ($sort == 'cliente' && $sortDirection == 'asc') ? 'desc' : 'asc']) }}">Cliente</a>
        @if ($sort == 'cliente')
        @if ($sortDirection == 'asc')
        <i class="fa fa-sort-up"></i>
        @else
        <i class="fa fa-sort-down"></i>
        @endif
        @endif
      </th>
        

      <th>
        <a href="{{ route('reporte.index', ['sort' => 'habitacion', 'sort_direction' => ($sort == 'habitacion' && $sortDirection == 'asc') ? 'desc' : 'asc']) }}">Habitacion</a>
        @if ($sort == 'habitacion')
        @if ($sortDirection == 'asc')
        <i class="fa fa-sort-up"></i>
        @else
        <i class="fa fa-sort-down"></i>
        @endif
        @endif
      </th>
      <th>
        <a href="{{ route('reporte.index', ['sort' => 'servicio', 'sort_direction' => ($sort == 'servicio' && $sortDirection == 'asc') ? 'desc' : 'asc']) }}">Servicio</a>
        @if ($sort == 'servicio')
        @if ($sortDirection == 'asc')
        <i class="fa fa-sort-up"></i>
        @else
        <i class="fa fa-sort-down"></i>
        @endif
        @endif
      </th>
      <th>
        <a href="{{ route('reporte.index', ['sort' => 'start', 'sort_direction' => ($sort == 'start' && $sortDirection == 'asc') ? 'desc' : 'asc']) }}">Inicio del Evento</a>
        @if ($sort == 'start')
        @if ($sortDirection == 'asc')
        <i class="fa fa-sort-up"></i>
        @else
        <i class="fa fa-sort-down"></i>
        @endif
        @endif
      </th>
      <th>
        <a href="{{ route('reporte.index', ['sort' => 'end', 'sort_direction' => ($sort == 'end' && $sortDirection == 'asc') ? 'desc' : 'asc']) }}">Final del Evento</a>
        @if ($sort == 'end')
        @if ($sortDirection == 'asc')
        <i class="fa fa-sort-up"></i>
        @else
        <i class="fa fa-sort-down"></i>
        @endif
        @endif
      </th>
      <th>
        <a href="{{ route('reporte.index', ['sort' => 'estado', 'sort_direction' => ($sort == 'estado' && $sortDirection == 'asc') ? 'desc' : 'asc']) }}">Estado</a>
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
    @foreach($reportes as $reporte)
    <tr>
      <td>{{ $reporte->id }}</td>
     
      <td>{{ $reporte->userNombre }}</td>
      <td>{{ $reporte->idEvento }}</td>
      <td>{{ $reporte->encargadaEvento }}</td>
      <td>{{ $reporte->cliente }}</td>
      <td>{{ $reporte->habitacion }}</td>
      <td>{{ $reporte->servicio }}</td>
      <td>{{ $reporte->start }}</td>
      <td>{{ $reporte->end }}</td>
      <td>{{ $reporte->estado }}</td>
    </tr>
    @endforeach
  </tbody>
</table>
@endsection
