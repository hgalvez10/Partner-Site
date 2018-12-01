@extends('layouts.app')

@section('content')
<section class="content-header">
	<h1>
		Nombres de Dominio
		<small>Todos</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="/"><i class="fa fa-home"></i> Home</a></li>
		<li class="active">Todas</li>
	</ol>
</section>

<section class="content">
	@if(session('message'))
	<div class="alert alert-{{ session('type') }} alert-dismissible">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		<h4><i class="icon fa {{ session('icon') }}"></i> {{ session('title') }}</h4>
		{{ session('message') }}
	</div>
	@endif

	<div class="box box-primary">
		<div class="box-header with-border">
			<h3 class="box-title">Todos los dominios asociados</h3>
		</div>
		<div class="box-body">
			<table id="table" class="table" data-order='[[1, "asc"]]'>
				<thead>
					<tr>
						<th>Nombre de dominio</th>
						<th>Fecha Creación</th>
						<th>Fecha Expiración</th>
						<th class="disable-sorting text-center">Acciones</th>
					</tr>
				</thead>
				<tbody>
					@foreach($domains as $domain)
					<tr>
						<td>{{ ucfirst($domain->domainName) }}</td>
						<td>{{ $domain->created_at }}</td>
						<td>{{ $domain->expirate_date }}</td>

						<td class="text-center">
							<a onclick="renewDomain('{{ $domain->id }}')" class="btn btn-warning btn-xs">Renovar</a>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		<div class="box-footer">
			<a href="/home" class="btn btn-default btn-flat">Volver</a>
		</div>
	</div>
</section>
@endsection
@section('modal')
<div class="modal fade" id="RenewModal" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Renovar Dominio</h4>
			</div>
			<form id="form-renew" method="POST" role="form">
				{{ csrf_field() }}
				<div class="modal-body">
	             	<div class="form-group has-feedback {{ $errors->has('period') ? 'has-error': '' }}">
	                	<label>Periodo de Renovación</label>
	                	<input type="number" class="form-control" placeholder="periodo en años" min="1" max="9" name="period">
		                @if ($errors->has('period'))
		                <span class="help-block">
		                  <strong>{{ $errors->first('period') }}</strong>
		                </span>
		                @endif
              		</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-success pull-left" >Si, renovar</button>
					<button type="button" class="btn btn-default pull-rigth" data-dismiss="modal">No, Cancelar</button>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection

@section('style')
<link rel="stylesheet" href="{{ asset('plugins/datatables/datatables.min.css') }}"/>
@endsection('style')

@section('script')

<script>
	function renewDomain(id){
		$('#form-renew').attr('action', '/domain/renew/'+id);
		$('#RenewModal').modal('toggle');
	};
</script>

<script src="{{ asset('plugins/datatables/datatables.min.js') }}"></script>

<script>
    var table;
    $(document).ready(function () {
        table = $("#table").DataTable({
            "responsive": true,
            "order": [0, 'asc'],
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "columnDefs": [
                    { targets: 'no-sort', orderable: false }
                ], 
            "language": {
                "sProcessing":     "Procesando...",
                "sLengthMenu":     "Mostrar _MENU_ registros",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningún dato disponible en esta tabla",
                "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix":    "",
                "sSearch":         "Buscar:",
                "sUrl":            "",
                "sInfoThousands":  ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst":    "Primero",
                    "sLast":     "Último",
                    "sNext":     "Siguiente",
                    "sPrevious": "Anterior"
                }, 
                "oAria": {
                    "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            },
        });
    });
</script>
@endsection