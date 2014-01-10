$(document).ready(function() {
    if($('.dataTable_1').length > 0){
		$('.dataTable_1').each(function(){
			if(!$(this).hasClass("dataTable-custom")) {
				var opt = {
					"bSort": false,
					"sPaginationType": "full_numbers",
					"oLanguage":{
						"sSearch": "<span>Filter:</span> ",
						"sInfo": "Showing <span>_START_</span> to <span>_END_</span> of <span>_TOTAL_</span> entries",
						"sLengthMenu": "_MENU_ <span>entries per page</span>"
					},
                    "aoColumns": [
			            /* Checkbox */  null,
			            /* Prefix */    null,
						/* Prefix */    null,
                       
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
                $("#check_all_1").click(function(e){
					$('input', oTable.fnGetNodes()).prop('checked',this.checked);

				});

			}
		});
    }



    $("#gv").click(function(e){
        e.preventDefault();
        var rows = $("#logic-table").dataTable().fnGetNodes();
		if(rows.length > 0){
			
				var k = rows.length-1 ;
				var a = $(rows[k]).find("td:eq(0)").text();
				var b = $(rows[k]).find("td:eq(1)").text();
			   
				ProcessInfo( a, b,'G')
			
		}else{
		  ProcessInfo( 0, -1,'G')
		}
	});

    $("#cv").click(function(e){
        e.preventDefault();
        var rows = $("#logic-table").dataTable().fnGetNodes();
		
		if(rows.length > 0){
			
				var k = rows.length-1 ;  
				var a = $(rows[k]).find("td:eq(0)").text();
				var b = $(rows[k]).find("td:eq(1)").text();
				
				ProcessInfo( a, b,'C')
			
		}else{
		  ProcessInfo( 0, -1,'C')
		}
	});
	
});


function ProcessInfo( GV, CV, Action){
	 if(GV == 0 && CV == -1 ){
	     GV = 1;
		 CV = 0;
	     $('#logic-table').dataTable().fnAddData([  GV, CV ,'<a href="#" class="delete" onclick="DeleteRow($(this))">Delete</a>']);
		 $('#logic-table tr:last').addClass('odd1');
	 }else{
	      if( Action == 'G'){
		      GV = parseFloat(GV) + 1 ;
			  CV =  0;
	          $('#logic-table').dataTable().fnAddData([  GV, CV  ,'<a href="#" class="delete" onclick="DeleteRow($(this))">Delete</a>']);
		  }
	      if( Action == 'C'){
			  GV = GV;
			  CV = parseFloat(CV) + 1;
	          $('#logic-table').dataTable().fnAddData([  GV, CV ,'<a href="#" class="delete" onclick="DeleteRow($(this))">Delete</a>' ]);
		  }
		  
		  var a = GV % 2 ;
		   if(a > 0 ){
		     $('#logic-table tr:last').addClass('odd1');
		   }else{
		      $('#logic-table tr:last').addClass('even1');
		   }
	 }
     
  }
  
  function DeleteRow(row){
	  
			var a = $(row).closest('tr').find("td:eq(0)").text();
			var b = $(row).closest('tr').find("td:eq(1)").text();
              
            if( parseFloat(b) != 0){
				var rowindex = $('#logic-table').dataTable().fnGetPosition($(row).closest('tr')[0]);
				console.log(rowindex);
				$('#logic-table').dataTable().fnDeleteRow(rowindex);
				
			}else{
				
			   var rows = $("#logic-table").dataTable().fnGetNodes();
			   for(var i=0;i<rows.length;i++)
				{ 
					var c = $(rows[i]).find("td:eq(0)").text();
					var d = $(rows[i]).find("td:eq(1)").text();
					if(c == a ){
						var rowindex = $('#logic-table').dataTable().fnGetPosition($(rows[i]).closest('tr')[0]);
						$('#logic-table').dataTable().fnDeleteRow(rowindex);

					}
				}
			}
    
  }


