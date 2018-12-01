@extends('layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Tablero
    <small>Resumen del Sitio</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Tablero</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <!-- Small boxes (Stat box) -->
  <div class="row">
    @if( Auth::user()->type == 1 )
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-yellow">
        <div class="inner">
          <h3>{{$partnerCount}}</h3>

          <p>Partner Registrados</p>
        </div>
        <div class="icon">
          <i class="ion ion-person-add"></i>
        </div>
        <a href="/partners" class="small-box-footer">Más info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    @endif
    @if( Auth::user()->type == 1 || Auth::user()->type == 2  )
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-aqua">
        <div class="inner">
          <h3>{{$domainCount}}</h3>

          <p>Dominios Registrados</p>
        </div>
        <div class="icon">
          <i class="ion ion-cloud"></i>
        </div>
        <a href="/domains" class="small-box-footer">Más Info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-green">
        <div class="inner">
          <h3>{{$customerCount}}</h3>

          <p>Clientes Registrados</p>
        </div>
        <div class="icon">
          <i class="ion ion-person-add"></i>
        </div>
        <a href="/customers" class="small-box-footer">Más Info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    @endif
    @if( Auth::user()->type == 2  )
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-red">
        <div class="inner">
          <h3>${{$balance_available}}</h3>

          <p>Balance Disponible</p>
        </div>
        <div class="icon">
          <i class="ion ion-social-usd"></i>
        </div>
        <a href="/mytransactions" class="small-box-footer">Más Info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    @endif
    <!-- ./col -->
  </div>
  <!-- /.row -->
  <!-- Main row -->
  <!-- /.row (main row) -->
</section>
<!-- /.content -->
@endsection
