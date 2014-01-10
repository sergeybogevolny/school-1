$(document).ready(function() {

    $('#inventory-label').html('<i class="icon-list-alt"></i> Unreported');

    $("#detail-cancel").click(function(){
		$('#detail-void').prop('checked', false);
        $('#inventory-box').hide();
        $('#inventory-label').html('<i class="icon-list-alt"></i> Unreported');
        $('#list-actions').show();
        $('#inventory-list').show();
	});
	$('#detail-amount').autoNumeric('init');
    $("#detail-executeddate").inputmask("mm/dd/yyyy", { clearIncomplete: true, placeholder: "mm/dd/yyyy"});
    $("#detail-voided").inputmask("mm/dd/yyyy", { clearIncomplete: true, placeholder: "mm/dd/yyyy"});
	
        $("#detail-void").change(function() {
            var flag = $('#detail-void').is(":checked");
            if (flag==true){
				
				$('#detail-name').val('');
				$('#detail-executeddate').val('');
				$('#detail-amount').val('');
				var voiddate = $('#void-date').text();
				$('#detail-voided').val(voiddate);
				$('#detail-voided').prop('disabled', false);
				$('#detail-transfer').prop('checked', false);
				$('#detail-name').attr("disabled","disabled");
				$('#detail-executeddate').attr("disabled","disabled");
				$('#detail-amount').attr("disabled","disabled");
				document.getElementById("detail-transfer").disabled=true;
            } else{
				$('#detail-voided').val('');
				$('#detail-voided').attr("disabled","disabled");
				$('#detail-name').prop('disabled', false);
				$('#detail-executeddate').prop('disabled', false);
				$('#detail-amount').prop('disabled', false);
				document.getElementById("detail-transfer").disabled=false;
				
				
				var rname = $('#name-review').text();
				var rexecuteddate = $('#executeddate-review').text();
				var ramount = $('#amount-review').text();
				var rtransfer = $('#transfer-review').text();
				
				if(rname != 'null'){
				 $('#detail-name').val(rname);
				}
				$('#detail-executeddate').val(rexecuteddate);
				$('#detail-amount').val(ramount);
				 if(rtransfer == 1){
						 $('#detail-transfer').prop('checked', true);
					}else{
						$('#detail-transfer').prop('checked', false);
					}
            }
        });
	   
	   
	   
	    $("#inventory-form").validate({
	        submitHandler: function() {
               
                    var id = $("#bond-id").val();
                    if (id==''){
                        ModifyBond('add');
                    } else {
                        ModifyBond('edit');
                    }
                
            },
        });	
	

});


function LoadInventory(id){
    var row = INVENTORY_SOURCE.filter( function(item){return (item.id==id);} );

	var name = row[0]['name'];
	var executeddate = row[0]['executeddate'];
	var voiddate = row[0]['voiddate'];
	var amount   = row[0]['amount'];
	var transfer = row[0]['transfer'];
	var voids = row[0]['void'];
	var bondid = row[0]['bond_id'];
	var powerid = row[0]['id'];
	
	if(voids == 1){
		$('#detail-name').val('');
		$('#detail-executeddate').val('');
		$('#detail-amount').val('');
		$('#detail-voided').prop('disable', false);
		$('#detail-voided').val(voiddate);
		$('#detail-transfer').prop('checked', false);
		$('#detail-void').prop('checked', true);
		$('#detail-name').attr("disabled","disabled");
		$('#detail-executeddate').attr("disabled","disabled");
		$('#detail-amount').attr("disabled","disabled");
		document.getElementById("detail-transfer").disabled=true;
	}else{
		
		$('#detail-voided').val('');
		$('#detail-voided').attr("disabled","disabled");
		
		$('#detail-void').prop('checked', false);
		$('#detail-name').prop('disabled', false);
		$('#detail-executeddate').prop('disabled', false);
		$('#detail-amount').prop('disabled', false);
		document.getElementById("detail-transfer").disabled=false;
		
		$('#detail-void').prop('checked', false);
		$('#detail-name').val(name);
		$('#detail-executeddate').val(executeddate);
		$('#detail-amount').val(amount);
	}
	
	$('#name-review').text(name);
	$('#executeddate-review').text(executeddate);
	$('#amount-review').text(amount);
	$('#transfer-review').text(transfer);
	$('#void-date').text(voiddate);
	
    //$("#bond-class").val(bondclass);

    $('input[name=bond-id]').val(bondid);
    $('input[name=power-id]').val(powerid);
	
   
 if(transfer == 1){
	     $('#detail-transfer').prop('checked', true);
	}else{
		$('#detail-transfer').prop('checked', false);
	}
    $('#list-actions').hide();
    $('#inventory-list').hide();
    $('#inventory-label').html('<i class="icon-list-alt"></i> Unreported - Edit');
    $('#inventory-box').show();
	

}

function ModifyBond(type){

    var post = $('#inventory-form').serialize();
   
    $.post('classes/inventory.class.php', post, function (data) {
        if (data.match('success') !== null) {
            location.reload();
        } else {
            $('#modal-title-error').html('System');
            $('#modal-body-error').html(data);
            $("#modal-error").modal();
            if (type=='delete'){
                $('#jqxWindow-confirm').jqxWindow('close');
            } else {
                $('#bond-save').button('reset');
            }
        }
    });
}




