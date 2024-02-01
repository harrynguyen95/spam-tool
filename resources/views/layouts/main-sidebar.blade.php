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

                
            ];
        }

        if ($route == 2) {
            $route = [
                'merge.index', 'merge',
                'dashboard'
            ];
        }

        if ($route == 3) {
            $route = [
                'compare.index', 'compare',
            ];
        }

        if ($route == 4) {
            $route = [
                'translate.index', 'translate.store',
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
                    <i class="fa fa-book"></i> <span>Shared ok folder</span>
                </a>
            </li>

            <li class="{{ active_route('merge.*') }} {{ active_route('merge.index') }} {{ active_route('dashboard') }}">
                <a href="{{ route('merge.index') }}">
                    <i class="fa fa-cog"></i> <span>Merge files</span>
                </a>
            </li>

            <li class="{{ active_route('compare.*') }} {{ active_route('compare.index') }}">
                <a href="{{ route('compare.index') }}">
                    <i class="fa fa-list"></i> <span>Compare files</span>
                </a>
            </li>

            <li class="{{ active_route('split.*') }} {{ active_route('split.index') }}">
                <a href="{{ route('split.index') }}">
                    <i class="fa fa-car"></i> <span>Split text</span>
                </a>
            </li>

            <li class="{{ active_route('translate.*') }} {{ active_route('translate.index') }}">
                <a href="{{ route('translate.index') }}">
                    <i class="fa fa-user-o"></i> <span>Google Translate</span>
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
