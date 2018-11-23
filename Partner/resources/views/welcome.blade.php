@extends('layouts.admin')

@section('content')
<br/>
<div class="container">
    <section class="content">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="wrap">
                    <!-- <h1 class="wrap-title text-center hidden-sm hidden-xs">Partner Site</h1> -->
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
                    
                </div>
            </div>
        </div>
        <br/>                                       
        <div class="row">
            <div class="col-md-3 text-center">
                <i class="fa fa-calendar fa-4x"></i>
                <h2>Reservas</h2>
                <p></p>
                <br/>
            </div>
            <div class="col-md-3 text-center">
                <i class="fa fa-handshake-o fa-4x"></i>
                <h2>Partner</h2>
                <p>Registrate como un socio, luego empieza a vender dominios .CL</p>
                <br/>
            </div>
            <div class="col-md-3 text-center">
                <i class="fa fa-soccer-ball-o fa-4x"></i>
                <h2>A Jugar!</h2>
                <p></p>
                <br/>
            </div>
            <div class="col-md-3 text-center">
                <i class="fa fa-suitcase fa-4x"></i>
                <h2>Administración</h2>
                <p>Si eres un Partner registrado, puedes gestionar tus propios clientes a través de esta plataforma. Regístrate y comienza!</p>
                <br/>
            </div>
        </div>
    </section>
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
@endsection
