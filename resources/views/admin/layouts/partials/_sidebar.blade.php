<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">

            <ul class="sidebar-vertical">
                <li class="menu-title">
                    <span>Main</span>
                </li>

                <li>
                    <a href="{{ route('admin.dashboard') }}" class="{{ ($activeMenu == 'dashboard')?'active':'' }}"><i class="la la-dashboard"></i> <span>Dashboard</span></a>
                </li>

            </ul>
        </div>
    </div>
</div>
