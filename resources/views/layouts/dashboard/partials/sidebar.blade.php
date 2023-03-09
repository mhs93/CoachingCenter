<div class="sidebar sidebar-dark sidebar-fixed" id="sidebar">
    <div class="sidebar-brand d-none d-md-flex">
        <img src="{{ asset('images/setting/logo/'.setting('logo')) }}" width="118" height="46" alt="Logo">
    </div>
    <ul class="sidebar-nav icon-m-r" data-coreui="navigation" data-simplebar="">
        <li class="nav-item">
            <a class="nav-link" href="{{route('admin.dashboard')}}">
                <i class='bx bx-color'></i>
                Dashboard
            </a>
        </li>
        @can('subject_list')
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.subjects.index') }}">
                <i class='bx bx-book'></i> Subjects
            </a>
        </li>
        @endcan
        @can('batches_list')
        <li class="nav-item">
            <a class="nav-link" href="{{route('admin.batches.index')}}">
                <i class='bx bx-list-check'></i> Batches
            </a>
        </li>
        @endcan
        @can('student_list')
        <li class="nav-group">
            <a class="nav-link nav-group-toggle" >
                <i class='bx bxs-user-account'></i>
                Student
            </a>
            <ul class="nav-group-items">
                <li class="nav-item"><a class="nav-link" href="{{route('admin.students.index')}}">
                        <span class="nav-icon"></span> Students List
                    </a>
                </li>
                @can('student_modify')
                <li class="nav-item"><a class="nav-link" href="{{route('admin.students.create')}}">
                        <span class="nav-icon"></span> Register Student
                    </a>
                </li>
                @endcan
            </ul>
        </li>
        @endcan

        @can('teacher_list')
        <li class="nav-group">
            <a class="nav-link nav-group-toggle" href="">
                <i class='bx bxs-user-rectangle'></i>
                Teacher
            </a>
            <ul class="nav-group-items">
                <li class="nav-item"><a class="nav-link" href="{{route('admin.teachers.index')}}">
                        <span class="nav-icon"></span> Teacher List
                    </a>
                </li>
                @can('teacher_modify')
                <li class="nav-item"><a class="nav-link" href="{{route('admin.teachers.create')}}">
                        <span class="nav-icon"></span> Register Teacher
                    </a>
                </li>
                @endcan
            </ul>
        </li>
        @endcan


        @can('routine_list')
        <li class="nav-group">
            <a class="nav-link nav-group-toggle" >
                <i class='bx bxs-user-account'></i>
                Class Routine
            </a>
            <ul class="nav-group-items">
                <li class="nav-item"><a class="nav-link" href="{{route('admin.routine.index')}}">
                        <span class="nav-icon"></span> Routine List
                    </a>
                </li>

                @can('routine_modify')
                <li class="nav-item"><a class="nav-link" href="{{route('admin.routine.create')}}">
                        <span class="nav-icon"></span> Add Routine
                    </a>
                </li>
                @endcan
            </ul>
        </li>
        @endcan
        {{-- Class Routine Module End --}}

        @can('attendance_manage')
            <li class="nav-group">
                <a class="nav-link nav-group-toggle">
                    <i class='bx bx-male-female'></i>
                    Attendance
                </a>

                <ul class="nav-group-items">
                    @can('student_attendance')
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('admin.attendances.index')}}">
                                <span class="nav-icon"></span>Student Attendance
                            </a>
                        </li>
                    @endcan

                    @can('teacher_attendance')
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('admin.tattendances.index')}}">
                                <span class="nav-icon"></span>Teacher Attendance
                            </a>
                        </li>
                    @endcan

                    @can('attendance_report')
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('admin.attendances.report')}}">
                                <span class="nav-icon"></span>Student Attendance Report
                            </a>
                        </li>
                    @endcan

                    @can('teacher_attendance')
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('admin.teachers.attendances.report')}}">
                                <span class="nav-icon"></span>Teacher Attendance Report
                            </a>
                        </li>
                    @endcan

                </ul>
            </li>
        @endcan


        {{-- Exam Module Start --}}
        {{-- @canany(['student_list','register_student']) --}}
        @can('exam_list')
        <li class="nav-group">
            <a class="nav-link nav-group-toggle" >
                <i class='bx bxs-user-account'></i>
                Exam
            </a>
            <ul class="nav-group-items">
                @can('exam_list')
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.exams.index')}}">
                        <span class="nav-icon"></span> Exam Routine
                    </a>
                </li>
                @endcan

                {{--@can('exam_modify')--}}
                    {{--<li class="nav-item"><a class="nav-link" href="{{route('admin.exams.create')}}">--}}
                            {{--<span class="nav-icon"></span> Create Exam Routine--}}
                        {{--</a>--}}
                    {{--</li>--}}
                {{--@endcan--}}

                @can('exam_modify')
                    <li class="nav-item"><a class="nav-link" href="{{route('admin.marks.index')}}">
                            <span class="nav-icon"></span>Exam Result List
                        </a>
                    </li>
                @endcan
                {{--@can('exam_modify')--}}
                    {{--<li class="nav-item"><a class="nav-link" href="{{route('admin.marks.create')}}">--}}
                            {{--<span class="nav-icon"></span>Assign Exam Result--}}
                        {{--</a>--}}
                    {{--</li>--}}
                {{--@endcan--}}
                @can('exam_list')
                    <li class="nav-item"><a class="nav-link" href="{{route('admin.result-show-by-exam')}}">
                            <span class="nav-icon"></span>Exam Result Report
                        </a>
                    </li>
                @endcan
            </ul>
        </li>
        @endcan
        {{-- Exam Module End --}}



        @can('announcement_list')
        <li class="nav-item">
            <a class="nav-link" href="{{route('admin.announcements.index')}}">
                <i class='bx bx-user-voice'></i> Announcement
            </a>
        </li>
        @endcan

        @can('specialClass_list')
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.class-rooms.index') }}">
                <i class='bx bx-group'></i> Special Class
            </a>
        </li>
        @endcan

        @canany(['resources_list','resource_upload'])
            <li class="nav-group">
                <a class="nav-link nav-group-toggle" href="">
                    <i class='bx bxs-file-archive'></i>
                    Resources
                </a>
                <ul class="nav-group-items">
                    <li class="nav-item"><a class="nav-link" href="{{route('admin.resources.index')}}">
                            <span class="nav-icon"></span> Resource List
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('admin.resources.create')}}">
                            <span class="nav-icon"></span> Upload Resource
                        </a>
                    </li>
                </ul>
            </li>
        @endcan

        @can('payment_manage')
        <li class="nav-group">
            <a class="nav-link nav-group-toggle" href="#">
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
                        <span class="nav-icon"></span> Transactions
                    </a>
                </li>
                <li class="nav-item"><a class="nav-link" href="{{route('admin.balance-sheet')}}">
                        <span class="nav-icon"></span> Balance Sheet
                    </a>
                </li>

                <li class="nav-item"><a class="nav-link" href="{{route('admin.accounts-statement')}}">
                        <span class="nav-icon"></span> Accounts Statement
                    </a>
                </li>
            </ul>
        </li>
        @endcan


        @can('payment_manage')
            <li class="nav-item">
                <a class="nav-link " href="{{route('admin.income.index')}}">
                    <i class='bx bx-dollar-circle'></i>
                    Income
                </a>
            </li>
        @endcan

        @can('payment_manage')
            <li class="nav-item">
                <a class="nav-link " href="{{route('admin.expense.index')}}">
                    <i class='bx bxs-wallet-alt'></i>
                    Expense
                </a>
            </li>
        @endcan

        {{--@can('payment_list_student')--}}
        @role('Student')
            <li class="nav-item">
                <a class="nav-link " href="{{route('admin.student.payment.installments')}}">
                    <i class='bx bx-dollar-circle'></i>
                    Installment
                </a>
            </li>
        @endrole
        {{--@endcan--}}
        {{--@can('payment_list_teacher')--}}
        @role('Teacher')
            <li class="nav-item">
                <a class="nav-link " href="{{route('admin.teacher.payment.installments')}}">
                    <i class='bx bx-dollar-circle'></i>
                    Installment
                </a>
            </li>
        @endrole
        {{--@endcan--}}

        @role('Super Admin')
        <li class="nav-group">
            <a class="nav-link nav-group-toggle" href="colors.html">
                <i class='bx bx-user'></i>
                Administration
            </a>

            <ul class="nav-group-items">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.roles.index')}}">
                        <span class="nav-icon"></span> Roles and Permissions
                    </a>
                </li>
            </ul>
        </li>
        @endrole

        @can('report_manage')
        <li class="nav-group">
            <a class="nav-link nav-group-toggle" href="#">
                <i class='bx bx-file'></i>
                Reports
            </a>

            @can('student_report')
            <ul class="nav-group-items">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.active-inactive-students')}}">
                        <span class="nav-icon"></span> Students Report
                    </a>
                </li>
            </ul>
            @endcan
            @can('teacher_report')
            <ul class="nav-group-items">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.active-inactive-teachers')}}">
                        <span class="nav-icon"></span> Teachers Report
                    </a>
                </li>
            </ul>
            @endcan

            @can('student_report')
            <ul class="nav-group-items">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.students-attendance')}}">
                        <span class="nav-icon"></span> Students Attendance Report
                    </a>
                </li>
            </ul>
            @endcan
            @can('teacher_report')
            <ul class="nav-group-items">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.teachers-attendance')}}">
                        <span class="nav-icon"></span> Teachers Attendance Report
                    </a>
                </li>
            </ul>
            @endcan

            @can('student_report')
            <ul class="nav-group-items">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.subject-wise-attendance')}}">
                        <span class="nav-icon"></span> Subject Wise Attendance
                    </a>
                </li>
            </ul>
            @endcan

            @can('student_report')
            <ul class="nav-group-items">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.batch-wise-students')}}">
                        <span class="nav-icon"></span> Batch Wise Students
                    </a>
                </li>
            </ul>
            @endcan

            @can('student_report')
            <ul class="nav-group-items">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.batch-wise-attendance')}}">
                        <span class="nav-icon"></span> Batch Wise Attendance
                    </a>
                </li>
            </ul>
            @endcan
            @can('student_transaction_report')
            <ul class="nav-group-items">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.students-transaction')}}">
                        <span class="nav-icon"></span>Student Transactions Report
                    </a>
                </li>
            </ul>
            @endcan
            @can('teacher_transaction_report')
            <ul class="nav-group-items">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.teachers-transaction')}}">
                    <span class="nav-icon"></span>Teacher Transactions Report
                    </a>
                </li>
            </ul>
            @endcan

            @can('teacher_transaction_report')
            <ul class="nav-group-items">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.students-mark')}}">
                    <span class="nav-icon"></span>Students Mark
                    </a>
                </li>
            </ul>
            @endcan

        </li>
        @endcan




        @role('Super Admin')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('contact.messages') }}">
                    <i class='bx bx-group'></i> Messages
                </a>
            </li>
            <li class="nav-group">
                <a class="nav-link nav-group-toggle" href="#">
                    <i class='bx bx-list-check'></i>
                    Setting
                </a>

                <ul class="nav-group-items">
                    <li class="nav-item"><a class="nav-link" href="{{route('admin.setting.general')}}">
                            <span class="nav-icon"></span> General Settings
                        </a>
                    </li>
                    {{--<li class="nav-item"><a class="nav-link" href="">--}}
                            {{--<span class="nav-icon"></span> Frontend Settings--}}
                        {{--</a>--}}
                    {{--</li>--}}
                </ul>
            </li>
        @endrole

    </ul>
    <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
</div>
