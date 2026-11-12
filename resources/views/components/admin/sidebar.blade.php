<aside class="main-sidebar sidebar-dark-warning elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('/') }}" target="_blank" class="brand-link">
        <img src="{{asset('adminassets/dist/img/AdminLTELogo.png')}}" alt="Adminpanel"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">
            {{  env('APP_NAME') }}
        </span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{asset('adminassets/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2"
                    alt="User Image">
            </div>
            <div class="info">
                <a href="javascript:void(0);" class="d-block">
                    {{ auth()->user()->first_name . ' ' . auth()->user()->last_name }}
                </a>
            </div>
        </div>
        
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link @if(request()->routeIs('admin.dashboard')) active @endif">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                @role('admin')
                <li class="nav-item 
                    @if(
    request()->routeIs('admin.modules.*')
    || request()->routeIs('admin.permissions.*')
) menu-is-opening menu-open @endif">
                    <a href="javascript:void(0);" class="nav-link *:
                     @if(
    request()->routeIs('admin.modules.*')
    || request()->routeIs('admin.permissions.*')
) active @endif ">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Site Control
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.modules.index') }}" class="nav-link @if(request()->routeIs('admin.modules.index')) active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Modules</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.permissions.edit', 'manager') }}" 
                            class="nav-link @if(request()->routeIs('admin.permissions.*')) active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Roles & Permissions</p>
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a href="javascript:void(0);" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Site Information</p>
                            </a>
                        </li>
                        

                        
                        
                        
                    </ul>
                </li>
                
                {{-- <li class="nav-header">EXAMPLES</li> --}}
               
                {{-- <li class="nav-item">
                @can('category.view')
                    <a href="{{ route('admin.products.index') }}">Products</a>
                @endcan
                </li> --}}
                <li class="nav-item">
                    <a href="{{ route('admin.manager.index') }}" class="nav-link 
                    @if (request()->routeIs('admin.manager.*')) active @endif 
                    ">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Managers</p>
                    </a>
                </li>
                @endrole
                
                @hasanyrole('admin|manager')
                <li class="nav-item">
                    <a href="{{ route('admin.managers.edit', auth()->user()->randomid) }}" 
                        class="nav-link @if (request()->routeIs('admin.managers.*')) active @endif ">
                        <i class="nav-icon fas fa-user"></i>
                        <p>My Profile </p>
                    </a>
                </li>
                @endhasanyrole

                @hasanyrole('admin|manager')
                <li class="nav-item
                @if (request()->routeIs('admin.masters.*')) 
                    menu-is-opening menu-open @endif"
                >
                    <a href="javascript:void(0);" class="nav-link
                    @if (request()->routeIs('admin.masters.*')) active @endif
                    ">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            E-commerce
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.masters.category') }}"
                                class="nav-link
                                 @if (request()->routeIs('admin.masters.category') || request()->routeIs('admin.masters.create.category')) active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Category</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.masters.size') }}"
                                class="nav-link
                                 @if (request()->routeIs('admin.masters.size') || request()->routeIs('admin.masters.create.size')) active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Size</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.masters.color') }}"
                                class="nav-link
                                      @if (request()->routeIs('admin.masters.color') || request()->routeIs('admin.masters.create.color')) active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Color</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.masters.brand') }}"
                                class="nav-link @if (request()->routeIs('admin.masters.brand') || request()->routeIs('admin.masters.create.brand')) active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Brand</p>
                            </a>
                        </li>


                        <li class="nav-item">
                            <a href="{{ route('admin.masters.products.index') }}"
                                class="nav-link @if(request()->routeIs('masters.products.index.*')) active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Products</p>
                            </a>
                        </li>
                        
                    </ul>
                </li>
                @endhasanyrole
                
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>