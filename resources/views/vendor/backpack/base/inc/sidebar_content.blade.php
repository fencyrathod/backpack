{{-- This file is used to store sidebar items, inside the Backpack admin panel --}}

{{-- <li class="nav-item"><a class="nav-link" href="{{ backpack_url('staff') }}"><i class="nav-icon la la-question"></i> Staff</a></li> --}}

@if (backpack_user()->hasRole('staff'))
    <li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i>
            {{ trans('backpack::base.dashboard') }}</a></li>

    <li class="nav-item"><a class="nav-link" href="{{ backpack_url('customer') }}"><i class="nav-icon 
        la la-contao"></i>
            Customers</a></li>
    <li class="nav-item"><a class="nav-link" href="{{ backpack_url('jobs') }}"><i class="nav-icon la la-binoculars"></i>
            Jobs</a></li>
@else
    <li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i>
            {{ trans('backpack::base.dashboard') }}</a></li>

    <li class="nav-item"><a class="nav-link" href="{{ backpack_url('customer') }}"><i
                class="nav-icon 
                la la-contao"></i> Customers</a></li>

   

    <li class="nav-item"><a class="nav-link" href="{{ backpack_url('jobs') }}"><i class="nav-icon la la-binoculars"></i>
            Jobs</a></li>

    <li class="nav-item nav-dropdown">
        <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-users"></i>Masters</a>
        <ul class="nav-dropdown-items">
            <li class="nav-item"><a class="nav-link" href="{{ backpack_url('service') }}"><i class="nav-icon 
                la la-contao"></i> Services</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ backpack_url('source') }}"><i
                        class="nav-icon 
                        la la-adjust"></i> Sources</a></li>

            <li class="nav-item"><a class="nav-link" href="{{ backpack_url('service-type') }}"><i
                        class="nav-icon 
                        la la-archive"></i> Service types</a></li>

            <li class="nav-item"><a class="nav-link" href="{{ backpack_url('device-type') }}"><i
                        class="nav-icon la la-apple"></i> Device types</a></li>

            <li class="nav-item"><a class="nav-link" href="{{ backpack_url('device-brand') }}"><i
                        class="nav-icon 
                        la la-beer"></i> Device brands</a></li>

            <li class="nav-item"><a class="nav-link" href="{{ backpack_url('storage-location') }}"><i
                        class="nav-icon 
                        la la-codepen"></i> Storage locations</a></li>
        </ul>
    </li>
    <li class="nav-item nav-dropdown">
        <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-users"></i> Authentication</a>
        <ul class="nav-dropdown-items">
            <li class="nav-item"><a class="nav-link" href="{{ backpack_url('user') }}"><i
                        class="nav-icon la la-user"></i> <span>Users</span></a></li>
            <li class="nav-item"><a class="nav-link" href="{{ backpack_url('role') }}"><i
                        class="nav-icon la la-id-badge"></i> <span>Roles</span></a></li>
            <li class="nav-item"><a class="nav-link" href="{{ backpack_url('permission') }}"><i
                        class="nav-icon la la-key"></i> <span>Permissions</span></a></li>
        </ul>
    </li> <li class="nav-item"><a class="nav-link" href="{{ backpack_url('reports') }}"><i class="nav-icon la la-binoculars"></i> Reports</a></li>
    <li class="nav-item"><a class="nav-link" href="{{ backpack_url('payment') }}"><i class="nav-icon la la-binoculars"></i> Payments</a></li>
    <li class="nav-item"><a class="nav-link" href="{{ backpack_url('settings') }}"><i class="nav-icon la la-connectdevelop"></i> Settings</a></li>
    @endif
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('tag') }}"><i class="nav-icon la la-question"></i> Tags</a></li>

<li class="nav-item"><a class="nav-link" href="{{ backpack_url('emp') }}"><i class="nav-icon la la-question"></i> Employee</a></li>