@extends('layouts.app')

@section('content')
<section class="content-header">
	<h1>
		Balance
		<small>Partner</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="/home"><i class="fa fa-home"></i> Home</a></li>
		<li class="active">Balance</li>
	</ol>
</section>

<section class="content">
	<div class="box box-success" style="background-color:#F2F2F2;">
		<div class="box-header with-border">
			<h3 class="box-title">Cargar fondos a tu cuenta</h3>
		</div>
		<div class="box-body">
			<div class="row">
				<div class="col-md-10">
					<!-- Widget: user widget style 1 -->
					<div class="box box-widget widget-user-2">
						<!-- Add the bg color to the header using any of the bg-* classes -->
						<div class="widget-user-header bg-black" style="background: url('../img/balance.jpg') center center;">
							<!-- /.widget-user-image -->
							<h1 class="widget-user-username">{{Auth::user()->name}}</h1>
							<h4 class="widget-user-desc">{{$address}}</h4>
						</div>
						<div class="box-footer no-padding">
							<ul class="nav nav-stacked">
								<li><a>Fondos Disponible <span class="pull-right badge bg-blue">${{$balance_available}}</span></a></li>
								<li><a>Ingresos Totales <span class="pull-right badge bg-aqua">${{$partner->income}}</span></a></li>
							</ul>
						</div>
					</div>
					<!-- /.widget-user -->
		        </div>
		        <form method="POST" role="form" action="/addFunds">
				{{ csrf_field() }}
			        <div class="col-md-10">
						<div class="col-md-8">
							<div class="input-group">
				                <span class="input-group-addon"><i class="fa fa-dollar"></i></span>
				                <input name="balance" placeholder="Ingresa el monto" type="text" class="form-control" autocomplete="off" required>
				          	</div>
			          	</div>
			          	<div class="col-md-2">
			          		<button type="submit" class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> Cargar Fondos
	          				</button>
			          	</div>
		          	</div>
	          	</form>
          	</div>
		</div>
		<div class="box-footer" style="background-color:#F2F2F2;">
			<a href="/home" class="btn btn-default btn-flat">Volver</a>
		</div>
	</div>
</section>
@endsection