<div class="deznav">
    <div class="deznav-scroll">
        {{-- <div class="main-profile">
            <div>
                <img src="{{ asset('logo/logo.jpg') }}" alt="" style="width:150px;">
                <a href="javascript:void(0);"><i class="fa fa-cog" aria-hidden="true"></i></a>
            </div>
            <h5 class="name"><span class="font-w400">Hello,</span> {{ Session::get('scits_ces_go_log_user_name') }}
            </h5>
            <p class="email">{{ Session::get('pos_log_user_email') }}</p>

        </div> --}}

        <ul class="metismenu" id="menu">
            <li class="nav-label first">Main Menu</li>

            @if (Session::get('pos_log_user_type') == 'Admin')
                {{-- Dashboard --}}
                <li><a class="ai-icon" href="{{ route('admin_dashboard') }}" aria-expanded="false">
                        <i class="flaticon-144-layout"></i>
                        <span class="nav-text">Dashboard</span>
                    </a>
                </li>

                <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                        <i class="flaticon-381-user-4"></i>
                        <span class="nav-text">Users</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{ route('active_users') }}">Users</a></li>
                        <li><a href="{{ route('deactive_users') }}">Inactive Users</a></li>
                    </ul>
                </li>

                {{-- Customers --}}
                <li>
                    <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                        <i class="flaticon-381-user-9"></i>
                        <span class="nav-text">Customers</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{ route('all_customers') }}">All Customers</a></li>
                        <li><a href="{{ route('deactive_customer') }}">Inactive Customers</a></li>
                    </ul>
                </li>

                 {{-- Suppliers --}}
                <li>
                    <a class="ai-icon" href="{{ route('all_suppliers') }}" aria-expanded="false">
                        <i class="flaticon-381-user-8"></i>
                        <span class="nav-text">Suppliers</span>
                    </a>
                </li>

                {{-- products --}}
                <li>
                    <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                        <i class="flaticon-381-list"></i>
                        <span class="nav-text">Products</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{ route('create_product') }}">Create Products</a></li>
                        <li><a href="{{ route('products') }}">Products</a></li>
                    </ul>
                </li>


                {{-- Purchases --}}
                <li>
                    <a class="ai-icon" href="{{ route('purchases') }}" aria-expanded="false">
                        <i class="flaticon-381-app"></i>
                        <span class="nav-text">Purchases</span>
                    </a>
                </li>

                 {{-- POS --}}
                <li>
                    <a class="ai-icon" href="{{ route('pos') }}" aria-expanded="false">
                        <i class="flaticon-381-search-3"></i>
                        <span class="nav-text">POS</span>
                    </a>
                </li>


                 {{-- Sales --}}
                 <li>
                    <a class="ai-icon" href="{{ route('sales') }}" aria-expanded="false">
                        <i class="flaticon-381-print"></i>
                        <span class="nav-text">Sales</span>
                    </a>
                </li>
            @else
                {{-- Dashboard --}}
                <li><a class="ai-icon" href="{{ route('user_dashboard') }}" aria-expanded="false">
                        <i class="flaticon-144-layout"></i>
                        <span class="nav-text">Dashboard</span>
                    </a>
                </li>

                {{-- Customers --}}
                <li>
                    <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                        <i class="flaticon-381-user-9"></i>
                        <span class="nav-text">Customers</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{ route('all_customers') }}">All Customers</a></li>
                        <li><a href="{{ route('deactive_customer') }}">Inactive Customers</a></li>
                    </ul>
                </li>

                 {{-- POS --}}
                 <li>
                    <a class="ai-icon" href="{{ route('pos') }}" aria-expanded="false">
                        <i class="flaticon-381-search-3"></i>
                        <span class="nav-text">POS</span>
                    </a>
                </li>


                 {{-- Sales --}}
                 <li>
                    <a class="ai-icon" href="{{ route('sales') }}" aria-expanded="false">
                        <i class="flaticon-381-print"></i>
                        <span class="nav-text">Sales</span>
                    </a>
                </li>
            @endif

        </ul>

        <div class="copyright">
            <p><strong>POS Admin Dashboard</strong> © 2023 All Rights Reserved</p>
        </div>

        {{-- <div class="copyright">
            @if (Session::get('pos_log_user_type') == 'Admin')
                <p><strong>EasyWash Admin Dashboard</strong> © 2023 All Rights Reserved</p>
            @else
                <p><strong>EasyWash User Dashboard</strong> © 2023 All Rights Reserved</p>
            @endif
        </div> --}}
    </div>
</div>
