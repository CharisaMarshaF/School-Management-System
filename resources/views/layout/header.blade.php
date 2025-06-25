<div class="header">

    <div class="header-left">
        <a href="index.html" class="logo">
            <img src="{{ url('public/assets/img/logo.png') }}" alt="Logo">
        </a>
        <a href="index.html" class="logo logo-small">
            <img src="{{ url('public/assets/img/logo-small.png') }}" alt="Logo" width="30" height="30">
        </a>
    </div>
    <div class="menu-toggle">
        <a href="javascript:void(0);" id="toggle_btn">
            <i class="fas fa-bars"></i>
        </a>
    </div>


    <a class="mobile_btn" id="mobile_btn">
        <i class="fas fa-bars"></i>
    </a>

    <ul class="nav user-menu">



        <li class="nav-item zoom-screen me-2">
            <a href="#" class="nav-link header-nav-list win-maximize">
                <img src="{{ url('public/assets/img/icons/header-icon-04.svg') }}" alt="">
            </a>
        </li>

        <li class="nav-item dropdown has-arrow new-user-menus">
            <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                @php
                $user = Auth::user();
                $rolePath = match($user->user_type) {
                1 => 'admin',
                2 => 'teacher',
                3 => 'students',
                4 => 'parent',
                default => 'default'
                };
                $photoPath = $user->profile_pic
                ? asset("SchoolMS_App/public/uploads/{$rolePath}/{$user->profile_pic}")
                : asset('SchoolMS_App/public/assets/img/profiles/avatar-01.jpg');
                @endphp

                <span class="user-img">
                    <img class="rounded-circle" src="{{ $photoPath }}" width="31" alt="{{ $user->name }}">
                    <div class="user-text">
                        <h6>{{ $user->name }}</h6>
                        <p class="text-muted mb-0">{{ $user->email }}</p>
                    </div>
                </span>

            </a>
            <div class="dropdown-menu">
                @php
                $user = Auth::user();
                $rolePath = match($user->user_type) {
                1 => 'admin',
                2 => 'teacher',
                3 => 'students',
                4 => 'parent',
                default => 'default'
                };
                $photoPath = $user->profile_pic ? asset("SchoolMS_App/public/uploads/{$rolePath}/{$user->profile_pic}")
                : asset('SchoolMS_App/public/assets/img/profiles/avatar-01.jpg');
                @endphp

                <div class="user-header">
                    <div class="avatar avatar-sm">
                        <img src="{{ $photoPath }}" alt="User Image" class="avatar-img rounded-circle">
                    </div>
                    <div class="user-text">
                        <h6>{{ $user->name }}</h6>
                        <p class="text-muted mb-0">{{ $user->email }}</p>
                    </div>
                </div>

                <a class="dropdown-item" href="{{ route('myAccount') }}">My Profile</a>
                <a class="dropdown-item" href="{{ url('logout') }}">Logout</a>
            </div>
        </li>

    </ul>

</div>


<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                @if(Auth::user()->user_type == 1)
                <li class="menu-title">
                    <span>Main Menu</span>
                </li>
                <li class=" @if(Request::segment(2) == 'dashboard') submenu active @endif ">
                    <a href="{{ url('admin/dashboard') }}"><i class="fe fe-home"></i> <span> Dashboard</span></a>
                </li>
                <li class=" @if(Request::segment(2) == 'admin') submenu active @endif ">
                    <a href="{{ url('admin/admin/list') }}"><i class="fe fe-user-check"></i> <span> Admin</span></a>
                </li>
                <li class=" @if(Request::segment(2) == 'teacher') submenu active @endif ">
                    <a href="{{ url('admin/teacher/list') }}"><i class="fe fe-users"></i> <span> Teacher</span></a>
                </li>
                <li class=" @if(Request::segment(2) == 'student') submenu active @endif ">
                    <a href="{{ url('admin/student/list') }}"><i class="fe fe-user"></i> <span> Student</span></a>
                </li>
                <li class=" @if(Request::segment(2) == 'parent') submenu active @endif ">
                    <a href="{{ url('admin/parent/list') }}"><i class="fe fe-user-plus"></i> <span> Parent</span></a>
                </li>
                <li
                    class="submenu {{ in_array(Request::segment(2), ['class', 'subject', 'assign_subject', 'assign_class_teacher']) ? 'active' : '' }}">
                    <a href="#"><i class="fe fe-book-open"></i> <span> Academic</span> <span
                            class="menu-arrow"></span></a>
                    <ul>
                        <li class="{{ Request::segment(2) == 'class' ? 'active' : '' }}">
                            <a href="{{ url('admin/class/list') }}">Class</a>
                        </li>
                        <li class="{{ Request::segment(2) == 'subject' ? 'active' : '' }}">
                            <a href="{{ url('admin/subject/list') }}">Subject</a>
                        </li>
                        <li class="{{ Request::segment(2) == 'assign_subject' ? 'active' : '' }}">
                            <a href="{{ url('admin/assign_subject/list') }}">Assign Subject</a>
                        </li>
                        <li class="{{ Request::segment(2) == 'assign_class_teacher' ? 'active' : '' }}">
                            <a href="{{ url('admin/assign_class_teacher/list') }}">Assign Class Teacher</a>
                        </li>
                        <li class="{{ Request::is('admin/class_timetable*') ? 'active' : '' }}">
                            <a href="{{ url('admin/class_timetable/list') }}">Class Timetable</a>
                        </li>
                    </ul>
                </li>
                <li class="submenu {{ in_array(Request::segment(2), ['exam']) ? 'active' : '' }}">
                    <a href="#"><i class="fe fe-file-text"></i> <span> Examination</span> <span
                            class="menu-arrow"></span></a>
                    <ul>
                        <li class="{{ Request::segment(2) == 'exam' ? 'active' : '' }}">
                            <a href="{{ url('admin/exam/list') }}">Exam</a>
                        </li>
                        <li class="{{ Request::segment(2) == 'exam-schedule' ? 'active' : '' }}">
                            <a href="{{ url('admin/exam-schedule/list') }}">Exam Schedule</a>
                        </li>
                        <li class="{{ Request::segment(2) == 'register' ? 'active' : '' }}">
                            <a href="{{ url('admin/register') }}">Mark Register</a>
                        </li>
                        <li class="{{ Request::segment(2) == 'marks-grade' ? 'active' : '' }}">
                            <a href="{{ url('admin/marks-grade/list') }}">Mark Grade</a>
                        </li>
                    </ul>
                </li>
                <li class="submenu {{ in_array(Request::segment(2), ['student-attendance']) ? 'active' : '' }}">
                    <a href="#"><i class="fe fe-calendar"></i> <span> Attendance</span> <span
                            class="menu-arrow"></span></a>
                    <ul>
                        {{-- <li class="{{ Request::segment(2) == 'student-attendance' ? 'active' : '' }}">
                            <a href="{{ url('admin/student-attendance') }}">Student Attendance</a>
                        </li> --}}
                        <li class="{{ Request::segment(2) == 'student-attendance-report' ? 'active' : '' }}">
                            <a href="{{ url('admin/student-attendance-report') }}">Report Attendance</a>
                        </li>
                    </ul>
                </li>
                <li class="submenu {{ in_array(Request::segment(2), ['notice-board']) ? 'active' : '' }}">
                    <a href="#"><i class="fe fe-volume-2"></i> <span> Communicate</span> <span
                            class="menu-arrow"></span></a>
                    <ul>
                        <li class="{{ Request::segment(2) == 'notice-board' ? 'active' : '' }}">
                            <a href="{{ url('admin/notice-board') }}">Notice Board</a>
                        </li>
                    </ul>
                </li>
                <li class="submenu {{ in_array(Request::segment(2), ['fees']) ? 'active' : '' }}">
                    <a href="#"><i class="fe fe-credit-card"></i> <span> Fees Collection</span> <span
                            class="menu-arrow"></span></a>
                    <ul>
                        <li class="{{ Request::segment(2) == 'fees' ? 'active' : '' }}">
                            <a href="{{ url('fees') }}">Collect Fees</a>
                        </li>
                        <li class="{{ Request::segment(2) == 'collection-report' ? 'active' : '' }}">
                            <a href="{{ url('fees/collection-report') }}">Collect Fees Report</a>
                        </li>
                    </ul>
                </li>
                <li class="submenu {{ in_array(Request::segment(2), ['homework']) ? 'active' : '' }}">
                    <a href="#"><i class="fe fe-file"></i> <span> Homework</span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li class="{{ Request::segment(2) == 'homework' ? 'active' : '' }}">
                            <a href="{{ url('admin/homework') }}">Homework</a>
                        </li>
                        <li class="{{ Request::segment(2) == 'homework-report' ? 'active' : '' }}">
                            <a href="{{ url('admin/homework-report') }}">Homework Report</a>
                        </li>
                    </ul>
                </li>

                @elseif(Auth::user()->user_type == 2)
                <li class="menu-title">
                    <span>Main Menu</span>
                </li>
                <li class=" @if(Request::segment(2) == 'dashboard') submenu active @endif ">
                    <a href="{{ url('teacher/dashboard') }}"><i class="fe fe-home"></i> <span> Dashboard</span></a>
                </li>
                <li class=" @if(Request::segment(2) == 'my-class-subject') submenu active @endif ">
                    <a href="{{ url('teacher/my-class-subject') }}"><i class="fe fe-book-open"></i> <span> My Class &
                            Subject</span></a>
                </li>
                <li class=" @if(Request::segment(2) == 'students') submenu active @endif ">
                    <a href="{{ url('teacher/students') }}"><i class="fe fe-users"></i> <span> My Student</span></a>
                </li>
                <li class=" @if(Request::segment(2) == 'my-exam-timetable') submenu active @endif ">
                    <a href="{{ url('teacher/my-exam-timetable') }}"><i class="fe fe-clock"></i> <span> My Exam
                            Timetable</span></a>
                </li>
                <li class=" @if(Request::segment(2) == 'calendar') submenu active @endif ">
                    <a href="{{ url('teacher/calendar') }}"><i class="fe fe-calendar"></i> <span> My Calendar</span></a>
                </li>
                <li class=" @if(Request::segment(2) == '/marks/register') submenu active @endif ">
                    <a href="{{ url('teacher/marks/register') }}"><i class="fe fe-edit"></i> <span> Marks
                            Register</span></a>
                </li>
                <li class=" @if(Request::segment(2) == 'student-attendance') submenu active @endif ">
                    <a href="{{ url('teacher/student-attendance') }}"><i class="fe fe-check-square"></i> <span> Student
                            Attendance</span></a>
                </li>
                <li class=" @if(Request::segment(2) == 'student-attendance-report') submenu active @endif ">
                    <a href="{{ url('teacher/student-attendance-report') }}"><i class="fe fe-file-text"></i> <span>
                            Report Attendance</span></a>
                </li>
                <li class=" @if(Request::segment(2) == 'notice-board') submenu active @endif ">
                    <a href="{{ url('teacher/notice-board') }}"><i class="fe fe-bell"></i> <span> Notice
                            Board</span></a>
                </li>
                <li class=" @if(Request::segment(2) == 'homework') submenu active @endif ">
                    <a href="{{ route('teacher.homework.index') }}">
                        <i class="fe fe-file"></i> <span>Homework</span>
                    </a>
                </li>

                @elseif(Auth::user()->user_type == 3)
                <li class="menu-title">
                    <span>Main Menu</span>
                </li>
                <li class=" @if(Request::segment(2) == 'dashboard') submenu active @endif">
                    <a href="{{ url('student/dashboard') }}"><i class="fe fe-home"></i> <span> Dashboard</span></a>
                </li>
                <li class=" @if(Request::segment(2) == 'my-subject') submenu active @endif">
                    <a href="{{ url('student/my-subject') }}"><i class="fe fe-book-open"></i> <span> My
                            Subject</span></a>
                </li>
                <li class=" @if(Request::segment(2) == 'my-class-timetable') submenu active @endif">
                    <a href="{{ url('student/my-class-timetable') }}"><i class="fe fe-calendar"></i> <span> My Class
                            Timetable</span></a>
                </li>
                <li class=" @if(Request::segment(2) == 'my-exam-timetable') submenu active @endif">
                    <a href="{{ url('student/my-exam-timetable') }}"><i class="fe fe-clock"></i> <span> My Exam
                            Timetable</span></a>
                </li>
                <li class=" @if(Request::segment(2) == 'my-calendar') submenu active @endif">
                    <a href="{{ url('student/my-calendar') }}"><i class="fe fe-calendar"></i> <span> My
                            Calendar</span></a>
                </li>
                <li class=" @if(Request::segment(2) == 'my-exam-result') submenu active @endif">
                    <a href="{{ url('student/my-exam-result') }}"><i class="fe fe-award"></i> <span> My Exam
                            Result</span></a>
                </li>
                <li class=" @if(Request::segment(2) == 'attendance') submenu active @endif">
                    <a href="{{ url('student/attendance') }}"><i class="fe fe-check-square"></i> <span> My
                            Attendance</span></a>
                </li>
                <li class=" @if(Request::segment(2) == 'notice-board') submenu active @endif">
                    <a href="{{ url('student/notice-board') }}"><i class="fe fe-bell"></i> <span> My Notice
                            Board</span></a>
                </li>
                <li class=" @if(Request::segment(2) == 'my-homework') submenu active @endif">
                    <a href="{{ url('student/my-homework') }}"><i class="fe fe-file-text"></i> <span> My
                            Homework</span></a>
                </li>
                <li class=" @if(Request::segment(2) == 'submitted') submenu active @endif">
                    <a href="{{ url('student/homework/submitted') }}"><i class="fe fe-upload-cloud"></i> <span> My
                            Homework Submitted</span></a>
                </li>
                <li class=" @if(Request::segment(2) == 'fees-collection') submenu active @endif">
                    <a href="{{ url('student/fees-collection') }}"><i class="fe fe-credit-card"></i> <span> My
                            Fees</span></a>
                </li>

                @elseif(Auth::user()->user_type == 4)
                <li class="menu-title">
                    <span>Main Menu</span>
                </li>
                <li class=" @if(Request::segment(2) == 'dashboard') submenu active @endif">
                    <a href="{{ url('parent/dashboard') }}"><i class="fe fe-home"></i> <span> Dashboard</span></a>
                </li>
                <li class=" @if(Request::segment(2) == 'my-students') submenu active @endif">
                    <a href="{{ url('parent/my-students') }}"><i class="fe fe-users"></i> <span> My Student</span></a>
                </li>
                <li class=" @if(Request::segment(2) == 'notice-board') submenu active @endif">
                    <a href="{{ url('parent/notice-board') }}"><i class="fe fe-bell"></i> <span> My Notice
                            Board</span></a>
                </li>
                <li class=" @if(Request::segment(2) == 'student-notice-board') submenu active @endif">
                    <a href="{{ url('parent/student-notice-board') }}"><i class="fe fe-message-square"></i> <span>
                            Student Notice Board</span></a>
                </li>
                @endif

                
            </ul>
        </div>
    </div>
</div>