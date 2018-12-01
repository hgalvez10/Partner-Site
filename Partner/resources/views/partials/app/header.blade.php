<header class="main-header">
    <!-- Logo -->
    <a href="/" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>P</b>Site</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Partner</b>Site</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            @if( Auth::user()->type == 1 )
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <span class="hidden-xs"><span class="label label-danger">Admin</span> {{ Auth::user()->name }} </span>
            </a>
            @endif
            @if( Auth::user()->type == 2 )
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <span class="hidden-xs"><span class="label label-success">Partner</span> {{ Auth::user()->name }} </span>
            </a>
            @endif
            @if( Auth::user()->type == 3 )
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <span class="hidden-xs"><span class="label label-warning">Cliente</span> {{ Auth::user()->name }} </span>
            </a>
            @endif
            <ul class="dropdown-menu">
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-right">
                  <a href="#" class="btn btn-default btn-flat" href="{{ route('logout') }}"
                  onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">Salir</a>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                      @csrf
                  </form>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>