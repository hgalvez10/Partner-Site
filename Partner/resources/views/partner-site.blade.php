@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-md-12">
		<section class="content">
			  @if(session('message'))
			  <div class="alert alert-{{ session('type') }} alert-dismissible">
			    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			    <h4><i class="icon fa {{ session('icon') }}"></i> {{ session('title') }}</h4>
			    {{ session('message') }}
			  </div>
			  @endif
			  <div class="box box-success">
			    <div class="box-header with-border">
			      <h3 class="box-title">Comprar Dominio</h3>
			    </div>
			    <form role="form">
			      {{ csrf_field() }}
			      	<div class="box-body">
			      		<div class="row">
			      			<div class="col-md-12">
							 	<div class="btn-group btn-group-justified">
							    	<a href="#" class="btn btn-primary">Verificación</a>
							    	<a href="#" class="btn btn-primary">Completar Datos</a>
							    	<a href="#" class="btn btn-primary">Confirmar Compra</a>
							  	</div>
							</div>
			      		</div>
			      		<br>
				        <div class="row" id="paso1">
				          <div class="col-md-12">
				            <div class="col-md-10">
				              <div class="form-group has-feedback {{ $errors->has('domain') ? 'has-error': '' }}">
				              	<div class="col-md-3">
				                	<label>Verificar Disponibilidad</label>
				                </div>
				                <div class="col-md-7">
					                <input type="text" class="form-control" placeholder="Ingrese el nombre de dominio" name="domain" id="domain">
					                @if ($errors->has('domain'))
					                <span class="help-block">
					                  <strong>{{ $errors->first('domain') }}</strong>
					                </span>
					                @endif
				                </div>
				                <button type="button" onclick="check()" class="btn btn-info">Verificar</button>
				              </div>
				            </div>
				          </div>
				        </div>

				        <div id="msjsuccess" class="row" hidden>
				        	<div id="mensaje" >
				        	 	<div class="alert alert-success alert-dismissible" role="alert" >
	  								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  								<p id="nameDomain"> 
								</div>
				        	</div>	
				    	</div>

				    	<div id="msjerror" class="row" hidden>
				    		<div id="mensaje2">
				        	 	<div class="alert alert-danger alert-dismissible" role="alert">
	  								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  								<p id="nameDomain2"> 
								</div>
				        	</div>
				    	</div>

				    	<!-- Paso 2 completar datos dominio -->
				    	<div class="row" id="paso2" hidden>
				    		<div class="col-md-12">
					            <div class="col-md-6">
					              <div class="form-group has-feedback {{ $errors->has('name') ? 'has-error': '' }}">
					                <label>Nombre</label>
					                <input type="text" class="form-control" placeholder="nombre del cliente" name="name">
					                @if ($errors->has('name'))
					                <span class="help-block">
					                  <strong>{{ $errors->first('name') }}</strong>
					                </span>
					                @endif
					              </div>
					            </div>
					            <div class="col-md-6">
					              <div class="form-group has-feedback {{ $errors->has('email') ? 'has-error': '' }}">
					                <label>Email</label>
					                <input type="email" class="form-control" placeholder="email del cliente" name="email">
					                @if ($errors->has('email'))
					                <span class="help-block">
					                  <strong>{{ $errors->first('email') }}</strong>
					                </span>
					                @endif
					              </div>
					            </div>
				          	</div>
				    	</div>

				    	<!-- Paso 3 confirmar la compra -->
				    	<div class="row" id="paso3" hidden>
				    		
				    	</div>
			    	</div>
			      	<div class="box-footer" hidden id="footer">
				        <a href="/" class="btn btn-default btn-flat">Volver</a>
				        <button type="button" onclick="step2()" class="btn btn-success btn-flat pull-right" id="buyButton">Comprar</button>
			      	</div>
			    </form>
			  </div>
		</section>
	</div>
 </div>
@endsection

@section('style')
<style>
	#mensaje{
	  	width: 400px ;
  		margin-left: auto ;
  		margin-right: auto ;
	}
	#mensaje2{
	  	width: 400px ;
  		margin-left: auto ;
  		margin-right: auto ;
	}
</style>

<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Titillium+Web:400,200,300,600,700}}" type='text/css'/>

<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" type='text/css'/>

<style>
	.timeline{
  		list-style-type: none;
  		display: flex;
  		align-items: center;
  		justify-content: center;
  	}
	.li{
  		transition: all 200ms ease-in;
	}

	.timestamp{
  		margin-bottom: 20px
  		padding: 0px 40px
  		display: flex
  		flex-direction: column
  		align-items: center
  		font-weight: 100
  	}
	.status{
  		padding: 0px 40px
  		display: flex
  		justify-content: center
  		border-top: 2px solid #D6DCE0
  		position: relative
  		transition: all 200ms ease-in}  
  	h4{
    	font-weight: 600
  	}
  	&:before{
    	content: ''
    	width: 25px
    	height: 25px
    	background-color: white
    	border-radius: 25px
    	border: 1px solid #ddd
    	position: absolute
    	top: -15px
    	left: 42%
    	transition: all 200ms ease-in 
    }
	.li.complete{
  		.status{
    		border-top: 2px solid #66DC71
    		&:before
      		background-color: #66DC71
      		border: none
      		transition: all 200ms ease-in 
      	}
    	h4{
      	color: #66DC71
      	}
      }

	@media (min-device-width: 320px) and (max-device-width: 700px){
  	.timeline{
    	list-style-type: none
    	display: block}
  	.li{
    	transition: all 200ms ease-in
    	display: flex
    	width: inherit}
  	.timestamp{
    	width: 100px
  	}
  	.status{
    	&:before
      		left: -8%
      		top: 30%
      		transition: all 200ms ease-in 
  	}

	/// Layout stuff
	html,body{
  		width: 100%
  		height: 100%
  		display: flex
  		justify-content: center
  		font-family: 'Titillium Web', sans serif
  		color: #758D96
  	}
	button{
  		position: absolute
  		width: 100px
  		min-width: 100px
  		padding: 20px
  		margin: 20px
  		font-family: 'Titillium Web', sans serif
  		border: none
  		color: white
  		font-size: 16px
  		text-align: center
  	}
	#toggleButton{
  		position: absolute
  		left: 50px
  		top: 20px
  		background-color: #75C7F6
  	}
  	}
</style>
@endsection

@section('script')
<script>
	function check() {
		$.ajax({
			type: 'POST',
			url: '/checkDomain',
			data: {
                '_token': "{{ csrf_token() }}",
                'domain': $('#domain').val(),
            },
			success: function(data) {
				console.log(data['response']);
				if(data['response'] == true)
				{
					$("#nameDomain").text("El nombre de dominio "+$('#domain').val()+" está disponible");
					$("#msjsuccess").show();
					$("#footer").show();
				}
				else
				{
					$("#nameDomain2").text("El nombre de dominio "+$('#domain').val()+" no está disponible");
					$("#msjerror").show();
				}
			}
		});
	}
</script>

<script>
 	$("#domain").keyup(function () {
        if ($("#domain").val() == 0) {
        	$("#msjsuccess").hide();
        	$("#msjerror").hide();
        	$("#buyButton").hide();
        }
	});
</script>

<script>
	function step2()
	{
		$("#paso1").hide();
		$("#msjsuccess").hide();
		$("#paso2").show();

	}
</script>

<script type="text/javascript">
	var completes = document.querySelectorAll(".complete");
	var toggleButton = document.getElementById("toggleButton");


	function toggleComplete(){
	  var lastComplete = completes[completes.length - 1];
	  lastComplete.classList.toggle('complete');
	}

	toggleButton.onclick = toggleComplete;
</script>
@endsection