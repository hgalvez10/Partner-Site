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
              <div class="form-group has-feedback {{ $errors->has('org') ? 'has-error': '' }}">
                  <label>Organización</label>
                  <input type="text" class="form-control" placeholder="organización del cliente" name="org">
                  @if ($errors->has('org'))
                  <span class="help-block">
                      <strong>{{ $errors->first('org') }}</strong>
                  </span>
                  @endif
                </div>
            </div>
            <div class="col-md-6">
              <div class="form-group has-feedback {{ $errors->has('street') ? 'has-error': '' }}">
                  <label>Dirección</label>
                  <input type="text" class="form-control" placeholder="dirección del cliente" name="street">
                  @if ($errors->has('street'))
                  <span class="help-block">
                      <strong>{{ $errors->first('street') }}</strong>
                  </span>
                  @endif
                </div>
            </div>
            <div class="col-md-6">
              <div class="form-group has-feedback {{ $errors->has('city') ? 'has-error': '' }}">
                  <label>Ciudad</label>
                  <input type="text" class="form-control" placeholder="ciudad del cliente" name="city">
                  @if ($errors->has('city'))
                  <span class="help-block">
                      <strong>{{ $errors->first('city') }}</strong>
                  </span>
                  @endif
                </div>
            </div>
            <div class="col-md-6">
              <div class="form-group has-feedback {{ $errors->has('sp') ? 'has-error': '' }}">
                  <label>Región</label>
                  <input type="text" class="form-control" placeholder="región del cliente" name="sp">
                  @if ($errors->has('sp'))
                  <span class="help-block">
                      <strong>{{ $errors->first('sp') }}</strong>
                  </span>
                  @endif
                </div>
            </div>
            <div class="col-md-6">
              <div class="form-group has-feedback {{ $errors->has('voice') ? 'has-error': '' }}">
                  <label>Número Telefónico</label>
                  <input type="text" class="form-control" placeholder="número telefónico del cliente" name="voice">
                  @if ($errors->has('voice'))
                  <span class="help-block">
                      <strong>{{ $errors->first('voice') }}</strong>
                  </span>
                  @endif
                </div>
            </div>
            <div class="col-md-6">
              <div class="form-group has-feedback {{ $errors->has('email') ? 'has-error': '' }}">
                  <label>Correo Electrónico</label>
                  <input type="email" class="form-control" placeholder="correo electrónico del cliente" name="email">
                  @if ($errors->has('email'))
                  <span class="help-block">
                      <strong>{{ $errors->first('email') }}</strong>
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