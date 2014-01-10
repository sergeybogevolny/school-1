$(document).ready(function() {

	var type =  TYPE_LIST ;
	var typeevent = TYPE_EVENT;
	$("#list-type").select2('val', type);

    $('#calendar-label').html('<i class="icon-calendar"></i>');

    var myCalendar = $(".calendar");

	// If DIV element for showing calendar is available, procceed!
	if (myCalendar.length > 0) {
		myCalendar.fullCalendar({
			// Defines the buttons and title at the top of the calendar
			header: {
				left: '',
				center: 'prev,title,next',
				right: ''
			},

			// Load events as JSON feed
			events: 'calendar-feed.php?type='+typeevent,
/*			viewDisplay: function(view) {
            if (view.name == 'month'){ //just in month view mode 
                var d = view.calendar.getDate(); //choise the date for cell customize
				//alert(getDate());
                var cell = view.dateCell(d); //get the cell location for date
                var bodyCells = view.element.find('tbody').find('td');//get all cells from current calendar
                var _element = bodyCells[cell.row*view.getColCnt() + cell.col]; //get specific cell for the date
                $(_element).css('background-color', '#FAA732'); //customize the cell
            }
       }*/
	   
 
	   
viewDisplay: function(view) {  
                    
                    if (view.name == 'month')
                    { //just in month view mode
						var start_date = $.fullCalendar.formatDate(view.start, 'yyyy-MM-dd'); // this is the first day of the current month ( you can see documentation in Fullcalender web page )
						var last_date = $.fullCalendar.formatDate(view.end, 'yyyy-MM-dd'); // this is actually the 1st day of the next month ( you can see documentation in Fullcalender web page )                          					
						var start = Date.parse(start_date)/1000;
						var end =  Date.parse(last_date)/1000;
						//console.log(con);
						$.get('calendar-feed.php',{start:start,end:end,type:typeevent} ).done(function(data){
									console.log(data);
									var jsonData = JSON.parse(data);
									console.log(jsonData);
									if( jsonData != null ){
										for (var i in jsonData) {
											var rec = jsonData[i];
											console.log(rec.length);
											//if(rec.length)
											if (view.name == 'month'){ //just in month view mode 
													var d =$.fullCalendar.parseDate(rec.start);
													//var d = view.calendar.getDate(); //choise the date for cell customize
													var cell = view.dateCell(d); //get the cell location for date
													var bodyCells = view.element.find('tbody').find('td');//get all cells from current calendar
													var _element = bodyCells[cell.row*view.getColCnt() + cell.col]; //get specific cell for the date
				
													$(_element).css('background-color', '#368EE0'); //customize the cell
													$(_element).css('cursor', 'pointer'); //customize the cell
													
													$(_element).click(function(){
														   window.location = 'calendar-detail.php?date='+rec.start+'&type='+typeevent;
														})
											 }                    
										
										}
									}else{
											var bodyCells = view.element.find('tbody').find('td');//get all cells from current calendar
											bodyCells.css('background-color', '#fff'); //customize the cell
			
									}
									
						})
			
				   }                   
		
				},	   
	   
		});

		// Remove those glosy effect on button
		$(".fc-button-effect").remove();
		// Replace next button image
		$(".fc-button-next .fc-button-content").html("<i class='icon-chevron-right'></i>");
		// Replace prev button image
		$(".fc-button-prev .fc-button-content").html("<i class='icon-chevron-left'></i>");
	}

});

function getList(){
			var listaction = $('#list-type').val();
			document.location = "calendar.php?type="+listaction;
}






