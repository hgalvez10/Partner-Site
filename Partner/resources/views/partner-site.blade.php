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
			    <!-- Falta actuion y route -->
			    <form method="POST" role="form" action="/storeAction">
			      {{ csrf_field() }}
			      	<div class="box-body">
			      		<div class="row">
			      			<div class="col-md-12">
							 	<div class="btn-group btn-group-justified">
							    	<a class="btn btn-success" id="verificacion" style="cursor: default;">Verificación</a>
							    	<a class="btn btn-primary" id="completardatos" style="cursor: default;" disabled>Completar Datos</a>
							    	<a class="btn btn-primary" id="confirmarcompra" style="cursor: default;" disabled>Confirmar Compra</a>
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
				                	<div class="input-group">
                						<input type="text" class="form-control" placeholder="Ingrese el nombre de dominio" name="domain" id="domain">
                						<span class="input-group-addon">.cl</span>
              						</div>
					                @if ($errors->has('domain'))
					                <span class="help-block">
					                  <strong>{{ $errors->first('domain') }}</strong>
					                </span>
					                @endif
				                </div>
				                <button id="checkButton" type="button" onclick="check()" class="btn btn-info" style="display: none">Verificar</button>
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
					              <div class="form-group has-feedback {{ $errors->has('period') ? 'has-error': '' }}">
					                <label>Periodo de Registro</label>
					                <input type="number" class="form-control" placeholder="periodo en años" min="1" max="9" name="period" required>
					                @if ($errors->has('period'))
					                <span class="help-block">
					                  <strong>{{ $errors->first('period') }}</strong>
					                </span>
					                @endif
					              </div>
					            </div>
					            <div class="col-md-6">
					              	<div class="form-group has-feedback {{ $errors->has('nameserver') ? 'has-error': '' }}">
					                	<label>NameServer</label>
					               		<input type="text" class="form-control" placeholder="nameserver del dominio" name="nameserver" required>
					                	@if ($errors->has('nameserver'))
					                	<span class="help-block">
					                  		<strong>{{ $errors->first('nameserver') }}</strong>
					                	</span>
					                	@endif
					              	</div>
					            </div>

					            <!--  Administrador -->
					            <div class="col-md-12" id="questionAdmin">
					            	<div class="form-group">
					            		<label>¿Quieres ser el contacto administrador?</label>
					            		<div class="radio">
							                <label class="checkbox-inline">
							                <input type="radio" name="radio-admin-si" id="radio-admin-si" value="si" onclick="admin_si()">
							            	Si</label>
							            	<label class="checkbox-inline">
							                <input type="radio" name="radio-admin-no" id="radio-admin-no" value="no" onclick="admin_no()">
							            	No</label>
						            	</div>
					              	</div>	                
					            </div>
					            <div class="row" id="admin" hidden>
					            	<!--Formulario Admin Contact -->
					            	<div class="col-md-12">
					            		<div class="col-md-6">
					            			<div class="form-group has-feedback {{ $errors->has('name-admin') ? 'has-error': '' }}">
							                	<label>Nombre</label>
							               		<input id="name-admin" type="text" class="form-control" placeholder="nombre del contacto administrador" name="name-admin" required>
							                	@if ($errors->has('name-admin'))
							                	<span class="help-block">
							                  		<strong>{{ $errors->first('name-admin') }}</strong>
							                	</span>
							                	@endif
					              			</div>
					            		</div>
					            		<div class="col-md-6">
					            			<div class="form-group has-feedback {{ $errors->has('org-admin') ? 'has-error': '' }}">
							                	<label>Organización</label>
							               		<input id="org-admin" type="text" class="form-control" placeholder="organización del contacto administrador" name="org-admin" required>
							                	@if ($errors->has('org-admin'))
							                	<span class="help-block">
							                  		<strong>{{ $errors->first('org-admin') }}</strong>
							                	</span>
							                	@endif
					              			</div>
					            		</div>
					            		<div class="col-md-6">
					            			<div class="form-group has-feedback {{ $errors->has('street-admin') ? 'has-error': '' }}">
							                	<label>Dirección</label>
							               		<input id="street-admin" type="text" class="form-control" placeholder="dirección del contacto administrador" name="street-admin" required>
							                	@if ($errors->has('street-admin'))
							                	<span class="help-block">
							                  		<strong>{{ $errors->first('street-admin') }}</strong>
							                	</span>
							                	@endif
					              			</div>
					            		</div>
					            		<div class="col-md-6">
					            			<div class="form-group has-feedback {{ $errors->has('city-admin') ? 'has-error': '' }}">
							                	<label>Ciudad</label>
							               		<input id="city-admin" type="text" class="form-control" placeholder="ciudad del contacto administrador" name="city-admin" required>
							                	@if ($errors->has('city-admin'))
							                	<span class="help-block">
							                  		<strong>{{ $errors->first('city-admin') }}</strong>
							                	</span>
							                	@endif
					              			</div>
					            		</div>
					            		<div class="col-md-6">
					            			<div class="form-group has-feedback {{ $errors->has('sp-admin') ? 'has-error': '' }}">
							                	<label>Región</label>
							               		<input id="sp-admin" type="text" class="form-control" placeholder="región del contacto administrador" name="sp-admin" required>
							                	@if ($errors->has('sp-admin'))
							                	<span class="help-block">
							                  		<strong>{{ $errors->first('sp-admin') }}</strong>
							                	</span>
							                	@endif
					              			</div>
					            		</div>
					            		<div class="col-md-6">
					            			<div class="form-group has-feedback {{ $errors->has('voice-admin') ? 'has-error': '' }}">
							                	<label>Número Telefónico</label>
							               		<input id="voice-admin" type="number" pattern="[0-9]{9}" maxlength= "4" size = "5" class="form-control" placeholder="número telefónico del contacto administrador" name="voice-admin" required>
							                	@if ($errors->has('voice-admin'))
							                	<span class="help-block">
							                  		<strong>{{ $errors->first('voice-admin') }}</strong>
							                	</span>
							                	@endif
					              			</div>
					            		</div>
					            		<div class="col-md-6">
					            			<div class="form-group has-feedback {{ $errors->has('email-admin') ? 'has-error': '' }}">
							                	<label>Correo Electrónico</label>
							               		<input id="email-admin" type="email" class="form-control" placeholder="correo electrónico del contacto administrador" name="email-admin" required>
							                	@if ($errors->has('email-admin'))
							                	<span class="help-block">
							                  		<strong>{{ $errors->first('email-admin') }}</strong>
							                	</span>
							                	@endif
					              			</div>
					            		</div>
					            		<div class="col-md-12">
					            			<button type="button" onclick="createContactAdmin()" class="btn btn-success pull-right" id="createAdmin">Crear</button>
					            		</div>
					            	</div>
					            </div>
					            <div class="col-md-12" id="adminOk" hidden>
					            	<div class="alert alert-success">
									  <strong>Éxito!</strong> Se creó el contacto administrativo.
									</div>
		            			</div>
		            			<div class="col-md-12" id="adminFailed" hidden>
					            	<div class="alert alert-danger">
									  <strong>Error!</strong> Hubo problemas para crear el contacto administrativo.
									</div>
		            			</div>
		            			<!---------------------------------------------- Admin Contact ------>
		            			<!------------Billing Contact ----->
					            <div class="col-md-12" id="questionBilling">
					            	<div class="form-group">
					            		<label>¿Quieres ser el contacto Financiero?</label>
					            		<div class="radio">
							                <label class="checkbox-inline">
							                <input type="radio" name="radio-billing-si" id="radio-billing-si" value="si" onclick="billing_si()">
							            	Si</label>
							            	<label class="checkbox-inline">
							                <input type="radio" name="radio-billing-no" id="radio-billing-no" value="no" onclick="billing_no()">
							            	No</label>
						            	</div>
					              	</div>	                
					            </div>
					            <div class="row" id="billing" hidden>
					            	<!--Formulario billing Contact -->
					            	<div class="col-md-12">
					            		<div class="col-md-6">
					            			<div class="form-group has-feedback {{ $errors->has('name-billing') ? 'has-error': '' }}">
							                	<label>Nombre</label>
							               		<input id="name-billing" type="text" class="form-control" placeholder="nombre del contacto financiero" name="name-billing" required>
							                	@if ($errors->has('name-billing'))
							                	<span class="help-block">
							                  		<strong>{{ $errors->first('name-billing') }}</strong>
							                	</span>
							                	@endif
					              			</div>
					            		</div>
					            		<div class="col-md-6">
					            			<div class="form-group has-feedback {{ $errors->has('org-billing') ? 'has-error': '' }}">
							                	<label>Organización</label>
							               		<input id="org-billing" type="text" class="form-control" placeholder="organización del contacto financiero" name="org-billing" required>
							                	@if ($errors->has('org-billing'))
							                	<span class="help-block">
							                  		<strong>{{ $errors->first('org-billing') }}</strong>
							                	</span>
							                	@endif
					              			</div>
					            		</div>
					            		<div class="col-md-6">
					            			<div class="form-group has-feedback {{ $errors->has('street-billing') ? 'has-error': '' }}">
							                	<label>Dirección</label>
							               		<input id="street-admin" type="text" class="form-control" placeholder="dirección del contacto financiero" name="street-admin" required>
							                	@if ($errors->has('street-billing'))
							                	<span class="help-block">
							                  		<strong>{{ $errors->first('street-billing') }}</strong>
							                	</span>
							                	@endif
					              			</div>
					            		</div>
					            		<div class="col-md-6">
					            			<div class="form-group has-feedback {{ $errors->has('city-billing') ? 'has-error': '' }}">
							                	<label>Ciudad</label>
							               		<input id="city-billing" type="text" class="form-control" placeholder="ciudad del contacto financiero" name="city-billing" required>
							                	@if ($errors->has('city-billing'))
							                	<span class="help-block">
							                  		<strong>{{ $errors->first('city-billing') }}</strong>
							                	</span>
							                	@endif
					              			</div>
					            		</div>
					            		<div class="col-md-6">
					            			<div class="form-group has-feedback {{ $errors->has('sp-billing') ? 'has-error': '' }}">
							                	<label>Región</label>
							               		<input id="sp-billing" type="text" class="form-control" placeholder="región del contacto financiero" name="sp-billing" required>
							                	@if ($errors->has('sp-billing'))
							                	<span class="help-block">
							                  		<strong>{{ $errors->first('sp-billing') }}</strong>
							                	</span>
							                	@endif
					              			</div>
					            		</div>
					            		<div class="col-md-6">
					            			<div class="form-group has-feedback {{ $errors->has('voice-billing') ? 'has-error': '' }}">
							                	<label>Número Telefónico</label>
							               		<input id="voice-billing" type="text" class="form-control" placeholder="número telefónico del contacto financiero" name="voice-billing" required>
							                	@if ($errors->has('voice-billing'))
							                	<span class="help-block">
							                  		<strong>{{ $errors->first('voice-billing') }}</strong>
							                	</span>
							                	@endif
					              			</div>
					            		</div>
					            		<div class="col-md-6">
					            			<div class="form-group has-feedback {{ $errors->has('email-billing') ? 'has-error': '' }}">
							                	<label>Correo Electrónico</label>
							               		<input id="email-billing" type="email" class="form-control" placeholder="correo electrónico del contacto financiero" name="email-billing" required>
							                	@if ($errors->has('email-billing'))
							                	<span class="help-block">
							                  		<strong>{{ $errors->first('email-billing') }}</strong>
							                	</span>
							                	@endif
					              			</div>
					            		</div>
					            		<div class="col-md-12">
					            			<button type="button" onclick="createContactBilling()" class="btn btn-success pull-right" id="createBilling">Crear</button>
					            		</div>
					            	</div>
					            </div>
					            <div class="col-md-12" id="BillingOk" hidden>
					            	<div class="alert alert-success">
									  <strong>Éxito!</strong> Se creó el contacto financiero.
									</div>
		            			</div>
		            			<div class="col-md-12" id="BillingFailed" hidden>
					            	<div class="alert alert-danger">
									  <strong>Error!</strong> Hubo problemas para crear el contacto financiero.
									</div>
		            			</div>
		            			<!-------- Tech Contact --------------->
					            <div class="col-md-12" id="questionTech">
					            	<div class="form-group">
					            		<label>¿Quieres ser el contacto Técnico?</label>
					            		<div class="radio">
							                <label class="checkbox-inline">
							                <input type="radio" name="radio-tech-si" id="radio-tech-si" value="si" onclick="tech_si()">
							            	Si</label>
							            	<label class="checkbox-inline">
							                <input type="radio" name="radio-tech-no" id="radio-tech-no" value="no" onclick="tech_no()">
							            	No</label>
						            	</div>
					              	</div>	                
					            </div>
					            <div class="row" id="tech" hidden>
					            	<!--Formulario tech Contact -->
					            	<div class="col-md-12">
					            		<div class="col-md-6">
					            			<div class="form-group has-feedback {{ $errors->has('name-tech') ? 'has-error': '' }}">
							                	<label>Nombre</label>
							               		<input id="name-tech" type="text" class="form-control" placeholder="nombre del contacto técnico" name="name-tech" required>
							                	@if ($errors->has('name-tech'))
							                	<span class="help-block">
							                  		<strong>{{ $errors->first('name-tech') }}</strong>
							                	</span>
							                	@endif
					              			</div>
					            		</div>
					            		<div class="col-md-6">
					            			<div class="form-group has-feedback {{ $errors->has('org-tech') ? 'has-error': '' }}">
							                	<label>Organización</label>
							               		<input id="org-tech" type="text" class="form-control" placeholder="organización del contacto técnico" name="org-tech" required>
							                	@if ($errors->has('org-tech'))
							                	<span class="help-block">
							                  		<strong>{{ $errors->first('org-tech') }}</strong>
							                	</span>
							                	@endif
					              			</div>
					            		</div>
					            		<div class="col-md-6">
					            			<div class="form-group has-feedback {{ $errors->has('street-tech') ? 'has-error': '' }}">
							                	<label>Dirección</label>
							               		<input id="street-admin" type="text" class="form-control" placeholder="dirección del contacto técnico" name="street-admin" required>
							                	@if ($errors->has('street-tech'))
							                	<span class="help-block">
							                  		<strong>{{ $errors->first('street-tech') }}</strong>
							                	</span>
							                	@endif
					              			</div>
					            		</div>
					            		<div class="col-md-6">
					            			<div class="form-group has-feedback {{ $errors->has('city-tech') ? 'has-error': '' }}">
							                	<label>Ciudad</label>
							               		<input id="city-tech" type="text" class="form-control" placeholder="ciudad del contacto técnico" name="city-tech" required>
							                	@if ($errors->has('city-tech'))
							                	<span class="help-block">
							                  		<strong>{{ $errors->first('city-tech') }}</strong>
							                	</span>
							                	@endif
					              			</div>
					            		</div>
					            		<div class="col-md-6">
					            			<div class="form-group has-feedback {{ $errors->has('sp-tech') ? 'has-error': '' }}">
							                	<label>Región</label>
							               		<input id="sp-tech" type="text" class="form-control" placeholder="región del contacto técnico" name="sp-tech" required>
							                	@if ($errors->has('sp-tech'))
							                	<span class="help-block">
							                  		<strong>{{ $errors->first('sp-tech') }}</strong>
							                	</span>
							                	@endif
					              			</div>
					            		</div>
					            		<div class="col-md-6">
					            			<div class="form-group has-feedback {{ $errors->has('voice-tech') ? 'has-error': '' }}">
							                	<label>Número Telefónico</label>
							               		<input id="voice-tech" type="text" class="form-control" placeholder="número telefónico del contacto técnico" name="voice-tech" required>
							                	@if ($errors->has('voice-tech'))
							                	<span class="help-block">
							                  		<strong>{{ $errors->first('voice-tech') }}</strong>
							                	</span>
							                	@endif
					              			</div>
					            		</div>
					            		<div class="col-md-6">
					            			<div class="form-group has-feedback {{ $errors->has('email-tech') ? 'has-error': '' }}">
							                	<label>Correo Electrónico</label>
							               		<input id="email-tech" type="email" class="form-control" placeholder="correo electrónico del contacto técnico" name="email-tech" required>
							                	@if ($errors->has('email-tech'))
							                	<span class="help-block">
							                  		<strong>{{ $errors->first('email-tech') }}</strong>
							                	</span>
							                	@endif
					              			</div>
					            		</div>
					            		<div class="col-md-12">
					            			<button type="button" onclick="createContactTech()" class="btn btn-success pull-right" id="createTech">Crear</button>
					            		</div>
					            	</div>
					            </div>
					            <div class="col-md-12" id="TechOk" hidden>
					            	<div class="alert alert-success">
									  <strong>Éxito!</strong> Se creó el contacto técnico.
									</div>
		            			</div>
		            			<div class="col-md-12" id="TechFailed" hidden>
					            	<div class="alert alert-danger">
									  <strong>Error!</strong> Hubo problemas para crear el contacto técnico.
									</div>
		            			</div>
				          	</div>
				    	</div>

				    	<!-- Paso 3 confirmar la compra -->
				    	<div class="row" id="paso3" hidden>
				    		<div class="col-md-6">
				    			<button type="submit" class="btn btn-success"> Terminar registro</button>
				    		</div>
				    	</div>
			    	</div>

			    	<!-- Input IDS-->
					<input type="hidden" name="registrant_id" id="registrant_id" value="{{$contact}}">
					<input type="hidden" name="admin_id" id="admin_id">
					<input type="hidden" name="billing_id" id="billing_id">
					<input type="hidden" name="tech_id" id="tech_id">
					
			      	<div class="box-footer" hidden id="footer">
				        <a onclick="volverStep1()" class="btn btn-default btn-flat" style="display: none" id="volverpasouno">Volver paso 1</a>
				        <a onclick="volverStep2()" class="btn btn-default btn-flat" style="display: none" id="volverpasodos">Volver paso 2</a>

				        <button type="button" onclick="step2()" class="btn btn-info btn-flat pull-right" id="buyButton">Comprar</button>
				        <button type="button" onclick="step3()" class="btn btn-info btn-flat pull-right" id="buyButton2" style="display: none">Siguiente</button>
				        <button type="button" onclick="finish()" class="btn btn-success btn-flat pull-right" id="buyButton3" style="display: none">Finalizar Comprar</button>
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
	  	width: 600px ;
  		margin-left: auto ;
  		margin-right: auto ;
	}
	#mensaje2{
	  	width: 400px ;
  		margin-left: auto ;
  		margin-right: auto ;
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
				if(data['response'] == true)
				{
					$("#nameDomain").text("El nombre de dominio "+$('#domain').val()+".cl"+"  está disponible");
					$("#msjsuccess").show();
					$("#footer").show();
				}
				else
				{
					$("#nameDomain2").text("El nombre de dominio "+$('#domain').val()+".cl"+"  no está disponible");
					$("#msjerror").show();
				}
			}
		});
	}
</script>
<script>
	function createContactAdmin()
	{
		$.ajax({
			type: 'POST',
			url: '/createContactAdmin',
			data: {
                '_token': "{{ csrf_token() }}",
                'name': $('#name-admin').val(),
                'org': $('#org-admin').val(),
                'street': $('#street-admin').val(),
                'city': $('#city-admin').val(),
                'region': $('#sp-admin').val(),
                'voice': $('#voice-admin').val(),
                'email': $('#email-admin').val(),
            },
			success: function(data) {
				if (data['response'] == true) 
				{
					//desabilito los campos
					$("#admin *").attr("disabled", "disabled").off('click');
					$("#questionAdmin *").attr("disabled", "disabled").off('click');
					$('#createAdmin').hide();

					// Mostrar label
					$('#adminFailed').hide();
					$('#adminOk').show();

					$("#admin_id").val(data['id']);
				}
				else
				{
					$('#adminOk').hide();
					$('#adminFailed').show();
				}

			}
		});
	}
</script>

<script>
	function createContactBilling()
	{
		$.ajax({
			type: 'POST',
			url: '/createContactBilling',
			data: {
                '_token': "{{ csrf_token() }}",
                'name': $('#name-billing').val(),
                'org': $('#org-billing').val(),
                'street': $('#street-billing').val(),
                'city': $('#city-billing').val(),
                'region': $('#sp-billing').val(),
                'voice': $('#voice-billing').val(),
                'email': $('#email-billing').val(),
            },
			success: function(data) {
				if (data['response'] == true) 
				{
					//desabilito los campos
					$("#billing *").attr("disabled", "disabled").off('click');
					$("#questionBilling *").attr("disabled", "disabled").off('click');
					$('#createBilling').hide();

					// Mostrar label
					$('#BillingOk').show();
					$("#billing_id").val(data['id']);
				}
				else
				{
					$('#BillingOk').hide();
					$('#BillingFailed').show();
				}
			}
		});
	}
</script>

<script>
	function createContactTech()
	{
		$.ajax({
			type: 'POST',
			url: '/createContactTech',
			data: {
                '_token': "{{ csrf_token() }}",
                'name': $('#name-tech').val(),
                'org': $('#org-tech').val(),
                'street': $('#street-tech').val(),
                'city': $('#city-tech').val(),
                'region': $('#sp-tech').val(),
                'voice': $('#voice-tech').val(),
                'email': $('#email-tech').val(),
            },
			success: function(data) {
				if (data['response'] == true) 
				{
					//desabilito los campos
					$("#tech *").attr("disabled", "disabled").off('click');
					$("#questionTech *").attr("disabled", "disabled").off('click');
					$('#createTech').hide();

					// Mostrar label
					$('#TechFailed').hide();
					$('#TechOk').show();
					//cambiar id por el id del contacto recien creado
					$("#tech_id").val(data['id']);
				}
				else
				{
					$('#TechOk').hide();
					$('#TechFailed').show();
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
        	$("#checkButton").hide();
        }
        else
        {
        	$("#checkButton").show();
        }
	});
</script>

<script>
	function step2()
	{
		$("#paso1").hide();
		$("#msjsuccess").hide();
		$("#buyButton").hide();
		$("#buyButton2").show();
		$("#paso2").show();
		$("#volverpasouno").show();
		$("#verificacion").removeClass("btn btn-success").addClass("btn btn-primary");
		$("#completardatos").removeClass("btn btn-primary").addClass("btn btn-success");
		$("#completardatos").attr("disabled",false);
		$("#verificacion").attr("disabled",true);
		
	}

	function volverStep1()
	{
		$("#paso2").hide();
		$("#paso1").show();
		$("#footer").hide();
		$("#volverpasouno").hide();
		$("#buyButton").show();
		$("#buyButton2").hide();
		$("#verificacion").removeClass("btn btn-primary").addClass("btn btn-success");
		$("#completardatos").removeClass("btn btn-success").addClass("btn btn-primary");
		$("#completardatos").attr("disabled",true);
		$("#verificacion").attr("disabled",false);
	}

	function step3()
	{
		$("#paso2").hide();
		$("#volverpasouno").hide();
		$("#buyButton2").hide();
		$("#completardatos").removeClass("btn btn-success").addClass("btn btn-primary");
		$("#completardatos").attr("disabled",true);
		$("#confirmarcompra").removeClass("btn btn-primary").addClass("btn btn-success");
		$("#confirmarcompra").attr("disabled",false);
		$("#volverpasodos").show();
		$("#paso3").show();
	}

	function volverStep2()
	{
		$("#paso2").show();
		$("#volverpasouno").show();
		$("#buyButton2").show();
		$("#completardatos").removeClass("btn btn-primary").addClass("btn btn-success");
		$("#completardatos").attr("disabled",false);
		$("#confirmarcompra").removeClass("btn btn-success").addClass("btn btn-primary");
		$("#confirmarcompra").attr("disabled",true);
		$("#volverpasodos").hide();
		$("#paso3").hide();
	}
</script>

<!-- Administrador -->
<script>
	function admin_si() {
    	document.getElementById("radio-admin-si").checked = true;
    	document.getElementById("radio-admin-no").checked = false;

    	//Cambiar id de la wea contacto id admin por el id del wea pero del contacto
    	var id = $('#registrant_id').val(); 
    	$("#admin_id").val(id);
    	$("#admin").hide();
 	}
	function admin_no() {
		document.getElementById("radio-admin-no").checked = true;
    	document.getElementById("radio-admin-si").checked = false;

    	$("#admin").show();


    	//completo datos y envio por ajax retornando el id  del contacto y Cambiar id de la wea contacto id admin por el id del wea pero del contacto
	}
</script>

<!-- Billing -->
<script>
	function billing_si() {
    	document.getElementById("radio-billing-si").checked = true;
    	document.getElementById("radio-billing-no").checked = false;

    	//Cambiar id de la wea contacto id admin por el id del wea pero del contacto
    	var id = $('#registrant_id').val(); 
    	$("#billing_id").val(id);
    	$("#billing").hide();
 	}
	function billing_no() {
		document.getElementById("radio-billing-no").checked = true;
    	document.getElementById("radio-billing-si").checked = false;

    	$("#billing").show();

    	//completo datos y envio por ajax retornando el id  del contacto y Cambiar id de la wea contacto id admin por el id del wea pero del contacto
	}
</script>

<!-- Tech -->
<script>
	function tech_si() {
    	document.getElementById("radio-tech-si").checked = true;
    	document.getElementById("radio-tech-no").checked = false;

    	//Cambiar id de la wea contacto id admin por el id del wea pero del contacto
    	var id = $('#registrant_id').val(); 
    	$("#tech_id").val(id);
    	$("#tech").hide();
 	}
	function tech_no() {
		document.getElementById("radio-tech-no").checked = true;
    	document.getElementById("radio-tech-si").checked = false;

    	$("#tech").show();

    	//completo datos y envio por ajax retornando el id  del contacto y Cambiar id de la wea contacto id admin por el id del wea pero del contacto
	}
</script>
@endsection