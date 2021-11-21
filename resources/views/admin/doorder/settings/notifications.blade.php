

<form method="POST"
	action="{{route('doorder_postSaveNotification', 'doorder')}}"
	method="POST" id="save_notification_settings_form">
	{{csrf_field()}}
	<div class="card" v-for="(notification, index) in customNotifications"
		:id="'notificationCardDiv'+(index)">
		<div class="card-body">
			<div class="container " style="width: 100%; max-width: 100%;">
				<div class="row">
					<div class="col-12 col-lg-7 col-md-6 d-flex form-head pl-3">
						<span> @{{index+1}} </span>
						<input type="hidden" :name="'id'+index" v-model="notification.id">
						<h5 class="singleViewSubTitleH5">Custom Notification @{{index+1}}</h5>
						<div class="togglebutton">
							<label>
								<input type="checkbox"
								:id="'customNotification' + (index)"
								v-model="notification.customNotification" value="1">
								<span class="toggle"></span>
								<input type="hidden" :name="'customNotification' + (index)" :value="notification.customNotification">
							</label>
						</div>
					</div>
					<div class="col-12 col-lg-5 col-md-6 mt-md-2 ">
						<div class="row justify-content-end float-sm-right">
							<span v-if="index==0">
								<button type="button"
									class=" btn btn-primary doorder-btn-lg doorder-btn addBtn"
									@click="clickAddNotification()">Add Notification</button>
							</span> <span v-else> <i
								class="fas fa-minus-circle removeRatePropertySizeCircle"
								@click="removeNotification(index)"></i>
							</span>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group bmd-form-group">
							<label for="notificationTypeSelect">Notification type </label>

							<div id="component_notification_type">
								<template>
									<treeselect class="form-control"
										v-model="notification.notification_type"
										:name="'notification_type' + (index)"
										:id="'notification_type' + (index)" placeholder="Select type"
										:multiple="false" :options="options" :clearable="true"
										:searchable="true" :openOnClick="true"
										:disable-branch-nodes="true" :closeOnSelect="true"
										:flat="true" :open-on-focus="true" :always-open="false"
										:normalizer="normalizer">
									<div slot="value-label" slot-scope="{ node }">@{{node.raw.customLabel}}</div>

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
							<label for="notification_name">Notification name </label> <input
								type="text" class="form-control"
								:name="'notification_name' + (index)"
								:id="'notification_name' + (index)"
								v-model="notification.notification_name" value=""
								placeholder="Notification name" required>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group bmd-form-group">

							<label for="notification_channel">Notification channel </label>
							<treeselect2 class="form-control"
								:name="'notification_channel' + (index)"
								:id="'notification_channel' + (index)"
								v-model="notification.notification_channel"
								placeholder="Select channel" :multiple="false"
								:options="optionschannel" :clearable="true" :searchable="true"
								:openOnClick="true" :disable-branch-nodes="true"
								:closeOnSelect="true" :flat="false" :open-on-focus="true"
								:always-open="false" @select="onChangeChannel(index)"/>
						</div>
					</div>

					<div class="col-sm-6">
						<div class="form-group bmd-form-group"
							v-if="notification.notification_channel=='sms'">
							<label>
								Phone number <li class="fa fa-plus-circle addCircle" @click="addPhone(index)"></li>
							</label>
							<div v-for="(phone_number, phone_index) in notification.phone_number">
								<input type="tel" :name="'phone_number' + (index) + '[]'" :class="phone_number == 0 ? 'form-control' : 'form-control mt-2'" :id="'phone_number' + (index) + '_' + phone_index" v-model="phone_number.value" required />
{{--								<input type="hidden" :name="'phone_number' + (index) + '[]'">--}}
								<span style="float: right; margin-top: -32px; margin-left: -20px;cursor: pointer" v-if="phone_index !== 0" @click="removePhone(index,phone_index)">
									<i class="fas fa-times-circle" style="color: #df5353"></i>
								</span>
							</div>
						</div>
						<div class="form-group bmd-form-group"
							v-if="notification.notification_channel=='email'">
							<label>
								Email <li class="fa fa-plus-circle addCircle" @click="addEmail(index)"></li>
							</label>
							<div v-for="(email, email_index) in notification.email">
								<input type="email" :class="email_index == 0 ? 'form-control' : 'form-control mt-2'"
									   :name="'email' + (index) + '[]'" :id="'email' + (index)"
									   v-model="email.value" required/>
								<span style="float: right; margin-top: -30px; margin-right: 10px;cursor: pointer" v-if="email_index !== 0" @click="removeEmail(index,email_index)">
									<i class="fas fa-times-circle" style="color: #df5353"></i>
								</span>
							</div>

						</div>
						<div class="form-group bmd-form-group"
							v-if="notification.notification_channel=='platform'">
							<label>User type</label>
							<treeselectuser class="form-control"
								:name="'user_type'+(index)+'[]'" :id="'user_type' + (index)"
								v-model="notification.user_type"
								placeholder="Select user type" :multiple="true"
								:options="optionsusers" :clearable="true" :searchable="true"
								:openOnClick="true" :disable-branch-nodes="true"
								:closeOnSelect="false" :flat="false" :open-on-focus="true"
								:always-open="false" search-nested :normalizer="normalizer"/>
							<div slot="value-label" slot-scope="{ node }">@{{node.raw.customLabel}}</div>

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
							v-else ></div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<div class="form-group bmd-form-group">
							<label for="notification_content">Notification content </label>
							<textarea class="form-control"
								:name="'notification_content' + (index)"
								:id="'notification_content' + (index)"
								v-model="notification.notification_content" rows="5"
								placeholder="Notification content" required></textarea>
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