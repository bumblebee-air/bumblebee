function getDetialsOfDate(date, serviceId,token,url) {
	//console.log("get details of date "+serviceId);
	//Get Date Format
	var selectedDate = new Date(date);
	var d = selectedDate.getDate();
	var m = selectedDate.getMonth();
	var y = selectedDate.getFullYear();

	const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
	var monthName = months[m];
	const days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
	var dayName = days[selectedDate.getDay()]


	console.log("job list " + serviceId+" "+date.format());
	$.ajax({
		type: "GET",
		url: url+'/get_job_list/' + '?date=' + date.format() + '&serviceId=' + serviceId,
		success: function(data) {
			console.log(data);

			if (data.jobsList.length == 0) {
				$('#calendar-modal-job-list-empty').modal();
				//console.log("before set href")
				$('#calendar-modal-job-list-empty .btn-nojob-add-calendar').attr("href",
					url+"/calendar/add_scheduled_job/" + date.format("MM-DD-YYYY") + "/" + serviceId);
				$('#calendar-modal-job-list-empty #dateSpan').html(dayName + ', ' + monthName + ' ' + d + ', ' + y);
				$('#calendar-modal-job-list-empty #date').val(date.format("MM/DD/YYYY"));
				$('#calendar-modal-job-list-empty #isDateHidden').val(1);
				$('#calendar-modal-job-list-empty #serviceId').val(serviceId);
				$("#calendar-modal-job-list-empty #jobsListTitleModalSpan").html(data.titleModal);

			} else {
				var ulContent = '';
				for (var i = 0; i < data.jobsList.length; i++) {
					var hrefA = url+"/calendar/edit_scheduled_job/"+ data.jobsList[i].id ;
					//console.log(hrefA);
					ulContent = ulContent + '<li class="list-group-item" style="background-color:'
						+ data.jobsList[i].backgroundColor
						+ '"> <a href="' +hrefA+ '">'
							+ data.jobsList[i].title
							+ '</a>  </li>';
				}

				// onclick="clickEditScheduledJob('+data.jobsList[i].id+')"
				$('#calendar-modal-job-list').modal();
				$('#calendar-modal-job-list .btn-add-calendar').attr("href",
					url+"/calendar/add_scheduled_job/"  + date.format("MM-DD-YYYY") + "/" + serviceId);
				$('#calendar-modal-job-list #dateSpan').html(dayName + ', ' + monthName + ' ' + d + ', ' + y);
				$('#calendar-modal-job-list #date').val(date.format("MM/DD/YYYY"));
				$('#calendar-modal-job-list #isDateHidden').val(1);
				$('#calendar-modal-job-list #serviceId').val(serviceId);
				$("#calendar-modal-job-list #jobsListTitleModalSpan").html(data.titleModal);

				$('#jobsListUl').html(ulContent);
			}
		}
	});

}

	function getContractsExpiredData(date,token,url){
				//console.log("get details of date "+serviceId);
		//Get Date Format
		var selectedDate = new Date(date);
		var d = selectedDate.getDate();
		var m = selectedDate.getMonth();
		var y = selectedDate.getFullYear();

		const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
		var monthName = months[m];
		const days = ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'];
		var dayName = days[selectedDate.getDay()]
		
	
	 $.ajax({
        type: "GET",
       	url: url+'/get_contract_expire/'+'?date='+date.format(),
        success: function(data) {
        	//console.log(data);
        	
        		var ulContent = '';
        		for(var i=0; i< data.jobsList.length; i++){
					ulContent = ulContent+ '<li class="list-group-item" style="background-color:'
								+data.jobsList[i].backgroundColor
								+'"> <a href="'+url+'/customers/view/'+data.jobsList[i].customerId 
								+ '" >'
								+data.jobsList[i].title 
								+' </a> </li>';
				}
        	
                    $('#calendar-modal-contract-list').modal();
                    $('#calendar-modal-contract-list #dateSpan').html(dayName+', '+monthName+' '+d+', '+y);
                    $("#calendar-modal-contract-list #contractListTitleModalSpan").html(data.titleModal);
                    
					$('#calendar-modal-contract-list #contractListUl').html(ulContent);
        	
        }
     });
	}
	
	

	
	function clickServiceGetJobList(serviceId,token,url){
		var view = $('#calendar').fullCalendar('getView');
		var viewTitle = view.title; //date
		var viewName =view.name;
		//if(viewName==='month'){
			//alert(viewTitle)
			 $.ajax({
        type: "GET",
       	url: url+'/get_job_list/?date='+viewTitle+'&serviceId='+serviceId+'&viewName='+viewName,
        success: function(data) {
        	console.log(data);
        	
        	if(data.jobsList.length==0){
                    $('#calendar-modal-job-list-empty').modal();
                    $('#calendar-modal-job-list-empty .btn-nojob-add-calendar').attr("href",
                    					url+"/calendar/add_scheduled_job/0/"+serviceId);
                    $('#calendar-modal-job-list-empty #dateSpan').html(viewTitle);
                    $('#calendar-modal-job-list-empty #date').val('');
                    $('#calendar-modal-job-list-empty #isDateHidden').val(0);
                    $('#calendar-modal-job-list-empty #serviceId').val(serviceId);
                    $("#calendar-modal-job-list-empty #jobsListTitleModalSpan").html(data.titleModal);
        	}else{
        		var ulContent = '';
        		for(var i=0; i< data.jobsList.length; i++){
					ulContent = ulContent+ '<li class="list-group-item" style="background-color:'
								+data.jobsList[i].backgroundColor
								+'"> <a href="'+url+'/calendar/edit_scheduled_job/'+data.jobsList[i].id+'">'
								+data.jobsList[i].title 
								+'</a>  </li>';
				}
        	
                    $('#calendar-modal-job-list').modal();
                    $('#calendar-modal-job-list .btn-add-calendar').attr("href",
                    					url+"/calendar/add_scheduled_job/0/"+serviceId);
                    $('#calendar-modal-job-list #dateSpan').html(viewTitle);
                    $('#calendar-modal-job-list #date').val('');
                    $('#calendar-modal-job-list #isDateHidden').val(0);
                    $('#calendar-modal-job-list #serviceId').val(serviceId);
                    $("#calendar-modal-job-list #jobsListTitleModalSpan").html(data.titleModal);
                    
					$('#jobsListUl').html(ulContent);
        	}
        }
     });   
		//}
	}