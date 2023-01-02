 <!-- Navbar -->
 <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
    <div class="container-fluid py-1 px-3">
      <span class="d-xl-none ps-3 d-flex align-items-center me-2">
        <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
          <div class="sidenav-toggler-inner">
            <i class="sidenav-toggler-line"></i>
            <i class="sidenav-toggler-line"></i>
            <i class="sidenav-toggler-line"></i>
          </div>
        </a>
      </span>
      <nav aria-label="breadcrumb">
        <h6 class="font-weight-bolder mb-0">{{ $title ?? 'Template'}}</h6>
      </nav>
      <div class="mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
        <!-- UL -->
        <ul class="navbar-nav  justify-content-end">

            <li class="nav-item d-lg-none">
              <a role="button" data-bs-toggle="offcanvas" data-bs-target="#filter-panel"><i class="fas fa-search"></i></a>
            </li>
           
          </ul>
        <!-- END UL -->
      </div>
    </div>
  </nav>
  <!-- End Navbar -->