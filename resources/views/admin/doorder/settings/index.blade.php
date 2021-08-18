@extends('templates.dashboard') @section('title', 'DoOrder | Settings')

@section('page-styles')
<style>
#settingsCardDiv .addBtn {
	font-family: Quicksand;
	font-size: 13px;
	font-weight: 500;
	font-stretch: normal;
	font-style: normal;
	line-height: normal;
	letter-spacing: 0.72px;
	color: #ffffff;
	padding: 6px 1.2rem;
	border-radius: 11.2px 0;
	height: auto;
	max-width: 170px;
	text-transform: capitalize;
}

#navSettingsUl li a {
	font-family: Quicksand;
	font-size: 16px;
	font-weight: 600;
	font-stretch: normal;
	font-style: normal;
	line-height: 1.19;
	letter-spacing: 0.8px;
	color: #b6b6b6;
	background: transparent;
}

#navSettingsUl li a.active, #navSettingsUl li a:hover {
	color: #d2b431 !important;
	box-shadow: none !important;
}

.tab-space {
	padding: 0 !important;
}

.togglebutton {
	margin-top: -3px;
}

.togglebutton label .toggle, .togglebutton label input[type=checkbox][disabled]+.toggle
	{
	width: 45px;
	height: 20px;
	margin-left: 30px;
	background-color: #b2b2b2
}

.togglebutton label input[type=checkbox]+.toggle:after {
	border-color: #b2b2b2;
}

.togglebutton label input[type=checkbox]:checked+.toggle {
	background-color: #f7dc69;
}

.togglebutton label .toggle:after {
	box-shadow: none;
	left: 0;
	top: -5px;
}
#toggleButtonConnectedApi label .toggle:after{
top: 0 !important;}

.togglebutton label input[type=checkbox]:checked+.toggle:after {
	border-color: #f7dc69;
	left: 24px;
}

.togglebutton label input[type=checkbox]+.toggle:active:after,
	.togglebutton label input[type=checkbox][disabled]+.toggle:active:after,
	.togglebutton label input[type=checkbox]:checked+.toggle:active:after {
	box-shadow: none !important;
}

.dropdown-menu .dropdown-item, .dropdown-menu li>a {
	font-family: Quicksand;
	font-size: 13px;
	font-weight: normal;
	font-stretch: normal;
	font-style: normal;
	line-height: normal;
	letter-spacing: normal;
	color: #494949;
}

.bootstrap-select .dropdown-item.active, .bootstrap-select .dropdown-item:hover
	{
	font-weight: bold;
	color: white;
	box-shadow: none !important;
}

.dropdown-menu .dropdown-item:focus, .dropdown-menu .dropdown-item:hover,
	.dropdown-menu a:active, .dropdown-menu a:focus, .dropdown-menu a:hover
	{
	background: #e8ca49;
}

.vue-treeselect__control {
	border: none !important;
	margin-top: -6px;
}

.vue-treeselect__menu {
	font-family: Quicksand;
	font-size: 13px;
	font-weight: normal;
	font-stretch: normal;
	font-style: normal;
	line-height: normal;
	letter-spacing: normal;
	color: #494949;
}

.vue-treeselect__menu li:hover {
	background: #e8ca49;
	font-weight: bold;
	color: white;
	box-shadow: none !important;
}

.vue-treeselect__menu li:hover .vue-treeselect__label,
	.vue-treeselect__option--highlight .vue-treeselect__label,
	.vue-treeselect--single .vue-treeselect__option--selected .vue-treeselect__label
	{
	font-weight: bold !important;
	color: white !important;
	box-shadow: none !important;
}

.vue-treeselect__option--highlight, .vue-treeselect--single .vue-treeselect__option--selected
	{
	background: #e8ca49 !important;
	font-weight: bold !important;
	color: white !important;
	box-shadow: none !important;
}

.vue-treeselect__indent-level-0 .vue-treeselect__option {
	padding: 5px
}

.removeRatePropertySizeCircle {
	color: #df5353;
	cursor: pointer;
	margin-left: 5px;
	font-size: 16px
}

.addCircle {
	color: #e8ca49;
}

.nav-pills:not(.flex-column) .nav-item+.nav-item:not(:first-child) {
	margin-left: 0 !important;
}
</style>

@endsection @section('page-content')
<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12" id="settingsCardDiv">
				<div class="card">
					<div class="card-header card-header-icon card-header-rose row">
						<div class="col-12 col-lg-5 col-md-6">
							<div class="card-icon">
								<img class="page_icon"
									src="{{asset('images/doorder_icons/Settings.png')}}"
									alt="dashboard icon">
							</div>
							<h4 class="card-title ">Settings</h4>
						</div>
						<div class="col-12 col-lg-7 col-md-6 mt-md-4 ">
							<div class="row justify-content-end float-sm-right">
								<a class=" btn btn-primary doorder-btn-lg doorder-btn addBtn"
									href=""> Add new user </a>
							</div>

						</div>
					</div>

					<div class="card-body"></div>
				</div>

				<div>
					<ul
						class="nav nav-pills nav-pills-primary justify-content-start justify-content-md-center"
						role="tablist" id="navSettingsUl">
						<li class="nav-item"><a class="nav-link" data-toggle="tab"
							href="#generalSettings" role="tablist" aria-expanded="true">
								General Settings </a></li>
						<li class="nav-item"><a class="nav-link" data-toggle="tab"
							href="#profile" role="tablist" aria-expanded="false"> Profile </a>
						</li>
						<li class="nav-item"><a class="nav-link active" data-toggle="tab"
							href="#notificationsDiv" role="tablist" aria-expanded="false">
								Notifications </a></li>
						<li class="nav-item"><a class="nav-link " data-toggle="tab"
							href="#securityLogin" role="tablist" aria-expanded="false">
								Security & Login </a></li>
						<li class="nav-item"><a class="nav-link" data-toggle="tab"
							href="#users" role="tablist" aria-expanded="false"> Users </a></li>
						<li class="nav-item"><a class="nav-link" data-toggle="tab"
							href="#connectedAPIs" role="tablist" aria-expanded="false">
								Connected APIs </a></li>
					</ul>
				</div>

				<div class="tab-content tab-space">
					<div class="tab-pane" id="generalSettings" aria-expanded="false"></div>
					<div class="tab-pane" id="profile" aria-expanded="false"></div>
					<div class="tab-pane active" id="notificationsDiv"
						aria-expanded="false">
						@include('admin.doorder.settings.notifications')</div>

					<div class="tab-pane " id="securityLogin" aria-expanded="false"></div>
					<div class="tab-pane " id="users" aria-expanded="false"></div>
					<div class="tab-pane " id="connectedAPIs" aria-expanded="false">
						@include('admin.doorder.settings.connected_apis')
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
