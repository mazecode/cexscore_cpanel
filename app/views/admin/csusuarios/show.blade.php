@extends('layouts.cpanel')

@section('title')
	Ver Usuario
@endsection

@section('page-title')
	<i class="fa fa-eye fa-fw"></i>Ver Usuario
@endsection

@section('breadcrumb')
	@parent
	<li>Usuarios</li>
	<li class="active">Ver</li>
@endsection

@section('content')
	<p>{{ link_to_route('admin.csusuarios.index', 'Volver a usuarios', null, array('class'=>'btn btn-lg btn-primary')) }}</p>

	<table class="table table-striped table-condensed table-hover">
		<thead>
		<tr>
			<th>Nombre</th>
			<th>RUT</th>
			<th>Usuario</th>
			<th>E-Mail</th>
		</tr>
		</thead>
		<tbody>
		<tr>
			<td>{{{ $usuario->nombre }}}</td>
			<td>{{{ $usuario->rut }}}</td>
			<td>{{{ $usuario->usuario }}}</td>
			<td>{{{ $usuario->email }}}</td>
			<td>
				{{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('admin.csusuarios.destroy', $usuario->id_usuario))) }}
				{{ Form::submit('Eliminar', array('class' => 'btn btn-danger')) }}
				{{ Form::close() }}
				{{ link_to_route('admin.csusuarios.edit', 'Editar', array($usuario->id_usuario), array('class' => 'btn btn-info')) }}
			</td>
		</tr>
		</tbody>
	</table>
@endsection