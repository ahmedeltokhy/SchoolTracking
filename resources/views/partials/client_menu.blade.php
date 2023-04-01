<div id="sidebar" class="c-sidebar c-sidebar-fixed c-sidebar-lg-show">

    <div class="c-sidebar-brand d-md-down-none">
        <a class="c-sidebar-brand-full h4" href="#">
            {{ trans('panel.site_title') }}
        </a>
    </div>

    <ul class="c-sidebar-nav">
        <li class="c-sidebar-nav-item">
            <a href="{{ route("client.home") }}" class="c-sidebar-nav-link">
                <i class="c-sidebar-nav-icon fas fa-fw fa-tachometer-alt">

                </i>
                {{ trans('global.dashboard') }}
            </a>
        </li>
        @if(auth('client')->user()->type=="teacher")
            <li class="c-sidebar-nav-item">
                <a href="{{ route('teacher.list_sections') }}" class="c-sidebar-nav-link {{ request()->is("list_sections") || request()->is("section/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-book c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.classSection.title') }}
                </a>
            </li>
            <li class="c-sidebar-nav-item">
                <a href="{{ route("teacher.attendances.index") }}" class="c-sidebar-nav-link {{ request()->is("list_attendances") || request()->is("list_attendances/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-address-card c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.attendance.title') }}
                </a>
            </li>
            <li class="c-sidebar-nav-item">
                <a href="{{ route("teacher.homeworks.index") }}" class="c-sidebar-nav-link {{ request()->is("teacher/homeworks") || request()->is("teacher/homeworks/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-align-left c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.homework.title') }}
                </a>
            </li>
            <li class="c-sidebar-nav-item">
                <a href="{{ route("teacher.messages.index") }}" class="c-sidebar-nav-link {{ request()->is("teacher/messages") || request()->is("teacher/messages/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-align-left c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.message.title') }}
                </a>
            </li>
        @endif
        @if(auth('client')->user()->type=="student")
            <li class="c-sidebar-nav-item">
                <a href="{{ route('student.list_sections') }}" class="c-sidebar-nav-link {{ request()->is("list_sections") || request()->is("section/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-book c-sidebar-nav-icon"></i>
                    {{ trans('cruds.classSection.title') }}
                </a>
            </li>
            <li class="c-sidebar-nav-item">
                <a href="{{ route("student.homeworks.index") }}" class="c-sidebar-nav-link {{ request()->is("student/homeworks") || request()->is("homeworks/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-align-left c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.homework.title') }}
                </a>
            </li>
            <li class="c-sidebar-nav-item">
                <a href="{{ route("student.solution.index") }}" class="c-sidebar-nav-link {{ request()->is("student/homework-solutions") || request()->is("homework-solutions/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-align-left c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.homeworkSolution.title') }}
                </a>
            </li>
        @endif
        @if(auth('client')->user()->type=="parent")
            <li class="c-sidebar-nav-item">
                <a href="{{ route('parent.message.index') }}" class="c-sidebar-nav-link {{ request()->is("parent") || request()->is("parent/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-book c-sidebar-nav-icon"></i>
                    {{ trans('cruds.message.title') }}
                </a>
            </li>
            
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