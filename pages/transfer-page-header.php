<?php
$stype = $transfer->getField('type');
$samount = $transfer->getField('amount');
if (strpos($samount, '.') !== TRUE){
    $samount = number_format($samount);
    $samount = $samount . '.00';
} else {
    $samount = number_format($samount);
}
$stime = '';
switch ($stype) {
    case 'recorded':
        $timestamp = strtotime($transfer->getField('recorded'));
        $stime = date('F j, Y, g:i a', $timestamp);
        break;
    case 'dispatched':
        $timestamp = strtotime($transfer->getField('dispatched'));
        $stime = date('F j, Y, g:i a', $timestamp);
        break;
    case 'rejected':
        $timestamp = strtotime($transfer->getField('rejected'));
        $stime = date('F j, Y, g:i a', $timestamp);
        break;
    case 'posted':
        $timestamp = strtotime($transfer->getField('posted'));
        $stime = date('F j, Y, g:i a', $timestamp);
        break;
    case 'settled':
        $timestamp = strtotime($transfer->getField('settled'));
        $stime = date('F j, Y, g:i a', $timestamp);
        break;
}
?>

                    <div class="page-header">
						<div class="pull-left">
							<ul class="stats">
								<li class='lightgrey extend'>
                                    <i class="icon-random"></i>
									<div class="details">
										<span class="big"><strong><?php echo '$'.$samount; ?> Transfer</strong></span>
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