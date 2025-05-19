<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">

            <ul class="sidebar-vertical">
                <li class="menu-title">
                    <span>Main</span>
                </li>

                <li>
                    <a href="{{ route('user.dashboard') }}" class="{{ ($activeMenu == 'dashboard')?'active':'' }}"><i class="la la-dashboard"></i> <span>Dashboard</span></a>
                </li>

                <li>
                    <a href="{{ route('user.upload.form') }}" class="{{ ($activeMenu == 'file-upload')?'active':'' }}"><i class="la la-upload"></i> <span>File Upload</span></a>
                </li>

                <li>
                    <a href="{{ route('user.orders.index') }}" class="{{ ($activeMenu == 'orders')?'active':'' }}"><i class="la la-upload"></i> <span>Order Management</span></a>
                </li>

            </ul>
        </div>
    </div>
</div>
