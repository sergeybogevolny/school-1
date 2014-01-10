	
	
	// this is root condition for when page loading 
	
	var rootcondition = '<table class="table conditionTable" style="margin-top:10px"><tr><td><div style="margin:10px"><button class="add btn btn-primary" > Add Condition </button>&nbsp; &nbsp; <button class="addroot btn btn-primary"> Add Group </button> &nbsp; &nbsp; <a class="remove deleteroot btn btn-primary" href="#" style="margin:10px 10px 10px 10px">Delete Group</a><div class="querystmts" ></div></div>';
	
		rootcondition += '</td></tr></table>';
	// this is next group conditin that showing condition 'and' & 'or'
	var rootconditionN = '<table class="table conditionTable" style="margin-top:10px"><tr><td><div style="margin:10px"><select class="groupCond span3 select2-me  filter-fields "  style="width:100px; margin:0px 10px;" ><option value="and">And</option><option value="or">Or</option></select><button class="add btn btn-primary" > Add Condition </button>&nbsp; &nbsp; <button class="addroot btn btn-primary"> Add Group </button> &nbsp; &nbsp; <a class="remove deleteroot btn btn-primary" href="#" style="margin:10px 10px 10px 10px">Delete Group</a><div class="querystmts" ></div></div>';
	
		rootconditionN += '</td></tr></table>';
	
	// this is statement that show without condition when 1st time laod in a group 
	
	var statement = '<div class="span12 conditionData" id="queryResult" style="margin:0px 0px 10px">';
	var id = $("#report-id").val();

	$.get('classes/reports_columnar.class.php',{field:'field',reportid:id}).done(function(data){
						var jsonData = JSON.parse(data);
				statement += '<select class="col span3 select2-me  filter-fields"  style="width:100px; margin:0px 10px;"  onchange="getOperator(\'.col\',$(this).val())">';
				statement += '<option value=""></option>';
				
				for (var i in jsonData) {
							var rec = jsonData[i];
							statement += '<option value="'+rec.field+'">'+rec.fieldfriendly+'</option>';
				
				}
				
				statement += '</select>';
				
				statement += '<select class="op span3 select2-me  filter-fields" style="width:100px; margin:0px 10px;" onchange="checkValid(\'.op\',$(this).val())">';
				statement += '</select>'
			
			
				statement += '<span id="inputText"><input type="text"  id="valData" class="form-control span2 valData" onkeyup="checkVal(\'.op\',$(this).val())" onfocus="checkVal(\'.op\',$(this).val())" onblur="checkVal(\'.op\',$(this).val())" onclick="checkVal(\'.op\',$(this).val())" style="width:100px ; margin:0px 10px;"/></span><a class="remove btn btn-primary" href="#" onclick="getRemove(\'.op\')" style="margin:10px 10px 10px 10px"><i class="glyphicon-circle_remove"></i></a></div>';
		
		
	});
	
	// this is new statement that load with condition 
	
  var statementN = '<div class="span12 conditionData" id="queryResult" style="margin:0px 0px 10px">';
	$.get('classes/reports_columnar.class.php',{field:'field',reportid:id}).done(function(data){
						var jsonData = JSON.parse(data);
						
	statementN += '<select class="groupCond span3 select2-me  filter-fields"  style="width:100px; margin:0px 10px;" ><option value="and">And</option><option value="or">Or</option></select>';
	
	statementN += '<select class="col span3"  style="width:100px; margin:0px 10px;"  onchange="getOperator(\'.col\',$(this).val())">';
	statementN += '<option value=""></option>';
				for (var i in jsonData) {
							var rec = jsonData[i];
							statementN += '<option value="'+rec.field+'">'+rec.fieldfriendly+'</option>';
				}
				
	statementN += '</select>';
	
	statementN += '<select class="op span3 select2-me  filter-fields" style="width:100px; margin:0px 10px;" onchange="checkValid(\'.op\',$(this).val())">';
	statementN += '</select>'


    statementN += '<span id="inputText"><input type="text"  id="valData" class="form-control span2 valData" onkeyup="checkVal(\'.op\',$(this).val())" onfocus="checkVal(\'.op\',$(this).val())" onblur="checkVal(\'.op\',$(this).val())" onclick="checkVal(\'.op\',$(this).val())" style="width:100px ; margin:0px 10px;"/></span><a class="remove btn btn-primary" href="#" onclick="getRemove(\'.op\')" style="margin:10px 10px 10px 10px"><i class="glyphicon-circle_remove"></i></a></div>';
	});
	
	
	
	// this is function that called when click on add group or add condition

var addqueryroot = function (sel, isroot) {
	 
	 if (isroot) { // it checking if there is root system or not if root then it append rootcondition variable
			$(sel).append(rootcondition);
	 }else{ // if not root then loading system with condition 
			$(sel).append(rootconditionN);
	 }
	 
    var q = $(sel).find('table');
    var l = q.length;
    var elem = q;
    if (l > 1) {
        elem = $(q[l - 1]);
		
    }
    

    //this if and else condition is for delete group or condition statement 
    if (isroot) {
	    elem.children().children().children().find('.deleteroot').hide();
    }
    else {
	    elem.children().children().children().find('.deleteroot').show();

        elem.find('.remove').click(function () {
             elem.detach();
        });
    }
        
    // Add the default staement segment to the root condition
    elem.find('td >.querystmts').append(statement);

    // Add the head class to the first statement
    elem.find('td >.querystmts div >.remove').addClass('head');
	
    if(gCond1 == 0){
		resultButtonDisable();
	    elem.children().children().children().find('.addroot').attr("disabled", "disabled");
	    elem.children().children().children().find('.deleteroot').attr("disabled", "disabled");
	}
	

    // Handle click for adding new statement segment
    // When a new statement is added add a condition to handle remove click.
    elem.find('td div >.add').click(function () {
		resultButtonDisable();
		elem.children().children().children().find('.addroot').attr("disabled", "disabled");
		elem.children().children().children().find('.add').attr("disabled", "disabled");
		// elem.children().children().children().find('.deleteroot').attr("disabled", "disabled");
		
		var gCond = $(this).parent().find('.querystmts').find('.conditionData').length ;
		
		
		if( gCond > 0 ){
			 $(this).parent().find('.querystmts').append(statementN);
		}else{
			$(this).parent().find('.querystmts').append(statement);
		}
        var stmts = $(this).parent().find('.querystmts').find('.remove').filter(':not(.head)');
        stmts.unbind('click');
        stmts.click(function () {
            $(this).parent().detach();
        });
    });

    // Handle click to add new root condition
    elem.find('td div > .addroot').click(function () {
        addqueryroot($(this).parent(), false);
    });
};




//Recursive method to parse the condition and generate the query. Takes the selector for the root condition
var getCondition = function (rootsel) {
	
	
    //Get the columns from table (to find a clean way to do it later) //tbody>tr>td
    var elem = $(rootsel).children().children().children().children().find('.querystmts');
    var elem1 = $(rootsel).children().children().children().children();
    //elem 0 is for operator, elem 1 is for expressions
    var q = {};
    var expressions = [];
    var nestedexpressions = [];
	var expressionelem = $(elem[0]).find('div');
		
	var gCond = elem.find('.conditionData').length ;
	var operator = $(expressionelem).find('.groupCond :selected').val();
		
		q.operator = operator;

    // Get all the expressions in a condition
  
    for (var i = 0; i < expressionelem.length; i++) {
        expressions[i] = {};
        var col = $(expressionelem[i]).find('.col :selected');
        var op = $(expressionelem[i]).find('.op :selected');
		
		
        expressions[i].colval = col.val();
		
        expressions[i].coldisp = col.text();
        expressions[i].opval = op.val();
        expressions[i].opdisp = op.text();
        expressions[i].val = $(expressionelem[i]).find(':text').val();;
		
    }
    q.expressions = expressions;
     
    // Get all the nested expressions
	
    if ($(elem1).find('table').length != 0) {
        var len = $(elem1).find('table').length;

        for (var k = 0; k < len; k++) {
			var as = $(elem1).find('table');
			var condition = $(elem[k]).find('.conditiondata').val()
            nestedexpressions[k] = getCondition($(elem1).find('table')[k],condition);
        }
    }
    q.nestedexpressions = nestedexpressions;

    return q; // return statement
};

//Recursive method to iterate over the condition tree and generate the query
var getQuery = function (condition) {
	
	console.log(condition);
    var op = [' ', condition.operator, ' '].join('');

    var e = [];
    var elen = condition.expressions.length;
    for (var i = 0; i < elen; i++) {
        var expr = condition.expressions[i];
		var inputValue = expr.val;
		var conditionType = expr.opval;
		console.log(conditionType);
		
   // get input value according to condition select 
		
		if(inputValue.indexOf('/')>0){
			var fdate = inputValue.split('/');
			var new_date = fdate[2]+'-'+fdate[0]+'-'+fdate[1]; 
			var  exps = "'" + new_date + "'";
		}else if(conditionType == 'LIKE' ){
		  var exps = "'%"+ inputValue +"%'";
		}
		else{
		  var exps = encodeURIComponent("'"+ inputValue +"'");
		}
		
        e.push(expr.colval + " " + expr.opval + " " + exps);
    }

    var n = [];
    var nlen = condition.nestedexpressions.length;
    for (var k = 0; k < nlen; k++) {
        var nestexpr = condition.nestedexpressions[k];
        var result = getQuery(nestexpr);
        n.push(result);
    }

    var q = [];
    if (e.length > 0)
        q.push(e.join(op));
    if (n.length > 0)
        q.push(n.join(op));

    return ['(', q.join(op), ')'].join(' ');
};

// after this all are secondery condition 


var getFriendlyQuery = function (condition) {
	
	console.log(condition);
    var op = [' ', condition.operator, ' '].join('');

    var e = [];
    var elen = condition.expressions.length;
    for (var i = 0; i < elen; i++) {
        var expr = condition.expressions[i];
        e.push(expr.coldisp + " " + expr.opdisp + " " + expr.val);
    }

    var n = [];
    var nlen = condition.nestedexpressions.length;
    for (var k = 0; k < nlen; k++) {
        var nestexpr = condition.nestedexpressions[k];
        var result = getQuery(nestexpr);
        n.push(result);
    }

    var q = [];
    if (e.length > 0)
        q.push(e.join(op));
    if (n.length > 0)
        q.push(n.join(op));

    return ['(', q.join(op), ')'].join(' ');
};




function getOperator(col,val){
		 var par = $(col).parent();
		 var len = par.length;
	$(par[len-1]).find('.valData').val('');
  if(val.length > 0){	
	$.get('classes/reports_columnar.class.php',{operator:val}).done(function(data){
		 
		var jsonData = JSON.parse(data);
		console.log(jsonData[0]);
		var type =  jsonData[0].type;
		
		if(type == 'date'){
			$(par[len-1]).find('#inputText').html('<input type="text"  id="valData" class="form-control span2 valData date" onkeyup="checkVal(\'.op\',$(this).val())" onfocus="checkVal(\'.op\',$(this).val())" onblur="checkVal(\'.op\',$(this).val())" onclick="checkVal(\'.op\',$(this).val())" style="width:100px ; margin:0px 10px;"/>');
				$(par[len-1]).find('.valData').val('');
					var datep = $(par[len-1]).find('.date').datepicker().on('changeDate', function(ev) {datep.hide(); $(par[len-1]).find('.valData').trigger('click')}).data('datepicker');
		}
		if(type == 'currency'){
			$(par[len-1]).find('#inputText').html('<input type="text"  id="valData" class="form-control span2 valData currency" onkeyup="checkVal(\'.op\',$(this).val())" onfocus="checkVal(\'.op\',$(this).val())" onblur="checkVal(\'.op\',$(this).val())" onclick="checkVal(\'.op\',$(this).val())" style="width:100px ; margin:0px 10px;"/>');
				$(par[len-1]).find('.valData').val('');
					$(par[len-1]).find('.currency').autoNumeric('init');
		}
		
		
				arr = '';
				for (var i in jsonData) {
							var rec = jsonData[i];
							//console.log(rec);
							arr += '<option value="'+rec.comparison+'">'+rec.comparison+'</option>';
				}
				
			    $(par[len-1]).find('.op').html(arr);
				
			
		}); //end get 
	   
	   }
	
	} //end function
	
function checkValid(op,val){
	
			var buttonDiv = $(op).parent().parent().parent();
		    var par = $(op).parent();
		    var len = par.length;
	  if(val.length > 0){	
			if($(par[len-1]).find('.col').val().length > 0){
				if($(par[len-1]).find('.valData').val().length > 0){
					buttonDiv.find('.addroot').prop('disabled', false);
					buttonDiv.find('.deleteroot').removeAttr("disabled");
					resultButtonEnable();
				
				}
			
			 }
	  } else{
	  		buttonDiv.find('.addroot').attr("disabled", "disabled");
			buttonDiv.find('.deleteroot').attr("disabled", "disabled");
			resultButtonDisable();
	  }
}



function checkVal(op,val){
	
			var buttonDiv = $(op).parent().parent().parent();
		    var par = $(op).parent();
		    var len = par.length;
	 if(val.length == 0){
	  		buttonDiv.find('.addroot').attr("disabled", "disabled");
			resultButtonDisable();
	 }
			
	  if(val.length > 0){	
			if($(par[len-1]).find('.col').val().length > 0){
				if($(par[len-1]).find('.op').val().length > 0){
					
					buttonDiv.find('.addroot').prop('disabled', false);
					buttonDiv.find('.add').prop('disabled', false);
					buttonDiv.find('.deleteroot').removeAttr("disabled");
					resultButtonEnable();
				
				}
				
			
			 }
	  }
}

function getRemove(op){
		var buttonDiv = $(op).parent().parent().parent();
		var par = $(op).parent();
		var len = par.length;
		var buttonDivLen = buttonDiv.length;
		console.log($(buttonDiv[buttonDivLen-1]).find('.add'));
		if(len=1){
		  $(buttonDiv[buttonDivLen-1]).find('.add').prop('disabled', false);
		 //$(buttonDiv[buttonDivLen-1]).find('.addroot').prop('disabled', false);
		   $(buttonDiv[buttonDivLen-1]).find('.deleteroot').removeAttr("disabled");
		}

}

function resultButtonDisable(){
	$('#btnFriendQuery').attr("disabled", "disabled");
	$('#btnQuery').attr("disabled", "disabled");
	$('#getResult').attr("disabled", "disabled");
}
function resultButtonEnable(){
	$('#btnFriendQuery').prop('disabled',false);
	$('#btnQuery').prop('disabled', false);
	$('#getResult').prop('disabled', false);
}