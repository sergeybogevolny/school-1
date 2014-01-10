$(document).ready(function() {

        if ($("#detail-type").length > 0) {
			function formatImages(option) {
				var img = "task_list_" + option.text.toLowerCase() + ".png";
				return "<img style='padding-right:10px;' src='img/" + img + "'>" + option.text;
			}
			$("#detail-type").select2({
				formatResult: formatImages,
				formatSelection:formatImages,
				escapeMarkup: function(m) { return m; }
			});
	    }
        if ($("#detail-priority").length > 0) {
			function formatImages(option) {
				var img = "task_list_" + option.text.toLowerCase() + ".png";
				return "<img style='padding-right:10px;' src='img/" + img + "'>" + option.text;
			}
			$("#detail-priority").select2({
				formatResult: formatImages,
				formatSelection:formatImages,
				escapeMarkup: function(m) { return m; }
			});
	    }

        $('#detail-label').html('Detail');
        $('#timeline-label').html('Timeline');

        $("#jqxWindow-status").jqxWindow({
            width: 290, height: 160, resizable: false, keyboardCloseKey: 'esc', isModal: true, autoOpen: false, theme: 'metro' });

        var detaildeadline = $('.datepicker').datepicker().on('changeDate', function(ev) {detaildeadline.hide();}).data('datepicker');

        $("#detail-cancel").click(function(){
            DetailCancel();
		});

        $("#timeline-cancel").click(function(){
            TimelineCancel();
		});

        $("#detail-form").validate({
	        submitHandler: function() {
                $('#detail-save').button('loading');
				var id = $('#detail-id').val();
                ModifyDetail(id);
            },
        });

        $("#timeline-form").validate({
	        submitHandler: function() {
                $('#timeline-save').button('loading');
                ModifyTimeline();
            },
        });

        $("#timeline-add").click(function(event){
			event.preventDefault();
			$("#timeline-comment").val('');
			$('#list-actions').hide();
			$('#timeline-list-actions').hide();
			$('#timeline-list').hide();
			$('#detail-view').hide();
			$('#timeline-label').html('Timeline - Add');
			$('#timeline-box').show();
		    $("#timeline-id").val(-1);
			
		});


        var assignedto = DETAIL_ASSIGNEDTO;
        var user = DETAIL_USER;
        assignedto = assignedto.replace(/:1/g,"");
        assignedto = assignedto.replace(/:0/g,"");
        var ipublic = assignedto.indexOf("{public;");
        if (ipublic!=-1){
            assignedto = "EVERYONE";
        } else {
            assignedto = assignedto.replace("{private","");
            assignedto = assignedto.replace("}","");
            var iuser = assignedto.indexOf(";"+user);
            if (iuser!=-1){
                var userassignedto = assignedto.replace(";"+user,"");
                userassignedto = userassignedto.replace(";", " + ");
                userassignedto = userassignedto.replace(/;/g, ", ");
                userassignedto = "YOU"+userassignedto;
            } else {
                var userassignedto = assignedto.replace(";", "");
                userassignedto = userassignedto.replace(/;/g, ", ");
            }
            assignedto = userassignedto;
        }
        DETAIL_ASSIGNEDTO = assignedto;
        $('#detail-assignedto').html(assignedto);
		
		
		$(".slider").each(function(){
			var $el = $(this);
			var min = parseInt($el.attr('data-min')),
			max = parseInt($el.attr('data-max')),
			step = parseInt($el.attr('data-step')),
			range = $el.attr('data-range'),
			rangestart = parseInt($el.attr('data-rangestart')),
			rangestop = parseInt($el.attr('data-rangestop'));

			var opt = {
				min: min,
				max: max,
				step: step,
				slide: function( event, ui ) {
					console.log(ui.value);
					$('#timeline-progress').val( ui.value );
					$el.find('.amount').html( ui.value +'%');
				}
			};

			if(range !== undefined)
			{
				opt.range = true;
				opt.values = [rangestart, rangestop];
				opt.slide = function( event, ui ) {
					$el.find('.amount').html( ui.values[0]+" - "+ui.values[1] );
					$el.find(".amount_min").html(ui.values[0]+"$");
					$el.find(".amount_max").html(ui.values[1]+"$");
				};
			}

			$el.slider(opt);
			if(range !== undefined){
				var val = $el.slider('values');
				$el.find('.amount').html(val[0] + ' - ' + val[1]);
				$el.find(".amount_min").html(val[0]+"$");
				$el.find(".amount_max").html(val[1]+"$");
			} else {
				$el.find('.amount').html($el.slider('value'));
			}
		});
         var progress = PROGRESS+'%';
		$('.ui-slider-handle').css( "left", progress );
        $('.amount').html( progress );
		$('#timeline-progress').val(PROGRESS);

});


function LoadDetail(id){
    var type  = DETAIL_TYPE;
    var task  = DETAIL_TASK;
    var description = DETAIL_DESCRIPTION;
    var priority  = DETAIL_PRIORITY;
    var deadline = DETAIL_DEADLINE;

    $("#detail-type").select2('val', type);
    $("#detail-name").val(task);
    $("#detail-description").val(description);
    $("#detail-priority").select2('val', priority);
    $("#detail-deadline").val(deadline);
    $('input[name=detail-id]').val(id);

    $('#list-actions').hide();
    $('#detail-list-actions').hide();
    $('#detail-list').hide();
    $('#timeline-view').hide();
    $('#detail-label').html('Detail - Edit');
    $('#detail-box').show();

    $("#detail-task").focus();

}


function LoadTimeline(id){
    var row = TIMELINE_SOURCE.filter( function(item){return (item.id==id);} );

    var id = row[0]['id'];
    var activity = row[0]['activity'];
    var progress = row[0]['progress'];
	
    $("#timeline-id").val(id);
    $("#timeline-comment").val(activity);
	
    $('#list-actions').hide();
    $('#timeline-list-actions').hide();
    $('#timeline-list').hide();
    $('#detail-view').hide();
    $('#timeline-label').html('Timeline - Edit');
    $('#timeline-view').css('margin-left','-5px');
    $('#timeline-box').show();

    //$("#timeline-source").focus();

}

function ReportCampaign(reportid,sqlid){
    window.location.href = 'reports-campaign.php?id='+reportid+'&rsqlid='+sqlid;
}


function DetailCancel(){
    $('#detail-box').hide();
    $('#detail-label').html('Detail');
    $('#list-actions').show();
    $('#detail-list-actions').show();
    $('#detail-list').show();
    $('#timeline-view').show();
}

function TimelineCancel(){
    $('#timeline-box').hide();
    //$('#timeline-view').css('margin-left','40px');
    $('#timeline-label').html('Timeline');
    $('#list-actions').show();
    $('#timeline-list-actions').show();
    $('#timeline-list').show();
    $('#detail-view').show();
}

function ModifyDetail(){
    post = $('#detail-form').serialize();
    $.post('classes/logic_task.class.php', post, function (data) {
        if (data.match('success') !== null) {
            location.reload();
        } else {
			$('#modal-title-error').html('System');
			$('#modal-body-error').html(data);
			$("#modal-error").modal();
            $('#detail-save').button('reset');
        }
    });
}

function ModifyTimeline(){
	
    post = $('#timeline-form').serialize();
    $.post('classes/logic_task.class.php', post, function (data) {
        if (data.match('success') !== null) {
            location.reload();
        } else {
			$('#modal-title-error').html('System');
			$('#modal-body-error').html(data);
			$("#modal-error").modal();
            $('#timeline-save').button('reset');
        }
    });
}

function markread(id){
    $.get('classes/logic_task.class.php', {'read': true,'id':id }).done( function(data) {
		      location.reload();
		});

}
