$(document).ready(function() {

    $('#tasks-label').html('<i class="icon-list-alt"></i> Tasks');

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
			            /* Party */  null,
			            /* Focus */    null,
                        /* Assignedby */    null,
						/* Assignedto */    null,
			            /* Task */  null,
                        /* Type */  null,
			            /* Priority */    null,
                        /* Read,Unread */    null,
						/* Deadline */    null,
						/* Progress */    null,
                        /* Tasksorder */    null
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

	LoadTasks();
});

function LoadTasks(){

    var partyid = $('#client-id').val();
    var user = $('#user-email').val();

    var oTable = $('.dataTable_1').dataTable();
	oTable.fnClearTable();

    $('#tasks-table').hide();
    $('#tasks-loading').show();
    $.get('classes/tasks.class.php', { tasks: 1, type: 'party', filter: 'NONE', partyid: partyid }, function (data) {
        var jsonData = JSON.parse(data);
        for (var i in jsonData) {
		    var rec = jsonData[i];

            var sread = rec.assignedto;
            sread = occurrences(sread,":1",false);
            var sunread = rec.assignedto;
            sunread = occurrences(sunread,":0",false);
            var sreadunread = sread+","+sunread;

            var assignedto = rec.assignedto;
            assignedto = assignedto.replace(/:1/g,"");
            assignedto = assignedto.replace(/:0/g,"");
            var ipublic = assignedto.indexOf("{public;");
            if (ipublic!=-1){
                assignedto = "<span style='color:#fff;background-color:#339933;padding:0px 4px;'>EVERYONE</span>";
            } else {
                assignedto = assignedto.replace("{private","");
                assignedto = assignedto.replace("}","");
                var iuser = assignedto.indexOf(";"+user);
                if (iuser!=-1){
                    var userassignedto = assignedto.replace(";"+user,"");
                    userassignedto = userassignedto.replace(";", " + ");
                    userassignedto = userassignedto.replace(/;/g, ", ");
                    userassignedto = "<span style='color:#fff;background-color:#339933;padding:0px 4px;'>YOU</span>"+userassignedto;
                } else {
                    var userassignedto = assignedto.replace(";", "");
                    userassignedto = userassignedto.replace(/;/g, ", ");
                }
                assignedto = userassignedto;
            }

			$('#tasks-table').dataTable().fnAddData([
            	    rec.partyid,
                    rec.focusid,
				    rec.assignedby,
				    assignedto,
		            '<a href="task.php?id='+rec.id+'">'+rec.task+'</a>',
                    '<img src="img/task_list_'+rec.type+'.png" style="margin-right:10px;">'+rec.type.charAt(0).toUpperCase()+rec.type.slice(1),
				    '<img src="img/task_list_'+rec.priority+'.png" style="margin-right:10px;">'+rec.priority.charAt(0).toUpperCase()+rec.priority.slice(1),
                    '<div style="float:left;padding:4px 6px;color:#fff;background-color:#368EE0;margin-right:10px;">'+sread+'</div><div style="float:left;padding:4px 6px;color:#000000;background-color:#9EC8F0;margin-right:10px;">'+sunread+'</div>',
                    rec.deadline,
                    '<div style="float:left;margin-right:5px;">'+rec.progress+'%</div><div class="progress progress-striped" style="width:80%;float:left;"><div class="bar" style="width: '+rec.progress+'%;float:left;"></div></div>',
                    rec.tasksorder
            ]);

		}

		var rows = $("#tasks-table").dataTable().fnGetNodes();
		for(var i=0;i<rows.length;i++){
		    $(rows[i]).find("td:eq(0)").hide();
			$(rows[i]).find("td:eq(1)").hide();
            $(rows[i]).find("td:eq(2)").hide();
			$(rows[i]).find("td:eq(10)").hide();
		}

    });

    $('#tasks-loading').hide();
    $('#tasks-table').show();

}


/** Function count the occurrences of substring in a string;
 * @param {String} string   Required. The string;
 * @param {String} subString    Required. The string to search for;
 * @param {Boolean} allowOverlapping    Optional. Default: false;
 */
function occurrences(string, subString, allowOverlapping){

    string+=""; subString+="";
    if(subString.length<=0) return string.length+1;

    var n=0, pos=0;
    var step=(allowOverlapping)?(1):(subString.length);

    while(true){
        pos=string.indexOf(subString,pos);
        if(pos>=0){ n++; pos+=step; } else break;
    }
    return(n);
}

