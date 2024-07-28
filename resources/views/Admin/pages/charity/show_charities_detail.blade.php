<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Star Admin2</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('assets/vendors/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/typicons/typicons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/simple-line-icons/css/simple-line-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="{{ asset('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/js/select.dataTables.min.css') }}">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" />
    <style>
        @import url('https://fonts.googleapis.com/css?family=Roboto+Slab:100,300,400,700');
        @import url('https://fonts.googleapis.com/css?family=Raleway:300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i');

        .container {
            display: flex;
            flex-wrap: wrap;
        }

        .cards1 {
            width: 100%;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .card11 {
            width: 100%;
            margin-bottom: 20px;
            transition: all .4s cubic-bezier(0.175, 0.885, 0, 1);
            background-color: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0px 13px 10px -7px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .card11:hover {
            box-shadow: 0px 30px 18px -8px rgba(0, 0, 0, 0.1);
            transform: scale(1.10, 1.10);
        }

        .card__img11 {
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            width: 100%;
            height: 235px;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
        }

        .card__info11 {
            z-index: 2;
            background-color: #fff;
            border-bottom-left-radius: 12px;
            border-bottom-right-radius: 12px;
            padding: 16px 24px 24px 24px;
            width: 100%;
        }

        .card__category11 {
            font-family: 'Raleway', sans-serif;
            text-transform: uppercase;
            font-size: 13px;
            letter-spacing: 2px;
            font-weight: 500;
            color: #868686;
        }

        .card__title11 {
            margin-top: 5px;
            margin-bottom: 10px;
            font-family: 'Roboto Slab', serif;
        }

        .card__by11 {
            font-size: 12px;
            font-family: 'Raleway', sans-serif;
            font-weight: 500;
        }

        .card__author11 {
            font-weight: 600;
            text-decoration: none;
            color: #AD7D52;
        }

        .card11:hover .card__img11 {
            opacity: 0.3;
        }

        .card11:hover .card__info11 {
            background-color: transparent;
            position: relative;
        }
    </style>
</head>
<body class="with-welcome-text">
    <div class="container-scroller">
        <!-- Navbar -->
        <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex align-items-top flex-row">
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
                <div class="me-3">
                    <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-bs-toggle="minimize">
                        <span class="icon-menu"></span>
                    </button>
                </div>
                <div>
                    <a class="navbar-brand brand-logo" href="index.html">
                        <img src="{{ asset('assets/images/logo.svg') }}" alt="logo" />
                    </a>
                    <a class="navbar-brand brand-logo-mini" href="index.html">
                        <img src="{{ asset('assets/images/logo-mini.svg') }}" alt="logo" />
                    </a>
                </div>
            </div>
            <div class="navbar-menu-wrapper d-flex align-items-top">
                <ul class="navbar-nav">
                    <li class="nav-item fw-semibold d-none d-lg-block ms-0">
                        <h1 class="welcome-text">Good Morning, <span class="text-black fw-bold">My Admin</span></h1>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <form class="search-form" action="#">
                            <i class="icon-search"></i>
                            <input type="search" class="form-control" placeholder="Search Here" title="Search here">
                        </form>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link count-indicator" id="notificationDropdown" href="#" data-bs-toggle="dropdown">
                            <i class="icon-bell"></i>
                            <span class="count"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list pb-0" aria-labelledby="notificationDropdown">
                            <a class="dropdown-item py-3 border-bottom">
                                <p class="mb-0 fw-medium float-start">You have 4 new notifications</p>
                                <span class="badge badge-pill badge-primary float-end">View all</span>
                            </a>
                            <a class="dropdown-item preview-item py-3">
                                <div class="preview-thumbnail">
                                    <i class="mdi mdi-alert m-auto text-primary"></i>
                                </div>
                                <div class="preview-item-content">
                                    <h6 class="preview-subject fw-normal text-dark mb-1">Application Error</h6>
                                    <p class="fw-light small-text mb-0">Just now</p>
                                </div>
                            </a>
                            <a class="dropdown-item preview-item py-3">
                                <div class="preview-thumbnail">
                                    <i class="mdi mdi-lock-outline m-auto text-primary"></i>
                                </div>
                                <div class="preview-item-content">
                                    <h6 class="preview-subject fw-normal text-dark mb-1">Settings</h6>
                                    <p class="fw-light small-text mb-0">Private message</p>
                                </div>
                            </a>
                            <a class="dropdown-item preview-item py-3">
                                <div class="preview-thumbnail">
                                    <i class="mdi mdi-airballoon m-auto text-primary"></i>
                                </div>
                                <div class="preview-item-content">
                                    <h6 class="preview-subject fw-normal text-dark mb-1">New user registration</h6>
                                    <p class="fw-light small-text mb-0">2 days ago</p>
                                </div>
                            </a>
                        </div>
                    </li>
                    <li class="nav-item dropdown d-none d-lg-block user-dropdown">
                        <a class="nav-link" id="UserDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                            <img class="img-xs rounded-circle" src="{{ asset('assets/images/faces/face8.jpg') }}" alt="Profile image">
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                            <div class="dropdown-header text-center">
                                <img class="img-md rounded-circle" src="{{ asset('assets/images/faces/face8.jpg') }}" alt="Profile image">
                                <p class="mb-1 mt-3 fw-semibold">Allen Moreno</p>
                                <p class="fw-light text-muted mb-0">allenmoreno@gmail.com</p>
                            </div>
                            <a class="dropdown-item"><i class="dropdown-item-icon mdi mdi-account-outline text-primary me-2"></i> My Profile <span class="badge badge-pill badge-danger">1</span></a>
                            <a class="dropdown-item"><i class="dropdown-item-icon mdi mdi-power text-primary me-2"></i>Sign Out</a>
                        </div>
                    </li>
                </ul>
                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-bs-toggle="offcanvas">
                    <span class="mdi mdi-menu"></span>
                </button>
            </div>
        </nav>
        <!-- Sidebar -->
        <div class="container-fluid page-body-wrapper">
            <nav class="sidebar sidebar-offcanvas" id="sidebar">
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link" href="index.html">
                            <i class="mdi mdi-grid-large menu-icon"></i>
                            <span class="menu-title">لوحة التحكم</span>
                        </a>
                    </li>
                    <li class="nav-item nav-category">عرض الجمعيات</li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                            <i class="menu-icon mdi mdi-floor-plan"></i>
                            <span class="menu-title">عرض الجمعيات</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="ui-basic">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link" href="{{ route('charity_browse') }}">عرض الجمعيات</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#form-elements" aria-expanded="false" aria-controls="form-elements">
                            <i class="menu-icon mdi mdi-card-text-outline"></i>
                            <span class="menu-title">عرض التقارير</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="form-elements">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"><a class="nav-link" href="pages/forms/basic_elements.html">عرض التقارير</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#charts" aria-expanded="false" aria-controls="charts">
                            <i class="menu-icon mdi mdi-chart-line"></i>
                            <span class="menu-title">التعليقات</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="charts">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link" href="pages/charts/chartjs.html">التعليقات</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#tables" aria-expanded="false" aria-controls="tables">
                            <i class="menu-icon mdi mdi-table"></i>
                            <span class="menu-title">طلبات انضمام الجمعيات</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="tables">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link" href="pages/tables/basic-table.html">طلبات انضمام الجمعيات</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-bs-toggle="collapse" href="#forms" aria-expanded="false" aria-controls="forms">
                        <i class="menu-icon mdi mdi-floor-plan"></i>
                        <span class="menu-title">تفعيل الحالة الطارئة</span>
                        <i class="menu-arrow"></i>
                      </a>
                      <div class="collapse" id="forms">
                        <ul class="nav flex-column sub-menu">
                          <li class="nav-item"> <a class="nav-link" href="{{ route('active_emergency_status') }}">تفعيل الحالة الطارئة</a></li>
                             <li class="nav-item"> <a class="nav-link" href="{{ route('factor_emergency_status') }}">تحديد احتياج الحالة الطارئة</a></li>
                             <li class="nav-item"> <a class="nav-link" href="{{route('get_emergency')}}">عرض الاحتياجات الطارئة</a></li>


                        </ul>
                      </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link">
                            <i class="menu-icon mdi mdi-account-circle-outline"></i>
                            <span class="menu-title">إدارة الحساب</span>
                            <i class="menu-arrow"></i>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- Content -->
            <div class="main-panel">
              <div class="content-wrapper">
                  <div class="container">
                      <div class="row justify-content-center">
                          <div class="col-12">
                              <section class="card" style="height:100%; width:100%; padding: 20px;">
                                  <article class="card-body">
                                      <div class="card__info" style="display:flex; flex-direction:column; align-items:flex-start; gap:10px;">
                                          <span class="card__title" style="font-size:1.2rem; font-weight:600;">
                                              أسم الجمعية: <span style="color:gray;">{{ $charities->name }}</span>
                                          </span>
                                          <h3 class="card__title" style="font-size:1.2rem; font-weight:600;">
                                              رقم الإشهار: <span style="color:gray;">{{ $charities->licensenumber }}</span>
                                          </h3>
                                          <span class="card__by" style="font-size:1.2rem; font-weight:600;">
                                              الهاتف: <span style="color:gray;">{{ $charities->charityphone }}</span>
                                          </span>
                                          <span class="card__by" style="font-size:1.2rem; font-weight:600;">
                                              نائب رئيس الجمعية: <span style="color:gray;">{{ $charities->vicepresidentofcharity }}</span>
                                          </span>
                                          <span class="card__by" style="font-size:1.2rem; font-weight:600;">
                                              نوع الجمعية: <span style="color:gray;">{{ $charities->typeofcharity }}</span>
                                          </span>
                                          <span class="card__by" style="font-size:1.2rem; font-weight:600;">
                                              أمين الصندوق: <span style="color:gray;">{{ $charities->nameofcashier }}</span>
                                          </span>
                                          <span class="card__by" style="font-size:1.2rem; font-weight:600;">
                                              موقع الإنترنت: <a href="{{ $charities->linkwebsite }}" style="color:gray;">{{ $charities->linkwebsite }}</a>
                                          </span>
                                          <span class="card__by" style="font-size:1.2rem; font-weight:600;">
                                              صفحة الفيسبوك: <a href="{{ $charities->linkoffacebookpage }}" style="color:gray;">{{ $charities->linkoffacebookpage }}</a>
                                          </span>
                                          <span class="card__by" style="font-size:1.2rem; font-weight:600;">
                                              أهداف الجمعية:
                                              <ul style="list-style-type: disc; margin-left: 20px;">
                                                  @foreach(explode('\n', $charities->charity_goals) as $goal)<br>
                                                      <li style="color:gray;">{{ $goal }}</li>
                                                  @endforeach
                                              </ul>
                                          </span>
                                          <span class="card__by" style="font-size:1.2rem; font-weight:600;">
                                            رؤية الجمعية:
                                              <ul style="list-style-type: disc; margin-left: 20px;">
                                                  @foreach(explode('\n', $charities->vision_of_charity) as $goal)
                                                      <li style="color:gray;">{{ $goal }}</li>
                                                  @endforeach
                                              </ul>
                                          </span>
                                          <span class="card__by" style="font-size:1.2rem; font-weight:600;">
                                            رسالة الجمعية:
                                              <ul style="list-style-type: disc; margin-left: 20px;">
                                                  @foreach(explode('\n', $charities->charity_message) as $goal)
                                                      <li style="color:gray;">{{ $goal }}</li>
                                                  @endforeach
                                              </ul>
                                          </span>
                                                    </div>
                                  </article>
                              </section>

                          </div>
                      </div>
                  </div>
              </div>
          </div>



        </div>
        <div class="main-panel">
      <div class="content-wrapper" style="margin-left:550px;">
          <div class="container">
              <div class="row justify-content-center">
                  <!-- Education Card -->
                  <div class="col-md-3 mb-4">
                      <section class="card" style="height:100%; width:100%; padding: 20px;">
                          <h3>القسم التعليمي</h3>
                          <article class="card-body">
                              <div class="card__info" style="display:flex; flex-direction:column; align-items:flex-start; gap:10px;">
                                  <span class="card__by" style="font-size:1.2rem; font-weight:600;">
                                      حقائب:
                                      <ul style="list-style-type: disc; margin-left: 20px;">
                                          @foreach($education as $educationItem)
                                              @foreach(explode('\n', $educationItem->bags) as $goal)
                                                  <li style="color:gray;">{{ $goal }}</li>
                                              @endforeach
                                          @endforeach
                                      </ul>
                                  </span>
                                  <span class="card__by" style="font-size:1.2rem; font-weight:600;">
                                      ملابس:
                                      <ul style="list-style-type: disc; margin-left: 20px;">
                                          @foreach($education as $educationItem)
                                              @foreach(explode('\n', $educationItem->clothes) as $goal)
                                                  <li style="color:gray;">{{ $goal }}</li>
                                              @endforeach
                                          @endforeach
                                      </ul>
                                  </span>
                                  <span class="card__by" style="font-size:1.2rem; font-weight:600;">
                                      قرطاسية:
                                      <ul style="list-style-type: disc; margin-left: 20px;">
                                          @foreach($education as $educationItem)
                                              @foreach(explode('\n', $educationItem->booksandpens) as $goal)
                                                  <li style="color:gray;">{{ $goal }}</li>
                                              @endforeach
                                          @endforeach
                                      </ul>
                                  </span>
                                  <span class="card__by" style="font-size:1.2rem; font-weight:600;">
                                      نوع التعليم:
                                      <ul style="list-style-type: disc; margin-left: 20px;">
                                          @foreach($education as $educationItem)
                                              @foreach(explode('\n', $educationItem->typeofeducation) as $goal)
                                                  <li style="color:gray;">{{ $goal }}</li>
                                              @endforeach
                                          @endforeach
                                      </ul>
                                  </span>
                                  <span class="card__by" style="font-size:1.2rem; font-weight:600;">
                                      دورات تدريبية:
                                      <ul style="list-style-type: disc; margin-left: 20px;">
                                          @foreach($education as $educationItem)
                                              @foreach(explode('\n', $educationItem->courses) as $goal)
                                                  <li style="color:gray;">{{ $goal }}</li>
                                              @endforeach
                                          @endforeach
                                      </ul>
                                  </span>
                              </div>
                          </article>
                      </section>
                  </div>

                  <!-- Health Card -->
                  <div class="col-md-3 mb-4">
                      <section class="card" style="height:100%; width:100%; padding: 20px;">
                          <h3>القسم الصحي</h3>
                          <article class="card-body">
                              <div class="card__info" style="display:flex; flex-direction:column; align-items:flex-start; gap:10px;">
                                  <span class="card__by" style="font-size:1.2rem; font-weight:600;">
                                    نوع المرض:
                                      <ul style="list-style-type: disc; margin-left: 20px;">
                                          @foreach($health as $healthItem)
                                              @foreach(explode('\n', $healthItem->typeofdisease) as $detail)
                                                  <li style="color:gray;">{{ $detail }}</li>
                                              @endforeach
                                          @endforeach
                                      </ul>
                                  </span>
                                  <span class="card__by" style="font-size:1.2rem; font-weight:600;">
                                      عملية
                                      <ul style="list-style-type: disc; margin-left: 20px;">
                                          @foreach($health as $healthItem)
                                              @foreach(explode('\n', $healthItem->operation) as $detail)
                                                  <li style="color:gray;">{{ $detail }}</li>
                                              @endforeach
                                          @endforeach
                                      </ul>
                                  </span>
                                  <span class="card__by" style="font-size:1.2rem; font-weight:600;">
                                      فحص طبيب:
                                      <ul style="list-style-type: disc; margin-left: 20px;">
                                          @foreach($health as $healthItem)
                                              @foreach(explode('\n', $healthItem->doctorcheck) as $detail)
                                                  <li style="color:gray;">{{ $detail }}</li>
                                              @endforeach
                                          @endforeach
                                      </ul>
                                  </span>
                                  <span class="card__by" style="font-size:1.2rem; font-weight:600;">
                                      دواء:
                                      <ul style="list-style-type: disc; margin-left: 20px;">
                                          @foreach($health as $healthItem)
                                              @foreach(explode('\n', $healthItem->medicine) as $detail)
                                                  <li style="color:gray;">{{ $detail }}</li>
                                              @endforeach
                                          @endforeach
                                      </ul>
                                  </span>
                                  <span class="card__by" style="font-size:1.2rem; font-weight:600;">
                                         جهاز طبي:
                                      <ul style="list-style-type: disc; margin-left: 20px;">
                                          @foreach($health as $healthItem)
                                              @foreach(explode('\n', $healthItem->medicaldevice) as $detail)
                                                  <li style="color:gray;">{{ $detail }}</li>
                                              @endforeach
                                          @endforeach
                                      </ul>
                                  </span>
                                  <span class="card__by" style="font-size:1.2rem; font-weight:600;">
                                    نوع الجهاز:
                                      <ul style="list-style-type: disc; margin-left: 20px;">
                                          @foreach($health as $healthItem)
                                              @foreach(explode('\n', $healthItem->typeofdevice) as $detail)
                                                  <li style="color:gray;">{{ $detail }}</li>
                                              @endforeach
                                          @endforeach
                                      </ul>
                                  </span>
                                  <span class="card__by" style="font-size:1.2rem; font-weight:600;">
                                    حليب و حفاظ:
                                      <ul style="list-style-type: disc; margin-left: 20px;">
                                          @foreach($health as $healthItem)
                                              @foreach(explode('\n', $healthItem->milkanddiaper) as $detail)
                                                  <li style="color:gray;">{{ $detail }}</li>
                                              @endforeach
                                          @endforeach
                                      </ul>
                                  </span>
                              </div>
                          </article>
                      </section>
                  </div>

                  <!-- Relief Card -->
                  <div class="col-md-3 mb-4">
                      <section class="card" style="height:100%; width:100%; padding: 20px;">
                          <h3>القسم الإغاثي</h3>
                          <article class="card-body">
                              <div class="card__info" style="display:flex; flex-direction:column; align-items:flex-start; gap:10px;">
                                  <span class="card__by" style="font-size:1.2rem; font-weight:600;">
                                      منازل:
                                      <ul style="list-style-type: disc; margin-left: 20px;">
                                          @foreach($relief as $reliefItem)
                                              @foreach(explode('\n', $reliefItem->home) as $detail)
                                                  <li style="color:gray;">{{ $detail }}</li>
                                              @endforeach
                                          @endforeach
                                      </ul>
                                  </span>
                                  <span class="card__by" style="font-size:1.2rem; font-weight:600;">
                                      أثاث منازل:
                                      <ul style="list-style-type: disc; margin-left: 20px;">
                                          @foreach($relief as $reliefItem)
                                              @foreach(explode('\n', $reliefItem->housefurniture) as $detail)
                                                  <li style="color:gray;">{{ $detail }}</li>
                                              @endforeach
                                          @endforeach
                                      </ul>
                                  </span>
                                  <span class="card__by" style="font-size:1.2rem; font-weight:600;">
                                      طعام:
                                      <ul style="list-style-type: disc; margin-left: 20px;">
                                          @foreach($relief as $reliefItem)
                                              @foreach(explode('\n', $reliefItem->food) as $detail)
                                                  <li style="color:gray;">{{ $detail }}</li>
                                              @endforeach
                                          @endforeach
                                      </ul>
                                  </span>
                                  <span class="card__by" style="font-size:1.2rem; font-weight:600;">
                                      ملابس:
                                      <ul style="list-style-type: disc; margin-left: 20px;">
                                          @foreach($relief as $reliefItem)
                                              @foreach(explode('\n', $reliefItem->clothes) as $detail)
                                                  <li style="color:gray;">{{ $detail }}</li>
                                              @endforeach
                                          @endforeach
                                      </ul>
                                  </span>
                                  <span class="card__by" style="font-size:1.2rem; font-weight:600;">
                                      مال:
                                      <ul style="list-style-type: disc; margin-left: 20px;">
                                          @foreach($relief as $reliefItem)
                                              @foreach(explode('\n', $reliefItem->money) as $detail)
                                                  <li style="color:gray;">{{ $detail }}</li>
                                              @endforeach
                                          @endforeach
                                      </ul>
                                  </span>
                                  <span class="card__by" style="font-size:1.2rem; font-weight:600;">
                                      مساعدة نفسية:
                                      <ul style="list-style-type: disc; margin-left: 20px;">
                                          @foreach($relief as $reliefItem)
                                              @foreach(explode('\n', $reliefItem->psychologicalaid) as $detail)
                                                  <li style="color:gray;">{{ $detail }}</li>
                                              @endforeach
                                          @endforeach
                                      </ul>
                                  </span>
                              </div>
                          </article>
                      </section>
                  </div>

                  <!-- Lifehood Card -->
                  <div class="col-md-3 mb-4">
                      <section class="card" style="height:100%; width:100%; padding: 20px;">
                          <h3>القسم المعيشي</h3>
                          <article class="card-body">
                              <div class="card__info" style="display:flex; flex-direction:column; align-items:flex-start; gap:10px;">
                                  <span class="card__by" style="font-size:1.2rem; font-weight:600;">
                                      تعليم مهنة:
                                      <ul style="list-style-type: disc; margin-left: 20px;">
                                          @foreach($lifehood as $lifehoodItem)
                                              @foreach(explode('\n', $lifehoodItem->learningaprofession) as $detail)
                                                  <li style="color:gray;">{{ $detail }}</li>
                                              @endforeach
                                          @endforeach
                                      </ul>
                                  </span>
                                  <span class="card__by" style="font-size:1.2rem; font-weight:600;">
                                      كسب خبرات:
                                      <ul style="list-style-type: disc; margin-left: 20px;">
                                          @foreach($lifehood as $lifehoodItem)
                                              @foreach(explode('\n', $lifehoodItem->gainmoreexperienceinspecificfield) as $detail)
                                                  <li style="color:gray;">{{ $detail }}</li>
                                              @endforeach
                                          @endforeach
                                      </ul>
                                  </span>
                                  <span class="card__by" style="font-size:1.2rem; font-weight:600;">
                                      نوع العمل:
                                      <ul style="list-style-type: disc; margin-left: 20px;">
                                          @foreach($lifehood as $lifehoodItem)
                                              @foreach(explode('\n', $lifehoodItem->typeofworkthatyouwanttogain) as $detail)
                                                  <li style="color:gray;">{{ $detail }}</li>
                                              @endforeach
                                          @endforeach
                                      </ul>
                                  </span>
                                  <span class="card__by" style="font-size:1.2rem; font-weight:600;">
                                      فرص عمل:
                                      <ul style="list-style-type: disc; margin-left: 20px;">
                                          @foreach($lifehood as $lifehoodItem)
                                              @foreach(explode('\n', $lifehoodItem->jobapportunity) as $detail)
                                                  <li style="color:gray;">{{ $detail }}</li>
                                              @endforeach
                                          @endforeach
                                      </ul>
                                  </span>
                              </div>
                          </article>
                      </section>
                  </div>
              </div>
          </div>
      </div>
  </div>


    <!-- plugins:js -->
    <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="{{ asset('assets/vendors/chart.js/chart.umd.js') }}"></script>
    <script src="{{ asset('assets/vendors/progressbar.js/progressbar.min.js') }}"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{ asset('assets/js/off-canvas.js') }}"></script>
    <script src="{{ asset('assets/js/template.js') }}"></script>
    <script src="{{ asset('assets/js/settings.js') }}"></script>
    <script src="{{ asset('assets/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('assets/js/todolist.js') }}"></script>
    <!-- endinject -->
    <!-- Custom js for this page-->
    <script src="{{ asset('assets/js/jquery.cookie.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
    <!-- <script src="{{ asset('assets/js/Chart.roundedBarCharts.js') }}"></script> -->
    <!-- End custom js for this page-->
</body>
</html>
