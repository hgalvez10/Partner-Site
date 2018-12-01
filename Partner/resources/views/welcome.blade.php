@extends('layouts.admin')

@section('content')
<br/>
<div class="container">
    <section class="content">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="wrap">
                    <ul id="pictures">
                        <li>
                            <img src="{{ asset('img/domain.jpg') }}">
                        </li>
                        <li>
                            <img src="{{ asset('img/partner.jpg') }}">
                        </li>
                        <li>
                            <img src="{{ asset('img/domain1.jpg') }}">
                        </li>
                        <li>
                            <img src="{{ asset('img/partner2.jpg') }}">
                        </li>
                        <li>
                            <img src="{{ asset('img/domain2.jpg') }}">
                        </li>
                        <li>
                            <img src="{{ asset('img/partner1.jpg') }}">
                        </li>
                        <li>
                            <img src="{{ asset('img/partner4.jpg') }}">
                        </li>
                        <li>
                            <img src="{{ asset('img/partner5.jpg') }}">
                        </li>
                    </ul>
                    <br/>
                    <h1 class="wrap-title text-center hidden-sm hidden-xs">Hablemos de la plataforma <b>Partner Site</b>.</h1>
                </div>
            </div>
        </div>
        <br/>                                       
        <div class="row">
            <div class="col-md-3 text-center">
                <i class="fa fa-handshake-o fa-4x"></i>
                <h2>Partner</h2>
                <p>Registrate como un socio, luego empieza a vender dominios .CL</p>
                <br/>
            </div>
            <div class="col-md-3 text-center">
                <i class="fa fa-usd fa-4x"></i>
                <h2>Independencia</h2>
                <p>Administra tus fondos como estimes conveniente. Es hora de generar dinero!</p>
                <br/>
            </div>
            <div class="col-md-3 text-center">
                <i class="fa fa-globe fa-4x"></i>
                <h2>Consulta!</h2>
                <p>Puedes consultar información acerca de un dominio ya registrado.</p>
                <br/>
            </div>
            <div class="col-md-3 text-center">
                <i class="fa fa-suitcase fa-4x"></i>
                <h2>Administración</h2>
                <p>Si eres un Partner registrado, puedes gestionar tus propios clientes a través de esta plataforma. Regístrate y comienza!</p>
                <br/>
            </div>
        </div>
        </br>
        <div class="row">
            <div class="col-md-12">
                <h3>Consulta Whois</h3>
            </div>
            <div class="col-md-11"> 
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Ingrese el nombre de dominio con la extención .cl" id="domainWhois" onkeyup="check_keyup()" autocomplete="off">
                </div>
            </div>
            <div class="col-md-1">
                <button id="checkButton" type="button" onclick="check_who_is()" class="btn btn-primary pull-right" style="display:none;">Buscar</button>
            </div>
        </div>
        </br>
        <div class="row" id="loading" style="display:none;">
            <div class="col-md-12 text-center">
                <i class="fa fa-spinner fa-pulse fa-5x fa-fw"></i>
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <div class="row" id="dataDomain" style="display:none;">
            <div class="col-md-12 text-center">
                <h2 id="domainName"><b></b></h2>
                <br/>
                <h5><i class="fa fa-user"> Titular</i></h5>
                <p id="registrant"></p>
                <h5><i class="fa fa-suitcase"> Agente Registrador</i></h5>
                <p id="registry"></p>
                <h5><i class="fa fa-calendar-check-o"> Fecha Creación</i></h5>
                <p id="createDate"></p>
                <h5><i class="fa fa-calendar-times-o"> Fecha Expiración</i></h5>
                <p id="expDate"></p>
            </div>
            <br/>
        </div>
    </section>
</br>
</br>
</br>
</br>
    @include('partials.app.footer')
</div>
@endsection

@section('script')
<script>
$('#pictures').slippry({
  slippryWrapper: '<div class="sy-box pictures-slider" />', // wrapper to wrap everything, including pager

  adaptiveHeight: true, // height of the sliders adapts to current slide
  captions: true, // Position: overlay, below, custom, false

  pager: false,

  controls: false,
  autoHover: false,

  transition: 'kenburns', // fade, horizontal, kenburns, false
  kenZoom: 140,
  speed: 2000 // time the transition takes (ms)
});
</script>

<script>
    function check_who_is()
    {
        hideData();
        document.getElementById('loading').style.display='block';
        $.ajax({
            type: 'POST',
            url: '/whoIsDomain',
            data: {
                '_token': "{{ csrf_token() }}",
                'domainWhois': $('#domainWhois').val(),
            },
            success: function(data) {

                if (data['response'] == true) 
                {
                    // muestro los datos
                    showData(data);
                    console.log(data['registrant_name']);
                    console.log(data['registry_name']);
                    console.log(data['created_date']);
                    console.log(data['exp_date']);
                }
                else
                {
                    // Entrego mensaje
                    document.getElementById('loading').style.display='none';
                    document.getElementById("domainName").innerHTML = 'No se encontró el dominio solicitado.';
                    document.getElementById("registrant").innerHTML = 'No encontrado.';
                    document.getElementById("registry").innerHTML = 'No encontrado.';
                    document.getElementById("createDate").innerHTML = 'No registrado.';
                    document.getElementById("expDate").innerHTML = 'No registrado.';

                    document.getElementById('dataDomain').style.display='block';                
                }

            }
        });
    }
</script>
<script> 
    function showData(data) { 
        if(document.getElementById('dataDomain').style.display=='none') 
        {
            document.getElementById('loading').style.display='none';

            document.getElementById("domainName").innerHTML = data['domainName'];
            document.getElementById("registrant").innerHTML = data['registrant_name'];
            document.getElementById("registry").innerHTML = data['registry_name'];
            document.getElementById("createDate").innerHTML = data['created_date'];
            document.getElementById("expDate").innerHTML = data['exp_date'];

            document.getElementById('dataDomain').style.display='block'; 
        }
    } 
    function hideData() { 
        if(document.getElementById('dataDomain').style.display=='block') { 
            document.getElementById('dataDomain').style.display='none'; 
        }
    }   
</script>
<script>
    function check_keyup() 
    {
        var x = document.getElementById("domainWhois");
        if (x.value != "")
        {
            //mostrar boton
            document.getElementById('checkButton').style.display='block';
        }
        else
        {
            //ocultar boton
            document.getElementById('checkButton').style.display='none';
        }        
    }   
</script> 
@endsection
