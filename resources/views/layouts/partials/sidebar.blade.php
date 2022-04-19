<div class="sidebar sidebar__width bg-light-black" id="sidebar">
    <div class="sidebar__logo">
       <a href="/"> <img src="{{ asset('img/sidebar-logo.png') }}" alt="boston logo"></a>
    </div>
    <div class="sidebar__collapse mgb-20">
        <button class="sidebar__collapse__btn"  onclick="sidebarToggle();">
            <span class="bars bg-white"></span>
            <span class="bars bg-white"></span>
            <span class="bars bg-white"></span>
        </button>
    </div>
    <div class="sidebar__menu-list">
        <a href="{{ route('dashboard') }}" class="list-item d-flex align-items-center text-white {{ (request()->is('dashboard')) ? 'active' : '' }}">
            <div class="d-inline-flex align-items-center">
                <span class="icon-dashboard text-white me-3 fs-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></span>
                <span class="items-text"> {{ __('messages.dashboard_view.dashboard') }} </span>
             </div>
             <span class="icon-arrow-down ms-auto"></span>
        </a>
        <a href="{{ url('/order') }}" class="list-item d-flex align-items-center  text-white {{ (request()->is('order')) ? 'active' : '' }}">
            <div class="d-inline-flex align-items-center">
                <span class="icon-order me-3 fs-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span>
               <span class="items-text">  {{ __('messages.dashboard_view.orders') }} </span>
             </div>
             <span class="icon-arrow-down ms-auto"></span>
        </a>
        <a href="{{ url('/calls') }}" class="list-item d-flex align-items-center  text-white {{ (request()->is('calls')) ? 'active' : '' }}">
            <div class="d-inline-flex align-items-center">
                <span class="icon-call me-3 fs-3"><span class="path1"></span><span class="path2"></span></span>
                <span class="items-text"> {{ __('messages.dashboard_view.calls') }} </span>
             </div>
             <span class="icon-arrow-down ms-auto"></span>
        </a>
        <a href="{{ url('/clients') }}" class="list-item d-flex align-items-center  text-white">
            <div class="d-inline-flex align-items-center">
                <span class="icon-client me-3 fs-3"><span class="path1"></span><span class="path2"></span></span>
                <span class="items-text"> {{ __('messages.dashboard_view.clients') }} </span>
             </div>
             <span class="icon-arrow-down ms-auto"></span>
        </a>
        <a href="{{ route('users.index') }}" class="list-item d-flex align-items-center  text-white">
            <div class="d-inline-flex align-items-center">
                <span class="icon-user me-3 fs-3"><span class="path1"></span><span class="path2"></span></span>
                <span class="items-text"> {{ __('messages.dashboard_view.users') }} </span>
             </div>
             <span class="icon-arrow-down ms-auto"></span>
        </a>
        <a href="{{ route('roles.index') }}" class="list-item d-flex align-items-center  text-white">
            <div class="d-inline-flex align-items-center">
                <span class="icon-user me-3 fs-3"><span class="path1"></span><span class="path2"></span></span>
                <span class="items-text"> {{ __('messages.dashboard_view.roles') }} </span>
             </div>
             <span class="icon-arrow-down ms-auto"></span>
        </a>
         <a href="{{ url('/invoice') }}" class="list-item d-flex align-items-center  text-white">
            <div class="d-inline-flex align-items-center">
                <span class="icon-invoice me-3 fs-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></span>
                <span class="items-text"> {{ __('messages.dashboard_view.invoices') }} </span>
             </div>
             <span class="icon-arrow-down ms-auto"></span>
        </a>
         <a href="{{ url('/marketing') }}" class="list-item d-flex align-items-center  text-white">
            <div class="d-inline-flex align-items-center">
                <span class="icon-ranking me-3 fs-3"></span>
                <span class="items-text"> {{ __('messages.dashboard_view.marketing') }} </span>
             </div>
             <span class="icon-arrow-down ms-auto"></span>
        </a>
         <a href="{{ url('/knowledge-base') }}" class="list-item d-flex align-items-center  text-white">
            <div class="d-inline-flex align-items-center">
                <span class="icon-note me-3 fs-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></span>
                <span class="items-text"> {{ __('messages.dashboard_view.knowledge_base') }} </span>
             </div>
             <span class="icon-arrow-down ms-auto"></span>
        </a>
         <a href="{{ route('profile') }}" class="list-item d-flex align-items-center  text-white">
            <div class="d-inline-flex align-items-center">
                <span class="icon-profile-circle me-3 fs-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span>
                <span class="items-text"> {{ __('messages.dashboard_view.my_profile') }} </span>
             </div>
             <span class="icon-arrow-down ms-auto"></span>
        </a>
         <a href="{{ url('/chats') }}" class="list-item d-flex align-items-center  text-white">
            <div class="d-inline-flex align-items-center">
                <span class="icon-messages me-3 fs-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span>
                <span class="items-text"> {{ __('messages.dashboard_view.chat') }} </span>
             </div>
             <span class="icon-arrow-down ms-auto"></span>
        </a>
    </div>
</div>
