<?php

if (! function_exists('active_route')) {
    /**
     * Return the "active" class if current route is matched.
     *
     * @param  string|array $route
     * @param  string $output
     * @return string|null
     */
    function active_route($route)
    {
        $output = 'active';
        
        if ($route == 1) {
            $route = [
                'folder.index', 'folder.show',
                'folder.create', 'folder.edit',

                'dashboard'
            ];
        }

        if ($route == 2) {
            $route = [
                'merge.index','merge',
            ];
        }

        if (is_array($route)) {
            if (call_user_func_array('Route::is', $route)) {
                return $output;
            }
        } else {
            if (\Route::is($route)) {
                return $output;
            }
        }
        return '';
    }
}

?>

<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ cxl_asset('backend/dist/img/admin.jpg') }}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ auth()->guard('web')->user() ? auth()->guard('web')->user()->name : 'Admin' }}</p>
            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">

            <li class="{{ active_route('folder.*') }} {{ active_route('folder.index') }}">
                <a href="{{ route('folder.index') }}">
                    <i class="fa fa-book"></i> <span>Shared folder</span>
                </a>
            </li>

            <li class="{{ active_route('merge.*') }} {{ active_route('merge.index') }}">
                <a href="{{ route('merge.index') }}">
                    <i class="fa fa-cog"></i> <span>Merge file</span>
                </a>
            </li>
{{-- 
            @if(is_admin())
                <li class="{{ active_route('user.*') }}">
                    <a href="{{ route('user.index') }}">
                        <i class="fa fa-user-o"></i> <span>Users</span>
                    </a>
                </li>
            @endif --}}

            {{-- <li class="treeview {{ active_route(3) }}">
                <a href="#">
                <i class="fa fa-cogs"></i> <span> Settings</span>
                    <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
                </a>
                <ul class="treeview-menu">
                <li class="{{ active_route('change.language') }}"><a href="#"><i class="fa fa-circle-o"></i> Setting 1</a></li>
                <li class="{{ active_route('translation.*') }}"><a href="#"><i class="fa fa-circle-o"></i> Setting 2</a></li>
                </ul>
            </li> --}}
            
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
