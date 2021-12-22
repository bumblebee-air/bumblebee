@extends('templates.dashboard')
@section('title', 'GardenHelp | Settings')

@section('page-styles')
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/@riophae/vue-treeselect@^0.4.0/dist/vue-treeselect.min.css">
    <link rel="stylesheet" href="{{asset('css/intlTelInput.css')}}">
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
            /*border-radius: 11.2px 0;*/
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

        #navSettingsUl li a.active {
            color: #60a244 !important;
            box-shadow: none !important;
        }

        #navSettingsUl li a:hover, #navSettingsUl li a.active:hover {
            color: white !important;
        }

        .tab-space {
            padding: 0 !important;
        }

        .togglebutton {
            margin-top: -3px;
        }

        .togglebutton label .toggle, .togglebutton label input[type=checkbox][disabled] + .toggle {
            width: 45px;
            height: 20px;
            margin-left: 30px;
            background-color: #b2b2b2
        }

        .togglebutton label input[type=checkbox] + .toggle:after {
            border-color: #b2b2b2;
        }

        .togglebutton label input[type=checkbox]:checked + .toggle {
            background-color: #60a244;
        }

        .togglebutton label .toggle:after {
            box-shadow: none;
            left: 0;
            top: -5px;
        }

        .toggleButtonConnectedApi label .toggle:after {
            top: 0 !important;
        }

        .togglebutton label input[type=checkbox]:checked + .toggle:after {
            border-color: #60a244;
            left: 24px;
        }

        .togglebutton label input[type=checkbox] + .toggle:active:after,
        .togglebutton label input[type=checkbox][disabled] + .toggle:active:after,
        .togglebutton label input[type=checkbox]:checked + .toggle:active:after {
            box-shadow: none !important;
        }

        .dropdown-menu .dropdown-item, .dropdown-menu li > a {
            font-family: Quicksand;
            font-size: 14px;
            font-weight: normal;
            font-stretch: normal;
            font-style: normal;
            line-height: normal;
            letter-spacing: normal;
            color: #494949;
            text-transform: inherit;
        }

        .filter-option-inner {
            text-transform: none;
        }

        .bootstrap-select .dropdown-item.active, .bootstrap-select .dropdown-item:hover {
            font-size: 14px;
            font-weight: 600;
            color: white;
            box-shadow: none !important;
        }

        .dropdown-menu .dropdown-item:focus, .dropdown-menu .dropdown-item:hover,
        .dropdown-menu a:active, .dropdown-menu a:focus, .dropdown-menu a:hover {
            background: #60a244;
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
            background: #60a244;
            font-weight: bold;
            color: white;
            box-shadow: none !important;
        }

        .vue-treeselect__menu li:hover .vue-treeselect__label,
        .vue-treeselect__option--highlight .vue-treeselect__label,
        .vue-treeselect--single .vue-treeselect__option--selected .vue-treeselect__label {
            font-weight: bold !important;
            color: white !important;
            box-shadow: none !important;
        }

        .vue-treeselect__option--highlight, .vue-treeselect--single .vue-treeselect__option--selected {
            background: #60a244 !important;
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
            color: #60a244;
        }

        .nav-pills:not(.flex-column) .nav-item + .nav-item:not(:first-child) {
            margin-left: 0 !important;
        }

        .iti {
            width: 100%;
        }

        .card #usersTable tr td:first-child, .card #usersTable tr th:first-child {
            text-align: left;
        }

        #usersTable .nameSpan {
            font-weight: 700 !important;
            color: #4D4D4D !important;
            height: 1.5rem;
        }

        .addUserModalHeader, .editUserModalHeader {
            font-family: Quicksand;
            font-style: normal;
            font-weight: bold;
            font-size: 20px;
            line-height: 19px;
            letter-spacing: 0.8px;
            color: #000000;
        }

        #add-user-modal #addUserBtn, #edit-user-modal #editUserBtn {
            height: 40px;
            text-transform: capitalize;
            padding: 8px;
        }

        .dataTables_empty {
            text-align: center !important;
        }

        /*
        .toggleButtonGeneralSettings label .toggle:after {
            top: 0 !important;
        }
        .toggleButtonGeneralSettings label .toggle, .toggleButtonGeneralSettings label input[type=checkbox][disabled]+.toggle
            {width: 50px !important;
            }

        .toggleButtonGeneralSettings label input[type=checkbox]:checked+.toggle:after {
            border-color: #f7dc69;
            left: 35px;
            content: "on";
        }
        .toggleButtonGeneralSettings label input[type=checkbox]+.toggle:after {
            content: "off";
        }	 */
        .btn-default.toggle-off, .btn-default.toggle-off:hover {
            background-color: #656565 !important;
            border-color: #656565 !important
        }

        .toggle-handle {
            background: white !important;
            border-radius: 50% !important;
            height: 95% !important;
            padding: 0 !important;
            width: 30px !important;
            top: 1px;
        }

        .toggle-handle:before {
            border-radius: 50% !important;
        }

        .toggle-on, .toggle-off, .toggle {
            border-radius: 25px !important;
        }

        .toggle .toggle-handle {
            left: -17px;
        }

        .toggle.off .toggle-handle {
            left: 17px;
        }

        .toggle-on.btn-sm {
            padding-right: 40px !important;
        }

        .toggle-off.btn-sm {
            padding-left: 40px !important;
        }

        label.toggle-on, label.toggle-off {
            font-family: Quicksand;
            font-style: normal;
            font-weight: bold;
            font-size: 15px !important;
            line-height: 22px;
            color: #FFFFFF;
        }

        #uploadButton {
            height: 38px !important;
            margin-top: 0;
            box-shadow: 0px 2px 4px rgb(182 182 182 / 50%), 2px 2px 5px #ffffff;
            background-color: white !important;
        }

        .form-head span {
            background-color: #60a244;
        }
    </style>

@endsection
@section('page-content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12" id="settingsCardDiv">
                    <div class="card">
                        <div class="card-header card-header-icon card-header-rose row">
                            <div class="col-12 col-lg-5 col-md-6">
                                <div class="card-icon">
                                    <img class="page_icon"
                                         src="{{asset('images/gardenhelp_icons/notifications_icon.png')}}"
                                         alt="settings icon">
                                </div>
                                <h4 class="card-title ">Notification</h4>
                            </div>
                            <div class="col-12 mt-md-4 ">
                                <form method="POST"
                                      action="{{route('gardenhelp_postSaveNotification', 'garden-help')}}"
                                      method="POST" id="save_notification_settings_form">
                                    {{csrf_field()}}
                                    <div class="card pt-3" v-for="(notification, index) in customNotifications"
                                         :id="'notificationCardDiv'+(index)">
                                        <div class="card-body">
                                            <div class="container " style="width: 100%; max-width: 100%;">
                                                <div class="row">
                                                    <div class="col-12 col-lg-7 col-md-6 d-flex form-head pl-3 align-items-center">
                                                        <span style="margin-top: -11px;"> @{{index+1}} </span>
                                                        <input type="hidden" :name="'id'+index"
                                                               v-model="notification.id">
                                                        <h5 class="singleViewSubTitleH5">Custom Notification
                                                            @{{index+1}}</h5>
                                                        <div class="togglebutton">
                                                            <label>
                                                                <input type="checkbox"
                                                                       :id="'customNotification' + (index)"
                                                                       v-model="notification.customNotification"
                                                                       value="1">
                                                                <span class="toggle"></span>
                                                                <input type="hidden"
                                                                       :name="'customNotification' + (index)"
                                                                       :value="notification.customNotification">
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-lg-5 col-md-6 mt-md-2">
                                                        <div class="row justify-content-end float-sm-right">
                                                            <span v-if="index==0">
                                                                <button type="button"
                                                                        class=" btn btn-primary addBtn"
                                                                        @click="clickAddNotification()">Add Notification</button>
                                                            </span>
                                                            <span v-else> <i
                                                                        class="fas fa-minus-circle removeRatePropertySizeCircle"
                                                                        @click="removeNotification(index)"></i>
							                                </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group bmd-form-group">
                                                            <label for="notificationTypeSelect">Notification
                                                                type </label>

                                                            <div id="component_notification_type">
                                                                <template>
                                                                    <treeselect class="form-control"
                                                                                v-model="notification.notification_type"
                                                                                :name="'notification_type' + (index)"
                                                                                :id="'notification_type' + (index)"
                                                                                placeholder="Select type"
                                                                                :multiple="false" :options="options"
                                                                                :clearable="true"
                                                                                :searchable="true" :openOnClick="true"
                                                                                :disable-branch-nodes="true"
                                                                                :closeOnSelect="true"
                                                                                :flat="true" :open-on-focus="true"
                                                                                :always-open="false"
                                                                                :normalizer="normalizer">
                                                                        <div slot="value-label" slot-scope="{ node }">
                                                                            @{{node.raw.customLabel}}
                                                                        </div>

                                                                    </treeselect>
                                                                </template>
                                                            </div>


                                                        </div>

                                                    </div>
                                                    <!-- <div class="col-sm-6">
                                                        <div class="form-group bmd-form-group">
                                                            <label></label>
                                                            <div id="notificationSubTypeDiv"></div>
                                                        </div>
                                                    </div> -->
                                                    <div class="col-sm-6">
                                                        <div class="form-group bmd-form-group">
                                                            <label for="notification_name">Notification name </label>
                                                            <input
                                                                    type="text" class="form-control"
                                                                    :name="'notification_name' + (index)"
                                                                    :id="'notification_name' + (index)"
                                                                    v-model="notification.notification_name" value=""
                                                                    placeholder="Notification name" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group bmd-form-group">

                                                            <label for="notification_channel">Notification
                                                                channel </label>
                                                            <treeselect2 class="form-control"
                                                                         :name="'notification_channel' + (index)"
                                                                         :id="'notification_channel' + (index)"
                                                                         v-model="notification.notification_channel"
                                                                         placeholder="Select channel" :multiple="false"
                                                                         :options="optionschannel" :clearable="true"
                                                                         :searchable="true"
                                                                         :openOnClick="true"
                                                                         :disable-branch-nodes="true"
                                                                         :closeOnSelect="true" :flat="false"
                                                                         :open-on-focus="true"
                                                                         :always-open="false"
                                                                         @select="onChangeChannel(index)"/>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <div class="form-group bmd-form-group"
                                                             v-if="notification.notification_channel=='sms'">
                                                            <label>
                                                                Phone number
                                                                <li class="fa fa-plus-circle addCircle"
                                                                    @click="addPhone(index)"></li>
                                                            </label>
                                                            <div v-for="(phone_number, phone_index) in notification.phone_number">
                                                                <input type="tel"
                                                                       :name="'phone_number' + (index) + '[]'"
                                                                       :class="phone_number == 0 ? 'form-control' : 'form-control mt-2'"
                                                                       :id="'phone_number' + (index) + '_' + phone_index"
                                                                       v-model="phone_number.value" required/>
                                                                {{--								<input type="hidden" :name="'phone_number' + (index) + '[]'">--}}
                                                                <span style="float: right; margin-top: -32px; margin-left: -20px;cursor: pointer"
                                                                      v-if="phone_index !== 0"
                                                                      @click="removePhone(index,phone_index)">
                                                                    <i class="fas fa-times-circle" style="color: #df5353"></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group bmd-form-group"
                                                             v-if="notification.notification_channel=='email'">
                                                            <label>
                                                                Email
                                                                <li class="fa fa-plus-circle addCircle"
                                                                    @click="addEmail(index)"></li>
                                                            </label>
                                                            <div v-for="(email, email_index) in notification.email">
                                                                <input type="email"
                                                                       :class="email_index == 0 ? 'form-control' : 'form-control mt-2'"
                                                                       :name="'email' + (index) + '[]'"
                                                                       :id="'email' + (index)"
                                                                       v-model="email.value" required/>
                                                                <span style="float: right; margin-top: -30px; margin-right: 10px;cursor: pointer"
                                                                      v-if="email_index !== 0"
                                                                      @click="removeEmail(index,email_index)">
                                                                    <i class="fas fa-times-circle" style="color: #df5353"></i>
                                                                </span>
                                                            </div>

                                                        </div>
                                                        <div class="form-group bmd-form-group"
                                                             v-if="notification.notification_channel=='platform'">
                                                            <label>User type</label>
                                                            <treeselectuser class="form-control"
                                                                            :name="'user_type'+(index)"
                                                                            :id="'user_type' + (index)"
                                                                            v-model="notification.user_type"
                                                                            placeholder="Select user type"
                                                                            :multiple="false"
                                                                            :options="optionsusers" :clearable="true"
                                                                            :searchable="true"
                                                                            :openOnClick="true"
                                                                            :disable-branch-nodes="true"
                                                                            :closeOnSelect="false" :flat="false"
                                                                            :open-on-focus="true"
                                                                            :always-open="false" search-nested
                                                                            :normalizer="normalizer"/>
                                                            <div slot="value-label" slot-scope="{ node }">
                                                                @{{node.raw.customLabel}}
                                                            </div>

                                                            {{-- </treeselectuser> --}}
                                                            {{-- <treeselect
                                                                :name="user_type"
                                                                :multiple="false"
                                                                :clearable="true"
                                                                :searchable="true"
                                                                :disabled="false"
                                                                :open-on-click="true"
                                                                :open-on-focus="false"
                                                                :clear-on-select="false"
                                                                :close-on-select="true"
                                                                :always-open="false"
                                                                :options="optionsusers"
                                                                :limit="3"
                                                                :max-height="200"
                                                                v-model="notification.user_type"
                                                                /> --}}

                                                        </div>
                                                        <div class="form-group bmd-form-group"
                                                             v-else></div>
                                                    </div>
                                                </div>
                                                <div class="row"
                                                     v-if="notification.notification_type=='new_order' || notification.notification_type=='external_store_fulfillment'">
                                                    <div class="col-sm-6">
                                                        <div class="form-group bmd-form-group">
                                                            <label for="retailer">Retailer </label>
                                                            <treeselectretailer class="form-control"
                                                                                :name="'retailer' + (index)+'[]'"
                                                                                :id="'retailer' + (index)"
                                                                                v-model="notification.retailer"
                                                                                placeholder="Select retailer(s)"
                                                                                :multiple="true"
                                                                                :options="optionsretailer"
                                                                                :clearable="true" :searchable="true"
                                                                                :openOnClick="true"
                                                                                :disable-branch-nodes="true"
                                                                                :closeOnSelect="true" :flat="false"
                                                                                :open-on-focus="true"
                                                                                :always-open="false"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="form-group bmd-form-group">
                                                            <label for="notification_content">Notification
                                                                content </label>
                                                            <textarea class="form-control pl"
                                                                      :name="'notification_content' + (index)"
                                                                      :id="'notification_content' + (index)"
                                                                      v-model="notification.notification_content"
                                                                      rows="5"
                                                                      placeholder="Notification content"
                                                                      required></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="indexes" :value="customNotifications.length">
                                    </div>

                                    <div class="row ">
                                        <div class="col text-center">


                                            <button class="btn bt-submit">Save</button>

                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>

                    {{--                    <div>--}}
                    {{--                        <ul class="nav nav-pills nav-pills-primary justify-content-start justify-content-md-center"--}}
                    {{--                                role="tablist" id="navSettingsUl">--}}
                    {{--                            <li class="nav-item"><a class="nav-link active" data-toggle="tab"--}}
                    {{--                                                    href="#generalSettings" role="tablist" aria-expanded="true">--}}
                    {{--                                    General Settings </a></li>--}}
                    {{--                            <li class="nav-item"><a class="nav-link" data-toggle="tab"--}}
                    {{--                                                    href="#profile" role="tablist" aria-expanded="false"> Profile </a>--}}
                    {{--                            </li>--}}
                    {{--                            <li class="nav-item">--}}
                    {{--                                <a class="nav-link active" data-toggle="tab" href="#notificationsDiv" role="tablist" aria-expanded="false">--}}
                    {{--                                    Notifications--}}
                    {{--                                </a>--}}
                    {{--                            </li>--}}
                    {{--                            <li class="nav-item"><a class="nav-link " data-toggle="tab"--}}
                    {{--                                                    href="#securityLogin" role="tablist" aria-expanded="false">--}}
                    {{--                                    Security & Login </a></li>--}}
                    {{--                            <li class="nav-item"><a class="nav-link" data-toggle="tab"--}}
                    {{--                                                    href="#users" role="tablist" aria-expanded="false"> Users </a></li>--}}
                    {{--                            <li class="nav-item"><a class="nav-link" data-toggle="tab"--}}
                    {{--                                                    href="#connectedAPIs" role="tablist" aria-expanded="false">--}}
                    {{--                                    Connected APIs </a></li>--}}
                    {{--                        </ul>--}}
                    {{--                    </div>--}}

                    {{--                    <div class="tab-content tab-space">--}}
                    {{--                        <div class="tab-pane active" id="generalSettings"--}}
                    {{--                             aria-expanded="false">--}}
                    {{--                            @include('admin.doorder.settings.general_settings')</div>--}}
                    {{--                        <div class="tab-pane" id="profile" aria-expanded="false"></div>--}}
                    {{--                        <div class="tab-pane active" id="notificationsDiv" aria-expanded="false">--}}
                    {{--                            @include('admin.garden_help.setting.notifications')</div>--}}

                    {{--                        <div class="tab-pane " id="securityLogin" aria-expanded="false"></div>--}}
                    {{--                        <div class="tab-pane " id="users" aria-expanded="false">--}}
                    {{--                            @include('admin.doorder.settings.users')</div>--}}
                    {{--                        <div class="tab-pane " id="connectedAPIs" aria-expanded="false">--}}
                    {{--                            @include('admin.doorder.settings.connected_apis')--}}
                    {{--                        </div>--}}
                    {{--                    </div>--}}
                </div>
            </div>
        </div>
    </div>
@endsection @section('page-scripts')

    <script src="{{asset('js/bootstrap-selectpicker.js')}}"></script>

    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.min.js"></script>
    <script
            src="https://cdn.jsdelivr.net/npm/@riophae/vue-treeselect@^0.4.0/dist/vue-treeselect.umd.min.js"></script>

    <script src="{{asset('js/intlTelInput/intlTelInput.js')}}"></script>

    <!-- <script src="https://cdn.jsdelivr.net/npm/v-click-outside"></script> -->
    <!-- <script type="module" -->
    <!-- 	src="https://cdn.jsdelivr.net/npm/vue-cascader-select"></script> -->

    <link
            href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css"
            rel="stylesheet">
    <script
            src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

    <script type="text/javascript">


        function addIntelInput(input_id, input_name) {
            let phone_input = document.querySelector("#" + input_id);
            window.intlTelInput(phone_input, {
                hiddenInput: input_name,
                initialCountry: 'IE',
                separateDialCode: true,
                preferredCountries: ['IE', 'GB'],
                utilsScript: "{{asset('js/intlTelInput/utils.js')}}"
            });
        }


        $(document).ready(function () {
// general settings
            addIntelInput('business_phone_number', 'business_phone_number');

            $(".timeShift").datetimepicker({
                format: "hh:mm",
                icons: {
                    time: "fa fa-clock",
                    date: "fa fa-calendar",
                    up: "fa fa-chevron-up",
                    down: "fa fa-chevron-down",
                    previous: 'fa fa-chevron-left',
                    next: 'fa fa-chevron-right',
                    today: 'fa fa-screenshot',
                    clear: 'fa fa-trash',
                    close: 'fa fa-remove'
                },
            });


//////////////////// users tab
            var table = $('#usersTable').DataTable({
                "pagingType": "full_numbers",
                "lengthMenu": [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ],
                responsive: true,
                "language": {
                    search: '',
                    "searchPlaceholder": "Search ",
                },
                "columnDefs": [{
                    "targets": -1,
                    "orderable": false
                }],
                "initComplete": function () {

                }
            });

            $(".filterhead").each(function (i) {
                if (i == 2) {
                    var select = $('<select ><option value="">Select user type</option></select>')
                        .appendTo($(this).empty())
                        .on('change', function () {
                            var term = $(this).val();
                            table.column(i).search(term, false, false).draw();
                        });
                    table.column(i).data().unique().sort().each(function (d, j) {
                        select.append('<option value="' + d + '">' + d + '</option>')
                    });
                } else {
                    $(this).empty();
                }
            });

////////////////////// end users tab
        });

        function changeToggleRetAutoCharging() {
            console.log($("#retailerAutomaticCharging:checked").val())
            if ($("#retailerAutomaticCharging:checked").val() == 1) {
                $("#dayOfMonthDiv").css("display", "block");
            } else {
                $("#dayOfMonthDiv").css("display", "none");
                $("#dayOfMonth").val("")
            }
        }

        function changeToggleDelivererPayout() {
            console.log($("#delivererPayout").val())
            if ($("#delivererPayout:checked").val() == 1) {
                $("#dayOfWeekDiv").css("display", "block");
            } else {
                $("#dayOfWeekDiv").css("display", "none");
                $("#weekday").val("")
            }
        }

        Vue.use('vue-cascader-select');
        Vue.component('treeselect', VueTreeselect.Treeselect);
        Vue.component('treeselect2', VueTreeselect.Treeselect);
        Vue.component('treeselectuser', VueTreeselect.Treeselect);
        Vue.component('treeselectretailer', VueTreeselect.Treeselect);

        var app = new Vue({
            el: '#app',

            data: {
                users: {!! $users !!},

                //customNotifications:[{"customNotification":"","notification_type":null,"notification_name":"","notification_channel":null,"phone_number":"","email":"","user_type":null,"notification_content":""}],
                customNotifications: {!! count($savedNotifications) ? json_encode($savedNotifications) : '[{"id":null,"customNotification":"1","notification_type":null,"notification_name":"","notification_channel":null,"phone_number":[{value: ""}],"email":[{value: ""}],"user_type":null,"notification_content":""}]' !!},
                // define the default value
                notification_type: null,
                notification_channel: null,
                user_type: null,

                // define options
                options: [{
                    id: 'registrations',
                    label: 'Registrations',
                    children: [{
                        id: 'new_customer',
                        label: 'New Customer',
                        customLabel: 'Registrations, New Customer'
                    }, {
                        id: 'new_contractor',
                        label: 'New Contractor',
                        customLabel: 'Registrations, New Contractor'
                    }],
                }, {
                    id: 'service_types',
                    label: 'Service Types',
                    children: [
                        @foreach(\App\ServiceType::all() as $service_type)
                        {
                            id: 'service_type_{!! str_replace(' ', '_', $service_type->name) !!}',
                            label: '{!! $service_type->name !!}',
                            customLabel: 'Service Delivery, {!! $service_type->name !!}'
                        }
                        @endforeach
                    ],
                }, {
                    id: 'payments',
                    label: 'Payments',
                    customLabel: 'Payments'
                }],

                optionschannel: [{
                    id: 'sms',
                    label: 'SMS',
                }, {
                    id: 'email',
                    label: 'Email',
                }, {
                    id: 'platform',
                    label: 'Platform notification',
                }

                ],
                optionsusers: [
                    {
                        id: 'admin',
                        label: 'Admin',
                        children: {!! $adminOptions !!}
                    },
                    {
                        id: 'call_center',
                        label: 'Call center',
                        children: {!! $callCenterOptions !!}
                    }

                ],
                optionsretailer: {!! $retailersOptions !!}

            },
            mounted() {
                //Intl input
                // setTimeout(() => {
                //    for (let notification of this.customNotifications) {
                // 	   let notification_index = this.customNotifications.indexOf(notification);
                // 	   let channel_type = this.customNotifications[notification_index].notification_channel;
                // 	   let phone_numbers = this.customNotifications[notification_index].phone_number;
                // 	   if (channel_type === 'sms') {
                // 		   let phone_index = 0;
                // 		   for (let phone of phone_numbers) {
                // 			   this.addIntlPhoneInput('phone_number' + notification_index + '_' + phone_index, 'phone_number' + notification_index + '[]');
                // 			   phone_index++;
                // 		   }
                // 	   }
                //    }
                // });
            },
            methods: {
                normalizer(node) {
                    return {
                        id: node.id,
                        label: node.label,
                        customLabel: node.customLabel,
                        children: node.children,
                    }
                },
                clickAddNotification() {
                    this.customNotifications.push({
                        id: null,
                        customNotification: '1',
                        notification_type: null,
                        notification_name: '',
                        notification_channel: null,
                        phone_number: [{value: ''}],
                        email: [{value: ''}],
                        user_type: null,
                        notification_content: ''
                    })
                },
                removeNotification(index) {
                    this.customNotifications.splice(index, 1);
                },
                addEmail(notification_index) {
                    this.customNotifications[notification_index].email.push({value: ""});
                },
                removeEmail(notification_index, item_index) {
                    this.customNotifications[notification_index].email.splice(item_index, 1);
                },
                addPhone(notification_index) {
                    this.customNotifications[notification_index].phone_number.push({value: ""});
                    //Intlinput code
                    // setTimeout(() => {
                    // 	let phone_index = this.customNotifications[notification_index].phone_number.length -1;
                    // 	this.addIntlPhoneInput('phone_number' + notification_index + '_' + phone_index, 'phone_number' + notification_index + '[]')
                    // }, 300);
                },
                removePhone(notification_index, item_index) {
                    this.customNotifications[notification_index].phone_number.splice(item_index, 1);
                },
                onChangeChannel(notification_index) {
                    //Intlinput
                    // setTimeout(() => {
                    // 	let channel_type = this.customNotifications[notification_index].notification_channel;
                    // 	let phone_numbers = this.customNotifications[notification_index].phone_number;
                    // 	if (channel_type === 'sms') {
                    // 		let phone_index = 0;
                    // 		for (let phone of phone_numbers) {
                    // 			this.addIntlPhoneInput('phone_number' + notification_index + '_' + phone_index, 'phone_number' + notification_index + '[]');
                    // 			phone_index++;
                    // 		}
                    // 	}
                    // }, 300);
                },
                addIntlPhoneInput(input_id, name) {
                    let phone_input = document.getElementById(input_id);
                    intlTelInput(phone_input, {
                        hiddenInput: name,
                        initialCountry: 'IE',
                        separateDialCode: true,
                        preferredCountries: ['IE', 'GB'],
                        utilsScript: "{{asset('js/intlTelInput/utils.js')}}"
                    });
                },
                clickEditUser(user_id, name, email, user_type) {
                    console.log("edit user ", user_id, name, email, user_type);

                    $("#edit-user-modal").modal('show');
                    $("#edit-user-modal #userId").val(user_id);
                    $("#edit-user-modal #user_nameEdit").val(name);
                    $("#edit-user-modal #emailEdit").val(email);
                    $("#edit-user-modal #userTypeSelectEdit").val(user_type);
                    $('#edit-user-modal .selectpicker').selectpicker('refresh')
                },
                clickDeleteUser(userId) {
                    console.log("delete user ", userId);

                    $('#delete-user-modal').modal('show')
                    $('#delete-user-modal #userId').val(userId);
                },
                clickAddUser() {
                    console.log("click add user");
                    $("#add-user-modal").modal('show');
                }
            }
        });

        /* function changeNotificationType(){
            var notificationType = $('#notificationTypeSelect').val();
            console.log(notificationType);

            if(notificationType=="registrations"){

                $("#notificationSubTypeDiv").html('<select name="notification_sub_type"  required="required" id="notificationSubTypeSelect" '
                                            +' data-style="select-with-transition" class="form-control selectpicker">'
                                            + '<option value="new_retailer">New retailer</option>'
                                            + '<option value="new_deliverer">New deliverer</option>'
                                            + '</select>');
                                            $('#notificationSubTypeSelect').selectpicker();
            }else if(notificationType=="service_delivery"){

                $("#notificationSubTypeDiv").html('<select name="notification_sub_type"  required="required" id="notificationSubTypeSelect" '
                                            +' data-style="select-with-transition" class="form-control selectpicker">'
                                            + '<option value="new_order">New order</option>'
                                            + '<option value="order_completed">Order completed</option>'
                                            + '<option value="collection_delay">Collection delay</option>'
                                            + '</select>');
                                            $('#notificationSubTypeSelect').selectpicker();
            }else{
                $("#notificationSubTypeDiv").html('');
            }
        } */

        function changeNotificationSubType() {
            var notificationChannel = $('#notificationChannelSelect').val();
            console.log(notificationChannel);

            if (notificationChannel == 'sms') {
                $('#notificationChannelDataDiv').html('<label>Phone number</label><input type="tel" class="form-control" name="phone_number" />')
            } else if (notificationChannel == 'email') {
                $('#notificationChannelDataDiv').html('<label>Email</label><input type="email" class="form-control" name="email" />')
            } else if (notificationChannel == 'platform') {
                $('#notificationChannelDataDiv').html('platform')
            } else {
                $('#notificationChannelDataDiv').html('')
            }
        }

        function addFile(id) {
            $('#' + id).click();
        }

        function onChangeFile(e, id) {
            console.log($(e));
            console.log($(e).files)
            $("#" + id).val(e.target.files[0].name);
        }

    </script>

@endsection

