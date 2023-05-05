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
          <option value="idHorarios">Horario ID</option>
          <option value="horarioInicio">Inicio del horario</option>
          <option value="horarioFinal">Final del horario</option>
          <option value="lunes">Lunes</option>
          <option value="martes">Martes</option>
          <option value="miercoles">Miercoles</option>
          <option value="jueves">Jueves</option>
          <option value="viernes">Viernes</option>
          <option value="sabado">Sabado</option>
          <option value="domingo">Domingo</option>
          <option value="estadoHorarios">Estado</option>
        </select>
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
        <a href="{{ route('reporteHorario.index') }}" class="btn btn-secondary mr-2">Reordenar</a>
        <a href="{{url('/')}}" class="btn btn-secondary">Menu principal</a>
      </div>
    </div>
  </div>
</form>



<br>
  <thead>
    <tr>
    <th>
        <a href="{{ route('reporteHorario.index', ['sort' => 'id', 'sort_direction' => ($sort == 'id' && $sortDirection == 'asc') ? 'desc' : 'asc']) }}">#</a>
        @if ($sort == 'id')
        @if ($sortDirection == 'asc')
        <i class="fa fa-sort-up"></i>
        @else
        <i class="fa fa-sort-down"></i>
        @endif
        @endif
      </th>
      <th>
        <a href="{{ route('reporteHorario.index', ['sort' => 'idHorarios', 'sort_direction' => ($sort == 'idHorarios' && $sortDirection == 'asc') ? 'desc' : 'asc']) }}">Horarios ID</a>
        @if ($sort == 'idHorarios')
          @if ($sortDirection == 'asc')
            <i class="fa fa-sort-up"></i>
          @else
            <i class="fa fa-sort-down"></i>
          @endif
        @endif
      </th>
      <th>
        <a href="{{ route('reporteHorario.index', ['sort' => 'horarioInicio', 'sort_direction' => ($sort == 'horarioInicio' && $sortDirection == 'asc') ? 'desc' : 'asc']) }}">Inicio del horario</a>
        @if ($sort == 'horarioInicio')
          @if ($sortDirection == 'asc')
            <i class="fa fa-sort-up"></i>
          @else
            <i class="fa fa-sort-down"></i>
          @endif
        @endif
      </th>
      <th>
        <a href="{{ route('reporteHorario.index', ['sort' => 'horarioFinal', 'sort_direction' => ($sort == 'horarioFinal' && $sortDirection == 'asc') ? 'desc' : 'asc']) }}">Final del horario</a>
        @if ($sort == 'horarioFinal')
        @if ($sortDirection == 'asc')
        <i class="fa fa-sort-up"></i>
        @else
        <i class="fa fa-sort-down"></i>
        @endif
        @endif
      </th>
      <th>
        <a href="{{ route('reporteHorario.index', ['sort' => 'lunes', 'sort_direction' => ($sort == 'lunes' && $sortDirection == 'asc') ? 'desc' : 'asc']) }}">Lunes</a>
        @if ($sort == 'lunes')
        @if ($sortDirection == 'asc')
        <i class="fa fa-sort-up"></i>
        @else
        <i class="fa fa-sort-down"></i>
        @endif
        @endif
      </th>
      <th>
        <a href="{{ route('reporteHorario.index', ['sort' => 'martes', 'sort_direction' => ($sort == 'martes' && $sortDirection == 'asc') ? 'desc' : 'asc']) }}">Martes</a>
        @if ($sort == 'martes')
        @if ($sortDirection == 'asc')
        <i class="fa fa-sort-up"></i>
        @else
        <i class="fa fa-sort-down"></i>
        @endif
        @endif
      </th>
      <th>
        <a href="{{ route('reporteHorario.index', ['sort' => 'miercoles', 'sort_direction' => ($sort == 'miercoles' && $sortDirection == 'asc') ? 'desc' : 'asc']) }}">Miercoles</a>
        @if ($sort == 'miercoles')
        @if ($sortDirection == 'asc')
        <i class="fa fa-sort-up"></i>
        @else
        <i class="fa fa-sort-down"></i>
        @endif
        @endif
      </th>
      <th>
        <a href="{{ route('reporteHorario.index', ['sort' => 'jueves', 'sort_direction' => ($sort == 'jueves' && $sortDirection == 'asc') ? 'desc' : 'asc']) }}">Jueves</a>
        @if ($sort == 'jueves')
        @if ($sortDirection == 'asc')
        <i class="fa fa-sort-up"></i>
        @else
        <i class="fa fa-sort-down"></i>
        @endif
        @endif
      </th>
      <th>
        <a href="{{ route('reporteHorario.index', ['sort' => 'viernes', 'sort_direction' => ($sort == 'viernes' && $sortDirection == 'asc') ? 'desc' : 'asc']) }}">Viernes</a>
        @if ($sort == 'viernes')
        @if ($sortDirection == 'asc')
        <i class="fa fa-sort-up"></i>
        @else
        <i class="fa fa-sort-down"></i>
        @endif
        @endif
      </th>
      <th>
        <a href="{{ route('reporteHorario.index', ['sort' => 'sabado', 'sort_direction' => ($sort == 'sabado' && $sortDirection == 'asc') ? 'desc' : 'asc']) }}">Sabado</a>
        @if ($sort == 'sabado')
        @if ($sortDirection == 'asc')
        <i class="fa fa-sort-up"></i>
        @else
        <i class="fa fa-sort-down"></i>
        @endif
        @endif
      </th>
      <th>
        <a href="{{ route('reporteHorario.index', ['sort' => 'domingo', 'sort_direction' => ($sort == 'domingo' && $sortDirection == 'asc') ? 'desc' : 'asc']) }}">Domingo</a>
        @if ($sort == 'domingo')
        @if ($sortDirection == 'asc')
        <i class="fa fa-sort-up"></i>
        @else
        <i class="fa fa-sort-down"></i>
        @endif
        @endif
      </th>
      <th>
        <a href="{{ route('reporteHorario.index', ['sort' => 'estadoHorarios', 'sort_direction' => ($sort == 'estadoHorarios' && $sortDirection == 'asc') ? 'desc' : 'asc']) }}">Estado</a>
        @if ($sort == 'estadoHorarios')
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
    @foreach($reporteHorario as $reporte)
    <tr>
      <td>{{ $reporte->id }}</td>
     
      <td>{{ $reporte->idHorarios }}</td>
      <td>{{ $reporte->horarioInicio }}</td>
      <td>{{ $reporte->horarioFinal }}</td>
      <td>{{ $reporte->lunes ? 'lun' : '-' }}</td>
      <td>{{ $reporte->martes ? 'mar' : '-' }}</td>
      <td>{{ $reporte->miercoles ? 'mie' : '-' }}</td>
      <td>{{ $reporte->jueves ? 'jue' : '-' }}</td>
      <td>{{ $reporte->viernes ? 'vie' : '-' }}</td>
      <td>{{ $reporte->sabado ? 'sab' : '-' }}</td>
      <td>{{ $reporte->domingo ? 'dom' : '-' }}</td>
      <td>{{$reporte->estadoHorarios}}</td>
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
