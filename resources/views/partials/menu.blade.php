<div id="sidebar" class="c-sidebar c-sidebar-fixed c-sidebar-lg-show">

    <div class="c-sidebar-brand d-md-down-none">
        <a class="c-sidebar-brand-full h4" href="#">
            {{ trans('panel.site_title') }}
        </a>
    </div>

    <ul class="c-sidebar-nav">
        <li class="c-sidebar-nav-item">
            <a href="{{ route("admin.home") }}" class="c-sidebar-nav-link">
                <i class="c-sidebar-nav-icon fas fa-fw fa-tachometer-alt">

                </i>
                {{ trans('global.dashboard') }}
            </a>
        </li>
        @can('user_management_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/permissions*") ? "c-show" : "" }} {{ request()->is("admin/roles*") ? "c-show" : "" }} {{ request()->is("admin/users*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-users c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.userManagement.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('permission_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.permissions.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/permissions") || request()->is("admin/permissions/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-unlock-alt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.permission.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('role_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.roles.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/roles") || request()->is("admin/roles/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-briefcase c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.role.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('user_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.users.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/users") || request()->is("admin/users/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-user c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.user.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('client_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.clients.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/clients") || request()->is("admin/clients/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-user-friends c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.client.title') }}
                </a>
            </li>
        @endcan
        @can('bus_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.buses.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/buses") || request()->is("admin/buses/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-bus-alt c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.bus.title') }}
                </a>
            </li>
        @endcan
        @can('bus_station_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.bus-stations.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/bus-stations") || request()->is("admin/bus-stations/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-hand-paper c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.busStation.title') }}
                </a>
            </li>
        @endcan
        @can('class_room_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.class-rooms.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/class-rooms") || request()->is("admin/class-rooms/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-archway c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.classRoom.title') }}
                </a>
            </li>
        @endcan
        @can('class_section_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.class-sections.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/class-sections") || request()->is("admin/class-sections/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-book c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.classSection.title') }}
                </a>
            </li>
        @endcan
        @can('homework_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.homeworks.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/homeworks") || request()->is("admin/homeworks/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-align-left c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.homework.title') }}
                </a>
            </li>
        @endcan
        @can('homework_solution_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.homework-solutions.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/homework-solutions") || request()->is("admin/homework-solutions/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-align-center c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.homeworkSolution.title') }}
                </a>
            </li>
        @endcan
        @can('message_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.messages.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/messages") || request()->is("admin/messages/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-envelope c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.message.title') }}
                </a>
            </li>
        @endcan
        @can('attendance_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.attendances.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/attendances") || request()->is("admin/attendances/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-address-card c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.attendance.title') }}
                </a>
            </li>
        @endcan
        
        @if(file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php')))
            @can('profile_password_edit')
                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link {{ request()->is('profile/password') || request()->is('profile/password/*') ? 'c-active' : '' }}" href="{{ route('profile.password.edit') }}">
                        <i class="fa-fw fas fa-key c-sidebar-nav-icon">
                        </i>
                        {{ trans('global.change_password') }}
                    </a>
                </li>
            @endcan
        @endif
        <li class="c-sidebar-nav-item">
            <a href="#" class="c-sidebar-nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                <i class="c-sidebar-nav-icon fas fa-fw fa-sign-out-alt">

                </i>
                {{ trans('global.logout') }}
            </a>
        </li>
    </ul>

</div>