@extends('templates.doom_yoga-meeting')
@section('title', 'DoOmYoga | Join Event')

@section('page-styles')
	<link type="text/css" rel="stylesheet" href="https://source.zoom.us/1.9.7/css/bootstrap.css" />
	<link type="text/css" rel="stylesheet" href="https://source.zoom.us/1.9.7/css/react-select.css" />
	<meta name="format-detection" content="telephone=no">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<meta http-equiv="origin-trial" content="">
@endsection

@section('page-content')

@endsection

@section('page-scripts')
	<script src="https://source.zoom.us/1.9.7/lib/vendor/react.min.js"></script>
	<script src="https://source.zoom.us/1.9.7/lib/vendor/react-dom.min.js"></script>
	<script src="https://source.zoom.us/1.9.7/lib/vendor/redux.min.js"></script>
	<script src="https://source.zoom.us/1.9.7/lib/vendor/redux-thunk.min.js"></script>
	<script src="https://source.zoom.us/1.9.7/lib/vendor/lodash.min.js"></script>
	<script src="https://source.zoom.us/zoom-meeting-1.9.7.min.js"></script>
	<script type="text/javascript">
		window.addEventListener('DOMContentLoaded', function(event) {
			console.log('DOM fully loaded and parsed');
			websdkready();
		});

		function websdkready() {
			let meetingConfig = {
				apiKey: '{{$api_key}}',
				meetingNumber: '{{$meeting_number}}',
				passWord: '{{$meeting_password}}',
				userName: '{{$user_name}}',
				leaveUrl: '{{$leave_url}}',
				role: parseInt('{{$role}}'),
				userEmail: '{{$user_email}}',
				lang: '{{$lang}}',
				signature: '{{$signature}}',
				china: 0,
			};

			console.log(JSON.stringify(ZoomMtg.checkSystemRequirements()));

			// it's option if you want to change the WebSDK dependency link resources. setZoomJSLib must be run at first
			// ZoomMtg.setZoomJSLib("https://source.zoom.us/1.9.7/lib", "/av"); // CDN version defaul
			if (meetingConfig.china)
				ZoomMtg.setZoomJSLib("https://jssdk.zoomus.cn/1.9.7/lib", "/av"); // china cdn option
			ZoomMtg.preLoadWasm();
			ZoomMtg.prepareJssdk();
			function beginJoin(signature) {
				ZoomMtg.init({
					leaveUrl: meetingConfig.leaveUrl,
					webEndpoint: meetingConfig.webEndpoint,
					disableCORP: !window.crossOriginIsolated, // default true
					// disablePreview: false, // default false
					success: function () {
						console.log(meetingConfig);
						console.log("signature", signature);
						ZoomMtg.i18n.load(meetingConfig.lang);
						ZoomMtg.i18n.reload(meetingConfig.lang);
						ZoomMtg.join({
							meetingNumber: meetingConfig.meetingNumber,
							userName: meetingConfig.userName,
							signature: signature,
							apiKey: meetingConfig.apiKey,
							userEmail: meetingConfig.userEmail,
							passWord: meetingConfig.passWord,
							success: function (res) {
								console.log("join meeting success");
								console.log("get attendeelist");
								ZoomMtg.getAttendeeslist({});
								ZoomMtg.getCurrentUser({
									success: function (res) {
										console.log("success getCurrentUser", res.result.currentUser);
									},
								});
							},
							error: function (res) {
								console.log(res);
							},
						});
					},
					error: function (res) {
						console.log(res);
					},
				});

				ZoomMtg.inMeetingServiceListener('onUserJoin', function (data) {
					console.log('inMeetingServiceListener onUserJoin', data);
				});

				ZoomMtg.inMeetingServiceListener('onUserLeave', function (data) {
					console.log('inMeetingServiceListener onUserLeave', data);
				});

				ZoomMtg.inMeetingServiceListener('onUserIsInWaitingRoom', function (data) {
					console.log('inMeetingServiceListener onUserIsInWaitingRoom', data);
				});

				ZoomMtg.inMeetingServiceListener('onMeetingStatus', function (data) {
					console.log('inMeetingServiceListener onMeetingStatus', data);
				});
			}

			beginJoin(meetingConfig.signature);
		}
	</script>
@endsection
