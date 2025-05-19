<div class="header">

    <!-- Logo -->
    <div class="header-left">
        <a href="{{ route('admin.dashboard') }}" class="logo">
            <img src="https://6amtech.com/wp-content/uploads/2023/06/6amTech-Primary-Logo.svg" >
        </a>
        <a href="{{ route('admin.dashboard') }}" class="logo2">
            <img src="https://6amtech.com/wp-content/uploads/2023/06/6amTech-Primary-Logo.svg" class="sidebar-expanded" alt="Logo">
            <img src="https://6amtech.com/wp-content/uploads/2023/06/6amTech-Primary-Logo.svg" class="sidebar-expanded-false" alt="Logo">
        </a>
    </div>
    <!-- /Logo -->

    <a id="toggle_btn" href="javascript:void(0);">
					<span class="bar-icon">
						<span></span>
						<span></span>
						<span></span>
					</span>
    </a>

    <!-- Header Title -->
    <div class="page-title-box">
        <h3>{{ config('app.name') }}</h3>
    </div>
    <!-- /Header Title -->

    <a id="mobile_btn" class="mobile_btn" href="#sidebar"><i class="fa-solid fa-bars"></i></a>

    <!-- Header Menu -->
    <ul class="nav user-menu">
        <li class="nav-item">
            <!-- Start::header-element -->
            <div class="header-element header-theme-mode">
                <a aria-label="anchor" href="javascript:void(0);" class="header-link layout-setting theme-change-btn d-none">
								<span class="light-layout">
									<!-- Start::header-link-icon -->
								<i class="la la-moon header-link-icon"></i>
                                    <!-- End::header-link-icon -->
								</span>
                    <span class="dark-layout">
									<!-- Start::header-link-icon -->
								<i class="la la-sun header-link-icon"></i>
                        <!-- End::header-link-icon -->
								</span>
                </a>
                <!-- End::header-link|layout-setting -->
            </div>
            <!-- End::header-element -->
        </li>

        <li class="nav-item dropdown has-arrow main-drop">
            <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
							<span class="user-img"><img src="https://6amtech.com/wp-content/uploads/2023/06/6amTech-Primary-Logo.svg" alt="User Image">
							<span class="status online"></span></span>
                <span class="ms-2"> {{ auth()->user()->name }} </span>
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="#">My Profile</a>
                <a class="dropdown-item" href="{{route('logout')}}">Logout</a>
            </div>
        </li>
    </ul>
    <!-- /Header Menu -->

    <!-- Mobile Menu -->
    <div class="dropdown mobile-user-menu">
        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-ellipsis-vertical"></i></a>
        <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" href="profile.html">My Profile</a>
            <a class="dropdown-item" href="index.html">Logout</a>
        </div>
    </div>
    <!-- /Mobile Menu -->

</div>
