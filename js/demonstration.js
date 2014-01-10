/*
	FLAT Theme v.1.4
	*/

	var onlineUserArray = [255,455,385,759,500,284,581,684,255,455,385,759,500,293,585,342,684];
	function getUser(){
		var min = 300,
		max = 600;
		var currentRandom = Math.floor(Math.random() * (max - min + 1)) + min;
		onlineUserArray.shift();
		onlineUserArray.push(currentRandom);

		return onlineUserArray;
	}

	function createOnlineUserStatistic(){
		var $el = $("#online-users"),
		userData = getUser();

		$el.sparkline(userData, {
			width: ($("#left").width() > 200) ? 100 : $("#left").width() - 100,
			height: '25px',
			enableTagOptions: true
		});

		$el.prev().html(userData[userData.length - 1]);

		setTimeout(function(){
			createOnlineUserStatistic();
		}, 2000);
	}

	var balanceArray = [255,455,385,759,500,284,581,684,255,455,385,759,500,293,585,342,684];
	function getBalance(){
		var min = 500,
		max = 750;
		var currentRandom = Math.floor(Math.random() * (max - min + 1)) + min;
		balanceArray.shift();
		balanceArray.push(currentRandom);

		return balanceArray;
	}

	function createBalanceStatistic(){
		var $el = $("#balance"),
		balanceData = getBalance();

		$el.sparkline(balanceData, {
			height: '25px',
			barWidth: ($("#left").width() > 200) ? 4 : Math.floor(($("#left").width() - 100)/17)-1,
			enableTagOptions: true
		});

		$el.prev().html("$"+balanceData[balanceData.length - 1]);

		setTimeout(function(){
			createBalanceStatistic();
		}, 3000);
	}

	function moneyRandom(){
		var $el = $(".stats .icon-money").parent().find(".details .big");
		if($el.length > 0){
			var current = parseFloat($el.html().replace("$","").replace(",",".")),
			randomOperation = (Math.random() * 10),
			operation = 1;
			if(randomOperation >= 5){
				operation = -1;
			}
			current += (operation) * Math.floor(Math.random() * 10);
			$el.html("$"+current.toFixed(2).toString().replace(".",","));
			setTimeout(function(){
				moneyRandom();
			}, 2500);
		}
	}

	function currentTime(){
		var $el = $(".stats .icon-calendar").parent(),
		currentDate = new Date(),
		monthNames = [ "January", "February", "March", "April", "May", "June",
		"July", "August", "September", "October", "November", "December" ],
		dayNames = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];

		$el.find(".details .big").html(monthNames[currentDate.getMonth()] + " " + currentDate.getDate() + ", " + currentDate.getFullYear());
		$el.find(".details span").last().html(dayNames[currentDate.getDay()] + ", " + currentDate.getHours()+":"+ ("0" + currentDate.getMinutes()).slice(-2));
		setTimeout(function(){
			currentTime();
		}, 10000);
	}

	function showTooltip(x, y, contents) {
		$('<div id="tooltip" class="flot-tooltip tooltip"><div class="tooltip-arrow"></div>' + contents + '</div>').css( {
			top: y - 43,
			left: x - 15,
		}).appendTo("body").fadeIn(200);
	}

	function randomFeed(){
		var $el = $("#randomFeed");
		var random = new Array('<span class="label"><i class="icon-plus"></i></span> <a href="#">John Doe</a> added a new photo','<span class="label label-success"><i class="icon-user"></i></span> New user registered','<span class="label label-info"><i class="icon-shopping-cart"></i></span> New order received','<span class="label label-warning"><i class="icon-comment"></i></span> <a href="#">John Doe</a> commented on <a href="#">News #123</a>'),
		auto = $el.parents(".box").find(".box-title .actions .custom-checkbox").hasClass("checkbox-active");
		var randomIndex = Math.floor(Math.random() * 4);
		var newElement = random[randomIndex];
		if(auto){
			$el.prepend("<tr><td>"+newElement+"</td></tr>").find("tr").first().hide();
			$el.find("tr").first().fadeIn();
			if($el.find("tbody tr").length > 20){
				$el.find("tbody tr").last().fadeOut(400, function(){
					$(this).remove();
				});
			}
		}

		slimScrollUpdate($el.parents(".scrollable"));

		setTimeout(function(){
			randomFeed();
		}, 3000);
	}


	$(document).ready(function() {

		var $left = $("#left");

/*
		$(".table-user .icon .btn").click(function(e){
			e.preventDefault();
			var $el = $(this);
			var $parent = $el.parents("tr");
			var name = $parent.find('td').eq(1).text(),
			img = $parent.find("td").eq(0).find("img").attr("src");
			var email = name + "@randomemailgenerated.com";
			$("#user-infos").text(name);
			$("#modal-user .dl-horizontal dd").eq(0).text(name);
			$("#modal-user .dl-horizontal dd").eq(1).text(email);
			$("#modal-user .span2 img").attr("src", img);
			$("#modal-user").modal("show");
		});
*/

		if($("#user").length > 0){
		//ajax mocks
		$.mockjaxSettings.responseTime = 500;

		$.mockjax({
			url: '/post',
			response: function(settings) {
			}
		});

		$.mockjax({
			url: '/error',
			status: 400,
			statusText: 'Bad Request',
			response: function(settings) {
				this.responseText = 'Please input correct value';
			}
		});

		$.mockjax({
			url: '/status',
			status: 500,
			response: function(settings) {
				this.responseText = 'Internal Server Error';
			}
		});

		$.mockjax({
			url: '/groups',
			response: function(settings) {
				this.responseText = [
				{value: 0, text: 'Guest'},
				{value: 1, text: 'Service'},
				{value: 2, text: 'Customer'},
				{value: 3, text: 'Operator'},
				{value: 4, text: 'Support'},
				{value: 5, text: 'Admin'}
				];
			}
		});
	}

	if($.isFunction($.mockjax)){
		$.mockjax({
			url: 'post.php',
			responseText: {
				say: 'Form was submitted!'
			}
		});
	}

	// Random money value
	//moneyRandom();
	// Set current Time
	currentTime();
	// Random feeds update
	//randomFeed();

	$("#message-form").submit(function (e) {
		e.preventDefault();
		var $el = $(this),
		randomAnswer = new Array("Lorem ipsum incididunt dolor...", "Lorem ipsum velit in incididunt id consectetur commodo.", "Lorem ipsum voluptate dolore occaecat reprehenderit anim elit nostrud.", "Lorem ipsum in dolor Excepteur et non sunt elit non officia in qui deserunt cupidatat aliquip.");
		var mess = $el.find("input[type=text]").val(),
		messageUl = $el.parents(".messages");

		if ($el.find("button").attr("disabled") == undefined) {
			var newEl = messageUl.find('.right').first().clone(),
			answer = messageUl.find('.left').first().clone();
			answer.find(".message p").html(randomAnswer[Math.floor(Math.random() * 4)]);
			answer.find(".message .time").html("Just now");
			newEl.find(".message p").html(mess);
			newEl.find(".message .time").html("Just now");
			messageUl.find(".typing").before(newEl);
			slimScrollUpdate(messageUl.parents(".scrollable"), 100000);
			$el.find("button").attr('disabled', 'disabled');
			messageUl.find(".typing").removeClass("active");
			setTimeout(function () {
				messageUl.find(".typing").addClass("active");
				messageUl.find(".typing .name").html("Jane Doe");
				slimScrollUpdate(messageUl.parents(".scrollable"), 100000);
			}, 300);

			setTimeout(function () {
				messageUl.find(".typing").before(answer);
				slimScrollUpdate(messageUl.parents(".scrollable"), 100000);
				$el.find("button").removeAttr("disabled");
				messageUl.find(".typing").removeClass("active");
			}, 1500);
		}
	});

if($("#online-users").length > 0){
	createBalanceStatistic();
	createOnlineUserStatistic();
	$left.on("resizestart", function(){
		$("#online-users").hide();
		$("#balance").hide();
	});
	$left.on("resizestop", function(){
		$("#online-users").show().sparkline(getUser(), {
			width: ($left.width() > 200) ? 100 : $left.width() - 100,
			height: '25px',
			enableTagOptions: true
		});

		$("#balance").show().sparkline(getBalance(), {
			height: '25px',
			barWidth: ($left.width() > 200) ? 4 : Math.floor(($left.width() - 100)/17)-1,
			enableTagOptions: true
		});
	});
}

	  // Flot
	  var d1 = [];
	  for (var i = 0; i <= 20; i += 1)
	  	d1.push([i, parseInt(32 + (Math.random() * 35))]);

	  var d2 = [];
	  for (var i = 0; i <= 20; i += 1)
	  	d2.push([i, parseInt(32 + (Math.random() * 55))]);

	  var d3 = [];
	  for (var i = 0; i <= 10; i += 1)
	  	d3.push([i, parseInt(31 + (Math.random() * 7))]);

	  var ds = new Array();

	  ds.push({
	  	label:"Clicks per month",
	  	data:d1,
	  	bars: {
	  		show: true,
	  		barWidth: 0.2,
	  		order: 1,
	  		lineWidth : 2
	  	}
	  });
	  ds.push({
	  	label:"Referalls per month",
	  	data:d2,
	  	bars: {
	  		show: true,
	  		barWidth: 0.2,
	  		order: 2
	  	}
	  });
	  ds.push({
	  	label:"Downloads per month",
	  	data:d3,
	  	bars: {
	  		show: true,
	  		barWidth: 0.2,
	  		order: 3
	  	}
	  });

	  if($("#flot-2").length > 0){
	  	var sin = [], cos = [];
	  	for (var i = 0; i < 14; i += 0.5) {
	  		sin.push([i, Math.sin(i)]);
	  		cos.push([i, Math.cos(i)]);
	  	}

	  	var plot = $.plot($("#flot-2"),
	  	                  [ { data: sin, label: "sin(x)"}, { data: cos, label: "cos(x)" } ], {
	  	                  	series: {
	  	                  		lines: { show: true },
	  	                  		points: { show: true }
	  	                  	},
	  	                  	grid: { hoverable: true, clickable: true },
	  	                  	yaxis: { min: -1.2, max: 1.2 }
	  	                  });
	  }

	  if($("#flot-5").length > 0){
	  	var data = [];
	  	var series = Math.floor(Math.random()*4)+2;
	  	for( var i = 0; i<series; i++)
	  	{
	  		data[i] = { label: "Series"+(i+1), data: Math.floor(Math.random()*100)+1 }
	  	}

	  	$.plot($("#flot-5"), data,
	  	{
	  		series: {
	  			pie: {
	  				show: true
	  			}
	  		}
	  	});

	  	$.plot($("#flot-6"), data,
	  	{
	  		series: {
	  			pie: {
	  				show: true,
	  				radius: 1,
	  				label: {
	  					show: true,
	  					radius: 1,
	  					formatter: function(label, series){
	  						return '<div style="font-size:8pt;text-align:center;padding:2px;color:white;">'+label+'<br/>'+Math.round(series.percent)+'%</div>';
	  					},
	  					background: { opacity: 0.8 }
	  				}
	  			}
	  		},
	  		legend: {
	  			show: false
	  		}
	  	});

	// GRAPH 3
	$.plot($("#flot-7"), data,
	{
		series: {
			pie: {
				show: true,
				radius: 1,
				label: {
					show: true,
					radius: 3/4,
					formatter: function(label, series){
						return '<div style="font-size:8pt;text-align:center;padding:2px;color:white;">'+label+'<br/>'+Math.round(series.percent)+'%</div>';
					},
					background: { opacity: 0.5 }
				}
			}
		},
		legend: {
			show: false
		}
	});

	$.plot($("#flot-8"), data,
	{
		series: {
			pie: {
				innerRadius: 0.5,
				show: true
			}
		}
	});

}
/*
if($('#flot-4-source').length > 0){
	var d1 = [];
	for (var i = 0; i <= 10; i += 1)
		d1.push([i, parseInt(Math.random() * 30)]);

	var d2 = [];
	for (var i = 0; i <= 10; i += 1)
		d2.push([i, parseInt(Math.random() * 30)]);

	var d3 = [];
	for (var i = 0; i <= 10; i += 1)
		d3.push([i, parseInt(Math.random() * 30)]);

    var d4 = [];
	for (var i = 0; i <= 10; i += 1)
		d4.push([i, parseInt(Math.random() * 30)]);

	var stack = 0, bars = true, lines = false, steps = false;

	function plotWithOptions() {
		$.plot($("#flot-4-source"), [ d1, d2, d3, d4 ], {
			series: {
				stack: stack,
				lines: { show: lines, fill: true, steps: steps },
				bars: { show: bars, barWidth: 0.6 }
			}
		});
	}

	plotWithOptions();

	$(".stackControls input").click(function (e) {
		e.preventDefault();
		stack = $(this).val() == "With stacking" ? true : null;
		plotWithOptions();
	});
	$(".graphControls input").click(function (e) {
		e.preventDefault();
		bars = $(this).val().indexOf("Bars") != -1;
		lines = $(this).val().indexOf("Lines") != -1;
		steps = $(this).val().indexOf("steps") != -1;
		plotWithOptions();
	});
}


if($('#flot-4-sales').length > 0){
	var d1 = [];
	for (var i = 0; i <= 10; i += 1)
		d1.push([i, parseInt(Math.random() * 30)]);

	var d2 = [];
	for (var i = 0; i <= 10; i += 1)
		d2.push([i, parseInt(Math.random() * 30)]);

	var stack = 0, bars = false, lines = true, steps = false;

	function plotWithOptions() {
		$.plot($("#flot-4-sales"), [ d1, d2 ], {
			series: {
				stack: stack,
				lines: { show: lines, fill: true, steps: steps },
				bars: { show: bars, barWidth: 0.6 }
			}
		});
	}

	plotWithOptions();

	$(".stackControls input").click(function (e) {
		e.preventDefault();
		stack = $(this).val() == "With stacking" ? true : null;
		plotWithOptions();
	});
	$(".graphControls input").click(function (e) {
		e.preventDefault();
		bars = $(this).val().indexOf("Bars") != -1;
		lines = $(this).val().indexOf("Lines") != -1;
		steps = $(this).val().indexOf("steps") != -1;
		plotWithOptions();
	});
}

*/

if($('#flot-3').length > 0){
	var data = [], totalPoints = 300;
	function getRandomData() {
		if (data.length > 0)
			data = data.slice(1);

        // do a random walk
        while (data.length < totalPoints) {
        	var prev = data.length > 0 ? data[data.length - 1] : 50;
        	var y = prev + Math.random() * 10 - 5;
        	if (y < 0)
        		y = 0;
        	if (y > 100)
        		y = 100;
        	data.push(y);
        }

        // zip the generated y values with the x values
        var res = [];
        for (var i = 0; i < data.length; ++i)
        	res.push([i, data[i]])
        return res;
    }

    // setup control widget
    var updateInterval = 30;
    $("#updateInterval").val(updateInterval).change(function () {
    	var v = $(this).val();
    	if (v && !isNaN(+v)) {
    		updateInterval = +v;
    		if (updateInterval < 1)
    			updateInterval = 1;
    		if (updateInterval > 2000)
    			updateInterval = 2000;
    		$(this).val("" + updateInterval);
    	}
    });

    // setup plot
    var options = {
        series: { shadowSize: 0 }, // drawing is faster without shadows
        yaxis: { min: 0, max: 100 },
        xaxis: { show: false }
    };
    var plot = $.plot($("#flot-3"), [ getRandomData() ], options);

    function update() {
    	plot.setData([ getRandomData() ]);
        // since the axes don't change, we don't need to call plot.setupGrid()
        plot.draw();

        setTimeout(update, updateInterval);
    }

    update();
}

if($("#flot-1").length > 0){
	var d4 = [];
	for (var i = 0; i < Math.PI * 2; i += 0.25)
		d4.push([i, Math.sin(i)]);

	var d5 = [];
	for (var i = 0; i < Math.PI * 2; i += 0.25)
		d5.push([i, Math.cos(i)]);

	var d6 = [];
	for (var i = 0; i < Math.PI * 2; i += 0.1)
		d6.push([i, Math.tan(i)]);

	$.plot($("#flot-1"), [
	       { label: "sin(x)",  data: d4},
	       { label: "cos(x)",  data: d5},
	       { label: "tan(x)",  data: d6}
	       ], {
	       	series: {
	       		lines: { show: true },
	       		points: { show: true }
	       	},
	       	xaxis: {
	       		ticks: [0, [Math.PI/2, "\u03c0/2"], [Math.PI, "\u03c0"], [Math.PI * 3/2, "3\u03c0/2"], [Math.PI * 2, "2\u03c0"]]
	       	},
	       	yaxis: {
	       		ticks: 10,
	       		min: -2,
	       		max: 2
	       	},
	       	grid: {
	       		backgroundColor: { colors: ["#fff", "#fff"] }
	       	}
	       });
}

if($("#flot-audience").length > 0){
	var data = [[1262304000000, 1300], [1264982400000, 2200], [1267401600000, 3600], [1270080000000, 5200], [1272672000000, 4500], [1275350400000, 3900], [1277942400000, 3600], [1280620800000, 4600], [1283299200000, 5300], [1285891200000, 7100], [1288569600000, 7800], [1291241700000, 8195]];

	$.plot($("#flot-audience"), [{
		label: "Visits",
		data: data,
		color: "#66CC66"
	}], {
		xaxis: {
			min: (new Date(2009, 12, 1)).getTime(),
			max: (new Date(2010, 11, 2)).getTime(),
			mode: "time",
			tickSize: [1, "month"],
			monthNames: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
		},
		series: {
			lines: {
				show: true,
				fill: true
			},
			points: {
				show: true,
			}
		},
		grid: { hoverable: true, clickable: true },
		legend: {
			show: false
		}
	});

	$("#flot-audience").bind("plothover", function (event, pos, item) {
		if (item) {
			if (previousPoint != item.dataIndex) {
				previousPoint = item.dataIndex;

				$("#tooltip").remove();
				var y = item.datapoint[1].toFixed();

				showTooltip(item.pageX, item.pageY,
				            item.series.label + " = " + y);
			}
		}
		else {
			$("#tooltip").remove();
			previousPoint = null;
		}
	});

}

if($("#flot-hdd").length > 0){
	var data = [[1364598000000, 10],[1364601600000, 12],[1364605200000, 14],[1364608800000, 14],[1364612400000, 10],[1364616000000, 16],[1364619600000, 18],[1364623200000, 15],[1364626800000, 16],[1364630400000, 18],[1364634000000, 20],[1364637600000, 22],[1364641200000, 24],[1364644800000, 25],[1364648400000, 27],[1364652000000, 31],[1364655600000, 33],[1364659200000, 36],[1364662800000, 37],[1364666400000, 38],[1364670000000, 39],[1364673600000, 42],[1364677200000, 45],[1364680800000, 47],[1364684400000, 50]];

	$.plot($("#flot-hdd"), [{
		label: "HDD usage",
		data: data,
		color: "#f36b6b"
	}], {
		xaxis: {
			min: (new Date("2013/03/30")).getTime(),
			max: (new Date("2013/03/31")).getTime(),
			mode: "time",
			tickSize: [3, "hour"],
		},
		series: {
			lines: {
				show: true,
				fill: true
			},
			points: {
				show: true,
			}
		},
		grid: { hoverable: true, clickable: true },
		legend: {
			show: false
		}
	});

	$("#flot-hdd").bind("plothover", function (event, pos, item) {
		if (item) {
			if (previousPoint != item.dataIndex) {
				previousPoint = item.dataIndex;

				$("#tooltip").remove();
				var y = item.datapoint[1].toFixed();

				showTooltip(item.pageX, item.pageY,
				            item.series.label + " = " + y+"%");
			}
		}
		else {
			$("#tooltip").remove();
			previousPoint = null;
		}
	});
}

if($("#flot-cpu").length > 0){
	var data = [[1364598000000, 50],[1364601600000, 45],[1364605200000, 50],[1364608800000, 40],[1364612400000, 60],[1364616000000, 50],[1364619600000, 40],[1364623200000, 30],[1364626800000, 35],[1364630400000, 55],[1364634000000, 40],[1364637600000, 30],[1364641200000, 45],[1364644800000, 55],[1364648400000, 65],[1364652000000, 40],[1364655600000, 45],[1364659200000, 50],[1364662800000, 55],[1364666400000, 60],[1364670000000, 65],[1364673600000, 70],[1364677200000, 75],[1364680800000, 78],[1364684400000, 80]];

	$.plot($("#flot-cpu"), [{
		label: "CPU usage",
		data: data,
		color: "#74ad4b"
	}], {
		xaxis: {
			min: (new Date("2013/03/30")).getTime(),
			max: (new Date("2013/03/31")).getTime(),
			mode: "time",
			tickSize: [3, "hour"],
		},
		series: {
			lines: {
				show: true,
				fill: true
			},
			points: {
				show: true,
			}
		},
		grid: { hoverable: true, clickable: true },
		legend: {
			show: false
		}
	});

	$("#flot-cpu").bind("plothover", function (event, pos, item) {
		if (item) {
			if (previousPoint != item.dataIndex) {
				previousPoint = item.dataIndex;

				$("#tooltip").remove();
				var y = item.datapoint[1].toFixed();

				showTooltip(item.pageX, item.pageY,
				            item.series.label + " = " + y+"%");
			}
		}
		else {
			$("#tooltip").remove();
			previousPoint = null;
		}
	});
}

if($('.flot-line').length > 0){
	$(function () {
		var data = [], totalPoints = 20;
		function getRandomData() {
			if (data.length > 0)
				data = data.slice(1);
			while (data.length < totalPoints) {
				var prev = data.length > 0 ? data[data.length - 1] : 50;
				var y = prev + (Math.random() * 10) - 5;
				if (y < 0)
					y = 0;
				if (y > 100)
					y = 100;
				data.push(y);
			}

			var res = [];
			for (var i = 0; i < data.length; ++i)
				res.push([i, data[i]])
			return res;
		}

		var updateInterval = 500;


		var options = {
			series: {
				shadowSize: 0
			},
			yaxis: {
				min: 0,
				max: 100
			},
			xaxis: {
				show: false
			}
		};
		var plot = $.plot($(".flot-line"), [ {
			label: "CPU at %",
			data: getRandomData(),
			lines: {show: false, fill:true},
			points: {show: false},
			color: '#fd6e58'
		}], options);

		function update() {
			plot.setData([ {
				label: "CPU at %",
				data: getRandomData(),
				lines: {show: true, fill:true},
				points: {show: false},
				color: '#fd6e58'
			}]);
			plot.draw();

			setTimeout(update, updateInterval);
		}

	  		// This resize bind fixes live-data resize bug in jquery.flot.resize.min
	  		$(window).resize(function(){
	  			if($(".flot-line").is(":visible")){
	  				plot.resize();
	  				plot.setupGrid();
	  				plot.draw();
	  			}
	  		});

	  		update();
	  	});
}

/*
// Calendar
if($(".calendar").length > 0)
{
	var date = new Date();
	var d = date.getDate();
	var m = date.getMonth();
	var y = date.getFullYear();

	$('.calendar').fullCalendar('addEventSource', [
	{
		title: 'All Day Event',
		start: new Date(y, m, 1)
	},
	{
		title: 'Long Event',
		start: new Date(y, m, d-5),
		end: new Date(y, m, d-2)
	},
	{
		id: 999,
		title: 'Repeating Event',
		start: new Date(y, m, d-3, 16, 0),
		allDay: false
	},
	{
		id: 999,
		title: 'Repeating Event',
		start: new Date(y, m, d+4, 16, 0),
		allDay: false
	},
	{
		title: 'Meeting',
		start: new Date(y, m, d, 10, 30),
		allDay: false
	},
	{
		title: 'Lunch',
		start: new Date(y, m, d, 12, 0),
		end: new Date(y, m, d, 14, 0),
		allDay: false
	},
	{
		title: 'Birthday Party',
		start: new Date(y, m, d+1, 19, 0),
		end: new Date(y, m, d+1, 22, 30),
		allDay: false
	},
	{
		title: 'Click for Google',
		start: new Date(y, m, 28),
		end: new Date(y, m, 29),
		url: 'http://google.com/'
	}
	]);
}
*/

var guide = {
	id: 'jQuery.PageGuide',
	title: 'Take a quick tour of all the possibilities',
	steps: [
	{
		target: '.ui-resizable-handle',
		content: 'You can resize this navigation. It will also snap to the original width if you are near it!',
		direction: 'right'
	},
	{
		target: '.content-remove',
		content: 'You can remove widgets, previous/next widgets will automatically resize!',
		direction: 'right'
	},
	{
		target: '.messages',
		content: 'Check out this fully working chat (with automated answer)!',
		direction: 'left'
	},
	{
		target: '.alpha .alpha-val',
		content: 'You can click on this elements to get an alphabetical overview.',
		direction: 'left'
	},
	{
		target: '.colo',
		content: 'Here you can choose between 9 different colors for this theme!',
		direction: 'bottom'
	},
	{
		target: '.sett',
		content: 'Here you can choose between fixed and fluid layout!',
		direction: 'bottom'
	}
	]
};
if((location.pathname == "/flat/" || location.pathname == '/flat' || location.pathname == '/flat/index.html') && location.host != "localhost" && $(window).width() > 767){
	bootbox.animate(false);

	bootbox.confirm("Would you like to start the page guide? It will show you functions you could miss!", "No", "Yes", function(r){
		if(r) $.pageguide(guide,{
			events: {
				close: function(){
					$.pageguide('unload');
				}
			}
		}).open();
	});
}

if($("#sico").length > 0){
	function formatIcons(option){
		return "<i class='" + option.text +"'></i> ." + option.text;
	}
	$("#sico").select2({
		formatResult: formatIcons,
		formatSelection:formatIcons,
		escapeMarkup: function(m) { return m; }
	});
}

if($("#simg").length > 0){
	function formatFlags(state){
		if (!state.id) return state.text;
		return "<img style='padding-right:10px;' src='img/demo/flags/" + state.id.toLowerCase() + ".gif'/>" + state.text;
	}
	$("#simg").select2({
		formatResult: formatFlags,
		formatSelection:formatFlags,
		escapeMarkup: function(m) { return m; }
	});
}


if($("#map1").length > 0){
	$("#map1").gmap3({
		map:{
			options:{
				center:[22.49156846196823, 89.75802349999992],
				zoom:7
			}
		}
	});
}

if($("#map4").length > 0){
	$("#map4").gmap3({
		map:{
			options:{
				center:[46.578498,2.457275],
				zoom:5
			}
		},
		marker:{
			values:[
			{latLng:[48.8620722, 2.352047], data:"Paris !"},
			{address:"86000 Poitiers, France", data:"Poitiers : great city !"},
			{address:"66000 Perpignan, France", data:"Perpignan ! GO USAP !", options:{icon: "http://maps.google.com/mapfiles/marker_green.png"}}
			],
			events:{
				click: function(marker, event, context){
					var map = $(this).gmap3("get"),
					infowindow = $(this).gmap3({get:{name:"infowindow"}});
					if (infowindow){
						infowindow.open(map, marker);
						infowindow.setContent(context.data);
					} else {
						$(this).gmap3({
							infowindow:{
								anchor:marker,
								options:{content: context.data}
							}
						});
					}
				}
			}
		}
	});
}

if($("#map2").length > 0){
	var menu = new Gmap3Menu($("#map2")),
  current,  // current click event (used to save as start / end position)
  m1,       // marker "from"
  m2;       // marker "to"
 
// update marker
function updateMarker(marker, isM1){
	  if (isM1){
		    m1 = marker;
	  } else {
		    m2 = marker;
	  }
	  updateDirections();
}
 
// add marker and manage which one it is (A, B)
function addMarker(isM1){
  // clear previous marker if set
  var clear = {name:"marker"};
  if (isM1 && m1) {
	    clear.tag = "from";
	    $("#map2").gmap3({clear:clear});
  } else if (!isM1 && m2){
	    clear.tag = "to";
	    $("#map2").gmap3({clear:clear});
  }
  // add marker and store it
  $("#map2").gmap3({
	    marker:{
		      latLng:current.latLng,
		      options:{
			        draggable:true,
			        icon:new google.maps.MarkerImage("http://maps.gstatic.com/mapfiles/icon_green" + (isM1 ? "A" : "B") + ".png")
		      },
		      tag: (isM1 ? "from" : "to"),
		      events: {
			        dragend: function(marker){
				          updateMarker(marker, isM1);
			        }
		      },
		      callback: function(marker){
			        updateMarker(marker, isM1);
		      }
	    }
  });
}
 
// function called to update direction is m1 and m2 are set
function updateDirections(){
	  if (!(m1 && m2)){
		    return;
	  }
	  $("#map2").gmap3({
		    getroute:{
			      options:{
				        origin:m1.getPosition(),
				        destination:m2.getPosition(),
				        travelMode: google.maps.DirectionsTravelMode.DRIVING
			      },
			      callback: function(results){
				        if (!results) return;
				        $("#map2").gmap3({get:"directionrenderer"}).setDirections(results);
			      }
		    }
	  });
}
 
// MENU : ITEM 1
menu.add("Direction to here", "itemB",
           function(){
         	    menu.close();
         	    addMarker(false);
           });
 
// MENU : ITEM 2
menu.add("Direction from here", "itemA separator",
           function(){
         	    menu.close();
         	    addMarker(true);
           })
 
// MENU : ITEM 3
menu.add("Zoom in", "zoomIn",
           function(){
         	    var map = $("#map2").gmap3("get");
         	    map.setZoom(map.getZoom() + 1);
         	    menu.close();
           });
 
// MENU : ITEM 4
menu.add("Zoom out", "zoomOut",
           function(){
         	    var map = $("#map2").gmap3("get");
         	    map.setZoom(map.getZoom() - 1);
         	    menu.close();
           });
 
// MENU : ITEM 5
menu.add("Center here", "centerHere",
           function(){
         	      $("#map2").gmap3("get").setCenter(current.latLng);
         	      menu.close();
           });
 
// INITIALIZE GOOGLE MAP
$("#map2").gmap3({
	  map:{
		    options:{
			      center:[48.85861640881589, 2.3459243774414062],
			      zoom: 5
		    },
		    events:{
			      rightclick:function(map, event){
				        current = event;
				        menu.open(current);
			      },
			      click: function(){
				        menu.close();
			      },
			      dragstart: function(){
				        menu.close();
			      },
			      zoom_changed: function(){
				        menu.close();
			      }
		    }
	  },
  // add direction renderer to configure options (else, automatically created with default options)
  directionsrenderer:{
	    divId:"directions",
	    options:{
		      preserveViewport: true,
		      markerOptions:{
			        visible: false
		      }
	    }
  }
});
}


});

$(window).resize(function(){
	// console.log($(window).width());
});