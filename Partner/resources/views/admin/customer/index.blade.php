@extends('layouts.app')

@section('content')

<section class="content-header">
	<h1>
		Cliente
		<small>Todos</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="/"><i class="fa fa-home"></i> Home</a></li>
		<li class="active">Cliente</li>
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
			<h3 class="box-title">Todos los clientes</h3>
		</div>
		<div class="box-body">
			<table id="table" class="table">
				<thead>
					<tr>
						<th>Nombre</th>
						<th>Organización</th>
						<th>Email</th>
						<th>Dirección</th>
						<th>Estado</th>
						<th class="disable-sorting text-center">Acciones</th>
					</tr>
				</thead>
				<tbody>
					@foreach($customers as $customer)
					<tr>
						<td>{{ ucfirst($customer->name) }}</td>
						<td>{{ $customer->org }}</td>
						<td>{{ $customer->email }}</td>
						<td>{{ $customer->address() }}</td>
						<td>{{ $customer->status }}</td>

						<td class="text-center">
							<a href="/domains/{{ $customer->id}}/view" class="btn btn-warning btn-xs">Editar</a>
							<button onclick="" class="btn btn-danger btn-xs">Eliminar</button>
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
<div class="modal fade" id="message_modal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-notice">
		<div class="modal-content">
			<div class="modal-header no-border-header">
				<h5 class="modal-title" id="message_modal_title"></h5>
			</div>
			<div class="modal-body">
				<p id="message_modal_content"></p>
				<div class="picture d-none">
                    <img src="" class="img-rounded img-responsive" style="max-width: 250px; max-height: 250px;">
                </div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary btn-link" data-dismiss="modal">Aceptar</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="delete_modal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-notice">
		<div class="modal-content">
			<div class="modal-header no-border-header">
				<h5 class="modal-title">Eliminar Cliente</h5>
			</div>
			<div class="modal-body text-center">
				<h5>¿Está seguro de que quiere eliminar este Cliente: <strong id="delete_modal_detail"></strong>?</h5>
				
			</div>
			<div class="modal-footer">
				<div class="left-side">
					<button type="button" class="btn btn-default btn-link" data-dismiss="modal">No, cancelar</button>
				</div>
				<div class="divider"></div>
				<div class="right-side">
					<form id="delete_modal_form" method="POST">
						@csrf
						<button type="submit" class="btn btn-danger btn-link">Si, eliminar</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('style')
<link rel="stylesheet" href="{{ asset('plugins/datatables/datatables.min.css') }}"/>
@endsection('style')

@section('script')
<script>
	function show_delete_modal(id, name) {
		$('#delete_modal_detail').text(name);
		$('#delete_modal_form').attr('action', '/customer/'+id+'/delete');
		$('#delete_modal').modal('toggle');
	}
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
                "sLengthMenu":     "Mostrar MENU registros",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningún dato disponible en esta tabla",
                "sInfo":           "Mostrando registros del START al END de un total de TOTAL registros",
                "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered":   "(filtrado de un total de MAX registros)",
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