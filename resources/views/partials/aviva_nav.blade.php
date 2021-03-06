<nav class="navbar navbar-expand-lg navbar-light navbar-aviva static-top">
    <div class="container">
        <a class="navbar-brand" href="{{url('/')}}" style="max-width: 75%">
            <img src="{{asset('images/aviva-intelligent-protection.png')}}" alt="Aviva Intelligent Protection"
                style="max-height: 30px; max-width: 100%;">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="{{url('/')}}">Home
                        <span class="sr-only">(current)</span>
                    </a>
                </li>
                @if($user!=null)
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="obdDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            OBD & Vehicles
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="obdDropdown">
                            <a class="nav-link" href="{{url('obd/add')}}">Add OBD</a>
                            <a class="nav-link" href="{{url('vehicle/add')}}">Add Vehicle</a>
                            <a class="nav-link" href="{{url('obd-to-vehicle/add')}}">Add OBD-Vehicle connection</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="fleetsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Fleets
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="fleetsDropdown">
                            <a class="nav-link" href="{{url('fleet/add')}}">Add Fleet</a>
                            <a class="nav-link" href="{{url('fleets/view')}}">View Fleets</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{$user->name}}
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="nav-link" href="{{url('logout')}}">Logout</a>
                        </div>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
