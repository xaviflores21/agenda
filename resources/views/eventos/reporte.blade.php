@extends('layouts.app')

@section('content')
<table class="table">
  <thead>
    <tr>
      <th scope="col">
        <a href="{{ route('reporte.index', ['sort' => 'id']) }}">#</a>
      </th>
      <th scope="col">
        <a href="{{ route('reporte.index', ['sort' => 'userNombre']) }}">Usuario</a>
      </th>
      <th scope="col">
        <a href="{{ route('reporte.index', ['sort' => 'idEvento']) }}">Id Evento</a>
      </th>
      <th scope="col">
        <a href="{{ route('reporte.index', ['sort' => 'encargadaEvento']) }}">Encargada</a>
      </th>
      <th scope="col">
        <a href="{{ route('reporte.index', ['sort' => 'cliente']) }}">Cliente</a>
      </th>
      <th scope="col">
        <a href="{{ route('reporte.index', ['sort' => 'habitacion']) }}">Habitación</a>
      </th>
      <th scope="col">
        <a href="{{ route('reporte.index', ['sort' => 'servicio']) }}">Servicio</a>
      </th>
      <th scope="col">
        <a href="{{ route('reporte.index', ['sort' => 'start']) }}">Inicio</a>
      </th>
      <th scope="col">
        <a href="{{ route('reporte.index', ['sort' => 'end']) }}">Fin</a>
      </th>
      <th scope="col">
        <a href="{{ route('reporte.index', ['sort' => 'estado']) }}">Estado</a>
      </th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td colspan="9">
      <form action="{{ route('reporte.index') }}" method="get" class="d-flex justify-content-end">
  <div class="row">
    <div class="col-md-8">
      <div class="input-group">
        <select class="form-control"  name="search_by" >
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
        <input type="text" class="form-control" placeholder="Search" name="search">
        <div class="input-group-append">
          <button class="btn btn-secondary" type="submit">
            <i class="fa fa-search">Buscar</i>
          </button>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <a href="{{ route('reporte.index') }}" class="btn btn-secondary float-right">Reset Order</a>
    </div>
  </div>
</form>

      </td>
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
