<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ settings('favicon') ? asset('storage/' . settings('favicon')) : asset('assets-front/img-main.png') }}">
    <!-- Bootstrap CSS -->
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="{{ asset('adminassets/css/style.css') }}">
    <link rel="stylesheet" href="{{asset('adminassets/css/bootstrap.min.css')}}">

    @include('layouts.notification')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @stack('styles')
      <style>
        .dataTables_length {
            font-size: 10px !important
        }
    </style>
   </head>

<body>
   <div id="sidebar" class="py-2">
        <!-- Sidebar Header with Close Button -->
        <div class="sidebar-header d-flex justify-content-between align-items-center px-3 mb-4">
            <!-- Logo -->
            <a href="{{ route('admin.dashboard') }}" class="text-decoration-none text-white flex-grow-1">
                <div class="d-flex align-items-center logo">
                    <img src="{{ settings('light_logo') ? asset('storage/' . settings('light_logo')) : asset('assets-front/img-main.png') }}" 
                         alt="P2GH Logo" 
                         style="height: 50px; width: auto; max-width: 180px;">
                </div>
            </a>
            
            <!-- Close Button -->
            <button id="sidebarCloseBtn" class="btn btn-sm btn-outline-light border-0 ms-2" 
                    title="Close Sidebar">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        <ul class="nav flex-column ">
            <!-- Logo Link (redundant, you can remove if using header logo) -->
            <a href="{{ route('admin.dashboard') }}" class="text-decoration-none text-white d-none"> 
                <li class="d-flex align-items-center logo mb-4">
                    <img src="{{ settings('light_logo') ? asset('storage/' . settings('light_logo')) : asset('assets-front/img-main.png') }}" 
                         alt="P2GH Logo" 
                         style="height: 60px; width: 77%; object-fit: cover;">
                </li>
            </a>

            <li class="{{ request()->is('admin') || request()->routeIs('admin.dashboard*') ? 'active' : '' }}">
                <a class="nav-link d-flex align-items-center 
                {{ request()->is('admin') || request()->routeIs('admin.dashboard*') ? 'active' : '' }}"
                href="{{ route('admin.dashboard') }}">

                    <i class="bi bi-speedometer2 me-2"></i>
                    <span class="menu-text">Dashboard</span>

                </a>
            </li>


             <li class="{{ request()->routeIs('admin.appointments*') ? 'active' : '' }}">
                <a class="nav-link d-flex align-items-center py-2
                    {{ request()->routeIs('admin.appointments*') ? 'active' : '' }}"
                href="{{ route('admin.appointments') }}">
                    <i class="bi bi-calendar me-3"></i>
                    <span class="menu-text">Appointments</span>
                </a>
            </li>


             <li class="{{ request()->routeIs('admin.camps*') ? 'active' : '' }}">
                <a class="nav-link d-flex align-items-center py-2
                    {{ request()->routeIs('admin.camps*') ? 'active' : '' }}"
                href="{{ route('admin.camps') }}">
                    <i class="bi bi-clipboard2-heart me-3"></i>
                    <span class="menu-text">Camps</span>
                </a>
            </li>


 


              <li class="sidebar-dropdown {{ request()->routeIs('showcontactform*') || request()->routeIs('showcontactpropertyform*') || request()->routeIs('admin.showconsultform*') ? 'active' : '' }}">
                <a class="nav-link d-flex align-items-center dropdown-btn" href="javascript:void(0)">
                    <i class="bi bi-envelope-open me-2"></i>
                    <span class="menu-text">Manage Contact</span>
                    <i class="bi bi-chevron-down ms-auto arrow"></i>

                </a>
                <ul class="submenu {{ request()->routeIs('showcontactform*') || request()->routeIs('showcontactpropertyform*') || request()->routeIs('admin.showconsultform*') ? 'show' : '' }}">
                    <li>
                        <a class="nav-link {{ request()->routeIs('showcontactform*') ? 'active' : '' }}" href="{{ route('showcontactform') }}">
                            <i class="bi bi-circle"></i>
                           Manage Inquiries
                        </a>
                    </li>
                    {{-- <li>
                        <a class="nav-link {{ request()->routeIs('showcontactpropertyform*') ? 'active' : '' }}" href="{{ route('showcontactpropertyform') }}">
                           <i class="bi bi-circle"></i>
                            Manage Properties contacts 
                        </a>
                    </li> --}}
                </ul>
            </li>
          {{-- <li class="sidebar-dropdown {{ request()->routeIs('admin.manage-booking-project*') || request()->routeIs('admin.manage-managers*') || request()->routeIs('admin.manage-pointofcontact*') ? 'active' : '' }}">
                <a class="nav-link d-flex align-items-center dropdown-btn" href="javascript:void(0)">
                   <i class="bi bi-calendar-check me-2"></i>
                    <span class="menu-text">Manage services name</span>
                    <i class="bi bi-chevron-down ms-auto arrow"></i>
                </a>
                <ul class="submenu {{ request()->routeIs('admin.manage-booking-project*') || request()->routeIs('admin.manage-managers*') || request()->routeIs('admin.manage-pointofcontact*') ? 'show' : '' }}">
                     <li>
                        <a class="nav-link {{ request()->routeIs('admin.manage-pointofcontact*') ? 'active' : '' }}" href="{{ route('admin.manage-pointofcontact') }}">
                           <i class="bi bi-circle"></i>
                            Manage servicee
                        </a> 
                    </li>
                  
                </ul>
            </li> --}}


            <li class="sidebar-dropdown {{ request()->routeIs('admin.manage-blogs*') ? 'active' : '' }}">
                <a class="nav-link d-flex align-items-center dropdown-btn" href="javascript:void(0)">
                   <i class="bi bi-newspaper me-2"></i>
                    <span class="menu-text">Manage Blogs</span>
                    <i class="bi bi-chevron-down ms-auto arrow"></i>
                </a>
                <ul class="submenu {{ request()->routeIs('admin.manage-blogs*') ? 'show' : '' }}">
                    <li>
                        <a class="nav-link {{ request()->routeIs('admin.manage-blogs*') ? 'active' : '' }}" href="{{ route('admin.manage-blogs') }}">
                           <i class="bi bi-circle"></i>
                            Manage Blogs  
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Masters Dropdown -->
            <li class="sidebar-dropdown {{ request()->routeIs('master*') || request()->routeIs('admin.consultants*') || request()->routeIs('admin.progresscounter*') || request()->routeIs('admin.showherobanners*') || request()->routeIs('admin.homeaboutsection*') || request()->routeIs('admin.tagline-cta*') || request()->routeIs('admin.bookingline*') || request()->routeIs('admin.whychooseus*') || request()->routeIs('admin.faqs*') || request()->routeIs('admin.processsteps*') || request()->routeIs('admin.testimonials*') ? 'active' : '' }}">
                <a class="nav-link d-flex align-items-center dropdown-btn" href="javascript:void(0)">
                    <i class="bi bi-database-fill-gear me-2"></i>
                    <span class="menu-text">Website Sections</span>
                    <i class="bi bi-chevron-down ms-auto arrow"></i>
                </a>
                <ul class="submenu {{ request()->routeIs('master*') || request()->routeIs('admin.testimonials*') || request()->routeIs('admin.faqs*') || request()->routeIs('admin.processsteps*') || request()->routeIs('admin.whychooseus*') || request()->routeIs('admin.progresscounter*') || request()->routeIs('admin.showherobanners*') || request()->routeIs('admin.homeaboutsection*') ? 'show' : '' }}">

                    <li>
                        <a class="nav-link {{ request()->routeIs('admin.testimonials*') ? 'active' : '' }}" href="{{ route('admin.testimonials') }}">
                            <i class="bi bi-circle"></i> Testimonials
                        </a>
                    </li>
                    <li>
                        <a class="nav-link {{ request()->routeIs('admin.whychooseus*') ? 'active' : '' }}" href="{{ route('admin.whychooseus') }}">
                            <i class="bi bi-circle"></i> Why Choose Us
                        </a>
                    </li>
                    <li>
                        <a class="nav-link {{ request()->routeIs('admin.faqs*') ? 'active' : '' }}" href="{{ route('admin.faqs') }}">
                            <i class="bi bi-circle"></i> FAQs
                        </a>
                    </li>
                    <li>
                        <a class="nav-link {{ request()->routeIs('admin.processsteps*') ? 'active' : '' }}" href="{{ route('admin.processsteps') }}">
                            <i class="bi bi-circle"></i> Process Steps
                        </a>
                    </li>
                    <li>
                        <a class="nav-link {{ request()->routeIs('admin.progresscounter*') ? 'active' : '' }}" href="{{ route('admin.progresscounter') }}">
                            <i class="bi bi-circle"></i> Stats Counters
                        </a>
                    </li>
                    <li>
                        <a class="nav-link {{ request()->routeIs('admin.showherobanners*') ? 'active' : '' }}" href="{{ route('admin.showherobanners') }}">
                            <i class="bi bi-circle"></i> Hero Banner
                        </a>
                    </li>
                    <li>
                        <a class="nav-link {{ request()->routeIs('admin.homeaboutsection*') ? 'active' : '' }}" href="{{ route('admin.homeaboutsection') }}">
                            <i class="bi bi-circle"></i> About Section
                        </a>
                    </li>
                    <li>
                        <a class="nav-link {{ request()->routeIs('admin.tagline-cta*') ? 'active' : '' }}" href="{{ route('admin.tagline-cta') }}">
                            <i class="bi bi-circle"></i> CTA Section
                        </a>
                    </li>
                </ul>
            </li>
           <li class="sidebar-dropdown {{ request()->routeIs('admin.service-categories*') || request()->routeIs('admin.services*') ? 'active' : '' }}">
    <a class="nav-link d-flex align-items-center dropdown-btn" href="javascript:void(0)">
        <i class="bi bi-gear-fill me-2"></i>
        <span class="menu-text">Manage Services</span>
        <i class="bi bi-chevron-down ms-auto arrow"></i>
    </a>
    <ul class="submenu {{ request()->routeIs('admin.service-categories*') || request()->routeIs('admin.services*') ? 'show' : '' }}">
        <li>
            <a class="nav-link {{ request()->routeIs('admin.service-categories*') ? 'active' : '' }}" href="{{ route('admin.service-categories.index') }}">
                <i class="bi bi-circle"></i> Services Category
            </a>
        </li>
        <li>
            <a class="nav-link {{ request()->routeIs('admin.services*') ? 'active' : '' }}" href="{{ route('admin.services.index') }}">
                <i class="bi bi-circle"></i> Services
            </a>
        </li>
    </ul>
</li>

           <li class="sidebar-dropdown {{ request()->routeIs('admin.gallery-categories*') || request()->routeIs('admin.gallery-images*') ? 'active' : '' }}">
    <a class="nav-link d-flex align-items-center dropdown-btn" href="javascript:void(0)">
        <i class="bi bi-images me-2"></i>
        <span class="menu-text">Manage Gallery</span>
        <i class="bi bi-chevron-down ms-auto arrow"></i>
    </a>
    <ul class="submenu {{ request()->routeIs('admin.gallery-categories*') || request()->routeIs('admin.gallery-images*') ? 'show' : '' }}">
        <li>
            <a class="nav-link {{ request()->routeIs('admin.gallery-categories*') ? 'active' : '' }}" href="{{ route('admin.gallery-categories.index') }}">
                <i class="bi bi-circle"></i> Gallery Categories
            </a>
        </li>
        <li>
            <a class="nav-link {{ request()->routeIs('admin.gallery-images*') ? 'active' : '' }}" href="{{ route('admin.gallery-images.index') }}">
                <i class="bi bi-circle"></i> Gallery Images
            </a>
        </li>
    </ul>
</li>

           <li class="sidebar-dropdown {{ request()->routeIs('admin.video-categories*') || request()->routeIs('admin.videos*') ? 'active' : '' }}">
    <a class="nav-link d-flex align-items-center dropdown-btn" href="javascript:void(0)">
        <i class="bi bi-camera-video-fill me-2"></i>
        <span class="menu-text">Manage Videos</span>
        <i class="bi bi-chevron-down ms-auto arrow"></i>
    </a>
    <ul class="submenu {{ request()->routeIs('admin.video-categories*') || request()->routeIs('admin.videos*') ? 'show' : '' }}">
        <li>
            <a class="nav-link {{ request()->routeIs('admin.video-categories*') ? 'active' : '' }}" href="{{ route('admin.video-categories.index') }}">
                <i class="bi bi-circle"></i> Video Categories
            </a>
        </li>
        <li>
            <a class="nav-link {{ request()->routeIs('admin.videos*') ? 'active' : '' }}" href="{{ route('admin.videos.index') }}">
                <i class="bi bi-circle"></i> Videos
            </a>
        </li>
    </ul>
</li>

           
          <li class="{{ request()->routeIs('admin.company-settings*') ? 'active' : '' }}">
                <a class="nav-link d-flex align-items-center py-2
                    {{ request()->routeIs('admin.company-settings*') ? 'active' : '' }}"
                href="{{ route('admin.company-settings') }}">
                    <i class="bi bi-gear me-3"></i>
                    <span class="menu-text">Settings</span>
                </a>
            </li>

            <li>
                <a class="nav-link d-flex align-items-center py-2" href="{{ url('/') }}" target="_blank">
                    <i class="bi bi-globe me-3"></i>
                    <span class="menu-text">View Site</span>
                </a>
            </li>

            <li>
                <a class="nav-link d-flex align-items-center py-2" href="{{ route('mylogout') }}">
                    <i class="bi bi-box-arrow-right me-3"></i> 
                    <span class="menu-text">Logout</span>
                </a>
            </li>
        </ul>   
    </div>

    <div class="sidebar-overlay"></div>
    <div id="content-area">
        <nav class="navbar bg-white shadow-sm px-3 py-2 mb-3">
            <div class="container-fluid p-0">
                <div class="d-flex align-items-center w-100">
                    <button id="toggleBtn" class="btn btn-primary btn-sm">
                        ☰
                    </button>
                    <h6 class="mb-0 fw-semibold text-dark ms-3 d-none d-md-block">
                        @yield('page', 'Admin Dashboard')
                    </h6>
                    <div class="dropdown ms-auto">
                        <button class="btn  btn-sm dropdown-toggle align-items-center gap-2 px-3"
                                data-bs-toggle="dropdown">
                            <img src="{{ settings('favicon') ? asset('storage/' . settings('favicon')) : asset('images/avatar.png') }}"
                                 class="rounded-circle"
                                 width="28"
                                 height="28">
                            <span class="fw-medium d-none d-sm-inline">
                                {{ auth()->user()->name }}
                            </span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end w-100">
                            <li><a class="dropdown-item" href="{{ route('admin.profile') }}">Profile</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.company-settings') }}">Settings</a></li>
                            <li><hr></li>
                            <li><a class="dropdown-item text-warning" href="{{ route('mylogout') }}">Logout</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Mobile Page Title -->
                <div class="d-md-none text-center mt-2 w-100">
                    <h6 class="mb-0 fw-semibold text-dark">
                        @yield('page', 'Dashboard')
                    </h6>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>
    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    
   <script>
document.addEventListener('DOMContentLoaded', function() {
    // Elements
    const toggleBtn = document.getElementById('toggleBtn');
    const sidebar = document.getElementById('sidebar');
    const sidebarCloseBtn = document.getElementById('sidebarCloseBtn');
    const overlay = document.querySelector('.sidebar-overlay');
    
    // Check if mobile
    function isMobile() {
        return window.innerWidth <= 992;
    }
    
    // Toggle Sidebar Function
    function toggleSidebar() {
        if (isMobile()) {
            sidebar.classList.toggle('show');
            overlay.style.display = sidebar.classList.contains('show') ? 'block' : 'none';
        } else {
            sidebar.classList.toggle('collapsed');
        }
        updateToggleButtonIcon();
    }
    
    // Close Sidebar Function
    function closeSidebar() {
        if (isMobile()) {
            sidebar.classList.remove('show');
            overlay.style.display = 'none';
        } else {
            sidebar.classList.add('collapsed');
        }
        updateToggleButtonIcon();
    }
    
    // Update toggle button icon
    function updateToggleButtonIcon() {
        if (toggleBtn) {
            if (sidebar.classList.contains('collapsed') || !sidebar.classList.contains('show')) {
                toggleBtn.innerHTML = '☰';
            } else {
                toggleBtn.innerHTML = '✕';
            }
        }
    }
    
    // Event Listeners
    if (toggleBtn) {
        toggleBtn.addEventListener('click', toggleSidebar);
    }
    
    if (sidebarCloseBtn) {
        sidebarCloseBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            closeSidebar();
        });
    }
    
    if (overlay) {
        overlay.addEventListener('click', closeSidebar);
    }
    
    // Dropdown functionality
    const dropdownBtns = document.querySelectorAll('.dropdown-btn');
    
    dropdownBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const parentLi = this.closest('.sidebar-dropdown');
            const submenu = parentLi.querySelector('.submenu');
            const arrow = parentLi.querySelector('.arrow');
            
            // Toggle current dropdown
            parentLi.classList.toggle('active');
            if (submenu) {
                submenu.classList.toggle('show');
            }
            if (arrow) {
                arrow.style.transform = parentLi.classList.contains('active') ? 'rotate(180deg)' : 'rotate(0deg)';
            }
            
            // Close other dropdowns
            document.querySelectorAll('.sidebar-dropdown').forEach(otherDropdown => {
                if (otherDropdown !== parentLi) {
                    otherDropdown.classList.remove('active');
                    const otherSubmenu = otherDropdown.querySelector('.submenu');
                    const otherArrow = otherDropdown.querySelector('.arrow');
                    if (otherSubmenu) {
                        otherSubmenu.classList.remove('show');
                    }
                    if (otherArrow) {
                        otherArrow.style.transform = 'rotate(0deg)';
                    }
                }
            });
        });
    });
    
    // Auto open dropdown if child is active
    function autoOpenActiveDropdowns() {
        document.querySelectorAll('.sidebar-dropdown').forEach(dropdown => {
            const activeChild = dropdown.querySelector('.submenu .active');
            if (activeChild) {
                dropdown.classList.add('active');
                const submenu = dropdown.querySelector('.submenu');
                const arrow = dropdown.querySelector('.arrow');
                if (submenu) {
                    submenu.classList.add('show');
                }
                if (arrow) {
                    arrow.style.transform = 'rotate(180deg)';
                }
            }
        });
    }
    
    // Close dropdowns when clicking outside (desktop only)
    document.addEventListener('click', function(e) {
        if (!isMobile() && !e.target.closest('.sidebar-dropdown')) {
            document.querySelectorAll('.sidebar-dropdown').forEach(dropdown => {
                dropdown.classList.remove('active');
                const submenu = dropdown.querySelector('.submenu');
                const arrow = dropdown.querySelector('.arrow');
                if (submenu) {
                    submenu.classList.remove('show');
                }
                if (arrow) {
                    arrow.style.transform = 'rotate(0deg)';
                }
            });
        }
    });
    
    // Handle window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth > 992) {
            sidebar.classList.remove('show');
            overlay.style.display = 'none';
        } else {
            sidebar.classList.remove('collapsed');
        }
        updateToggleButtonIcon();
    });
    
    // Close sidebar when clicking menu links (mobile)
    if (isMobile()) {
        document.querySelectorAll('#sidebar .nav-link').forEach(link => {
            if (!link.classList.contains('dropdown-btn')) {
                link.addEventListener('click', function() {
                    setTimeout(closeSidebar, 300);
                });
            }
        });
    }
    
    // Initialize
    autoOpenActiveDropdowns();
    updateToggleButtonIcon();
});
</script>
    @stack('scripts')
</body>
</html>