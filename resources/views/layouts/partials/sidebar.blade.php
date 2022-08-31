<div class="sidebar sidebar__width bg-light-black" id="sidebar">
    <div class="sidebar__logo">
        <a href="/"> <img src="{{ asset('img/sidebar-logo.png') }}" alt="boston logo"></a>
    </div>
    <div class="sidebar__collapse mgb-20">
        <button class="sidebar__collapse__btn" onclick="sidebarToggle();">
            <span class="bars bg-white"></span>
            <span class="bars bg-white"></span>
            <span class="bars bg-white"></span>
        </button>
    </div>
    <div class="sidebar__menu-list">
        <a href="{{ route('dashboard') }}"
           class="list-item d-flex align-items-center text-white {{ (request()->is('dashboard')) ? 'active' : '' }}">
            <div class="d-inline-flex align-items-center">
                <span class="icon-dashboard text-white me-3 fs-3"><span class="path1"></span><span class="path2"></span><span
                            class="path3"></span><span class="path4"></span></span>
                <span class="items-text"> {{ __('messages.dashboard_view.dashboard') }} </span>
            </div>
            <span class="icon-arrow-down ms-auto"></span>
        </a>
        {{--        <a href="{{ url('/order') }}" class="list-item d-flex align-items-center  text-white {{ (request()->is('order')) ? 'active' : '' }}">--}}
        {{--            <div class="d-inline-flex align-items-center">--}}
        {{--                <span class="icon-order me-3 fs-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span>--}}
        {{--               <span class="items-text">  {{ __('messages.dashboard_view.orders') }} </span>--}}
        {{--             </div>--}}
        {{--             <span class="icon-arrow-down ms-auto"></span>--}}
        {{--        </a>--}}
               <a href="{{ url('/call') }}" class="list-item d-flex align-items-center  text-white {{ (request()->is('call')) ? 'active' : '' }}">
                   <div class="d-inline-flex align-items-center">
                       <span class="icon-call me-3 fs-3"><span class="path1"></span><span class="path2"></span></span>
                       <span class="items-text"> {{ __('messages.dashboard_view.calls') }} </span>
                    </div>
                    <span class="icon-arrow-down ms-auto"></span>
               </a>
        @if(in_array('view.client', $user_permissions ?? []) || $is_owner  || $user_role == 'admin')
            <a href="{{ route('clients.index') }}"
               class="list-item d-flex align-items-center  text-white {{ (request()->is('clients*')) ? 'active' : '' }}">
                <div class="d-inline-flex align-items-center">
                    <span class="icon-client me-3 fs-3"><span class="path1"></span><span class="path2"></span></span>
                    <span class="items-text"> {{ __('messages.dashboard_view.clients') }} </span>
                </div>
                <span class="icon-arrow-down ms-auto"></span>
            </a>
        @endif
        @if(in_array('view.user', $user_permissions ?? []) || $is_owner || $user_role == 'admin')
            <a href="{{ route('users.index') }}"
               class="list-item d-flex align-items-center  text-white {{ (request()->is('users*')) ? 'active' : '' }}">
                <div class="d-inline-flex align-items-center">
                    <span class="icon-user me-3 fs-3"><span class="path1"></span><span class="path2"></span></span>
                    <span class="items-text"> {{ __('messages.dashboard_view.users') }} </span>
                </div>
                <span class="icon-arrow-down ms-auto"></span>
            </a>
        @endif
        @if(in_array('view.role', $user_permissions ?? []) || $is_owner || $user_role == 'admin')
            <a href="{{ route('roles.index') }}"
               class="list-item d-flex align-items-center  text-white {{ (request()->is('roles*')) ? 'active' : '' }}">
                <div class="d-inline-flex align-items-center">
                <span class="icon-user-role me-3 fs-3"><span class="path1"></span><span class="path2"></span><span
                            class="path3"></span></span>
                    <span class="items-text"> {{ __('messages.dashboard_view.roles') }} </span>
                </div>
                <span class="icon-arrow-down ms-auto"></span>
            </a>
        @endif
        @if(in_array('view.order', $user_permissions ?? []) || $is_owner || $user_role == 'admin')
        <!-- submenu -->
        <div class="sidebar-dropdown {{ (request()->is(['loan-types*', 'appraisal-types*','effective-date*'])) ? 'submenu-active' : '' }}">
            <a href="{{ route('orders.index') }}"
               class="list-item d-flex align-items-center text-white {{ (request()->is(['orders*'])) ? 'active' : '' }}">
                <div class="d-inline-flex align-items-center">
                <span class="icon-order me-3 fs-3"><span class="path1"></span><span class="path2"></span><span
                            class="path3"></span></span>
                    <span class="items-text"> {{ __('messages.dashboard_view.orders') }} </span>
                </div>
                <span class="icon-arrow-down ms-auto"></span>
            </a>
            <!-- dropdown menu -->
            <ul class="submenu">
                @if(in_array('view.loantype', $user_permissions ?? []) || $is_owner || $user_role == 'admin')
                    <li class="submenu-item {{ (request()->is(['loan-types*'])) ? 'active' : '' }}">
                        <a href="{{ route('loan-types.index') }}" class="submenu-link text-light">Loan Types</a>
                    </li>
                @endif
                @if(in_array('view.appraisaltype', $user_permissions ?? []) || $is_owner || $user_role == 'admin')
                    <li class="submenu-item {{ (request()->is(['appraisal-types*'])) ? 'active' : '' }}">
                        <a href="{{ route('appraisal-types.index') }}" class="submenu-link text-light">Appraisal Types</a>
                    </li>
                @endif
                @if(in_array('view.appraisaltype', $user_permissions ?? []) || $is_owner || $user_role == 'admin')
                    <li class="submenu-item {{ (request()->is(['effective-date*'])) ? 'active' : '' }}">
                        <a href="{{ route('effective-date.index') }}" class="submenu-link text-light">Effective Date</a>
                    </li>
                @endif
            </ul>
        </div>
        @endif
        {{--         <a href="{{ url('/marketing') }}" class="list-item d-flex align-items-center  text-white">--}}
        {{--            <div class="d-inline-flex align-items-center">--}}
        {{--                <span class="icon-ranking me-3 fs-3"></span>--}}
        {{--                <span class="items-text"> {{ __('messages.dashboard_view.marketing') }} </span>--}}
        {{--             </div>--}}
        {{--             <span class="icon-arrow-down ms-auto"></span>--}}
        {{--        </a>--}}
        {{--         <a href="{{ url('/knowledge-base') }}" class="list-item d-flex align-items-center  text-white">--}}
        {{--            <div class="d-inline-flex align-items-center">--}}
        {{--                <span class="icon-note me-3 fs-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></span>--}}
        {{--                <span class="items-text"> {{ __('messages.dashboard_view.knowledge_base') }} </span>--}}
        {{--             </div>--}}
        {{--             <span class="icon-arrow-down ms-auto"></span>--}}
        {{--        </a>--}}
        <a href="{{ route('profile') }}" class="list-item d-flex align-items-center  text-white {{ request()->is('profiles') ? 'active' : '' }}">
            <div class="d-inline-flex align-items-center">
                <span class="icon-profile-circle me-3 fs-3"><span class="path1"></span><span class="path2"></span><span
                            class="path3"></span></span>
                <span class="items-text"> {{ __('messages.dashboard_view.my_profile') }} </span>
            </div>
            <span class="icon-arrow-down ms-auto"></span>
        </a>
        @if(in_array('view.marketing', $user_permissions ?? []) || $is_owner || $user_role == 'admin')
            <a href="{{ route('marketing.index') }}" class="list-item d-flex align-items-center  text-white {{ request()->is('marketing') ? 'active' : '' }}">
                <div class="d-inline-flex align-items-center">
                <span class="icon-profile-circle me-3 fs-3"><span class="path1"></span><span class="path2"></span><span
                            class="path3"></span></span>
                    <span class="items-text"> Marketing </span>
                </div>
                <span class="icon-arrow-down ms-auto"></span>
            </a>
        @endif
        {{--        <a href="{{ url('/chats') }}" class="list-item d-flex align-items-center  text-white">--}}
        {{--            <div class="d-inline-flex align-items-center">--}}
        {{--                <span class="icon-messages me-3 fs-3"><span class="path1"></span><span class="path2"></span><span--}}
        {{--                            class="path3"></span></span>--}}
        {{--                <span class="items-text"> {{ __('messages.dashboard_view.chat') }} </span>--}}
        {{--            </div>--}}
        {{--            <span class="icon-arrow-down ms-auto"></span>--}}
        {{--        </a>--}}
    </div>
</div>
