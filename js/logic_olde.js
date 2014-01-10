var id = $("#report-id").val();
var BOOL = '<select name="bool-logic" id="bool-logic" class="boollogic select2-me input-large span2" style="width:100px;">'+
            '<option value="or">OR</option>'+ 
			'<option value="and">AND</option>'+   								           
            '</select>';
			
var GROUPBOOL = '<select name="groupbool-logic" id="groupboolbool-logic" class="groupboollogic select2-me input-large span2" style="width:100px;">'+
            '<option value="or">OR</option>'+ 
			'<option value="and">AND</option>'+   								           
            '</select>';
	
var FIELD   = '';			

	$.get('classes/reports_columnar.class.php',{field:'field',reportid:id}).done(function(data){
						var jsonData = JSON.parse(data);
				FIELD += '<select name="field-logic" id="field-logic" class="fieldlogic select2-me input-large span2" style="width:100px;"  onchange="getInput(this)" >';
				FIELD += '<option value=""></option>';
				
				for (var i in jsonData) {
							var rec = jsonData[i];
							FIELD += '<option value="'+rec.field+'">'+rec.fieldfriendly+'</option>';
				
				}
				
				FIELD += '</select>';
	});

var COMPARE   = '<select name="compare-logic" id="compare-logic" class="comparelogic select2-me input-large span2" style="width:100px;" >'+
                '<option value=""></option>'+
                '</select>';

var VALUE   = '<input type="text" name="value-logic" id="value-logic" class="valuelogic" onclick="validate()" onblur="validate()" onkeyup="validate()" value="">';

$(document).ready(function() {
	
   
	
	$('#gv').prop('disabled', true);
	$('#read').prop('disabled', true);
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
			            /* Checkbox */  null,
			            /* Prefix */    null,
						/* Prefix */    null,
						/* Prefix */    null,
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
			var a = $(rows[k]).find("td:eq(3)").text();
			var b = $(rows[k]).find("td:eq(4)").text();
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
				var a = $(rows[k]).find("td:eq(3)").text();
				var b = $(rows[k]).find("td:eq(4)").text();
				
				ProcessInfo( a, b,'C')
			
		}else{
		  ProcessInfo( 0, -1,'C')
		}
	});
	
	
	
});



function ProcessInfo( GV, CV, Action){
	 $('#read').prop('disabled', true);
	 if(GV == 0 && CV == -1 ){
	     GV = 1;
		 CV = 0;
	     $('#logic-table').dataTable().fnAddData(['','WHERE','',GV, CV,'','','' ,'<a href="#" class="delete" onclick="location.reload()">Delete</a>']);
         $('#logic-table tr:last').addClass('odd1');
         $('#logic-table').dataTable().fnAddData(['','','',GV, 1,FIELD,COMPARE,VALUE,'<a href="#" class="delete" onclick="DeleteRow($(this))">Delete</a>' ]);
         $('#logic-table tr:last').addClass('odd1');
	 }else{
	      if( Action == 'G'){
		      GV = parseFloat(GV) + 1 ;
			  CV =  0;
			  $('#gv').prop('disabled', true); 
	          $('#logic-table').dataTable().fnAddData(['Where',GROUPBOOL,'',GV, CV ,'','','','<a href="#" class="delete" onclick="DeleteRow($(this))">Delete</a>']);
		  }
	      if( Action == 'C'){
			  GV = GV;
			  CV = parseFloat(CV) + 1;
			  $('#gv').prop('disabled', false);
			  
			  if( CV == 1){
				  $('#logic-table').dataTable().fnAddData(['','','',GV, CV,FIELD,COMPARE,VALUE,'<a href="#" class="delete" onclick="DeleteRow($(this))">Delete</a>' ]);
			  }else{
	            $('#logic-table').dataTable().fnAddData(['','',BOOL,GV, CV,FIELD,COMPARE,VALUE,'<a href="#" class="delete" onclick="DeleteRow($(this))">Delete</a>' ]);
			  }
		  }
		  
		  
		  var a = GV % 2 ;
		   if(a > 0 ){
		     $('#logic-table tr:last').addClass('odd1');
		   }else{
		      $('#logic-table tr:last').addClass('even1');
		   }
	 }
	 
	   var hiderow = $("#logic-table").dataTable().fnGetNodes();
	   for(var r=0;r<hiderow.length;r++)
		{ 
			 $(hiderow[r]).find("td:eq(0)").hide();
			 $(hiderow[r]).find("td:eq(3)").hide();
			 $(hiderow[r]).find("td:eq(4)").hide();
		}

     
  }
  
  function DeleteRow(row){
	  
			var a = $(row).closest('tr').find("td:eq(3)").text();
			var b = $(row).closest('tr').find("td:eq(4)").text();
			
            if( parseFloat(b) != 0){
				var rowindex = $('#logic-table').dataTable().fnGetPosition($(row).closest('tr')[0]);
				console.log(rowindex);
				$('#logic-table').dataTable().fnDeleteRow(rowindex);
				
				  
				
			   var rows = $("#logic-table").dataTable().fnGetNodes();
			   if(rows.length == 1){
				   //location.reload();
			   }
			   for(var i=0;i<rows.length;i++)
				{ 
					var c = $(rows[i]).find("td:eq(3)").text();
					var d = $(rows[i]).find("td:eq(4)").text();
					if(c == a && d > b ){
                         d = parseFloat(d) - 1
						 $(rows[i]).find("td:eq(4)").text(d);
					}
				}
			}else{
                 
			   var rows = $("#logic-table").dataTable().fnGetNodes();
			   
			   for(var i=0;i<rows.length;i++)
				{ 
				
				
					var c = $(rows[i]).find("td:eq(3)").text();
					var d = $(rows[i]).find("td:eq(4)").text();
					if(c == a ){
						var rowindex = $('#logic-table').dataTable().fnGetPosition($(rows[i]).closest('tr')[0]);
						$('#logic-table').dataTable().fnDeleteRow(rowindex);

					}
					
					if(c > a ){
                         c = parseFloat(c) - 1
						 $(rows[i]).find("td:eq(3)").text(c);
						  var a = c % 2 ;
						   if(a > 0 ){
							 $(rows[i]).removeClass('even1');
							 $(rows[i]).removeClass('odd1');  
							 $(rows[i]).addClass('odd1');
						   }else{
							 $(rows[i]).removeClass('even1');
							 $(rows[i]).removeClass('odd1');  
							  $(rows[i]).addClass('even1');
						   }
					}
					
				}
				
				var lastrows = $("#logic-table").dataTable().fnGetNodes();
				if(lastrows.length > 0){
					
						var k = lastrows.length-1 ;
						var s = $(lastrows[k]).find("td:eq(3)").text();
						var t = $(lastrows[k]).find("td:eq(4)").text();
						if(  parseFloat(t) == 0){
								$('#gv').prop('disabled', true);
							}else{
								$('#gv').prop('disabled', false);
							}
				}
					
	   }
			
    
  }
  
  function validate(){
	 var inputval = true;
	 $("#logic-data :input").each(function(){
		  var input = $(this).val().length;
		 if(input == 0){
			inputval = false;
		 }
		 
	 });
	 if (inputval==true){
          $('#read').prop('disabled', false);
      }else{
		  $('#read').prop('disabled', true);
	  }
	 
  }
  

  function getInput(a){
	  fieldval = $(a).val();
	  valueclass = $(a).closest('tr').find('.valuelogic');
	  comparelogic = $(a).closest('tr').find('.comparelogic')
      $(valueclass).val('');
	  
		

		   
	$.get('classes/reports_columnar.class.php',{operator:fieldval}).done(function(data){
		 
			var jsonData = JSON.parse(data);
			console.log(jsonData[0]);
			var type =  jsonData[0].type;
			
			setMask(type)	
					
					arr = '';
					for (var i in jsonData) {
								var rec = jsonData[i];
								arr += '<option value="'+rec.comparison+'">'+rec.comparison+'</option>';
					}
					
					$(comparelogic).html(arr);
	   });
		   
								
								
  }
  
  function readInput(){
		var p = 0; 
		var s = 0;
		var input = '';
		var group = {};
		var condition = {}; 
		group['group'] = new Array();
		condition['condition'] = new Array();
		var rows = $("#logic-table").dataTable().fnGetNodes();
		var gval = $(rows).find("td:eq(3)");
		var grouplist = $(rows).find("td:eq(1)").find('.groupboollogic');
	    
		for(var k=1;k<rows.length;k++){
				var boollogic = $(rows[k]).find("td:eq(2)").find('.boollogic').val() == undefined ? '' : $(rows[k]).find("td:eq(2)").find('.boollogic').val();
				var fieldlogic = $(rows[k]).find("td:eq(5)").find('.fieldlogic').val()  == undefined ? '' : $(rows[k]).find("td:eq(5)").find('.fieldlogic').val();
				var comparelogic = $(rows[k]).find("td:eq(6)").find('.comparelogic').val() == undefined ? '' :$(rows[k]).find("td:eq(6)").find('.comparelogic').val() ;
				var valuelogic =  $(rows[k]).find("td:eq(7)").find('.valuelogic').val() == undefined ? '' :$(rows[k]).find("td:eq(7)").find('.valuelogic').val() ;
				var groupboollogic =  $(rows[k]).find("td:eq(1)").find('.groupboollogic').val() == undefined ? '' :$(rows[k]).find("td:eq(1)").find('.groupboollogic').val() ;
				var gval = $(rows[k]).find("td:eq(3)").text();
				var cval = $(rows[k]).find("td:eq(4)").text()
				var g = parseFloat(gval);
				var c = parseFloat(cval);
				
				if(groupboollogic != ''){
					group['group'][p] = groupboollogic;
					p++
			    }
				inputa  = boollogic +' '+fieldlogic +' '+comparelogic +' '+valuelogic +' ';
				condition['condition'][k] = inputa;
	       }
		 
		   var condi = condition.condition;
		   var lencond = condition.condition.length;
		   var co = '';
		   var con = {};
		   
		   con['con'] = new Array();
		   for(var m = 1 ; m < lencond ; m++){
			   var v = condi[m];
			   if(v == '    '){
			     v = '#';
			   }
			    co += v ; 
			 } 
			 
			 con['con'] = co.split('#')
			 var gro = {'con':con,'group':group};
			 console.log(con);
			   console.log(group);
			   console.log(gro.con.con.length);
			   var query = '';
			   for(var f= 0; f < con.con.length; f++  ){
					 var openbrace  =  '(';
					 var closebrace =  ')';
					 var cond = con.con[f];
					 var gr   = group.group[f];
					 if(gr == undefined) gr = '';
					 query += openbrace + cond + closebrace + gr;
			   }
			   
	    alert(query);
	    $("#report-conditionraw").val(query);
        loadResults();

  }


function setMask(fieldval){
	
	    if(fieldval == 'date'){
		   $(valueclass).removeClass('.currency').autoNumeric('destroy');
		   //var datep = $(valueclass).addClass('datepicker').datepicker('show').on('changeDate', function(ev) {datep.hide(); $(valueclass).trigger('click')}).data('datepicker');
		   
           $(valueclass).inputmask("mm/dd/yyyy", { clearIncomplete: true, placeholder: "mm/dd/yyyy"});		   
		}
		
		if(fieldval == 'currency'){
			 //$(valueclass).inputmask('remove');
			  if($(valueclass).inputmask("hasMaskedValue")){
				  $(valueclass).inputmask('unmaskedvalue');
			  }
			 $(valueclass).addClass('.currency').autoNumeric('init');
			// $(valueclass).inputmask('remove', { clearIncomplete: true, placeholder: ""});		   

		}
		
	    if(fieldval == 'string'){
		   	 $(valueclass).removeClass('.currency').autoNumeric('destroy');
			 //$(valueclass).inputmask('remove');
			 $(valueclass).inputmask('remove', { clearIncomplete: true, placeholder: ""});		   

		}
}
