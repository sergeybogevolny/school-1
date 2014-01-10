$(document).ready(function() {
	
	 //GoSearch();
    if($('.dataTable_1').length > 0){
		$('.dataTable_1').each(function(){
			if(!$(this).hasClass("dataTable-custom")) {
				var opt = {
					"sPaginationType": "full_numbers",
					"oLanguage":{
						"sSearch": "<span>Filter:</span> ",
						"sInfo": "Showing <span>_START_</span> to <span>_END_</span> of <span>_TOTAL_</span> entries",
						"sLengthMenu": "_MENU_ <span>entries per page</span>"
					},
                    "aoColumns": [
			            /* Name */          null,
			            /* DOB */           null,
                        /* SSN */           null,
                        /* Type */          null,
                        /* Standing */      null,
                        /* Logged */        null,
		            ]
				};
				if($(this).hasClass("dataTable-noheader")){
					opt.bFilter = false;
					opt.bLengthChange = false;
				}
				if($(this).hasClass("dataTable-nofooter")){
					opt.bInfo = false;
					opt.bPaginate = false;
				}
				if($(this).hasClass("dataTable-nosort")){
					var column = $(this).attr('data-nosort');
					column = column.split(',');
					for (var i = 0; i < column.length; i++) {
						column[i] = parseInt(column[i]);
					};
					opt.aoColumnDefs =  [
					{ 'bSortable': false, 'aTargets': column }
					];
				}
				var oTable = $(this).dataTable(opt);
			}
		});
    }
	
});


$(function () {
    'use strict';

    $.ajax({ url: 'classes/valuelist.class.php', type: "GET", data:{valuelist:"studentname"}, dataType: 'json'
    }).done(function (source) {

        var chargesArray = $.map(source, function (value, key) { return { value: value, data: key }; }),
            charges = $.map(source, function (value) { return value; });

        $('#student-name').autocomplete({
            lookup: chargesArray,
            lookupFilter: function(suggestion, originalQuery, queryLowerCase) {
                var re = new RegExp('\\b' + $.Autocomplete.utils.escapeRegExChars(queryLowerCase), 'gi');
                return re.test(suggestion.value);
            },
            onHint: function (hint) {
                $('#student-name-x').val(hint);
            }
        });
	})



 $.ajax({ url: 'classes/valuelist.class.php', type: "GET", data:{valuelist:"label"}, dataType: 'json'
    }).done(function (source) {

        var chargesArray = $.map(source, function (value, key) { return { value: value, data: key }; }),
            charges = $.map(source, function (value) { return value; });

        $('#label-name').autocomplete({
            lookup: chargesArray,
            lookupFilter: function(suggestion, originalQuery, queryLowerCase) {
                var re = new RegExp('\\b' + $.Autocomplete.utils.escapeRegExChars(queryLowerCase), 'gi');
                return re.test(suggestion.value);
            },
            onHint: function (hint) {
                $('#label-name-x').val(hint);
            }
        });
	})
	
 $.ajax({ url: 'classes/valuelist.class.php', type: "GET", data:{valuelist:"fathername"}, dataType: 'json'
    }).done(function (source) {

        var chargesArray = $.map(source, function (value, key) { return { value: value, data: key }; }),
            charges = $.map(source, function (value) { return value; });

        $('#father-name').autocomplete({
            lookup: chargesArray,
            lookupFilter: function(suggestion, originalQuery, queryLowerCase) {
                var re = new RegExp('\\b' + $.Autocomplete.utils.escapeRegExChars(queryLowerCase), 'gi');
                return re.test(suggestion.value);
            },
            onHint: function (hint) {
                $('#father-name-x').val(hint);
            }
        });
	})


});


function GoSearch(){
	var studentname = $('#student-name').val();
	var label = $('#label-name').val();
	var fathername = $('#father-name').val();

    $.get('classes/dashboard.class.php',{filter:true,studentname:studentname,lable:label,fathername:fathername}).done (function (data) {
	    console.log(data);
                var oTable = $('.dataTable_1').dataTable();
	            oTable.fnClearTable();
		
		   var jsonData = JSON.parse(data);
            for (var i in jsonData) {
                var rec = jsonData[i];
				
                    $('#search-table').dataTable().fnAddData([
                        '<input type="checkbox" name="check" value="1">',
                        rec.name,
                        rec.fname,
    		            rec.created,
                        rec.class,
                        rec.section,
                    ]);
                    $('#search-table').attr('id',rec.id);
				
				
			}
	
	});
}
