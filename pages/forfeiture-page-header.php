<?php
$stype = $forfeiture->getField('type');
$samount = $forfeiture->getField('amount');
if (strpos($samount, '.') !== TRUE){
    $samount = number_format($samount);
    $samount = $samount . '.00';
} else {
    $samount = number_format($samount);
}
$stime = '';
switch ($stype) {
    case 'recorded':
        $timestamp = strtotime($forfeiture->getField('recorded'));
        $stime = date('F j, Y, g:i a', $timestamp);
        break;
    case 'questioned':
        $timestamp = strtotime($forfeiture->getField('questioned'));
        $stime = date('F j, Y, g:i a', $timestamp);
        break;
    case 'charged':
        $timestamp = strtotime($forfeiture->getField('charged'));
        $stime = date('F j, Y, g:i a', $timestamp);
        break;
    case 'documented':
        $timestamp = strtotime($forfeiture->getField('documented'));
        $stime = date('F j, Y, g:i a', $timestamp);
        break;
    case 'disposed':
        $timestamp = strtotime($forfeiture->getField('disposed'));
        $stime = date('F j, Y, g:i a', $timestamp);
        break;
}
?>

                    <div class="page-header">
						<div class="pull-left">
							<ul class="stats">
								<li class='lightgrey extend'>
                                    <i class="glyphicon-bomb" style="margin-top:10px;"></i>
									<div class="details">
										<span class="big"><strong><?php echo '$'.$samount; ?> Forfeiture</strong></span>
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