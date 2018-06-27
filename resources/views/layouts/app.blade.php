<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>QRCode Generator</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    {{-- <link rel="stylesheet" src="{{asset('css/app.css')}}"> --}}
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">

    <!-- Theme style -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.3/css/AdminLTE.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.3/css/skins/_all-skins.min.css">

    <!-- iCheck -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/skins/square/_all.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css">

    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap.min.css">

    <!-- Subscription Form -->
 <style >
     .sp-force-hide { display: none;}
     .sp-form[sp-id="102227"] { 
         display: block; 
         background: #ffffff; 
         padding: 15px; 
         width: 450px; 
         max-width: 100%; 
         border-radius: 8px; 
         -moz-border-radius: 8px; 
         -webkit-border-radius: 8px; 
         border-color: #dddddd; 
         border-style: solid; 
         border-width: 1px; 
         font-family: Arial, "Helvetica Neue", sans-serif; 
         background-repeat: no-repeat; 
         background-position: center; 
         background-size: auto;}
         .sp-form[sp-id="102227"] 
         input[type="checkbox"] { 
             display: inline-block; 
             opacity: 1; 
             visibility: visible;}
             .sp-form[sp-id="102227"] 
             .sp-form-fields-wrapper { 
                 margin: 0 auto; 
                 width: 420px;
                }
             .sp-form[sp-id="102227"] 
             .sp-form-control { 
                 background: #ffffff; 
                 border-color: #cccccc; 
                 border-style: solid; 
                 border-width: 1px; 
                 font-size: 15px; padding-left: 8.75px; 
                 padding-right: 8.75px; border-radius: 4px; -moz-border-radius:
                  4px; -webkit-border-radius: 4px; height: 35px; width: 100%;}
                  .sp-form[sp-id="102227"] 
                  .sp-field label { color: #444444; font-size: 13px; 
                    font-style: normal; font-weight: bold;}
                    .sp-form[sp-id="102227"] 
                    .sp-button { border-radius: 4px; -moz-border-radius: 4px; 
                        -webkit-border-radius: 4px; 
                        background-color: #0089bf; 
                        color: #ffffff; width: auto; 
                        font-weight: bold;}
                        .sp-form[sp-id="102227"] 
                        .sp-button-container { text-align: left;}
                        .sp-popup-outer { background: rgba(0, 0, 0, 0.5);}
                    </style>
                 

                         <script type="text/javascript" 
                                src="//static-login.sendpulse.com/apps/fc3/build/default-handler.js?1528703554958">
                            </script> 
<!-- /Subscription Form -->

    @yield('css')
</head>

<body class="skin-purple-light sidebar-mini">


<div class="sp-form-outer sp-popup-outer sp-force-hide" 
style="background: rgba(0, 0, 0, 0.5);">
<div id="sp-form-102227" sp-id="102227" 
sp-hash="152467f169ef35697edd5901c26a4d19ce9df73be37d5f28155a7146e12997bb" 
sp-lang="en" class="sp-form sp-form-regular sp-form-popup" 
sp-show-options="%7B%22satellite%22%3Afalse%2C%22maDomain%22%3A%22login.sendpulse.com%22%2C%22formsDomain%22%3A%22forms.sendpulse.com%22%2C%22condition%22%3A%22onEnter%22%2C%22scrollTo%22%3A25%2C%22delay%22%3A10%2C%22repeat%22%3A3%2C%22background%22%3A%22rgba(0%2C%200%2C%200%2C%200.5)%22%2C%22position%22%3A%22bottom-right%22%2C%22animation%22%3A%22%22%2C%22hideOnMobile%22%3Afalse%2C%22urlFilter%22%3Afalse%2C%22urlFilterConditions%22%3A%5B%7B%22force%22%3A%22hide%22%2C%22clause%22%3A%22contains%22%2C%22token%22%3A%22%22%7D%5D%7D">
<div class="sp-form-fields-wrapper">
<button class="sp-btn-close ">&nbsp;</button>
<div class="sp-message"><div></div></div>
<form novalidate="" class="sp-element-container ui-sortable ui-droppable">
</form>
<div class="sp-link-wrapper sp-brandname__left">
<a class="sp-link " target="_blank" 
href="https://sendpulse.com/forms-powered-by-sendpulse?from=6928708">
    <span class="sp-link-img">&nbsp;</span>
    <span translate="FORM.PROVIDED_BY">
        Provided by SendPulse
    </span></a></div></div></div>
</div>







@if (!Auth::guest())
    <div class="wrapper">
        <!-- Main Header -->
        <header class="main-header">

            <!-- Logo -->
            <a href="#" class="logo">
                <b>QRCode Generator</b>
            </a>

            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>
                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <!-- User Account Menu -->
                        <li class="dropdown user user-menu">
                            <!-- Menu Toggle Button -->
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                              
                                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                                <span class="hidden-xs">{!! Auth::user()->name !!}</span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- The user image in the menu -->
                                <li class="user-header">
                                    <p>
                                        {!! Auth::user()->name !!}
                                        <small>Member since {!! Auth::user()->created_at->format('M. Y') !!}</small>
                                    </p>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                    <a href="/users/{{ Auth::user()->id }}" class="btn btn-default btn-flat">Profile</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="{!! url('/logout') !!}" class="btn btn-default btn-flat"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            Sign out
                                        </a>
                                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <!-- Left side column. contains the logo and sidebar -->
        @include('layouts.sidebar')
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

    @yield('content')
        </div>

        <!-- Main Footer -->
        <footer class="main-footer" style="max-height: 100px;text-align: center">
            <strong>Copyright © 2018 <a href="#">QRCode Generator</a>.</strong> All rights reserved.
        </footer>

    </div>
@else
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{!! url('/') !!}">
                    QRCode Generator
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li><a href="{!! url('/home') !!}">Home</a></li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    <li><a href="{!! url('/login') !!}">Login</a></li>
                    <li><a href="{!! url('/register') !!}">Register</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div id="page-content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    @yield('content')
                </div>

            </div>
        </div>
    </div>
    @endif

 
    <!-- jQuery 3.1.1 -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
   <script src="{{asset('js/app.js')}}"></script>


    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <!-- AdminLTE App -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.3/js/adminlte.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/icheck.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.min.js"></script>
     
    <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap.min.js"> </script>
<script src="//static-login.sendpulse.com/apps/fc3/build/loader.js"
 sp-form-id="152467f169ef35697edd5901c26a4d19ce9df73be37d5f28155a7146e12997bb"></script>
    
    <script>
        $(document).ready(function() {
            $('table').DataTable();
        } );
    </script>
 
        
    @yield('scripts')
</body>
</html>