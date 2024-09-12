<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
            <a href="{{ route('admin.index') }}" class="nav-link" id="dashboard">
                <i class="nav-icon fas fa-th"></i>
                <p>
                    {{ __('Dashboard') }}
                </p>
            </a>
        </li>

        {{-- <li class="nav-item">
            <a href="{{ route('admin.profile.edit') }}" class="nav-link" id="profile">
                <i class="nav-icon fas fa-user-circle"></i>
                <p>
                    {{ __('Profile') }}
                </p>
            </a>
        </li> --}}

        @can('view_group')
        <li class="nav-item {{ Route::currentRouteName() === 'admin.groups.index' ? 'active' : '' }}">
            <a href="{{ route('admin.groups.index') }}" class="nav-link">
                <i class="nav-icon fas fa-file-invoice-dollar"></i>
                <p>{{ __('Invoices') }}</p>
            </a>
        </li>
    @endcan
        
    @can('view_pos_transactions')
        <li class="nav-item {{ Route::currentRouteName() === 'admin.pos_transactions.index' ? 'active' : '' }}">
            <a href="{{ route('admin.pos_transactions.index') }}" class="nav-link" >
                <i class="nav-icon fas fa-exchange-alt"></i>
                <p>{{ __('POS Transactions') }}</p>
            </a>
        </li>
    @endcan

        @can('view_pos_transactions')
        <li class="nav-item {{ Route::currentRouteName() === 'admin.pos_transactions.sales_report' ? 'active' : '' }}">
            <a href="{{ route('admin.pos_transactions.sales_report') }}" class="nav-link">
                <i class="nav-icon fas fa-exchange-alt"></i>
                <p>
                    {{ __('All Transactions') }}
                </p>
            </a>
        </li>
        @endcan

        @can('view_pos')
        <li class="nav-item {{ Route::currentRouteName() === 'admin.pointofsales.index' ? 'active' : '' }}">
            <a href="{{ route('admin.pointofsales.index') }}" class="nav-link">
                <i class="nav-icon fas fa-exchange-alt"></i>
                <p>
                    {{ __('Point Of Sales') }}
                </p>
            </a>
        </li>
        @endcan

        @canany(['view_medical_report', 'view_culture_prices', 'view_package_prices'])
            <li class="nav-item has-treeview" id="prices">
                <a href="#" class="nav-link" id="prices_link">
                    <i class="nav-icon fas fa-flag"></i>
                    <p>
                        {{ __('Medical reports') }}
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                @if (auth()->guard('admin')->check() && auth()->guard('admin')->user()->theme == 'dark')
                    <ul style="background-color: #5e6b8f" class="nav nav-treeview">
                    @else
                        <ul style="background-color: #d3daed" class="nav nav-treeview">
                @endif
                @can('view_medical_report')
                <li class="nav-item {{ Route::currentRouteName() === 'admin.medical_reports.index' ? 'active' : '' }}">
                    <a href="{{ route('admin.medical_reports.index') }}" class="nav-link" id="medical_reports">
                        <i class="far fa-circle nav-icon"></i>
                        <p>{{ __('All Departments') }}</p>
                    </a>
                </li>
            @endcan

            <li class="nav-item {{ Route::currentRouteName() === 'admin.microbiologys.index' ? 'active' : '' }}">
                <a href="{{ route('admin.microbiologys.index') }}" class="nav-link" id="medical_reports">
                    <i class="far fa-circle nav-icon"></i>
                    <p>{{ __('Dep. Microbiology') }}</p>
                </a>
            </li>


            @can('view_medical_report')
                <li class="nav-item {{ Route::currentRouteName() === 'admin.biochemistrys.index' ? 'active' : '' }}">
                    <a href="{{ route('admin.biochemistrys.index') }}" class="nav-link" id="medical_reports">
                        <i class="far fa-circle nav-icon"></i>
                        <p>{{ __('Dep. Biochemistry') }}</p>
                    </a>
                </li>
            @endcan

            @can('view_medical_report')
                <li class="nav-item {{ Route::currentRouteName() === 'admin.visits.index' ? 'active' : '' }}">
                    <a href="{{ route('admin.visits.index') }}" class="nav-link" id="medical_reports">
                        <i class="far fa-circle nav-icon"></i>
                        <p>{{ __('Dep. Family Medicine') }}</p>
                    </a>
                </li>
            @endcan

            @can('view_visitdr')
                <li class="nav-item {{ Route::currentRouteName() === 'admin.visitsDr.index' ? 'active' : '' }}">
                    <a href="{{ route('admin.visitsDr.index') }}" class="nav-link" id="medical_reports">
                        <i class="far fa-circle nav-icon"></i>
                        <p>{{ __('Dep. Family Medicine - DR') }}</p>
                    </a>
                </li>
            @endcan


            @can('view_medical_report')
                <li class="nav-item {{ Route::currentRouteName() === 'admin.healthcertificates.index' ? 'active' : '' }}">
                    <a href="{{ route('admin.healthcertificates.index') }}" class="nav-link" id="health_certificates">
                        <i class="far fa-circle nav-icon"></i>
                        <p>{{ __('Dep. Health Certificate') }}</p>
                    </a>
                </li>
            @endcan

            @can('view_pathologys')
                <li class="nav-item {{ Route::currentRouteName() === 'admin.pathologys.index' ? 'active' : '' }}">
                    <a href="{{ route('admin.pathologys.index') }}" class="nav-link" id="pathology">
                        <i class="far fa-circle nav-icon"></i>
                        <p>{{ __('Dep. Pathology') }}</p>
                    </a>
                </li>
            @endcan
        </ul>
        </li>
    @endcan

    @canany(['view_category', 'view_test', 'view_package_prices', 'view_contract', 'view_culture',
        'view_culture_option', 'view_service'])
        <li class="nav-item has-treeview" id="prices">
            <a href="#" class="nav-link" id="prices_link">
                <i class="nav-icon fas fa-clone"></i>
                <p>
                    {{ __('Articles') }}
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            @if (auth()->guard('admin')->check() && auth()->guard('admin')->user()->theme == 'dark')
                <ul style="background-color: #5e6b8f" class="nav nav-treeview">
                @else
                    <ul style="background-color: #d3daed" class="nav nav-treeview">
            @endif
            @can('view_category')
            <li class="nav-item {{ Route::currentRouteName() === 'admin.categories.index' ? 'active' : '' }}">
                <a href="{{ route('admin.categories.index') }}" class="nav-link" id="categories">
                    <i class="nav-icon fas fa-tasks"></i>
                    <p>
                        {{ __('Categories') }}
                    </p>
                </a>
            </li>
        @endcan
        @can('view_test')
            <li class="nav-item {{ Route::currentRouteName() === 'admin.tests.index' ? 'active' : '' }}">
                <a href="{{ route('admin.tests.index') }}" class="nav-link" id="tests">
                    <i class="nav-icon fas fa-flask"></i>
                    <p>
                        {{ __('Tests') }}
                    </p>
                </a>
            </li>
        @endcan
        @can('view_test')
        <li class="nav-item {{ Route::currentRouteName() === 'admin.microbiology_tests.index' ? 'active' : '' }}">
          <a href="{{route('admin.microbiology_tests.index')}}" class="nav-link" id="microbiology_tests">
            <i class="nav-icon fas fa-flask"></i>
            <p>
              {{__('Microbiology Tests')}}
            </p>
          </a>
        </li>
        @endcan

        @can('view_service')
            <li class="nav-item {{ Route::currentRouteName() === 'admin.services.index' ? 'active' : '' }}">
                <a href="{{ route('admin.services.index') }}" class="nav-link" id="tests">
                    <i class="nav-icon fas fa-flask"></i>
                    <p>
                        {{ __('Services') }}
                    </p>
                </a>
            </li>
        @endcan
        @can('view_culture')
            <li class="nav-item {{ Route::currentRouteName() === 'admin.cultures.index' ? 'active' : '' }}">
                <a href="{{ route('admin.cultures.index') }}" class="nav-link" id="cultures">
                    <i class="nav-icon fas fa-vial"></i>
                    <p>
                        {{ __('Cultures') }}
                    </p>
                </a>
            </li>
        @endcan

        @can('view_culture_option')
            <li class="nav-item {{ Route::currentRouteName() === 'admin.culture_options.index' ? 'active' : '' }}">
                <a href="{{ route('admin.culture_options.index') }}" class="nav-link" id="culture_options">
                    <i class="nav-icon fas fa-vial"></i>
                    <p>
                        {{ __('Culture options') }}
                    </p>
                </a>
            </li>
        @endcan

        @can('view_antibiotic')
            <li class="nav-item {{ Route::currentRouteName() === 'admin.antibiotics.index' ? 'active' : '' }}">
                <a href="{{ route('admin.antibiotics.index') }}" class="nav-link" id="antibiotics">
                    <i class="nav-icon fas fa-capsules"></i>
                    <p>
                        {{ __('Antibiotics & Therapy') }}
                    </p>
                </a>
            </li>
        @endcan

        @can('view_package')
            <li class="nav-item {{ Route::currentRouteName() === 'admin.packages.index' ? 'active' : '' }}">
                <a href="{{ route('admin.packages.index') }}" class="nav-link" id="packages">
                    <i class="nav-icon fas fa-box"></i>
                    <p>
                        {{ __('Packages') }}
                    </p>
                </a>
            </li>
        @endcan
        @can('view_contract')
            <li class="nav-item {{ Route::currentRouteName() === 'admin.contracts.index' ? 'active' : '' }}">
                <a href="{{ route('admin.contracts.index') }}" class="nav-link" id="contracts">
                    <i class="fas fa-file-contract nav-icon"></i>
                    <p>{{ __('Contracts') }}</p>
                </a>
            </li>
        @endcan
        @can('view_contract')
            <li class="nav-item {{ Route::currentRouteName() === 'admin.contracts2.index' ? 'active' : '' }}">
                <a href="{{ url('admin.contracts2.index') }}" class="nav-link" id="contracts">
                    <i class="fas fa-file-contract nav-icon"></i>
                    <p>{{ __('Contracts 2') }}</p>
                </a>
            </li>
        @endcan

        </ul>
        </li>
    @endcan

    @canany(['view_test_prices', 'view_culture_prices', 'view_package_prices'])
        <li class="nav-item has-treeview" id="prices">
            <a href="#" class="nav-link" id="prices_link">
                <i class="nav-icon fas fa-list"></i>
                <p>
                    {{ __('Price List') }}
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            @if (auth()->guard('admin')->check() && auth()->guard('admin')->user()->theme == 'dark')
                <ul style="background-color: #5e6b8f" class="nav nav-treeview">
                @else
                    <ul style="background-color: #d3daed" class="nav nav-treeview">
            @endif

            @can('view_test_prices')
            <li class="nav-item {{ Route::currentRouteName() === 'admin.prices.tests' ? 'active' : '' }}">
                <a href="{{ route('admin.prices.tests') }}" class="nav-link" id="tests_prices">
                    <i class="far fa-circle nav-icon"></i>
                    <p>{{ __('Tests') }}</p>
                </a>
            </li>
        @endcan
        @can('view_test_prices')
        <li class="nav-item {{ Route::currentRouteName() === 'admin.prices.microbiology_tests' ? 'active' : '' }}">
          <a href="{{route('admin.prices.microbiology_tests')}}" class="nav-link" id="tests_prices">
            <i class="far fa-circle nav-icon"></i>
            <p>{{__('Microbiology Tests')}}</p>
          </a>
        </li>
        @endcan

        @can('view_culture_prices')
            <li class="nav-item {{ Route::currentRouteName() === 'admin.prices.cultures' ? 'active' : '' }}">
                <a href="{{ route('admin.prices.cultures') }}" class="nav-link" id="cultures_prices">
                    <i class="far fa-circle nav-icon"></i>
                    <p>{{ __('Cultures') }}</p>
                </a>
            </li>
        @endcan

        @can('view_package_prices')
            <li class="nav-item {{ Route::currentRouteName() === 'admin.prices.packages' ? 'active' : '' }}">
                <a href="{{ route('admin.prices.packages') }}" class="nav-link" id="packages_prices">
                    <i class="far fa-circle nav-icon"></i>
                    <p>{{ __('Packages') }}</p>
                </a>
            </li>
        @endcan

        @can('view_service_prices')
            <li class="nav-item {{ Route::currentRouteName() === 'admin.prices.services' ? 'active' : '' }}">
                <a href="{{ route('admin.prices.services') }}" class="nav-link" id="tests_prices">
                    <i class="far fa-circle nav-icon"></i>
                    <p>{{ __('Services') }}</p>
                </a>
            </li>
        @endcan

        </ul>
        </li>
    @endcan

    @canany(['view_test_orders', 'view_culture_prices', 'view_package_prices', 'view_service_prices'])
        <li class="nav-item has-treeview" id="prices">
            <a href="#" class="nav-link" id="prices_link">
                <i class="nav-icon fas fa-clipboard-list"></i>
                <p>
                    {{ __('Orders List') }}
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            @if (auth()->guard('admin')->check() && auth()->guard('admin')->user()->theme == 'dark')
                <ul style="background-color: #5e6b8f" class="nav nav-treeview">
                @else
                    <ul style="background-color: #d3daed" class="nav nav-treeview">
            @endif

            @can('view_test_orders')
            <li class="nav-item {{ Route::currentRouteName() === 'admin.tests.tests_orders' ? 'active' : '' }}">
                <a href="{{ route('admin.tests.tests_orders') }}" class="nav-link" id="tests_prices">
                    <i class="far fa-circle nav-icon"></i>
                    <p>{{ __('Tests') }}</p>
                </a>
            </li>
        @endcan

        </ul>
        </li>
    @endcan

    @can('view_patient')
        <li class="nav-item {{ Route::currentRouteName() === 'admin.patients.index' ? 'active' : '' }}">
            <a href="{{ route('admin.patients.index') }}" class="nav-link" id="patients">
                <i class="nav-icon fas fa-user-injured"></i>
                <p>
                    {{ __('Patients') }}
                </p>
            </a>
        </li>
    @endcan

    @can('view_doctor')
        <li class="nav-item {{ Route::currentRouteName() === 'admin.doctors.index' ? 'active' : '' }}">
            <a href="{{ route('admin.doctors.index') }}" class="nav-link" id="doctors">
                <i class="nav-icon fa fa-user-md"></i>
                <p>
                    {{ __('Doctors') }}
                </p>
            </a>
        </li>
    @endcan


    @can('view_appointments')
        <li class="nav-item {{ Route::currentRouteName() === 'admin.appointments.index' ? 'active' : '' }}">
            <a href="{{ route('admin.appointments.index') }}" class="nav-link" id="appointments">
                <i class="nav-icon fas fa-tasks"></i>
                <p>
                    {{ __('Appointments') }}
                </p>
            </a>
        </li>
    @endcan

    @canAny(['view_supplier', 'view_products', 'view_purchases', 'view_adjustments', 'view_transfers'])
        <li class="nav-item has-treeview" id="inventory">
            <a href="#" class="nav-link" id="inventory_link">
                <i class="nav-icon fas fa-cubes"></i>
                <p>
                    {{ __('Inventory') }}
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            @if (auth()->guard('admin')->check() && auth()->guard('admin')->user()->theme == 'dark')
                <ul style="background-color: #5e6b8f" class="nav nav-treeview">
                @else
                    <ul style="background-color: #d3daed" class="nav nav-treeview">
            @endif

            @can('view_supplier')
            <li class="nav-item {{ Route::currentRouteName() === 'admin.inventory.suppliers.index' ? 'active' : '' }}">
                <a href="{{ route('admin.inventory.suppliers.index') }}" class="nav-link" id="suppliers">
                    <i class="far fa-circle nav-icon"></i>
                    <p>
                        {{ __('Suppliers') }}
                    </p>
                </a>
            </li>
        @endcan

        @can('view_product')
            <li class="nav-item {{ Route::currentRouteName() === 'admin.inventory.products.index' ? 'active' : '' }}">
                <a href="{{ route('admin.inventory.products.index') }}" class="nav-link" id="products">
                    <i class="far fa-circle nav-icon"></i>
                    <p>
                        {{ __('Products') }}
                    </p>
                </a>
            </li>
        @endcan

        @can('view_purchase')
            <li class="nav-item {{ Route::currentRouteName() === 'admin.inventory.purchases.index' ? 'active' : '' }}">
                <a href="{{ route('admin.inventory.purchases.index') }}" class="nav-link" id="purchases">
                    <i class="far fa-circle nav-icon"></i>
                    <p>
                        {{ __('Purchases') }}
                    </p>
                </a>
            </li>
        @endcan

        @can('view_adjustment')
            <li class="nav-item {{ Route::currentRouteName() === 'admin.inventory.adjustments.index' ? 'active' : '' }}">
                <a href="{{ route('admin.inventory.adjustments.index') }}" class="nav-link" id="adjustments">
                    <i class="far fa-circle nav-icon"></i>
                    <p>
                        {{ __('Adjustments') }}
                    </p>
                </a>
            </li>
        @endcan

        @can('view_transfer')
            <li class="nav-item {{ Route::currentRouteName() === 'admin.inventory.transfers.index' ? 'active' : '' }}">
                <a href="{{ route('admin.inventory.transfers.index') }}" class="nav-link" id="transfers">
                    <i class="far fa-circle nav-icon"></i>
                    <p>
                        {{ __('Transfers') }}
                    </p>
                </a>
            </li>
        @endcan

        </ul>
        </li>
    @endcan

    @canany(['view_payment_method', 'view_expense', 'view_expense_category'])
        <li class="nav-item has-treeview" id="accounting">
            <a href="#" class="nav-link" id="accounting_link">
                <i class="nav-icon fas fa-calculator"></i>
                <p>
                    {{ __('Accounting') }}
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            @if (auth()->guard('admin')->check() && auth()->guard('admin')->user()->theme == 'dark')
                <ul style="background-color: #5e6b8f" class="nav nav-treeview">
                @else
                    <ul style="background-color: #d3daed" class="nav nav-treeview">
            @endif

            @can('view_payment_method')
            <li class="nav-item {{ Route::currentRouteName() === 'admin.payment_methods.index' ? 'active' : '' }}">
                <a href="{{ route('admin.payment_methods.index') }}" class="nav-link" id="payment_methods">
                    <i class="far fa-circle nav-icon"></i>
                    <p>
                        {{ __('Payment methods') }}
                    </p>
                </a>
            </li>
        @endcan

        @can('view_expense_category')
            <li class="nav-item {{ Route::currentRouteName() === 'admin.expense_categories.index' ? 'active' : '' }}">
                <a href="{{ route('admin.expense_categories.index') }}" class="nav-link" id="expense_categories">
                    <i class="far fa-circle nav-icon"></i>
                    <p>
                        {{ __('Expense Categories') }}
                    </p>
                </a>
            </li>
        @endcan

        @can('view_expense')
            <li class="nav-item {{ Route::currentRouteName() === 'admin.expenses.index' ? 'active' : '' }}">
                <a href="{{ route('admin.expenses.index') }}" class="nav-link" id="expenses">
                    <i class="far fa-circle nav-icon"></i>
                    <p>
                        {{ __('Expenses') }}
                    </p>
                </a>
            </li>
        @endcan

        </ul>
        </li>
    @endcan

    @canany(['view_accounting_report', 'view_doctor_report', 'view_supplier_report', 'view_inventory_report'])
        <li class="nav-item has-treeview" id="reports">
            <a href="#" class="nav-link" id="reports_link">
                <i class="nav-icon fas fa-chart-bar"></i>
                <p>
                    {{ __('Reports') }}
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            @if (auth()->guard('admin')->check() && auth()->guard('admin')->user()->theme == 'dark')
                <ul style="background-color: #5e6b8f" class="nav nav-treeview">
                @else
                    <ul style="background-color: #d3daed" class="nav nav-treeview">
            @endif

            @can('view_accounting_report')
            <li class="nav-item {{ Route::currentRouteName() === 'admin.ikshp_reports.index' ? 'active' : '' }}">
                <a href="{{ route('admin.ikshp_reports.index') }}" class="nav-link" id="ikshp_reports">
                    <i class="far fa-circle nav-icon"></i>
                    <p>
                        {{ __('Report X') }}
                    </p>
                </a>
            </li>
        @endcan

        @can('view_accounting_report')
            <li class="nav-item {{ Route::currentRouteName() === 'admin.reports.accounting' ? 'active' : '' }}">
                <a href="{{ route('admin.reports.accounting') }}" class="nav-link" id="accounting_report">
                    <i class="far fa-circle nav-icon"></i>
                    <p>{{ __('General report') }}</p>
                </a>
            </li>
        @endcan

        @can('view_doctor_report')
            <li class="nav-item {{ Route::currentRouteName() === 'admin.reports.doctor' ? 'active' : '' }}">
                <a href="{{ route('admin.reports.doctor') }}" class="nav-link" id="doctor_report">
                    <i class="far fa-circle nav-icon"></i>
                    <p>{{ __('Doctor report') }}</p>
                </a>
            </li>
        @endcan

        @can('view_supplier_report')
            <li class="nav-item {{ Route::currentRouteName() === 'admin.reports.supplier' ? 'active' : '' }}">
                <a href="{{ route('admin.reports.supplier') }}" class="nav-link" id="supplier_report">
                    <i class="far fa-circle nav-icon"></i>
                    <p>{{ __('Supplier report') }}</p>
                </a>
            </li>
        @endcan

        @can('view_purchase_report')
            <li class="nav-item {{ Route::currentRouteName() === 'admin.reports.purchase' ? 'active' : '' }}">
                <a href="{{ route('admin.reports.purchase') }}" class="nav-link" id="purchase_report">
                    <i class="far fa-circle nav-icon"></i>
                    <p>{{ __('Purchases report') }}</p>
                </a>
            </li>
        @endcan

        @can('view_inventory_report')
            <li class="nav-item {{ Route::currentRouteName() === 'admin.reports.inventory' ? 'active' : '' }}">
                <a href="{{ route('admin.reports.inventory') }}" class="nav-link" id="inventory_report">
                    <i class="far fa-circle nav-icon"></i>
                    <p>{{ __('Inventory report') }}</p>
                </a>
            </li>
        @endcan

        @can('view_product_report')
            <li class="nav-item {{ Route::currentRouteName() === 'admin.reports.product' ? 'active' : '' }}">
                <a href="{{ route('admin.reports.product') }}" class="nav-link" id="product_report">
                    <i class="far fa-circle nav-icon"></i>
                    <p>{{ __('Products report') }}</p>
                </a>
            </li>
        @endcan

        @can('view_product_report')
            <li class="nav-item {{ Route::currentRouteName() === 'admin.reports.hlresult' ? 'active' : '' }}">
                <a href="{{ route('admin.reports.hlresult') }}" class="nav-link" id="product_report">
                    <i class="far fa-circle nav-icon"></i>
                    <p>{{ __('High Low Result Report') }}</p>
                </a>
            </li>
        @endcan

        </ul>
        </li>
    @endcan

    @canany(['view_user', 'view_role'])
        <li class="nav-item has-treeview" id="users_roles">
            <a href="#" class="nav-link" id="users_roles_link">
                <i class="nav-icon fas fa-user"></i>
                <p>
                    {{ __('Roles And Users') }}
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            @if (auth()->guard('admin')->check() && auth()->guard('admin')->user()->theme == 'dark')
                <ul style="background-color: #5e6b8f" class="nav nav-treeview">
                @else
                    <ul style="background-color: #d3daed" class="nav nav-treeview">
            @endif

            @can('view_role')
            <li class="nav-item {{ Route::currentRouteName() === 'admin.roles.index' ? 'active' : '' }}">
                <a href="{{ route('admin.roles.index') }}" class="nav-link" id="roles">
                    <i class="far fa-circle nav-icon"></i>
                    <p>{{ __('Roles') }}</p>
                </a>
            </li>
        @endcan

        @can('view_user')
            <li class="nav-item {{ Route::currentRouteName() === 'admin.users.index' ? 'active' : '' }}">
                <a href="{{ route('admin.users.index') }}" class="nav-link" id="users">
                    <i class="far fa-circle nav-icon"></i>
                    <p>{{ __('Users') }}</p>
                </a>
            </li>
        @endcan

        </ul>
        </li>
    @endcan

    @canany(['view_instrument', 'view_laboratory', 'view_branch', 'view_setting', 'view_translation',
        'view_activity_log', 'view_backup', 'view_chat', 'view_vat'])
        <li class="nav-item has-treeview" id="users_roles">
            <a href="#" class="nav-link" id="users_roles_link">
                <i class="nav-icon fas fa-tools"></i>
                <p>
                    {{ __('Tools') }}
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            @if (auth()->guard('admin')->check() && auth()->guard('admin')->user()->theme == 'dark')
                <ul style="background-color: #5e6b8f" class="nav nav-treeview">
                @else
                    <ul style="background-color: #d3daed" class="nav nav-treeview">
            @endif
            @can('view_instrument')
            <li class="nav-item {{ Route::currentRouteName() === 'admin.instruments.index' ? 'active' : '' }}">
                <a href="{{ route('admin.instruments.index') }}" class="nav-link" id="instruments">
                    <i class="nav-icon fa fa-user-md"></i>
                    <p>
                        {{ __('Instruments') }}
                    </p>
                </a>
            </li>
        @endcan

        @can('view_laboratory')
            <li class="nav-item {{ Route::currentRouteName() === 'admin.laboratories.index' ? 'active' : '' }}">
                <a href="{{ route('admin.laboratories.index') }}" class="nav-link" id="laboratories">
                    <i class="nav-icon fas fa-vial"></i>
                    <p>
                        {{ __('Laboratories') }}
                    </p>
                </a>
            </li>
        @endcan

        @can('view_vat')
            <li class="nav-item {{ Route::currentRouteName() === 'admin.vat.index' ? 'active' : '' }}">
                <a href="{{ route('admin.vat.index') }}" class="nav-link" id="vat">
                    <i class="nav-icon fas fa-money-check-alt"></i>
                    <p>
                        {{ __('Vat') }}
                    </p>
                </a>
            </li>
        @endcan

        @can('view_branch')
            <li class="nav-item {{ Route::currentRouteName() === 'admin.branches.index' ? 'active' : '' }}">
                <a href="{{ route('admin.branches.index') }}" class="nav-link" id="branches">
                    <i class="fas fa-map-marked-alt nav-icon"></i>
                    <p>{{ __('Branches') }}</p>
                </a>
            </li>
        @endcan

        @can('view_setting')
            <li class="nav-item {{ Route::currentRouteName() === 'admin.settings.index' ? 'active' : '' }}">
                <a href="{{ route('admin.settings.index') }}" class="nav-link" id="settings">
                    <i class="fa fa-cogs nav-icon"></i>
                    <p>{{ __('Settings') }}</p>
                </a>
            </li>
        @endcan

        @can('view_translation')
            <li class="nav-item {{ Route::currentRouteName() === 'admin.translations.index' ? 'active' : '' }}">
                <a href="{{ route('admin.translations.index') }}" class="nav-link" id="translations">
                    <i class="fa fa-book nav-icon"></i>
                    <p>{{ __('Translations') }}</p>
                </a>
            </li>
        @endcan

        @can('view_permission')
            <li class="nav-item {{ Route::currentRouteName() === 'admin.permissions.index' ? 'active' : '' }}">
                <a href="{{ route('admin.permissions.index') }}" class="nav-link" id="permissions">
                    <i class="nav-icon fas fa-exchange-alt"></i>
                    <p>
                        {{ __('Permissions') }}
                    </p>
                </a>
            </li>
        @endcan
        {{-- @can('view_branch')
        <li class="nav-item">
            <a href="{{ route('admin.pointofsales.index') }}" class="nav-link" id="permissions">
                <i class="nav-icon fas fa-exchange-alt"></i>
                <p>
                    {{ __('Point Of Sales') }}
                </p>
            </a>
        </li>
        @endcan --}}

        @can('view_activity_log')
            <li class="nav-item {{ Route::currentRouteName() === 'admin.activity_logs.index' ? 'active' : '' }}">
                <a href="{{ route('admin.activity_logs.index') }}" class="nav-link" id="activity_logs">
                    <i class="fa fa-server nav-icon"></i>
                    <p>{{ __('Activity Logs') }}</p>
                </a>
            </li>
        @endcan

        @can('view_backup')
            <li class="nav-item {{ Route::currentRouteName() === 'admin.backups.index' ? 'active' : '' }}">
                <a href="{{ route('admin.backups.index') }}" class="nav-link" id="backups">
                    <i class="fa fa-database nav-icon"></i>
                    <p>{{ __('Database Backups') }}</p>
                </a>
            </li>
        @endcan

        @can('view_chat')
            <li class="nav-item {{ Route::currentRouteName() === 'admin.chat.index' ? 'active' : '' }}">
                <a href="{{ route('admin.chat.index') }}" class="nav-link" id="chat">
                    <i class="nav-icon far fa-comment-dots"></i>
                    <p>
                        {{ __('Chat') }}
                    </p>
                </a>
            </li>
        @endcan

        </ul>
        </li>
    @endcan
    </ul>
</nav>

<style>
    .active {
        background: linear-gradient(118deg,#7367f0,rgba(115,103,240,.7)) !important;
        color: #fff !important;
    }
</style>