<div class="sidebar sidebar-dark sidebar-fixed" id="sidebar">
    <div class="sidebar-brand d-none d-md-flex">
        <img src="{{ asset('images/setting/logo/'.setting('logo')) }}" width="118" height="46" alt="Logo">
    </div>
    <ul class="sidebar-nav icon-m-r" data-coreui="navigation" data-simplebar="">
        <li class="nav-item">
            <a class="nav-link" href="">
                <i class='bx bx-color'></i>
                Dashboard
            </a>
        </li>
        @canany(['student_list','register_student'])
        <li class="nav-group">
            <a class="nav-link nav-group-toggle" >
                <i class='bx bxs-user-account'></i>
                Student
            </a>
            <ul class="nav-group-items">

                @can('student_list')

                <li class="nav-item"><a class="nav-link" href="{{route('admin.students.index')}}">
                        <span class="nav-icon"></span> Students List
                    </a>
                </li>
                @endcan

                @can('register_student')
                <li class="nav-item"><a class="nav-link" href="{{route('admin.students.create')}}">
                        <span class="nav-icon"></span> Register Student
                    </a>
                </li>
                @endcan
            </ul>
        </li>
        @endcan

        @canany(['teacher_list','teacher_register'])
        <li class="nav-group">
            <a class="nav-link nav-group-toggle" href="colors.html">
                <i class='bx bxs-user-rectangle'></i>
                Teacher
            </a>
            <ul class="nav-group-items">
                @can('teacher_list')
                <li class="nav-item"><a class="nav-link" href="{{route('admin.teachers.index')}}">
                        <span class="nav-icon"></span> Teacher List
                    </a>
                </li>
                @endcan
                @can('teacher_register')
                <li class="nav-item"><a class="nav-link" href="{{route('admin.teachers.create')}}">
                        <span class="nav-icon"></span> Register Teacher
                    </a>
                </li>
                @endcan
            </ul>
        </li>
        @endcan


        @can('batches_manage','batches_create','batches_edit','batches_delete')
        <li class="nav-item">
            <a class="nav-link" href="{{route('admin.batches.index')}}">
                <i class='bx bx-list-check'></i> Batches
            </a>
        </li>
        @endcan

        @can('subject_manage')
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.subjects.index') }}">
                <i class='bx bx-book'></i> Subjects
            </a>
        </li>
        @endcan

        {{-- Class Routine Module Start --}}
        {{-- @canany(['student_list','register_student']) --}}
        @can('routine_list')
        <li class="nav-group">
            <a class="nav-link nav-group-toggle" >
                <i class='bx bxs-user-account'></i>
                Class Routine
            </a>
            <ul class="nav-group-items">
                @can('routine_list')
                <li class="nav-item"><a class="nav-link" href="{{route('admin.routine.index')}}">
                        <span class="nav-icon"></span> Routine List
                    </a>
                </li>
                @endcan

                @can('routine_create')
                <li class="nav-item"><a class="nav-link" href="{{route('admin.routine.create')}}">
                        <span class="nav-icon"></span> Add Routine
                    </a>
                </li>
                @endcan
            </ul>
        </li>
        @endcan
        {{-- Class Routine Module End --}}


        {{-- Exam Module Start --}}
        {{-- @canany(['student_list','register_student']) --}}
        @canany(['exam_list'])
        <li class="nav-group">
            <a class="nav-link nav-group-toggle" >
                <i class='bx bxs-user-account'></i>
                Exams
            </a>
            <ul class="nav-group-items">

                @can('exam_list')
                    <li class="nav-item"><a class="nav-link" href="{{route('admin.exams.index')}}">
                            <span class="nav-icon"></span> Exam List
                        </a>
                    </li>
                @endcan

                @can('exam_create')
                    <li class="nav-item"><a class="nav-link" href="{{route('admin.exams.create')}}">
                            <span class="nav-icon"></span> Create Exam
                        </a>
                    </li>
                @endcan

                @can('exam_result')
                    <li class="nav-item"><a class="nav-link" href="{{route('admin.result.show')}}">
                            <span class="nav-icon"></span>See Exam Result
                        </a>
                    </li>
                @endcan

                @can('result_list')
                    <li class="nav-item"><a class="nav-link" href="{{route('admin.marks.index')}}">
                            <span class="nav-icon"></span>Exam Result List
                        </a>
                    </li>
                @endcan

                @can('mark_create')
                <li class="nav-item"><a class="nav-link" href="{{route('admin.marks.create')}}">
                        <span class="nav-icon"></span>Give Exam Mark
                    </a>
                </li>
            @endcan
            </ul>
        </li>
        @endcan
        {{-- Exam Module End --}}



        @can('announcement_manage')
        <li class="nav-item">
            <a class="nav-link" href="{{route('admin.announcements.index')}}">
                <i class='bx bx-user-voice'></i> Announcements
            </a>
        </li>
        @endcan

        @can('classRooms_manage')
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.class-rooms.index') }}">
                <i class='bx bx-group'></i> Class rooms
            </a>
        </li>
        @endcan

        @canany(['attendance_manage'])
        <li class="nav-group">
            <a class="nav-link nav-group-toggle">
                <i class='bx bx-male-female'></i>
               Attendance
            </a>

            <ul class="nav-group-items">
                @can('attendance_manage')
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.attendances.index')}}">
                        <span class="nav-icon"></span>Student Attendances
                    </a>
                </li>
                @endcan
                @can('attendance_report')
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.attendances.report')}}">
                        <span class="nav-icon"></span>Attendance Report
                    </a>
                </li>
                @endcan

                @can('attendance_manage')
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.tattendances.index')}}">
                        <span class="nav-icon"></span>Teacher Attendances
                    </a>
                </li>
                @endcan
            </ul>
        </li>
        @endcan


        @can('payment_manage')
        <li class="nav-group">
            <a class="nav-link nav-group-toggle" href="">
                <i class='bx bxs-bank'></i>
                Payment
            </a>

            <ul class="nav-group-items">
                {{--<li class="nav-item"><a class="nav-link" href="{{route('admin.bank.index')}}">--}}
                        {{--<span class="nav-icon"></span> Bank--}}
                    {{--</a>--}}
                {{--</li>--}}
                <li class="nav-item"><a class="nav-link" href="{{route('admin.account.index')}}">
                        <span class="nav-icon"></span> Account
                    </a>
                </li>

                <li class="nav-item"><a class="nav-link" href="{{route('admin.transaction.index')}}">
                        <span class="nav-icon"></span> Transaction
                    </a>
                </li>
                <li class="nav-item"><a class="nav-link" href="{{route('admin.balance-sheet')}}">
                        <span class="nav-icon"></span> Balance Sheet
                    </a>
                </li>
            </ul>
        </li>
        @endcan


        @can('income_manage')
            <li class="nav-item">
                <a class="nav-link " href="{{route('admin.income.index')}}">
                    <i class='bx bx-dollar-circle'></i>
                    Income
                </a>
            </li>
        @endcan

        @can('enpense_manage')
            <li class="nav-item">
                <a class="nav-link " href="{{route('admin.expense.index')}}">
                    <i class='bx bxs-wallet-alt'></i>
                    Expense
                </a>
            </li>
        @endcan


        @can(['resources_list','upload_resource'])
        <li class="nav-group">
            <a class="nav-link nav-group-toggle" href="">
                <i class='bx bxs-file-archive'></i>
                Resources
            </a>

            <ul class="nav-group-items">
                @can('resources_list')
                <li class="nav-item"><a class="nav-link" href="{{route('admin.resources.index')}}">
                        <span class="nav-icon"></span> Resource List
                    </a>
                </li>
                @endcan

                @can('upload_resource')
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.resources.create')}}">
                        <span class="nav-icon"></span> Upload Resource
                    </a>
                </li>
                @endcan
            </ul>
        </li>
        @endcan

        @role('Super Admin')
        <li class="nav-group">
            <a class="nav-link nav-group-toggle" href="colors.html">
                <i class='bx bx-user'></i>
                Administration
            </a>

            <ul class="nav-group-items">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.roles.index')}}">
                        <span class="nav-icon"></span> Roles
                    </a>
                </li>
            </ul>
        </li>
        @endrole

        <li class="nav-group">
            <a class="nav-link nav-group-toggle" href="#">
                <i class='bx bx-file'></i>
                Reports
            </a>

            <ul class="nav-group-items">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.active-inactive-students')}}">
                        <span class="nav-icon"></span> Students List
                    </a>
                </li>
            </ul>

            <ul class="nav-group-items">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.students-attendance')}}">
                        <span class="nav-icon"></span> Students Attendance
                    </a>
                </li>
            </ul>

            <ul class="nav-group-items">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.subject-wise-attendance')}}">
                        <span class="nav-icon"></span> Subject Wise Attendance
                    </a>
                </li>
            </ul>

            <ul class="nav-group-items">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.batch-wise-students')}}">
                        <span class="nav-icon"></span> Batche Wise Students
                    </a>
                </li>
            </ul>

            <ul class="nav-group-items">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.batch-wise-attendance')}}">
                        <span class="nav-icon"></span> Batche Wise Attendance
                    </a>
                </li>
            </ul>

            <ul class="nav-group-items">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.active-inactive-teachers')}}">
                        <span class="nav-icon"></span> Teachers List
                    </a>
                </li>
            </ul>

            <ul class="nav-group-items">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.teachers-attendance')}}">
                        <span class="nav-icon"></span> Teachers Attendance
                    </a>
                </li>
            </ul>

        </li>

        @role('Super Admin')
            <li class="nav-item">
                <a class="nav-link" href="{{route('admin.setting.general')}}">
                    <i class='bx bx-list-check'></i> Setting
                </a>
            </li>
        @endrole

    </ul>
    <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
</div>
