<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 fixed-start bg-gradient-dark" id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="javascript:void(0);">
            <img src="{{ asset('/img/logo-ct.png') }}" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-1 font-weight-bold text-white">{{__('Customer Invoice')}}</span>
        </a>
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto  max-height-vh-100" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link text-white " href="">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-home"></i>
                    </div>
                    <span class="nav-link-text ms-1">{{ __('template.menu.home') }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white " href="{{ route('products.index') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-microchip"></i>
                    </div>
                    <span class="nav-link-text ms-1">{{ __('template.menu.product') }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white " href="{{ route('customers.index') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-address-book"></i>
                    </div>
                    <span class="nav-link-text ms-1">{{ __('template.menu.customer') }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white " href="{{ route('taxes.index') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-percent"></i>
                    </div>
                    <span class="nav-link-text ms-1">{{ __('template.menu.tax') }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" data-bs-toggle="collapse" data-bs-target="#{{ __('template.menu.invoice.general') }}-children">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-file-invoice"></i>
                    </div>
                    <span class="nav-link-text ms-1">{{ __('template.menu.invoice.general') }}</span>
                </a>
                <ul class="navbar-nav collapse" id="{{__('template.menu.invoice.general')}}-children">
                    <li class="nav-item">
						<a class="nav-link text-white" href="{{ route('invoices.index') }}">
							<span class="nav-link-text ms-3">{{ __('template.menu.invoice.general') }}</span>
						</a>
					</li>
                    <li class="nav-item">
						<a class="nav-link text-white" href="{{ route('reccuringInvoices.index') }}">
							<span class="nav-link-text ms-3">{{ __('template.menu.invoice.reccuring') }}</span>
						</a>
					</li>
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white " data-bs-toggle="collapse" data-bs-target="#{{ __('template.menu.report.report') }}-children">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-list"></i>
                    </div>
                    <span class="nav-link-text ms-1">{{ __('template.menu.report.report') }}</span>
                </a>
                <ul class="navbar-nav collapse" id="{{__('template.menu.report.report')}}-children">
                    <li class="nav-item">
						<a class="nav-link text-white" href="{{ route('transactions.index') }}">
							<span class="nav-link-text ms-3">{{ __('template.menu.report.transaction') }}</span>
						</a>
					</li>
                    <li class="nav-item">
						<a class="nav-link text-white" href="{{ route('reports.index') }}">
							<span class="nav-link-text ms-3">{{ __('template.menu.report.report') }}</span>
						</a>
					</li>
                </ul>
            </li>
        </ul>
    </div>
    <div class="sidenav-footer position-absolute w-100 bottom-0 ">
        <div class="mx-3">
        </div>
    </div>
</aside>
