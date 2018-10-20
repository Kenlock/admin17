  <!-- Left side column. contains the sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{ Admin::imageUser() }}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>{{ Admin::getUser()->name }}</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">MAIN NAVIGATION</li>
        @foreach(Admin::convertQueryMenuToArray() as $index => $menu)
          <li class = "{{ count($menu['childs']) > 0 ? 'treeview' : '' }} {{ Admin::activeArray($menu['slug'],$menu) }}">
            <a href="{{ $menu['url'] }}">
              <i class="fa {{ $menu['icon'] }}"></i>
              <span>{{ $menu['label'] }}</span>
              @if(count($menu['childs']) > 0)
                <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
              @endif
            </a>

            @if(count($menu['childs']) > 0)
              <ul class="treeview-menu">
                @foreach($menu['childs'] as $indexChild => $menuChild)
                    <li>
                      <a href="{{ $menuChild['url'] }}">
                        <i class="fa fa-circle-o"></i>
                        {{ $menuChild['label'] }}
                      </a>
                    </li>
                @endforeach
              </ul>
            @endif

          </li>
        @endforeach
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- =============================================== -->
