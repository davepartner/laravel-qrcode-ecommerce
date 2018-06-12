<aside class="main-sidebar" id="sidebar-wrapper">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                <br/>
                <br/>
            </div>
            <div class="pull-left info">
                @if (Auth::guest())
                <p>QRCode Generator</p>
                @else
                    <p>{{ Auth::user()->name}}</p>
                @endif
                <!-- Status -->
                <a href="#"><i class="fa fa-circle text-success"></i> 
                
                    @if(Auth::user()->role_id == 1)
                    Admin
                    @elseif(Auth::user()->role_id == 2)
                    Moderator
                    @elseif(Auth::user()->role_id == 3)
                    Webmaster
                    @elseif(Auth::user()->role_id == 4)
                    Buyer
                    @endif
                </a>
            </div>
        </div>

        <!-- search form (Optional) -->
       {{-- <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
          <span class="input-group-btn">
            <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
            </button>
          </span>
            </div>
        </form> --}}
        <!-- Sidebar Menu -->

        <ul class="sidebar-menu" data-widget="tree">
            @include('layouts.menu')
        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>