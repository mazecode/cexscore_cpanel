@extends('layouts.cpanel')

@section('title')
	Todos Usuarios
@endsection

@section('page-title')
	<i class="fa fa-home fa-fw"></i>Todos Usuarios
@endsection

@section('breadcrumb')
	@parent
	<li class="active">Usuarios</li>
@endsection

@section('content')
	<p>{{ link_to_route('admin.usuarios.create', 'Agregar Nuevo Usuario', null, array('class' => 'btn btn-lg btn-success')) }}</p>

	@if(isset($message) && $message != '')
		<div class="alert alert-info">
			<ul>
				{{{ $message }}}
			</ul>
		</div>
	@endif

	@if ($usuarios->count())
		<table class="table table-striped table-condensed table-hover">
			<thead>
			<tr>
				<th>Nombre</th>
				<th>RUT Usuario</th>
				<th>Usuario</th>
				<th>Correo</th>
				<th>&nbsp;</th>
			</tr>
			</thead>

			<tbody>
			@foreach ($usuarios as $usuario)
				<tr>
					<td>{{{ $usuario->nombre_usuario }}}</td>
					<td>{{{ $usuario->rut_usuario }}}</td>
					<td>{{{ $usuario->username }}}</td>
					<td>{{{ $usuario->correo_usuario }}}</td>
					<td>
						@if($usuario->id_tipo_usuario != 1)
							{{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('admin.usuarios.destroy', $usuario->id_usuario))) }}
							{{ Form::submit('Eliminar', array('class' => 'btn btn-danger')) }}
							{{ Form::close() }}
						@endif
						{{ link_to_route('admin.usuarios.edit', 'Editar', array($usuario->id_usuario), array('class' => 'btn btn-info')) }}
						{{ Form::open(array('class' => 'resetForm','style' => 'display: inline-block;', 'method' => 'POST', 'url' => array('admin/usuarios/resetPassword', $usuario->id_usuario)))}}
						{{ Form::submit('Reset Password', array('class' => 'btn btn-link resetButton')) }}
						{{ Form::close() }}
						{{--						<a href="{{ url('/admin/usuarios/resetPassword', array($usuario->id_usuario)) }}" class="bnt btn-link">Reset Password</a>--}}
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
	@else
		No se han encontrado usuarios.
	@endif
@endsection

@section('script')
	{{ HTML::script('js/bootbox.min.js') }}
	<script>
		(function ($) {
			$('.resetButton').on('click', function (e) {
				e.preventDefault();

				var $form = $(this).parents('form:first');

				bootbox.confirm("Está seguro que desea restaurar la contraseña?", function (result) {
					if (result) {
						$form.submit();
					}
				});

				return false;
			});


		})(jQuery);
	</script>
@endsection