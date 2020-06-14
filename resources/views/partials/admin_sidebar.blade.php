<div class="sidebar" data-color="rose" data-background-color="black" data-image="../assets/img/sidebar-1.jpg">
    <!--
      Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"
      Tip 2: you can also add an image using data-image tag
    -->
    @if($user_type == 'client' && $admin_nav_logo!=null)
        <div class="user" style="z-index: 3">
            <div class="photo photo-full">
                <img src="{{asset($admin_nav_logo)}}" title="{{$admin_client_name}}"
                     alt="{{$admin_client_name}}" />
            </div>
            <div class="user-info">
                <a href="{{url('/')}}" class="username">
                    <span>
                    </span>
                </a>
            </div>
        </div>
    @else
    <div class="logo">
        <a href="{{url('/')}}" class="simple-text logo-mini">
            @if($user_type == 'client')
                {{$admin_client_name[0]}}
            @else
                BB
            @endif
        </a>
        <a href="{{url('/')}}" class="simple-text logo-normal">
            @if($user_type == 'client')
                {{$admin_client_name}}
            @else
                Bumblebee
            @endif
        </a>
    </div>
    @endif
    <div class="sidebar-wrapper">
        <!--<div class="user">
            <div class="photo">
                <img src="../assets/img/faces/avatar.jpg" />
            </div>
            <div class="user-info">
                <a data-toggle="collapse" href="#collapseExample" class="username">
              <span>
                Tania Andrew
                <b class="caret"></b>
              </span>
                </a>
                <div class="collapse" id="collapseExample">
                    <ul class="nav">
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span class="sidebar-mini"> MP </span>
                                <span class="sidebar-normal"> My Profile </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span class="sidebar-mini"> EP </span>
                                <span class="sidebar-normal"> Edit Profile </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span class="sidebar-mini"> S </span>
                                <span class="sidebar-normal"> Settings </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>-->
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-chart-bar"></i>
                    <p> Dashboard </p>
                </a>
            </li>
            <!--<li class="nav-item ">
                <a class="nav-link" data-toggle="collapse" href="#pagesExamples">
                    <i class="material-icons">image</i>
                    <p> Pages
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse" id="pagesExamples">
                    <ul class="nav">
                        <li class="nav-item ">
                            <a class="nav-link" href="../examples/pages/pricing.html">
                                <span class="sidebar-mini"> P </span>
                                <span class="sidebar-normal"> Pricing </span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link" href="../examples/pages/rtl.html">
                                <span class="sidebar-mini"> RS </span>
                                <span class="sidebar-normal"> RTL Support </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>-->
            @if(!empty(Auth::user()) && Auth::user()->user_role == 'client')
                <li class="nav-item ">
                    <a class="nav-link" href="{{url('whatsapp-templates')}}">
                        <i class="fab fa-whatsapp-square"></i>
                        <p>WhatsApp Templates</p>
                    </a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="{{url('general-enquiry/add')}}">
                        <i class="fas fa-question-circle"></i>
                        <p>Add General Enquiry</p>
                    </a>
                </li>
            @else

            <li class="nav-item ">
                <a class="nav-link" data-toggle="collapse" href="#customer">
                    <i class="fas fa-user"></i>
                    <p> Customers
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse" id="customer">
                    <ul class="nav">
                        <li class="nav-item ">
                            <a class="nav-link" href="{{url('create-customer')}}">
                                <i class="fas fa-user"></i>
                                <p>Add Customer</p>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link" href="#">
                                <i class="fas fa-user-alt"></i>
                                <p>View Customers</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item ">
                <a class="nav-link" data-toggle="collapse" href="#client-companies">
                    <i class="fas fa-building"></i>
                    <p> Client companies
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse" id="client-companies">
                    <ul class="nav">
                        <li class="nav-item ">
                            <a class="nav-link" href="{{url('#')}}">
                                <i class="fas fa-truck"></i>
                                <p>Add Tookan merchant</p>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link" href="{{url('client/add')}}">
                                <i class="fas fa-building"></i>
                                <p>Add Client company</p>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link" href="{{url('clients')}}">
                                <i class="far fa-building"></i>
                                <p>View Client companies</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item ">
                <a class="nav-link" data-toggle="collapse" href="#service-types">
                    <i class="fas fa-tools"></i>
                    <p> Service Types
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse" id="service-types">
                    <ul class="nav">
                        <li class="nav-item ">
                            <a class="nav-link" href="{{url('service-type/add')}}">
                                <i class="fas fa-tools"></i>
                                <p>Add Service Type</p>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link" href="{{url('service-types')}}">
                                <i class="fas fa-tools"></i>
                                <p>View Service Types</p>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link" href="{{url('whatsapp-template/create')}}">
                                <i class="fab fa-whatsapp-square"></i>
                                <p>Add Whatsapp Template</p>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link" href="{{url('whatsapp-templates')}}">
                                <i class="fab fa-whatsapp-square"></i>
                                <p>View Whatsapp Templates</p>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link" href="#">
                                <i class="fas fa-phone-volume"></i>
                                <p>Add Programmable Voice Call</p>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link" data-toggle="collapse" href="#email-templates">
                                <i class="far fa-envelope"></i>
                                <p> Email Templates
                                    <b class="caret"></b>
                                </p>
                            </a>
                            <div class="collapse" id="email-templates">
                                <ul class="nav">
                                    <li class="nav-item ">
                                        <a class="nav-link" href="#">
                                            <i class="fas fa-envelope"></i>
                                            <p>Add Email Template</p>
                                        </a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="#">
                                            <i class="fas fa-envelope"></i>
                                            <p>View Email Templates</p>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link" data-toggle="collapse" href="#sms-templates">
                                <i class="fas fa-sms"></i>
                                <p> SMS Templates
                                    <b class="caret"></b>
                                </p>
                            </a>
                            <div class="collapse" id="sms-templates">
                                <ul class="nav">
                                    <li class="nav-item ">
                                        <a class="nav-link" href="#">
                                            <i class="fas fa-sms"></i>
                                            <p>Add SMS Template</p>
                                        </a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="#">
                                            <i class="fas fa-sms"></i>
                                            <p>View SMS Templates</p>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </li>
                <li class="nav-item ">
                    <a class="nav-link" data-toggle="collapse" href="#support-types">
                        <i class="far fa-question-circle"></i>
                        <p> Support Types
                            <b class="caret"></b>
                        </p>
                    </a>
                    <div class="collapse" id="support-types">
                        <ul class="nav">
                            <li class="nav-item ">
                                <a class="nav-link" href="{{url('support-type/add')}}">
                                    <i class="fas fa-question-circle"></i>
                                    <p>Add Support Type</p>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link" href="{{url('support-types')}}">
                                    <i class="fas fa-question-circle"></i>
                                    <p>View Support Types</p>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link" href="{{url('keywords')}}">
                                    <i class="fas fa-tags"></i>
                                    <p>Keywords</p>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link" href="{{url('responses')}}">
                                    <i class="fas fa-reply-all"></i>
                                    <p>Responses</p>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link" data-toggle="collapse" href="#email-notifications">
                                    <i class="far fa-envelope"></i>
                                    <p> Email Notifications
                                        <b class="caret"></b>
                                    </p>
                                </a>
                                <div class="collapse" id="email-notifications">
                                    <ul class="nav">
                                        <li class="nav-item ">
                                            <a class="nav-link" href="#">
                                                <i class="fas fa-envelope"></i>
                                                <p>Email Keywords</p>
                                            </a>
                                        </li>
                                        <li class="nav-item ">
                                            <a class="nav-link" href="#">
                                                <i class="fas fa-envelope"></i>
                                                <p>Email Responses</p>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link" data-toggle="collapse" href="#sms-notifications">
                                    <i class="fas fa-sms"></i>
                                    <p> SMS Notifications
                                        <b class="caret"></b>
                                    </p>
                                </a>
                                <div class="collapse" id="sms-notifications">
                                    <ul class="nav">
                                        <li class="nav-item ">
                                            <a class="nav-link" href="#">
                                                <i class="fas fa-sms"></i>
                                                <p>SMS Keywords</p>
                                            </a>
                                        </li>
                                        <li class="nav-item ">
                                            <a class="nav-link" href="#">
                                                <i class="fas fa-sms"></i>
                                                <p>SMS Responses</p>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>
            <li class="nav-item ">
                <a class="nav-link" data-toggle="collapse" href="#car-sync-prototypes">
                    <i class="fas fa-puzzle-piece"></i>
                    <p> Car Sync Prototypes
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse" id="car-sync-prototypes">
                    <ul class="nav">
                        <li class="nav-item ">
                            <a class="nav-link" href="{{url('obd-admin')}}">
                                <i class="fas fa-car-crash"></i>
                                <p>Emergency Crash Detection</p>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link" href="{{url('tyres-batteries')}}">
                                <i class="fas fa-car-battery"></i>
                                <p>AutoData Tyres & Batteries</p>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link" href="{{url('customer/health-check')}}">
                                <i class="fas fa-car"></i>
                                <p>Vehicle Health Check</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item ">
                <a class="nav-link" href="{{url('whatsapp-conversations')}}">
                    <i class="fab fa-whatsapp"></i>
                    <p>Whatsapp</p>
                </a>
            </li>
            @endif
        </ul>
    </div>
    @if($admin_nav_background_image!=null)
        <div class="sidebar-background" style="background-image: url('{{asset($admin_nav_background_image)}}')">
        </div>
    @endif
</div>