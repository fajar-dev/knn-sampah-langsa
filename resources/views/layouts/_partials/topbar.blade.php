<div id="kt_app_header" class="app-header" data-kt-sticky="true" data-kt-sticky-activate="{default: false, lg: true}" data-kt-sticky-name="app-header-sticky" data-kt-sticky-offset="{default: false, lg: '50px'}">
  <div class="app-container container d-flex align-items-stretch justify-content-between" id="kt_app_header_container">
    <div class="app-header-logo d-flex align-items-center me-lg-9">
      <div class="btn btn-icon btn-color-gray-500 btn-active-color-primary w-35px h-35px ms-n2 me-2 d-flex d-lg-none" id="kt_app_sidebar_mobile_toggle">
        <i class="ki-outline ki-abstract-14 fs-1"></i>
      </div>
      <a href="index.html" class="d-none d-lg-block">
        <img alt="Logo" src="{{ asset('assets/media/logos/demo44.svg') }}" class="h-25px theme-light-show" />
          <img alt="Logo" src="{{ asset('assets/media/logos/demo44-dark.svg') }}" class="h-25px theme-dark-show" />
      </a>
      <div class="page-title d-flex flex-column justify-content-center gap-1 me-3 ms-lg-20 ps-lg-15">
        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7">
          <li class="breadcrumb-item text-gray-700 fw-bold lh-1 mx-n1">
            <a href="index.html" class="text-hover-primary">
              <i class="ki-outline ki-home text-gray-700 fs-6"></i>
            </a>
          </li>
          <li class="breadcrumb-item">
            <i class="ki-outline ki-right fs-7 text-gray-700"></i>
          </li>
          <li class="breadcrumb-item text-gray-700 fw-bold lh-1 mx-n1">Menu</li>
          <li class="breadcrumb-item">
            <i class="ki-outline ki-right fs-7 text-gray-700"></i>
          </li>
          <li class="breadcrumb-item text-gray-500 mx-n1">{{ $title }}</li>
        </ul>
        <h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bolder fs-3 m-0">{{ $title }}</h1>
      </div>
    </div>
    <div class="d-flex align-items-stretch justify-content-end">
      <div class="app-navbar flex-shrink-0">
        <div class="app-navbar-item ms-1 ms-md-3" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="left-start" data-kt-menu-offset="70px, -40px">
          <div class="btn btn-flex btn-icon align-self-center fw-bold btn-secondary w-35px h-35px w-md-40px h-md-40px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end" id="kt_activities_toggle">
            <span class="">
              <i class="ki-outline ki-night-day theme-light-show fs-2"></i>
              <i class="ki-outline ki-moon theme-dark-show fs-2"></i>
            </span>
          </div>
          <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-gray-500 menu-active-bg menu-state-color fw-semibold py-4 fs-base w-150px" data-kt-menu="true" data-kt-element="theme-mode-menu">
            <div class="menu-item px-3 my-0">
              <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="light">
                <span class="menu-icon" data-kt-element="icon">
                  <i class="ki-outline ki-night-day fs-2"></i>
                </span>
                <span class="menu-title">Light</span>
              </a>
            </div>
            <div class="menu-item px-3 my-0">
              <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="dark">
                <span class="menu-icon" data-kt-element="icon">
                  <i class="ki-outline ki-moon fs-2"></i>
                </span>
                <span class="menu-title">Dark</span>
              </a>
            </div>
            <div class="menu-item px-3 my-0">
              <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="system">
                <span class="menu-icon" data-kt-element="icon">
                  <i class="ki-outline ki-screen fs-2"></i>
                </span>
                <span class="menu-title">System</span>
              </a>
            </div>
          </div>
        </div>
        <div class="app-navbar-item ms-1 ms-lg-4" id="kt_header_user_menu_toggle">
          <div class="cursor-pointer symbol symbol-35px symbol-md-40px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
            <img class="symbol symbol-35px symbol-md-40px" src="https://ui-avatars.com/api/?bold=true&name={{Auth::user()->name}}" alt="user" />
          </div>
          <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px" data-kt-menu="true">
            <div class="menu-item px-3">
              <div class="menu-content d-flex align-items-center px-3">
                <div class="symbol symbol-50px me-5">
                  <img alt="Logo" src="https://ui-avatars.com/api/?bold=true&name={{Auth::user()->name}}" />
                </div>
                <div class="d-flex flex-column">
                  <div class="fw-bold d-flex align-items-center fs-5">{{Auth::user()->name}}</div>
                  <a href="#" class="fw-semibold text-muted text-hover-primary fs-7">{{Auth::user()->email}}</a>
                </div>
              </div>
            </div>
            <div class="separator my-2"></div>
            <div class="menu-item px-5">
              <a href="account/overview.html" class="menu-link px-5">My Profile</a>
            </div>
            <div class="menu-item px-5">
              <a href="{{ route('logout') }}" class="menu-link px-5">Sign Out</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>