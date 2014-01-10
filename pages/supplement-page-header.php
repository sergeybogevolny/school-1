<?php
$stype = $supplement->getField('type');
$samount = $supplement->getField('amount');
if (strpos($samount, '.') !== TRUE){
    $samount = number_format($samount);
    $samount = $samount . '.00';
} else {
    $samount = number_format($samount);
}
$stime = '';
switch ($stype) {
    case 'recorded':
        $timestamp = strtotime($supplement->getField('recorded'));
        $stime = date('F j, Y, g:i a', $timestamp);
        break;
    case 'contracted':
        $timestamp = strtotime($supplement->getField('contracted'));
        $stime = date('F j, Y, g:i a', $timestamp);
        break;
    case 'billed':
        $timestamp = strtotime($supplement->getField('billed'));
        $stime = date('F j, Y, g:i a', $timestamp);
        break;
}
?>


                    <div class="page-header">
						<div class="pull-left">
							<ul class="stats">
								<li class='lightgrey extend'>
                                    <img src='img/supplement.png'>
									<div class="details">
										<span class="big"><strong><?php echo '$'.$samount; ?> Supplement</strong></span>
										<span><?php echo ucwords($stype).' - '.$stime; ?></span>
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