<?php
$sprefix = $power->getField('prefix');
$sserial = $power->getField('serial');
$samount = $power->getField('amount');
if ($samount!=''){
    if (strpos($samount, '.') !== TRUE){
        $samount = number_format($samount);
        $samount = $samount . '.00';
    } else {
        $samount = number_format($samount);
    }
    $samount = '$'.$samount;
}
$stransfer = $power->getField('transfer');
$sforfeited = $power->getField('forfeited');
if ($sforfeited!=""){
    $sforfeited = strtotime($sforfeited);
    $sforfeited  = date('m/d/Y', $sforfeited);
}

?>

                    <div class="page-header">
						<div class="pull-left">
							<ul class="stats">
								<li class='lightgrey extend'>
                                    <i class="icon-barcode"></i>
									<div class="details">
										<span class="big"><strong><?php echo $sprefix.'-'.$sserial; ?></strong></span>
										<span>Power</span>
									</div>
								</li>
							</ul>
						</div>
						<div class="pull-right">
							<ul class="stats">
								<li class='grey'>
									<i class="icon-calendar"></i>
									<div class="details">
										<span class="big">February 22, 2013</span>
										<span>Wednesday, 13:56</span>
									</div>
								</li>
							</ul>
						</div>
					</div>