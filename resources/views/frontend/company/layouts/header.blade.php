
<!DOCTYPE html>
<html lang="en">
<head>

    <!-- Basic Page Needs
  ================================================== -->
    <meta charset="utf-8">
    <title>SwiftCo Solutions</title>

    <!-- Mobile Specific Metas
  ================================================== -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Corporate Html5 Template">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta name="author" content="Themefisher">
    <meta name="generator" content="Themefisher Rappo HTML Template v1.0">
    <!-- bootstrap -->
    <link rel="stylesheet" href="{{url('frontend/company/plugins/bootstrap/bootstrap.min.css')}}">
    <!-- Animate -->
    <link rel="stylesheet" href="{{url('frontend/company/plugins/animate-css/animate.css')}}">
    <!-- Icon Font css -->
    <link rel="stylesheet" href="{{url('frontend/company/plugins/fontawesome/css/all.css')}}">
    <link rel="stylesheet" href="{{url('frontend/company/plugins/fonts/Pe-icon-7-stroke.css')}}">
    <!-- Themify icon Css -->
    <link rel="stylesheet" href="{{url('frontend/company/plugins/themify/css/themify-icons.css')}}">
    <!-- Slick Carousel CSS -->
    <link rel="stylesheet" href="{{url('frontend/company/plugins/slick-carousel/slick/slick.css')}}">
    <link rel="stylesheet" href="{{url('frontend/company/plugins/slick-carousel/slick/slick-theme.css')}}">
    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="{{url('frontend/company/css/style.css')}}">

    <!--Favicon-->
    <link rel="icon" href="{{url('frontend/company/images/favicon.png')}}" type="image/x-icon">

</head>

<body id="top-header">

    <!-- LOADER TEMPLATE -->
    <div id="page-loader">
        <div class="loader-icon fa fa-spin colored-border"></div>
    </div>
    <!-- /LOADER TEMPLATE -->

    <!-- NAVBAR
    ================================================= -->

    <nav
        class="navbar navbar-expand-lg navbar-dark fixed-top site-navigation main-nav navbar-togglable trans-navigation">
        <div class="container">
            <a class="navbar-brand" href="#">
                <h3>Logo</h3>
            </a>
            <!-- Toggler -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse"
                aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="fa fa-bars"></span>
            </button>

            <!-- Collapse -->
            <div class="collapse navbar-collapse has-dropdown" id="navbarCollapse">
                <!-- Links -->
                <ul class="navbar-nav ">
                    <li class="nav-item ">
                        <a href="{{ url('/')}}" class="nav-link js-scroll-trigger">
                            Home
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a href="{{ url('about')}}" class="nav-link js-scroll-trigger">
                            About
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a href="{{ url('services')}}" class="nav-link js-scroll-trigger">
                            Services
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a href="{{ url('pricing')}}" class="nav-link js-scroll-trigger">
                            Pricing
                        </a>
                    </li>

                    <li class="nav-item ">
                        <a href="{{ url('projects')}}" class="nav-link js-scroll-trigger">
                            Projects
                        </a>
                    </li>

                    <li class="nav-item ">
                        <a href="{{ url('contact')}}" class="nav-link">
                            Contact
                        </a>
                    </li>
                </ul>

                <ul class="ml-lg-auto list-unstyled m-0 nav-btn">
                    <li><a href="#" class="btn btn-trans-white btn-circled">Get a quote</a></li>
                </ul>
            </div>
        </div>
    </nav>
