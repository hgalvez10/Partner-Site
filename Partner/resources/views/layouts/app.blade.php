
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  @yield('title')
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  @include('partials.app.styles')
  @yield('style')
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  @include('partials.app.header')
  <!-- Left side column. contains the logo and sidebar -->
  @include('partials.app.sidebar')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    @yield('content')
  </div>
  @yield('modal')
  <!-- /.content-wrapper -->
  @include('partials.app.footer')
</div>
<!-- ./wrapper -->

@include('partials.app.scripts')
@yield('script')
</body>
</html>
