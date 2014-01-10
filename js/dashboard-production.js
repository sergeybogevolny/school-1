/*
	FILE: dashboard-production.js
	AUTHOR: risanbagja
	DATE: July 24th 2013
*/

// Wait for the DOM to be fully loaded, then execute!
$(document).ready(function() {
	// Plot Close Ratio Chart
	plotCloseRatio();
	// Plot Sales Source Chart
	plotSalesSource();
});

/////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Function to plot Close Ratio chart
function plotCloseRatio() {
	// DIV object to contain Close Ratio chart
	var sales_chart = $("#flot-4-sales");

	// Get data for 'client' and 'prospect' type
	var closeRatio_client = closeRatio_getData(CLOSE_RATIO_CLIENT);
	var closeRatio_prospect = closeRatio_getData(CLOSE_RATIO_PROSPECT);
	
	// Get date series to be used in x-axis label
	var closeRatio_x = closeRatio_getDate(CLOSE_RATIO_CLIENT);

	// If DIV object is exists, procceed!
	if(sales_chart.length > 0) {
		// Initialize data series
		var data_series = [
			{
			    label: "Clients Type",
				data: closeRatio_client
			},
			{
			    label: "All Type",
				data: closeRatio_prospect
			}
		];

		// Chart options
		var options = {
    		series: {
    			stack: 0,
        		lines: { show: true, fill: true, steps: false },
        		points: { show: true },
        		bars: { show: false }
    		},

    		xaxis: {
    			show: true,
    			ticks: closeRatio_x
    		}
		};

		// Plot Close Ratio chart!
		$.plot(sales_chart, data_series, options);
	}
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Function to plot Sales Source chart
function plotSalesSource() {
	// DIV object to show up Sales Source chart
	var source_chart = $("#flot-4-source");

	// Get data for each source type
	var salesSource_attorney = salesSource_getData(SALES_SOURCE, 'Attorney');
	var salesSource_coupon = salesSource_getData(SALES_SOURCE, 'Coupon');
	var salesSource_friend = salesSource_getData(SALES_SOURCE, 'Friend');
	var salesSource_internet = salesSource_getData(SALES_SOURCE, 'Internet');
	var salesSource_radio = salesSource_getData(SALES_SOURCE, 'Radio');
	var salesSource_television = salesSource_getData(SALES_SOURCE, 'Television');

	// Get date series to be used in x-axis label
	var salesSource_x = salesSource_getDate(SALES_SOURCE);

	// If targeted DIV object is available, procceed!
	if(source_chart.length > 0) {
		// Initialize data series for each source type
		var data_series = [
			{
			    label: "Attorney",
				data: salesSource_attorney
			},
			{
			    label: "Coupon",
				data: salesSource_coupon
			},
			{
			    label: "Friend",
				data: salesSource_friend
			},
			{
			    label: "Internet",
				data: salesSource_internet
			},
			{
			    label: "Radio",
				data: salesSource_radio
			},
			{
			    label: "Television",
				data: salesSource_television
			}
		];

		// Chart options
		var options = {
    		series: {
    			stack: 0,
        		lines: { show: false, fill: true, steps: true },
        		points: { show: false },
        		bars: { show: true, barWidth: 0.6, align: "center" }
    		},

    		xaxis: {
    			show: true,
    			ticks: salesSource_x
    		}
		};

		// Plot Sales Source chart!
		$.plot(source_chart, data_series, options);
	}
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Function to get data series for Close Ratio chart
function closeRatio_getData(closeRatio_data) {
	var data = new Array();
	for (var i = 0; i < closeRatio_data.length; i++) {
		// Get total numbers of the current type
		data[i] = [i, parseInt(closeRatio_data[i].counts)];
	}
	return data;
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Function to extract date series for Close Ration chart
function closeRatio_getDate(closeRatio_data) {
	var data = new Array();
	for (var i = 0; i < closeRatio_data.length; i++) {
		data[i] = [i, closeRatio_data[i].date];
	}
	return data;
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Function to get amount data series for each source type
// var source_type = 'Attorney' OR 'Coupon' OR 'Friend' OR 'Internet' OR 'Television' OR 'Radio'
function salesSource_getData(salesSource_data, source_type) {
	var data = new Array();
	for (var i = 0; i < salesSource_data.length; i++) {
		var value = eval('salesSource_data[i].detail.' + source_type);
		data[i] = [i, parseInt(value)];
	}
	return data;
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Function to extract date series for Sales Source chart
function salesSource_getDate(salesSource_data) {
	var data = new Array();
	for (var i = 0; i < salesSource_data.length; i++) {
		data[i] = [i, salesSource_data[i].date];
	}
	return data;
}