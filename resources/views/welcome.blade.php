
<html lang="bn-BD">

<!-- Mirrored from udvash.com/HomePage by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 21 Dec 2022 10:44:48 GMT -->
<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=utf-8" /><!-- /Added by HTTrack -->
<head>
    <meta charset="utf-8" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="author" content="" />
    <meta name="application-name" content="" />
    <meta name='dmca-site-verification' content='ZVFKZ1JuY2hzQXlYaloySC9vVUF1Zz090' />
    <link href="https://fonts.googleapis.com/css?family=Roboto|Roboto+Slab" rel="stylesheet">

    <title>Wardan coaching center</title>

    <link rel="shortcut icon" href="{{asset('images/frontend')}}/favicon.png" type="image/x-icon">
    <link rel="icon" href="{{asset('images/frontend')}}/favicon.png" type="image/x-icon">

    <!-- View: /Themes/NewUdvashUnmeshTheme/Shared/Layouts/Parts/_Head.cshtml-->
    <meta name="generator" content="NetCoreCMS v1.0.0.6" />


    <link rel="stylesheet" type="text/css" href="{{asset('css')}}/bootstrap.min5488.css?5.1.3" />
    <link rel="stylesheet" type="text/css" href="{{asset('css')}}/bootstrap-icons.css" />
    <link rel="stylesheet" type="text/css" href="{{asset('css')}}/aos.css" />
    <link rel="stylesheet" type="text/css" href="{{asset('css')}}/swiper-bundle.min.css" />
    <link rel="stylesheet" type="text/css" href="{{asset('css')}}/glightbox.min.css" />
    <link rel="stylesheet" type="text/css" href="{{asset('css')}}/ncc-common.css" />
    <link rel="stylesheet" type="text/css" href="{{asset('css')}}/css-loader.css" />
    <link rel="stylesheet" type="text/css" href="{{asset('css')}}/css/style.css" />
    <link rel="stylesheet" type="text/css" href="{{asset('css')}}/udm_custom1a18.css?2.3" />


</head>
<body id="body">
<!--Loading-->
<div id="loadingMask" class="loader loader-double"></div>

<!--Navbar-->
<style>
    .bt {
        border: none;
        user-select: none;
        font-size: 18px;
        color: white;
        text-align: center;
        background-color: #0873bd;
        box-shadow: #cacaca 2px 2px 10px 1px;
        border-radius: 12px;
        height: 60px;
        line-height: 60px;
        width: 155px;
        transition: all 0.2s ease;
        position: relative;
    }
    .msg {
        height: 0;
        width: 0;
        border-radius: 2px;
        position: absolute;
        left: 15%;
        top: 25%;
    }
    .bt:active {
        transition: all 0.001s ease;
        background-color: #5d9fcd;
        box-shadow: #97989a 0 0 0 0;
        transform: translateX(1px) translateY(1px);
    }
    .bt:hover .msg {
        animation: msgRun 2s forwards;
    }
    @keyframes msgRun {
        0% {
            border-top: #d6d6d9 0 solid;
            border-bottom: #f2f2f5 0 solid;
            border-left: #f2f2f5 0 solid;
            border-right: #f2f2f5 0 solid;
        }
        20% {
            border-top: #d6d6d9 14px solid;
            border-bottom: #f2f2f5 14px solid;
            border-left: #f2f2f5 20px solid;
            border-right: #f2f2f5 20px solid;
        }
        25% {
            border-top: #d6d6d9 12px solid;
            border-bottom: #f2f2f5 12px solid;
            border-left: #f2f2f5 18px solid;
            border-right: #f2f2f5 18px solid;
        }
        80% {
            border-top: transparent 12px solid;
            border-bottom: transparent 12px solid;
            border-left: transparent 18px solid;
            border-right: transparent 18px solid;
        }
        100% {
            transform: translateX(150px);
            border-top: transparent 12px solid;
            border-bottom: transparent 12px solid;
            border-left: transparent 18px solid;
            border-right: transparent 18px solid;
        }
    }


    .button {
        --color: #00A97F;
        padding: 0.8em 1.7em;
        background-color: transparent;
        border-radius: .3em;
        position: relative;
        overflow: hidden;
        cursor: pointer;
        transition: .5s;
        font-weight: 400;
        font-size: 17px;
        border: 1px solid;
        font-family: inherit;
        text-transform: uppercase;
        color: var(--color);
        z-index: 1;
    }

    .button::before, .button::after {
        content: '';
        display: block;
        width: 50px;
        height: 50px;
        transform: translate(-50%, -50%);
        position: absolute;
        border-radius: 50%;
        z-index: -1;
        background-color: var(--color);
        transition: 1s ease;
    }

    .button::before {
        top: -1em;
        left: -1em;
    }

    .button::after {
        left: calc(100% + 1em);
        top: calc(100% + 1em);
    }

    .button:hover::before, .button:hover::after {
        height: 410px;
        width: 410px;
    }

    .button:hover {
        color: rgb(10, 25, 30);
    }

    .button:active {
        filter: brightness(.8);
    }




    .navbar-nav{
        flex-direction: inherit !important;
    }
    img{
        width:100%;
    }
</style>


<!-- ======= Header ======= -->
<header id="header" class="header sticky-top" style="background: #b4e8fa">
    <div class="container container-xl d-flex align-items-center justify-content-between">
        <div>
            <div>
                <a href="#">
                    <img style="max-width:200px;" class="" src="{{ asset('images/setting/logo/'.setting('logo')) }}" alt="Logo" />
                </a>
            </div>
        </div>
        <div class="d-flex align-items-center justify-content-between">
            <div>
                @if(Route::has('login'))
                    @auth
                        <a class="btn joinNow scrollto rounded-pill" href="{{ route('admin.dashboard') }}">Dashboard</a>
                    @else
                        <button class="button">
                            <a  href="{{ route('login') }}"> Login </a>
                        </button>
                    @endauth
                @endif
            </div>
            <div id="wrapper">
                <div id="iconId" class="circle icon">
                    <span class="line top"></span>
                    <span class="line middle"></span>
                    <span class="line bottom"></span>
                </div>
            </div>
        </div>

    </div>
</header>


<!--MainBody-->
<div class="container-fluid p-0 m-0 mainBody" id="mainBody" style="overflow-x:hidden;">

    <!--Maincontent-->
    <div class="p-0 col-md-12">
        <style>
            .iframe-video{
                position: relative;
            }
            .video-iframe{
                display: none;
            }
        </style>
        <main id="main">
            <section id="hero" class="hero d-flex align-items-center">
                <div class="container-fluid p-0 m-0 hero-fluid">
                    <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 0"></button>
                            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1" aria-label="Slide 1"></button>
                        </div>
                        <div class="carousel-inner">
                            <div class="carousel-item active" data-bs-interval="4000" style="background: linear-gradient(to bottom, #657aba, #ec5d7e)">
                                <div class="container">
                                    <img src="{{asset('images/frontend')}}/hero-img.png" class="img-fluid d-lg-block d-md-block d-sm-block d-none" alt="Image">
                                    <img src="{{asset('images/frontend')}}/ProgramInfoMobile4.png" class="img-fluid d-lg-none d-md-none d-sm-none d-flex w-100" alt="image">
                                </div>
                            </div>
                            <div class="carousel-item" data-bs-interval="4000" style="background: linear-gradient(to right, #02aab0, #00cdac)">
                                <div class="container">
                                    <img src="{{asset('images/frontend')}}/why-us.png" class="img-fluid d-lg-block d-md-block d-sm-block d-none" alt="Image">
                                    <img src="{{asset('images/frontend')}}/BUET21Top3Mobile.png" class="img-fluid d-lg-none d-md-none d-sm-none d-flex w-100" alt="image">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- End Hero -->
            <!-- ======= course Section Start ======= -->
            <section class="course-home-section">
                <div class="container">
                    <div class="head d-flex justify-content-center">
                        <h1 class="head1">Running Batches</h1>
                    </div>
                    <!--Card Start-->

                    <div class="row d-flex">
                        @foreach($batches as $batch)
                        <div class="col-lg-4 col-md-6 col-sm-6 course">
                            <div class="card shadow">
                                <div class="card-header p-0">
                                    <img src="{{asset('images/batches/'.$batch->image)}}" alt="image">
                                </div>
                                <div class="card-body">
                                    <h3>
                                        <p>{{$batch->name}}</p>
                                    </h3>
                                    <ul>
                                        <?php
                                            $subjectIds= json_decode($batch->subject_id);
                                            $subjects  = '';
                                            foreach($subjectIds as $key=>$id){
                                                $subject = \App\Models\Subject::find($id);
                                                $subjects.= $subject->name;
                                                if(count($subjectIds)!=$key+1){
                                                    $subjects.= ', ';
                                                }
                                            }
                                        ?>

                                        <li><b>Subjects: {{$subjects}}</b></li>
                                        <li><b>Start Date: {{$batch->start_date}}</b></li>
                                        <li><b>End Date: {{$batch->end_date}}</b></li>
                                        <li><b>Batch Fee: {{$batch->total_amount}}tk</b></li>
                                    </ul>
                                </div>
                                {{--<div class="card-footer text-center border-0 pb-3 d-flex justify-content-center align-items-center">--}}
                                    {{--<a class="btn btn-enroll btn-details shadow d-block" href="https://unmesh.com/Program/Detail/Medical2022">Details/Routine</a>--}}
                                    {{--<a class="btn btn-enroll shadow" href="https://online.udvash-unmesh.com/Course/Programs?classId=8&amp;programType=0">Enroll Now</a>--}}
                                {{--</div>--}}
                            </div>
                        </div>
                        @endforeach
                    </div>

                </div>
            </section>
            <!-- End Course Section -->

            <!-- ======= Counter Section Start ======= -->
            <section id="counter-section" class="counter-section" style="margin-top: 10px;">
                <div class="container" >
                    <div class="head d-flex justify-content-center">
                        <h1 class="head1">Our Teachers</h1>
                    </div>

                    <div class="row d-flex justify-content-center">
                        @foreach($teachers as $teacher)
                        <div class="col-md-3 col-sm-6 col-6 text-center">
                            <img src="{{ asset('images/users/'.$teacher->profile)}}" alt="image">
                            <div class="form-inline d-flex justify-content-center align-items-center">
                                <h4>{{$teacher->name}}</h4>
                            </div>
                            <h6>
                                {{$teacher->qualification}}
                            </h6>
                        </div>
                        @endforeach
                    </div>
                </div>
            </section>


            <!-- ======= Service Section Start ======= -->
            <section id="service-section" class="service-section" style="margin-top: 15px; background-color: #D0F4F6">
                <div class="container">
                    <div class="d-flex justify-content-center">
                        <h1 class="head2" style="color: #0c0c0c">Our Specialties</h1>
                    </div>
                    <div class="row d-flex justify-content-center">
                        <div class="col-md-3 col-sm-6 col-6 text-center">
                            <img height="200px" width="300px" src="{{asset('images/frontend')}}/Online-Learning.webp" alt="icon1">
                            <p><b>Online and offline class</b></p>
                        </div>
                        <div class="col-md-3 col-sm-6 col-6 text-center">
                            <img height="200px" width="300px" src="{{asset('images/frontend')}}/teacher.webp" alt="icon1">
                            <p><b>Qualified teacher</b></p>
                        </div>
                        <div class="col-md-3 col-sm-6 col-6 text-center">
                            <img height="200px" width="300px" src="{{asset('images/frontend')}}/study material.jpg" alt="icon1">
                            <p><b>Better study material</b></p>
                        </div>

                        <div class="col-md-3 col-sm-6 col-6 text-center">
                            <img height="200px" width="300px" src="{{asset('images/frontend')}}/sss.png" alt="icon1">
                            <p><b>Result publish through SMS</b></p>
                        </div>
                    </div>
                </div>
            </section>
            <!-- End Service Section -->
            <!-- ======= Custom Section Start ======= -->
            <section id="contact" class="contact" style="margin-top: 20px; ">
                <div class="container" >
                    <div class="d-flex justify-content-center">
                        <h2 style="text-align: center"><b>Contact</b></h2>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info">
                                <div class="address">
                                    <i class='bx bx-current-location'></i>
                                    <h4>Address</h4>
                                    <p>{{ isset($setting) ? $setting->location : '' }}</p>
                                </div>
                                <div class="email">
                                    <i class='bx bx-envelope'></i>
                                    <h4>Email</h4>
                                    <p>{{ isset($setting) ? $setting->email : '' }}</p>
                                </div>
                                <div class="phone">
                                    <i class='bx bx-mobile'></i>
                                    <h4>Phone</h4>
                                    <p>{{ isset($setting) ? $setting->phone : '' }}</p>
                                </div>
                                <iframe src="{{ isset($setting) ? $setting->map : ' '}}" frameborder="0" style="border:0; width:  100%; height: 290px;" allowfullscreen>
                                </iframe>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <form action="{{route('contact.store')}}" method="POST"  class="php-email-form">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="name">Your Name<span style="color:red">*</span></label>
                                        <input type="text" class="form-control" name="name"  id="name" placeholder="Enter Your name" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="phone">Your Mobile<span style="color:red">*</span></label>
                                        <input type="text" class="form-control" name="phone" id="phone" placeholder="Enter Your Mobile Number" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="email">Your Email<span style="color:red">*</span></label>
                                    <input type="email" class="form-control" name="email"  id="email" placeholder="Enter Your Email" required>
                                </div>

                                <div class="form-group">
                                    <label for="subject">Subject<span style="color:red">*</span></label>
                                    <input type="text" class="form-control" name="subject" id="subject" placeholder="Enter A Subject" required>
                                </div>
                                <div class="form-group">
                                    <label for="message">Message<span style="color:red">*</span></label>
                                    <textarea class="form-control" name="message" id="message" rows="6" placeholder="Write your message here.." required></textarea>
                                </div>

                                <div class="text-center" style="margin-top: 10px">
                                    <button class="bt" id="bt" type="submit">
                                        <span class="msg" id="msg"></span>
                                        SEND
                                    </button>
                                </div>
                            </form>
                        </div>

                    </div>

                </div>
            </section>
        </main><!-- End #main -->

        <script src=""></script>

    </div>
</div>


<footer>
    <div class="container text-center">
        <hr>
        <p style="color: white">
            Copyright &copy; Wardan Tech Ltd.. All rights reserved. 2023
        </p>
    </div>
</footer>
{{--<a class="back-to-top d-flex align-items-center justify-content-center" href="#"><i class="bi bi-arrow-up-short"></i></a>--}}


<!-- View: /Themes/NewUdvashUnmeshTheme/Shared/Layouts/Parts/_Footer.cshtml--><script data-cfasync="false" src="cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script>
    (function (i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r; i[r] = i[r] || function () {
            (i[r].q = i[r].q || []).push(arguments)
        }, i[r].l = 1 * new Date(); a = s.createElement(o),
            m = s.getElementsByTagName(o)[0]; a.async = 1; a.src = g; m.parentNode.insertBefore(a, m)
    })(window, document, 'script', '../www.google-analytics.com/analytics.js', 'ga');

    ga('create', 'UA-42339180-6', 'auto', { 'allowLinker': true });
    ga('send', 'pageview');
    ga('require', 'linker');
    ga('linker:autoLink', ['orgbd.net', 'umsbd.net', 'unmeshbd.com', 'udvash.com'], false, true);

    ga('create', 'UA-42339180-4', 'auto', 'secondTracker');
    ga('secondTracker.send', 'pageview');
</script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-42339180-4"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-42339180-4');
</script>

<!-- Meta Pixel Code -->
<script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
        n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s)}(window, document,'script',
        '../connect.facebook.net/en_US/fbevents.js');
    fbq('init', '572479084654419');
    fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
               src="https://www.facebook.com/tr?id=572479084654419&amp;ev=PageView&amp;noscript=1"/>
</noscript>
<!-- End Meta Pixel Code -->


<script src="js/bootstrap.min.js"></script>
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

<script type="text/javascript" src="{{asset('js')}}/jquery.min.js"></script>
<script type="text/javascript" src="{{asset('js')}}/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="{{asset('js')}}/aos.js"></script>
<script type="text/javascript" src="{{asset('js')}}/swiper-bundle.min.js"></script>
<script type="text/javascript" src="{{asset('js')}}/purecounter.js"></script>
<script type="text/javascript" src="{{asset('js')}}/glightbox.min.js"></script>
<script type="text/javascript" src="{{asset('js')}}/main.js"></script>
<script type="text/javascript" src="{{asset('js')}}/custom.js"></script>





<script>
    //Course bank load more script
    const coursePageHome = document.querySelector('.course-home-section');
    const coursePageLoadMore = document.querySelector('.course-home-section .load-more');
    const coursePageBtnMore = document.querySelector('.course-home-section .btn-more');
    const coursePageElementList = [...document.querySelectorAll('.course-home-section .course')];
    let coursePageCurrentItems = 9;
    if (coursePageElementList.length <= coursePageCurrentItems) {
        coursePageLoadMore.style.display = 'none';
        coursePageHome.style.marginBottom = '0px';
    }
    if(coursePageElementList != null){
        for (var i = 1; i <= coursePageCurrentItems; i++) {
            var element = document.querySelector(`.course-home-section .course:nth-child(${i})`);
            element.style.display = 'flex';
        }
    }
    coursePageBtnMore.addEventListener('click', function () {

        console.log(coursePageElementList);
        for (let k = coursePageCurrentItems; k < coursePageCurrentItems + 6; k++) {
            if (coursePageElementList[k]) {
                coursePageElementList[k].style.display = 'flex';
            }
        }
        coursePageCurrentItems += 6;
        // Load more button will be hidden after list fully loaded
        if (coursePageCurrentItems >= coursePageElementList.length) {
            event.target.style.display = 'none';
            coursePageLoadMore.style.display = 'none';
            coursePageHome.style.marginBottom = '0px';
        }

    });
    if (coursePageElementList.length <= 6) {
        coursePageLoadMore.style.display = 'none';
    }
</script>
<script>
    /** For Testimonial Load More**/
    const loadtest = document.querySelector('.testimonial-section .btn-more');
    let testCurrentItems = 3;
    const testElementList = [...document.querySelectorAll('.testimonial-section .testmonial')];
    loadtest.addEventListener('click', function () {
        for (let j = testCurrentItems; j < testCurrentItems + 3; j++) {
            if (testElementList[j]) {
                testElementList[j].style.display = 'flex';
            }
        }
        testCurrentItems += 3;
        // Load more button will be hidden after list fully loaded
        if (testCurrentItems >= testElementList.length) {
            event.target.style.display = 'none';
        }
    });
    if (testElementList.length <= 3) {
        loadtest.style.display = 'none';
    }
</script>

</body>

<!-- Mirrored from udvash.com/HomePage by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 21 Dec 2022 10:45:14 GMT -->
</html>

