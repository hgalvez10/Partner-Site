@extends('layouts.app')

@section('content')
<section class="content-header">
  <h1>
    Cliente
    <small>Registrar</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="/"><i class="fa fa-home"></i> Home</a></li>
    <li class="active">Registrar</li>
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
  <div class="box box-success">
    <div class="box-header with-border">
      <h3 class="box-title">Registrar Cliente</h3>
    </div>
    <form method="POST" role="form" action="/customer">
      {{ csrf_field() }}
      <div class="box-body">
        <div class="row">
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
        <div class="row">
          <div class="col-md-12">
            <div class="col-md-6">
              <div class="form-group has-feedback {{ $errors->has('country') ? 'has-error': '' }}">
                <label>País</label>
                <input type="text" class="form-control" placeholder="país del cliente" name="country">
                @if ($errors->has('country'))
                <span class="help-block">
                  <strong>{{ $errors->first('country') }}</strong>
                </span>
                @endif
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group has-feedback {{ $errors->has('ciudad') ? 'has-error': '' }}">
                <label>Ciudad</label>
                <input type="text" class="form-control" placeholder="ciudad del cliente" name="city">
                @if ($errors->has('ciudad'))
                <span class="help-block">
                  <strong>{{ $errors->first('ciudad') }}</strong>
                </span>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="box-footer">
        <a href="/home" class="btn btn-default btn-flat">Volver</a>
        <button type="submit" class="btn btn-success btn-flat pull-right">Registrar Cliente</button>
      </div>
    </form>
  </div>
</section>
@endsection