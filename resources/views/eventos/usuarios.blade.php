@extends('layouts.app')

@section('content')
<table class="table">
<form action="{{ route('reporteUsuarios.index') }}" method="get" class="d-flex justify-content-end">
  <div class="row">
    <div class="col-md-8">
      <div class="input-group">
        <select class="form-control" name="search_by" style="width: 20%;">
          <option value="all">Todos los campos</option>
          <option value="id">ID</option>
          <option value="name">Usuario</option>
          <option value="email">Email</option>
          <option value="role">Rol</option>
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
        <a href="{{ route('usuariosTable.index') }}" class="btn btn-secondary mr-2">Reordenar</a>
        <a href="{{url('/')}}" class="btn btn-secondary">Menu principal</a>
      </div>
    </div>
  </div>
</form>



<br>
  <thead>
    <tr>
    <th>
        <a href="{{ route('usuariosTable.index', ['sort' => 'id', 'sort_direction' => ($sort == 'id' && $sortDirection == 'asc') ? 'desc' : 'asc']) }}">ID</a>
        @if ($sort == 'id')
        @if ($sortDirection == 'asc')
        <i class="fa fa-sort-up"></i>
        @else
        <i class="fa fa-sort-down"></i>
        @endif
        @endif
      </th>
      <th>
        <a href="{{ route('usuariosTable.index', ['sort' => 'name', 'sort_direction' => ($sort == 'name' && $sortDirection == 'asc') ? 'desc' : 'asc']) }}">Nombre del usuario</a>
        @if ($sort == 'name')
          @if ($sortDirection == 'asc')
            <i class="fa fa-sort-up"></i>
          @else
            <i class="fa fa-sort-down"></i>
          @endif
        @endif
      </th>
      <th>
        <a href="{{ route('usuariosTable.index', ['sort' => 'email', 'sort_direction' => ($sort == 'email' && $sortDirection == 'asc') ? 'desc' : 'asc']) }}">Email del usuario</a>
        @if ($sort == 'email')
        @if ($sortDirection == 'asc')
        <i class="fa fa-sort-up"></i>
        @else
        <i class="fa fa-sort-down"></i>
        @endif
        @endif
      </th>
      <th>
        <a href="{{ route('usuariosTable.index', ['sort' => 'role', 'sort_direction' => ($sort == 'role' && $sortDirection == 'asc') ? 'desc' : 'asc']) }}">Rol</a>
        @if ($sort == 'role')
        @if ($sortDirection == 'asc')
        <i class="fa fa-sort-up"></i>
        @else
        <i class="fa fa-sort-down"></i>
        @endif
        @endif
      </th>
        <th><a href="">Acciones</a></th>
    </tr>
  </thead>
  <tbody>
    <tr>
    </tr>
    @foreach($usuario as $reporte)
    <tr>
      <td>{{ $reporte->id }}</td>    
      <td>{{ $reporte->name }}</td>
      <td>{{ $reporte->email }}</td>
      <td>{{ $reporte->role }}</td>
      <td>
              <button class="btn btn-primary" id="submitButton" data-bs-toggle="modal" data-bs-target="#editModal{{$reporte->id}}" data-id="{{ $reporte->id }}" data-usuario_id="{{ $reporte->id }}" data-usuario="{{ $reporte->name }}" data-email="{{ $reporte->email }}" data-rol="{{ $reporte->role }}" >Modificar</button>
              <form action="{{ route('usuariosTable.destroy', $reporte->id) }}" method="POST" style="display: inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Borrar</button>
              </form>
        </td>
    </tr>
    <!-- MODAL MODIFICADR -->
    <div class="modal fade" id="editModal{{$reporte->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Modificar</h5>
                  <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form id="editForm{{$reporte->id}}" action="{{ route('usuariosTable.update', $reporte->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                   
                    <div class="form row">
                    <div class="form-group col-md-6">
                      <label for="name{{$reporte->id}}">Usuario</label>
                      <input type="text" class="form-control" id="name{{$reporte->id}}" name="name" value="{{ $reporte->name }}">
                    </div>
                    <div class="form-group col-md-4">
    <label for="role">Role</label>
    <select class="form-control" id="role" name="role">
        <option value="admin"{{ old('role', $reporte->role) === 'admin' ? ' selected' : '' }}>admin</option>
        <option value="Jefe de area"{{ old('role', $reporte->role) === 'Jefe de area' ? ' selected' : '' }}>Jefe de area</option>
        <option value="empleado"{{ old('role', $reporte->role) === 'empleado' ? ' selected' : '' }}>empleado</option>
    </select>
</div>

                
                      <div class="form-group col-md-8">
                        <label for="email{{$reporte->id}}">Email</label>
                        <input type="text" class="form-control" id="email{{$reporte->id}}" name="email" value="{{ $reporte->email }}">
                      </div>
                      
                    </div>
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                      <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Guardar cambios</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
    @endforeach
    
  </tbody>
</table>
@endsection
