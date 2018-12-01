<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <!-- Menu Ppal-->
        @if( Auth::user()->type == 1 )
        <li class="header">Menú Principal Haulmer</li>
        <li><a href="/home"><i class="fa fa-home"></i> <span>Home</span></a></li>
        @endif
        @if( Auth::user()->type == 2 )
        <li class="header">Menú Principal Partners</li>
        <li><a href="/home"><i class="fa fa-line-chart"></i> <span>Resumen</span></a></li>
        @endif
        @if( Auth::user()->type == 3 )
        <li class="header">Menú Principal Clientes</li>
        @endif
        <!--end-->
        
        @if( Auth::user()->type == 1 )
        <li class="treeview">
          <a href="#">
            <i class="fa fa-handshake-o"></i>
            <span>Partner</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="/partner/create"><i class="fa fa-circle-o"></i> Crear</a></li>
            <li><a href="/partners"><i class="fa fa-circle-o"></i> Ver Todos</a></li>
          </ul>
        </li>
        @endif
        @if( Auth::user()->type == 2 )
        <li class="treeview">
          <a href="#">
            <i class="fa fa-users"></i>
            <span>Cliente</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="/customer/create"><i class="fa fa-circle-o"></i> Crear</a></li>
            <li><a href="/customers"><i class="fa fa-circle-o"></i> Ver Todos</a></li>
          </ul>
        </li>
        <!--Other section-->
        <li>
          <a href="/mytransactions">
            <i class="fa fa-credit-card"></i> <span>Mis Transacciones</span>
          </a>
        </li>
        <li>
          <a href="/balance">
            <i class="fa fa-money"></i> <span>Cargar Fondos</span>
          </a>
        </li>
        @endif
        @if( Auth::user()->type == 3 )
         <li class="treeview">
          <a href="#">
            <i class="fa fa-shopping-bag"></i>
            <span>Mis Dominios</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="/buyDomain"><i class="fa fa-circle-o"></i> Comprar</a></li>
            <li><a href="/myDomains"><i class="fa fa-circle-o"></i> Ver Todos</a></li>
          </ul>
        </li>
        <!--Other section-->
        <li>
          <a href="/myOrders">
            <i class="fa fa-shopping-cart"></i> <span>Mis Ordenes</span>
          </a>
        </li>
        @endif
        @if( Auth::user()->type == 1)
        <!--Other section-->
        <li>
          <a href="/domains">
            <i class="fa fa-registered"></i> <span>Dominios</span>
          </a>
        </li>
        @endif
        <!--<li>
          <a href="pages/mailbox/mailbox.html">
            <i class="fa fa-envelope"></i> <span>Mailbox</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-yellow">12</small>
              <small class="label pull-right bg-green">16</small>
              <small class="label pull-right bg-red">5</small>
            </span>
          </a>
        </li>
        <li class="header">LABELS</li>
        <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>
        <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>
        <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li>
      </ul>-->
    </section>
    <!-- /.sidebar -->
  </aside>