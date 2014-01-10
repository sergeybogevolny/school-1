<?php
include_once(dirname(dirname(__FILE__)) . '/classes/check.class.php');
protect("1,2");

include_once('classes/client.class.php');
$id = $client->getField('id');
$linkid = $client->getField('link_id');
$stype = $client->getField('type');
if ($stype=='Reject'){
    $title = 'prospect';
} else if ($stype=='Prospect'){
    $title = 'prospect';
} else {
    $title = 'client';
}
$label = 'summary';

include("header.php");

include_once('./client-communication-call.php');
include_once('classes/functions-client.php');
include_once('classes/agency_user_history.class.php');
include_once('classes/listbox.class.php');
$races = $listbox->getRaces();
$phones = $listbox->getPhones();
$sts = $listbox->getSts();
$sources = $listbox->getSources();
$jails = $listbox->getJails();
$identifiers = $listbox->getIdentifiers();

$sname = '';
$sfirst = $client->getField('first');
$smiddle = $client->getField('middle');
$slast = $client->getField('last');
if ($sfirst!=""){
    $sname = $sfirst;
}
$sname = trim($sname);
if ($smiddle!=""){
    $sname = $sname . ' ' . $smiddle;
}
$sname = trim($sname);
if ($slast!=""){
    $sname = $sname . ' ' . $slast;
}
$sname = trim($sname);

$sdob = $client->getField('dob');
if ($sdob!=""){
    $timestamp = strtotime($sdob);
    $sdob  = date('m/d/Y', $timestamp);
}
$sssn = $client->getField('ssnlast4');
if ($sssn!=""){
    $sssn  = "XXX-XX-" . $sssn;
}

$sgender = $client->getField('gender');
$srace = $client->getField('race');
$saddress = $client->getField('address');
$scitystatezip="";
$scity = $client->getField('city');
$sstate = $client->getField('state');
$szip = $client->getField('zip');
if ($scity!=""){
    $scitystatezip = $scity;
}
if ($sstate!=""){
    if ($scitystatezip!=""){
        $scitystatezip = $scitystatezip . ", " . $sstate;
    } else {
        $scitystatezip = $sstate;
    }
}
if ($szip!=""){
    if ($scitystatezip!=""){
        $scitystatezip = $scitystatezip . " " . $szip;
    } else {
        $scitystatezip = $szip;
    }
}
$slatitude = $client->getField('latitude');
$slongitude = $client->getField('longitude');
$sisvalid = $client->getField('isvalid');
$sphone1type = $client->getField('phone1type');
$sphone1 = $client->getField('phone1');
$sphone2type = $client->getField('phone2type');
$sphone2 = $client->getField('phone2');
$sphone3type = $client->getField('phone3type');
$sphone3 = $client->getField('phone3');
$sphone4type = $client->getField('phone4type');
$ssuggest = $client->getField('suggest');
$ssuggestcomment = $client->getField('suggestcomment');
$sphone4 = $client->getField('phone4');
$ssource = $client->getField('source');
$slogged = $client->getField('logged');
if ($slogged!=""){
    $logged = strtotime($slogged);
    $slogged  = date('d F Y - h:i A', $logged);
}
$sjailed = $client->getField('jailed');
if ($sjailed!=""){
    $jailed = strtotime($sjailed);
    $sjailed  = date('d F Y - h:i A', $jailed);
}
$sposted = $client->getField('posted');
if ($sposted!=""){
    $posted = strtotime($sposted);
    $sposted  = date('d F Y - h:i A', $posted);
}
$srejected = $client->getField('rejected');
if ($srejected!=""){
    $rejected = strtotime($srejected);
    $srejected  = date('d F Y - h:i A', $rejected);
}

$sidentifiertype = $client->getField('identifiertype');
$sidentifier = $client->getField('identifier');

$stags = $client->getField('tags');
$sttags = "<input type='text' name='transaction-tags' class='input' value='".$stags."'/>";
$sstanding = $client->getField('standing');
$sjail = $client->getField('standingcustodyjail');
$swarrant = $client->getField('standingwarrantdescription');
$sother = $client->getField('standingotherdescription');
$srate = $client->getField('rate');
$sratecomment = $client->getField('ratecomment');
$srateby= $client->getField('rateby');
$sratestamp = $client->getField('ratestamp');
if ($sratestamp==''){
    $timediff = '';
} else {
    $currentdate = strtotime(date('Y-m-d h:i:s'));
    $diffrence = strtotime($sratestamp);
    $timediff = $client->timeFormat($diffrence,$currentdate);
}
$balance = number_format($client->getField('accountbalance'),2,'.', '');
$sbalance = number_format($client->getField('accountbalance'), 2, '.', ',');
$scheckin = $client->getCheckin($id);
$sappearance = $client->getAppearance($id);
$agencyuserhistory->add($sname, 'client.php?id='.$id);

$sdl = $client->getField('dl');
$sdlst = $client->getField('dlst');
$semployer = $client->getField('employer');
$semployersince = $client->getField('employersince');
if (!empty($semployersince)){
    $semployersince = date('m/d/Y',strtotime($semployersince));
   }
$semail = $client->getField('email');

$sfee = $client->getField('quotefee');
$sdown = $client->getField('quotedown');
$sterms = $client->getField('quoteterms');


//get ledger field value

$debitentries = $listbox->getDebitentries();
$creditentries = $listbox->getCreditentries();
$paymentmethods = $listbox->getPaymentmethods();

$accountdue = $client->setAccountDue($id,$balance);
//$nextpaydate =  $accountdue[0];
//$dayspastdue =  $accountdue[1];
//$pastdue = $accountdue[2];
$nextpaydate =  $accountdue[0];
$dayspastdue =  $accountdue[1];
$dueamount = $accountdue[2];


// bond summery
$bond_summery = $client->bondSummery($id);


if ($stype=='Client'){
    //transaction summery
    $transaction_summery = $client->transactionSummery($linkid);
    $transaction_date =  $transaction_summery['Date'];
    $transaction_count = $transaction_summery['Count'];
    $transaction_since = date('F Y',strtotime($transaction_summery['Date']['0']));
}



?>

    <?php if ($stype=='Client') { ?>
        <script src="js/ajaxupload.js"></script>
        <script type="text/javascript" src="//static.twilio.com/libs/twiliojs/1.1/twilio.min.js"></script>
        <script type="text/javascript">
            var TWILIO_TOKEN = "<?php echo $twilio_token; ?>";
        </script>
        <!-- [ADDED BY RISAN] Load scriptt for handling communication -->
        <script src="js/client-communication.js"></script>
        <!-- [ADDED BY RISAN] pass Twilio token to Javascript, used to make a phone call -->
    <?php } ?>

    <script src="js/client.js"></script>
    <script src="js/plugins/autonumeric/autoNumeric.js"></script>
    <script type="text/javascript">
        var np = "<?php echo $nextpaydate; ?>";
        var dp = "<?php echo $dayspastdue; ?>";
        var pd = "<?php echo $dueamount; ?>";
        var da = "<?php echo $dueamount; ?>";
		var CLIENT_ID   = "<?php echo $id; ?>";
        var CLIENT_LAST = "<?php echo $slast; ?>";
        var CLIENT_FIRST = "<?php echo $sfirst; ?>";
        var CLIENT_MIDDLE = "<?php echo $smiddle; ?>";
        var CLIENT_DOB = "<?php echo $sdob; ?>";
        var CLIENT_SSN = "<?php echo $client->getField('ssnlast4'); ?>";
        var CLIENT_GENDER = "<?php echo $sgender; ?>";
        var CLIENT_RACE = "<?php echo $srace; ?>";
        var CLIENT_ADDRESS = "<?php echo $saddress; ?>";
        var CLIENT_CITY = "<?php echo $scity; ?>";
        var CLIENT_STATE = "<?php echo $sstate; ?>";
        var CLIENT_ZIP = "<?php echo $szip; ?>";
        var CLIENT_LATITUDE = "<?php echo $slatitude; ?>";
        var CLIENT_LONGITUDE = "<?php echo $slongitude; ?>";
        var CLIENT_ISVALID = "<?php echo $sisvalid; ?>";
        var CLIENT_PHONE1TYPE = "<?php echo $sphone1type; ?>";
        var CLIENT_PHONE1 = "<?php echo $sphone1; ?>";
        var CLIENT_PHONE2TYPE = "<?php echo $sphone2type; ?>";
        var CLIENT_PHONE2 = "<?php echo $sphone2; ?>";
        var CLIENT_PHONE3TYPE = "<?php echo $sphone3type; ?>";
        var CLIENT_PHONE3 = "<?php echo $sphone3; ?>";
        var CLIENT_PHONE4TYPE = "<?php echo $sphone4type; ?>";
        var CLIENT_PHONE4 = "<?php echo $sphone4; ?>";
        var CLIENT_SOURCE = "<?php echo $ssource; ?>";
        var CLIENT_TAGS = "<?php echo $stags; ?>";
        var TRANSACTION_TAGS = "<?php echo $sttags; ?>"
        var CLIENT_LOGGED = "<?php echo $slogged; ?>";
        var CLIENT_JAILED = "<?php echo $sjailed; ?>";
        var CLIENT_POSTED = "<?php echo $sposted; ?>";
        var CLIENT_REJECTED = "<?php echo $srejected; ?>";
        var CLIENT_STANDING = "<?php echo $sstanding; ?>";
        var CLIENT_JAIL = "<?php echo $sjail; ?>";
        var CLIENT_WARRANT = "<?php echo $swarrant; ?>";
        var CLIENT_OTHER = "<?php echo $sother; ?>";
        var CLIENT_RATE = "<?php echo $srate; ?>";
        var CLIENT_RATECOMMENT = "<?php echo $sratecomment; ?>";
        var CLIENT_DL = "<?php echo $sdl; ?>";
        var CLIENT_EMPLOYER = "<?php echo $semployer; ?>";
        var CLIENT_EMPLOYERSINCE = "<?php echo $semployersince; ?>";
        var CLIENT_EMAIL = "<?php echo $semail; ?>";
		var CLIENT_IDENTIFIERTYPE = "<?php echo $sidentifiertype; ?>";
        var CLIENT_IDENTIFIER = "<?php echo $sidentifier; ?>";
        var CLIENT_TYPE = "<?php echo $stype; ?>";
		var CLIENT_FEE = "<?php echo $sfee; ?>";
        var CLIENT_DOWN = "<?php echo $sdown; ?>";
        var CLIENT_TERMS = "<?php echo $sterms; ?>";

    </script>

        <div class="container-fluid" id="content">

            <?php include_once('pages/client-nav-left.php'); ?>

			<div id="main">
				<div class="container-fluid">

                    <?php include_once('pages/client-page-header.php'); ?>

                    <div class="row-fluid">
						<div class="span12">
                            <div class="box">
      							<div class="box-title">
      								<h3>
      									<i class="icon-th-large"></i>
      									Summary
      								</h3>
      							</div>
      							<div class="box-content">
                                    <div class="pull-left">
                                        <?php if ($stype=='Reject') { ?>
                                        <ul class="stats">
                                            <li class="button client-menu">
                                                <div class="btn-group">
    												<a href="#" data-toggle="dropdown" class="btn btn-primary dropdown-toggle"><i class="icon-bolt"></i></a>
    												<ul class="dropdown-menu dropdown-primary">
                                                        <li>
    														<a href="#" id="actions-delete">Delete</a>
    													</li>
    												</ul>
    										    </div>
                                            </li>
                                            <?php if ($srate!=''){
                                                if ($srate=='uncertain'){ ?>
                                                    <li class='orange extend' id="prospect-rate-tile" style="display:none">
                                                <?php } else if ($srate=='thumbs-up'){ ?>
                                                    <li class='green extend' id="prospect-rate-tile" style="display:none">
                                                <?php } else if ($srate=='thumbs-down'){ ?>
                                                    <li class='red extend' id="prospect-rate-tile" style="display:none">
                                                <?php } else { ?>
                                                    <li class='extend' id="prospect-rate-tile" style="display:none">
                                                <?php } ?>
            										<!--<i class="icon-question-sign"></i>-->
                                                    <img src='img/rate_<?php echo $srate; ?>.png'>
            										<div class="details">
            											<span style="font-size:14px;"><?php echo $sratecomment; ?></span>
            											<span><span style="float:left; margin-right:5px"><?php echo $srateby ; ?></span><span style="float:right"><?php echo $timediff ?></span></span>
            										</div>
            									</li>
                                            <?php } ?>
                                        </ul>
                                        <?php } ?>
                                        <?php if ($stype=='Prospect') { ?>
                                        <ul class="stats">
                                            <li class="button client-menu">
                                                <div class="btn-group">
    												<a href="#" data-toggle="dropdown" class="btn btn-primary dropdown-toggle"><i class="icon-bolt"></i></a>
    												<ul class="dropdown-menu dropdown-primary">
    													<li>
    														<a href="#" id="actions-convert">Convert</a>
    													</li>
                                                        <li>
    														<a href="#" id="actions-reject">Reject</a>
    													</li>
                                                        <li>
    														<a href="#" id="actions-delete">Delete</a>
    													</li>
    												</ul>
    										    </div>
                                            </li>
                                            <li class="button">
                                                <div class="btn-group">
    												<a href="#" id="prospect-rate" class="btn btn-primary"><img src='img/client_rating.png'></a>
    										    </div>
                                            </li>
                                            <?php if ($srate!=''){
                                                if ($srate=='uncertain'){ ?>
                                                    <li class='orange extend' id="prospect-rate-tile" style="display:none">
                                                <?php } else if ($srate=='thumbs-up'){ ?>
                                                    <li class='green extend' id="prospect-rate-tile" style="display:none">
                                                <?php } else if ($srate=='thumbs-down'){ ?>
                                                    <li class='red extend' id="prospect-rate-tile" style="display:none">
                                                <?php } else { ?>
                                                    <li class='extend' id="prospect-rate-tile" style="display:none">
                                                <?php } ?>
            										<!--<i class="icon-question-sign"></i>-->
                                                    <img src='img/rate_<?php echo $srate; ?>.png'>
            										<div class="details">
            											<span style="font-size:14px;"><?php echo $sratecomment; ?></span>
            											<span><span style="float:left; margin-right:5px"><?php echo $srateby ; ?></span><span style="float:right"><?php echo $timediff ?></span></span>
            										</div>
            									</li>
                                            <?php } ?>
                                            <?php if($bond_summery['Count'] > 0){ ?>
                                            <li class='darkblue'>
        										<span class="count"><?php echo $bond_summery['Count']; ?></span>
                								<div class="details">
                								    <span class="big">Bond(s)</span>
                									<span>totaling $<?php echo $bond_summery['Sum']; ?></span>
                								</div>
        									</li>
                                            <?php } ?>
                                        </ul>
                                        <?php } ?>
                                        <?php if ($stype=='Client') { ?>
                                        <ul class="stats">
                                            <li class="button">
                                                <div class="btn-group">
    												<a href="#" data-toggle="dropdown" class="btn btn-primary dropdown-toggle"><i class="icon-bolt"></i></a>
    												<ul class="dropdown-menu dropdown-primary">
    													<li>
														    <a href="#" id="actions-revert">Revert</a>
													    </li>
    												</ul>
    										    </div>
                                            </li>
                                            <li class="button">
                                              <div class="btn-group">
                                                 <a href="#" class="btn btn-primary" id="client_checkin"><img src='img/client_checkin.png'></a>
                                               </div>
                                            </li>
                                            <li class="button">
                                              <div class="btn-group">
                                                  <a href="#" class="btn btn-primary" id="client_payment"><img src='img/client_payment.png'></a>
                                               </div>
                                            </li>
                                            <li class="button">
                                                <div class="btn-group">
    												<a href="#" data-toggle="dropdown" class="btn btn-primary"><i class="icon-bullhorn"></i></a>
                                                    <ul class="dropdown-menu dropdown-primary">
                                                        <?php displayClientcampaignmenu("client","client",$id,$id); ?>
                                                        <?php displayClientcampaignmenu("client","indemnitor",$id,$id); ?>
                                                    </ul>
    										    </div>
                                            </li>

                                            <?php if($transaction_count==1) { ?>
                                            <li class='darkblue'>
                                                <span class="count"><?php echo $transaction_count; ?></span>
                								<div class="details">
                								    <span class="big">Transaction(s)</span>
                									<span>since <?php echo $transaction_since; ?></span>
                								</div>
        									</li>
                                            <?php } ?>
                                            <?php if($transaction_count>1) { ?>
                                            <li class='menubutton'>
                                                <div class="btn-group">
    												<a href="#" data-toggle="dropdown" class="btn btn-primary dropdown-toggle menubutton-main">
                                                        <span class="count"><?php echo $transaction_count; ?></span>
                										<div class="details">
                											<span class="big">Transaction(s)</span>
                											<span>since <?php echo $transaction_since; ?></span>
                										</div>
                                                    </a>
                                                    <ul class="dropdown-menu dropdown-primary">
                                                    <?php foreach($transaction_date as $transDate ): ?>
                                                        <li>
												            <a href="#" id="transaction-action1"><?php echo date('m/d/Y',strtotime($transDate)); ?></a>
													    </li>
                                                    <?php endforeach ?>
    												</ul>
    										    </div>
        									</li>
                                            <?php } ?>
                                            <?php if($bond_summery['Count'] > 0){ ?>
                                            <li class='darkblue'>
        										<span class="count"><?php echo $bond_summery['Count']; ?></span>
                								<div class="details">
                								    <span class="big">Bond(s)</span>
                									<span>totaling $<?php echo $bond_summery['Sum']; ?></span>
                								</div>
        									</li>
                                            <?php } ?>
                                            <li class='green'>
        										<i class="icon-money"></i>
        										<div class="details">
        											<span class="big">$<?php echo $sbalance; ?></span>
        											<span>Balance</span>
        										</div>
        									</li>
                                            <?php if ($dayspastdue!=0){ ?>
                                                <li class='red'>
            										<i class="icon-flag"></i>
            										<div class="details">
            											<span class="big">Past Due</span>
            											<span><?php echo $dayspastdue.' day(s) / $'.number_format($dueamount, 2, '.', ','); ?></span>
            										</div>
            									</li>
                                            <?php } else if ($dueamount!=0) { ?>
                                                <li class='orange'>
            										<i class="icon-flag"></i>
            										<div class="details">
            											<span class="big">Payment Due</span>
            											<span><?php echo '$'.number_format($dueamount, 2, '.', ',').' on '.$nextpaydate; ?></span>
            										</div>
            									</li>
                                            <?php } ?>
        									<li class='orange'>
        										<i class="icon-check"></i>
        										<div class="details">
        											<span class="big">Last Check In</span>
        											<span><?php echo $scheckin; ?></span>
        										</div>
        									</li>
                                            <li class='orange'>
        										<i class="icon-legal"></i>
        										<div class="details">
        											<span class="big">Next Appearance</span>
        											<span><?php echo $sappearance ?></span>
        										</div>
        									</li>
                                            
                                            
                                            <li class='darkblue' id="taskSummery" style="display:none">
        										<span class="count" id="taskSummeryCount"></span>
                								<div class="details">
                								    <span class="big">Task(s)</span>
                									<span id="taskSummeryDetail"></span>
                								</div>
        									</li>
                                           
                                            
                                            
        								</ul>
                                        <?php } ?>
                                    </div>
      							</div>
      						</div>
                        </div>
                    </div>

                    <div class="row-fluid">

                        <div class="span6" id="personal-view">

                                <div class="box">
        							<div class="box-title">
        								<h3 id="personal-label"></h3>
                                        <div class="actions" id="personal-list-actions">
                                            <a class="btn btn-mini" href="javascript:LoadPersonal(<?php echo $id; ?>)"; class='btn'>
                                                <i class="icon-edit"></i>
                                            </a>
                                        </div>
        							</div>

                                    <div id="personal-list">
                                        <div class="box-content nopadding">
            								<div class='form-horizontal form-bordered'>
            									<div class="control-group">
            										<label for="textfield" class="control-label">Name</label>
            										<div class="controls">
                                                        <p><?php echo $sname; ?></p>
            										</div>
            									</div>
                                                <div class="control-group">
            										<label for="textfield" class="control-label">DOB</label>
            										<div class="controls">
                                                        <p><?php echo $sdob; ?></p>
            										</div>
            									</div>
                                                <div class="control-group">
            										<label for="textfield" class="control-label">SSN</label>
            										<div class="controls">
                                                        <p><?php echo $sssn; ?></p>
            										</div>
            									</div>
                                                <div class="control-group">
            										<label for="textfield" class="control-label">Gender</label>
            										<div class="controls">
                                                        <p><?php echo $sgender; ?></p>
            										</div>
            									</div>
                                                <div class="control-group">
            										<label for="textfield" class="control-label">Race</label>
            										<div class="controls">
                                                        <p><?php echo $srace; ?></p>
            										</div>
            									</div>
                                                <div class="control-group">
            										<label for="textfield" class="control-label">Address</label>
            										<div class="controls">
                                                        <p><?php echo $saddress; ?></p>
            										</div>
                                                    <div class="controls">
                                                        <p><?php echo $scitystatezip; ?></p>
            										</div>
            									</div>
                                                <div class="control-group">
            										<label for="textfield" class="control-label">Phone Primary</label>
            										<div class="controls">
                                                        <p><?php echo trim($sphone1type.' '.$sphone1); ?></p>
            										</div>
            									</div>
                                                <div class="control-group">
            										<label for="textfield" class="control-label">Phone Secondary</label>
            										<div class="controls">
                                                        <p><?php echo trim($sphone2type.' '.$sphone2); ?></p>
            										</div>
            									</div>
                                                <div class="control-group">
            										<label for="textfield" class="control-label">Phone Other</label>
            										<div class="controls">
                                                        <p><?php echo trim($sphone3type.' '.$sphone3); ?></p>
            										</div>
            									</div>
                                                <div class="control-group">
            										<label for="textfield" class="control-label">Phone Other</label>
            										<div class="controls">
                                                        <p><?php echo trim($sphone4type.' '.$sphone4); ?></p>
            										</div>
            									</div>
                                                <input type="hidden" name="client-id" id="client-id" value="<?php echo $id; ?>">
            								</div>
            							</div>
                                    </div>

                                    <!-- id for *-box, insert window body, change class horizontal -->
                                    <div id='personal-box' style="display:none">
                                        <div class="row-fluid">
                                                <div class="box">
                                                    <div class="box-content nopadding">
                                        			    <form method="POST" class='form-horizontal form-bordered' id='personal-form'>
                                        				    <div class="control-group">
                                        					    <label for="textfield" class="control-label">Last*</label>
                                        						<div class="controls">
                                        						    <input type="text" name="personal-last" id="personal-last" class="span12">
                                        						</div>
                                        					</div>
                                        					<div class="control-group">
                                        					    <label for="textfield" class="control-label">First*</label>
                                        						<div class="controls">
                                        						    <input type="text" name="personal-first" id="personal-first" class="span12">
                                        						</div>
                                        					</div>
                                                            <div class="control-group">
                                        					    <label for="textfield" class="control-label">Middle</label>
                                        						<div class="controls">
                                        						    <input type="text" name="personal-middle" id="personal-middle" class="span12">
                                        						</div>
                                        					</div>
                                                            <div class="control-group">
                                        					    <label for="textfield" class="control-label">DOB</label>
                                        						<div class="controls">
                                        						    <input type="text" name="personal-dob" id="personal-dob" class="span12">
                                        						</div>
                                        					</div>

                                                            <div class="control-group">
                                        					    <label for="textfield" class="control-label">SSN (last 4)</label>
                                        						<div class="controls">
                                        						    <input type="text" name="personal-ssn" id="personal-ssn" class="mask_ssn span12">


                                                                </div>
                                        					</div>
                                                            <div class="control-group">
                                        					    <label for="textfield" class="control-label">Drivers License</label>
                                        						<div class="controls">
                                        						    <input type="text" name="personal-dl" id="personal-dl" class="input-large span10">

                                                                    <div class="btn-group"  style="float:right;">
                                                                        <a href="#" data-toggle="dropdown" class="btn btn-primary dropdown-toggle" onclick="getDlDoc()" id="dl-doc"><img src='img/document_buttongroup_white.png'></a>
                                                                        <ul class="dropdown-menu dropdown-primary pull-right" id="dlDoc">
                                                                        <li>  Loading...  </li>
                                                                        </ul>
                                                                    </div>


                                                                </div>


                                        					</div>
                                                            <div class="control-group">
                                        					    <label for="textfield" class="control-label">Gender</label>
                                                                <div class="controls">
                                                                    <div class="check-col">
                                                                        <div class="check-line ">
                                                    						<input type="radio" name="personal-gender" id="personal-genderMale" value="Male" class=" icheck-me input-large" data-skin="square" data-color="blue" style="margin:0 5px"><label class='inline ' for="Executed">Male</label>
                                                                        </div>
                                                                     </div>
                                                                     <div class="check-col">
                                                                        <div class="check-line ">
                                                    						<input type="radio" name="personal-gender" id="personal-genderFemale" value="Female" class=" icheck-me input-large" data-skin="square" data-color="blue" style="margin:0 5px" ><label class='inline' for="Forfeited">Female</label>
                                                                        </div>
                                                                     </div>
                                                                </div>
                                        					</div>
                                                            <div class="control-group">
                                        					    <label for="textfield" class="control-label">Race</label>
                                        						<div class="controls">
                                                                    <select name="personal-race" id="personal-race" class="select2-me input-large span12">
                								                        <?php echo $races; ?>
                							                        </select>
                                        						</div>
                                                            </div>
                                                            <div class="control-group">
                                        					    <label for="textfield" class="control-label">Address</label>
                                        						<div class="controls">
                                                                    <div class="row-fluid">
                                                                        <input type="text" name="personal-address" id="personal-address" class="input-large span11">
                                                                    </div>
                                                                </div>
                                                                <div class="controls" style="margin-top:-10px">
                                                                    <div class="row-fluid">
                                                                        <input type="text" name="personal-city" id="personal-city" class="input-large span4">
                                                                        <select name="personal-state" id="personal-state" class="select2-me" style="width:80px">
                                                                            <?php echo $sts; ?>
                                                                        </select>
                                                                        <input type="text" name="personal-zip" id="personal-zip" class="span3">
                                                                        <img class="streets-valid" src="img/streets-address-valid.png" class="span1">
                                                                    </div>
                                                                </div>
                                                                <div class="controls" style="margin-top:-10px;display:none">
                                                                    <div class="row-fluid">
                                                                        <input type="text" name="personal-latitude" class="input-large span3 latitude" readonly>
                                                                        <input type="text" name="personal-longitude" class="input-large span3 longitude" readonly>
                                                                        <img class="streets-valid" src="img/streets-geo-valid.png" class="span1">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="control-group">
                                        					    <label for="textfield" class="control-label">Phone Primary</label>
                                        						<div class="controls">
                                                                    <select name="personal-phone1type" id="personal-phone1type" class="select2-me span6">
                								                        <?php echo $phones; ?>
                							                        </select>
                                        						    <input type="text" name="personal-phone1" id="personal-phone1" class="span6 mask_phone">
                                                                </div>
                                                            </div>
                                                            <div class="control-group">
                                        					    <label for="textfield" class="control-label">Phone Secondary</label>
                                        						<div class="controls">
                                                                    <select name="personal-phone2type" id="personal-phone2type" class="select2-me span6">
                								                        <?php echo $phones; ?>
                							                        </select>
                                        						    <input type="text" name="personal-phone2" id="personal-phone2" class="span6 mask_phone">
                                                                </div>
                                                            </div>
                                                            <div class="control-group">
                                        					    <label for="textfield" class="control-label">Phone Other</label>
                                        						<div class="controls">
                                                                    <select name="personal-phone3type" id="personal-phone3type" class="select2-me span6">
                								                        <?php echo $phones; ?>
                							                        </select>
                                        						    <input type="text" name="personal-phone3" id="personal-phone3" class="span6 mask_phone">
                                                                </div>
                                                            </div>
                                                            <div class="control-group">
                                        					    <label for="textfield" class="control-label">Phone Other</label>
                                        						<div class="controls">
                                                                    <select name="personal-phone4type" id="personal-phone4type" class="select2-me span6">
                								                        <?php echo $phones; ?>
                							                        </select>
                                        						    <input type="text" name="personal-phone4" id="personal-phone4" class="span6 mask_phone">
                                                                </div>
                                                            </div>
                                                            <div class="control-group">
                                        					    <label for="textfield" class="control-label">Email</label>
                                        						<div class="controls">
                                        						    <input type="text" name="personal-email" id="personal-email" class="input-large span12">
                                        						</div>
                                        					</div>
                                                            <div class="control-group">
                                        					    <label for="textfield" class="control-label">Employer</label>
                                        						<div class="controls">
                                        						    <input type="text" name="personal-employer" id="personal-employer" class="input-large span10" >

                                                                    <div class="btn-group"  style="float:right;">
                                                                        <a href="#" data-toggle="dropdown" class="btn btn-primary dropdown-toggle" onclick="getEmployerDoc()" id="employer-doc"><img src='img/document_buttongroup_white.png'></a>
                                                                        <ul class="dropdown-menu dropdown-primary pull-right" id="employerDoc">
                                                                        <li>  Loading...  </li>
                                                                        </ul>
                                                                    </div>

                                                                </div>
                                        					</div>
                                                            <div class="control-group">
                                        					    <label for="textfield" class="control-label">Since</label>
                                        						<div class="controls">
                                        						    <input type="text" name="personal-employersince" id="personal-employersince" class="input-large span12">
                                        						</div>
                                        					</div>
                                                            <input type="hidden" name="personal-isvalid" class="isvalid">
                                                            <input type="hidden" name="personal-id" id="personal-id" value="">
                                                            <div class="form-actions">
                        					                    <button type="button" class="btn btn-primary" id="personal-save" onclick="PersonalSave()">Save</button>
                        						                <button type="button" class="btn" id="personal-cancel" onclick="PersonalCancel()">Cancel</button>
                                        					</div>
                                        				</form>
                                        			</div>
                                                </div>
                                        </div>
                                    </div>

      						    </div>
                            </div>


                            <div class="span6">
                                <div id="transaction-view" style="margin-bottom:20px;">
                                    <div class="box">
            							<div class="box-title">
            								<h3 id="transaction-label"></h3>
                                            <div class="actions" id="transaction-list-actions">
                                                <a class="btn btn-mini" href="javascript:LoadTransaction(<?php echo $id; ?>)"; class='btn'>
                                                    <i class="icon-edit"></i>
                                                </a>
                                            </div>
            							</div>

                                        <div id="transaction-list">
                                            <div class="box-content nopadding">
                							    <div class='form-horizontal form-bordered'>
                                                    <div class="control-group">
                            						    <label class="control-label">Logged</label>
                            							<div class="controls">
                                                            <p><?php echo $slogged; ?></p>
                            							</div>
                            						</div>
                                                    <?php if ($stype=='Reject') { ?>
                                                        <div class="control-group">
                                						    <label class="control-label">Rejected</label>
                                							<div class="controls">
                                                                <p><?php echo $srejected; ?></p>
                                							</div>
                                						</div>
                                                    <?php } ?>
                                                    <?php if ($stype=='Client') { ?>
                                                        <div class="control-group">
                                						    <label class="control-label">Posted</label>
                                							<div class="controls">
                                                                <p><?php echo $sposted; ?></p>
                                                            </div>
                                						</div>
                                                    <?php } ?>
                									<div class="control-group">
                										<label for="textfield" class="control-label">Source</label>
                										<div class="controls">
                                                            <p><?php echo $ssource; ?></p>
                										</div>
                									</div>
                                                    <?php if ($stype!='Client') { ?>
                                                        <div class="control-group">
                                						    <label class="control-label">Standing</label>
                                							<div class="controls">
                                                                <p><?php echo $sstanding; ?></p>
                                                            </div>
                                						</div>
                                                    <?php } ?>
                                                    <div class="control-group">
                            						    <label class="control-label">Identifier</label>
                            							<div class="controls">
                                                            <p><?php echo trim($sidentifiertype.' '.$sidentifier); ?></p>
                            							</div>
                            						</div>
                                                    <input type="hidden">
                								</div>
                							</div>
                                        </div>

                                        <!-- id for *-box, insert window body, change class horizontal -->
                                        <div id='transaction-box' style="display:none">
                                            <div class="row-fluid">
                                                    <div class="box">
                                                        <div class="box-content nopadding">
                                                            <form method="POST" class='form-horizontal form-bordered' id='transaction-form'>
                                                                <div class="control-group">
                            										<label class="control-label">Logged*</label>
                            										<div class="controls">
                                                                        <input type="text" value="" class="span12" name="transaction-logged" id="transaction-logged" data-date-format="yyyy-mm-dd HH:ii">
                            										</div>
                            									</div>
                                                                <?php if ($stype=='Reject') { ?>
                                                                    <div class="control-group">
                                										<label class="control-label">Rejected*</label>
                                										<div class="controls">
                                                                            <input type="text" value="" class="span12" name="transaction-rejected" id="transaction-rejected" data-date-format="yyyy-mm-dd HH:ii">
                                										</div>
                                									</div>
                                                                <?php } ?>
                                                                <?php if ($stype=='Client') { ?>
                                                                    <div class="control-group">
                                										<label class="control-label">Posted*</label>
                                										<div class="controls">
                                                                            <input type="text" value="" class="span10" name="transaction-posted" id="transaction-posted" data-date-format="yyyy-mm-dd HH:ii">
                                                                            <div class="btn-group span1"  style="float:right;">
                                                                                <a href="#" data-toggle="dropdown" class="btn btn-primary dropdown-toggle" onclick="getPostedDoc()" id="posted-doc"><img src='img/document_buttongroup_white.png'></a>
                                                                                <ul class="dropdown-menu dropdown-primary pull-right" id="postedDoc">
                                                                                    <li>  Loading...  </li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                									</div>
                                                                <?php } ?>
                                                                <div class="control-group">
                                            					    <label for="textfield" class="control-label">Source*</label>
                                            						<div class="controls">
                                            						    <select name="transaction-source" id="transaction-source" class="select2-me span12">
                    								                        <?php echo $sources; ?>
                    							                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="control-group">
                                            					    <label for="textfield" class="control-label">Standing</label>
                                                                    <div class="controls">
                                                                        <div class="check-col">
                                                                            <div class="check-line">
                                                                               <input type="radio" name="transaction-standing" id="transaction-standingCustody" value="Custody"  class=" icheck-me input-large" data-skin="square" data-color="blue" style="margin:0 5px" ><label class='inline' for="Custody">Custody</label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="check-col">
                                                                            <div class="check-line">
                                                                                <input type="radio" name="transaction-standing" id="transaction-standingWarrant" value="Warrant" class=" icheck-me input-large" data-skin="square" data-color="blue" style="margin:0 5px" ><label class='inline' for="Warrant">Warrant</label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="check-col">
                                                                            <div class="check-line">
                                                                                <input type="radio" name="transaction-standing" id="transaction-standingOther" value="Other" class=" icheck-me input-large" data-skin="square" data-color="blue" style="margin:0 5px"  ><label class='inline' for="Warrant">Other</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                            					</div>
                                            				    <div class="control-group" style="display:none" id="standingjail">
                                                                    <label for="textfield" class="control-label">Jail</label>
                                                                    <div class="controls">
                                                                        <select name="transaction-standingcustodyjail" id="transaction-standingcustodyjail" class="select2-me span12">
                                                                            <?php echo $jails; ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="control-group" style="display:none" id="standingwarrant">
                                                                    <label for="textfield" class="control-label">Description </label>
                                                                    <div class="controls">
                                                                        <input type="text" name="transaction-standingwarrantdescription" id="transaction-standingwarrantdescription" class="span12">
                                                                    </div>
                                                                </div>
                                                                <div class="control-group" style="display:none" id="standingother">
                                                                    <label for="textfield" class="control-label">Description </label>
                                                                    <div class="controls">
                                                                        <input type="text" name="transaction-standingotherdescription" id="transaction-standingotherdescription" class="span12">
                                                                    </div>
                                                                </div>

                                                                <div class="control-group">
                                                                    <label for="textfield" class="control-label">Identifier</label>
                                                                    <div class="controls">
                                                                        <select name="transaction-identifiertype" id="transaction-identifiertype" class="select2-me span6">
                                                                            <?php echo $identifiers; ?>
                                                                        </select>
                                                                        <input type="text" name="transaction-identifier" id="transaction-identifier" class="span6">

                                                                    </div>
                                                                </div>
                                                                <input type="hidden" name="transaction-type" id="transaction-type" value="">
                                                                <input type="hidden" name="transaction-id" id="transaction-id" value="">
                                                                <div class="form-actions">
                                            					    <input type="submit" style="display:none">
                            					                    <button type="button" class="btn btn-primary" id="transaction-save" onclick="TransactionSave()">Save</button>
                            						                <button type="button" class="btn" id="transaction-cancel" onclick="TransactionCancel()">Cancel</button>
                                            					</div>
                                            				</form>
                                            			</div>
                                                    </div>
                                            </div>
                                        </div>

          						    </div>
                                </div>

                                <?php if($stype!='Client'){?>
                                <div id="quote-view">
                                    <div class="box">
            							<div class="box-title">
            								<h3 id="quote-label">Quote</h3>
                                            <div class="actions" id="quote-list-actions">
                                                <a class="btn btn-mini" href="javascript:LoadQuote(<?php echo $id; ?>)"; class='btn'>
                                                    <i class="icon-edit"></i>
                                                </a>
                                            </div>
            							</div>

                                        <div id="quote-list">
                                            <div class="box-content nopadding">
                							    <div class='form-horizontal form-bordered'>
                									<div class="control-group">
                										<label for="textfield" class="control-label">Fee</label>
                										<div class="controls">
                                                            <p><?php echo $sfee; ?></p>
                										</div>
                									</div>
                                                    <div class="control-group">
                										<label for="textfield" class="control-label">Down</label>
                										<div class="controls">
                                                            <p><?php echo $sdown; ?></p>
                										</div>
                									</div>
                                                    <div class="control-group">
                										<label for="textfield" class="control-label">Terms</label>
                										<div class="controls">
                                                            <p><?php echo $sterms; ?></p>
                										</div>
                									</div>
                								</div>
                							</div>
                                        </div>
                                    </div>


                                    <div id='quote-box' style="display:none">
                                            <div class="row-fluid">
                                                    <div class="box">
                                                        <div class="box-content nopadding">
                                                            <form method="POST" class='form-horizontal form-bordered' id='quote-form'>
                                                                <div class="control-group">
                            										<label class="control-label">Fee</label>
                            										<div class="controls">
                                                                        <input type="text" value="" class="span12" name="quote-fee" id="quote-fee" data-date-format="yyyy-mm-dd HH:ii">
                            										</div>
                            									</div>

                                                                <div class="control-group">
                            										<label class="control-label">Down</label>
                            										<div class="controls">
                                                                        <input type="text" value="" class="span12" name="quote-down" id="quote-down" data-date-format="yyyy-mm-dd HH:ii">
                            										</div>
                            									</div>

                                                               <div class="control-group">
                            										<label class="control-label">Terms</label>
                            										<div class="controls">
                                                                        <textarea value="" class="span12" name="quote-terms" id="quote-terms" ></textarea>
                            										</div>
                            									</div>                                                                                                                               <input type="hidden" name="quote-type" id="quote-type" value="">
                                                                <input type="hidden" name="quote-id" id="quote-id" value="">
                                                                <div class="form-actions">
                                            					    <input type="submit" style="display:none">
                            					                    <button type="button" class="btn btn-primary" id="quote-save" onclick="QuoteSave()">Save</button>
                            						                <button type="button" class="btn" id="transaction-cancel" onclick="QuoteCancel()">Cancel</button>
                                            					</div>
                                            				</form>
                                            			</div>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php }?>

                            </div>


<div id='rate-box' style="display:none" class="span6">
                    <div class="box">
                              <div class="box-title">
                                <h3 id="rate-label"></h3>
                               </div>
                        <div class="row-fluid">
                                <div class="span12">
                                    <div class="box-content nopadding">
                                        <form method="POST" class='form-horizontal form-bordered' id='rate-form'>
                                            <div class="control-group">
                                                <label for="textfield" class="control-label">Rate</label>
                                                <div class="controls">
                                                    <select name="rate" id="rate"  class='select2-me span12'>
                                                        <option value="thumbs-up">Thumbs-Up</option>
                                                        <option value="uncertain">Uncertain</option>
                                                        <option value="thumbs-down">Thumbs-Down</option>
                                                    </select>
                                                    <br /><br /><br />
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label for="textfield" class="control-label">Comment</label>
                                                <div class="controls">
                                                    <textarea name="ratecomment" id="ratecomment" class="input-block-level" value=""></textarea>
                                                </div>
                                            </div>
                                            <input type="hidden" name="client-id" id="client-id" value="<?php echo $id; ?>">
                                            <input type="hidden" name="prospectrate" id="prospectrate" value="prospectrate">
                                            <div class="form-actions">
                                                <button type="button" class="btn btn-primary" name="prospect-rate-save" id="prospect-rate-save" onclick="ProspectRate()">Save</button>
                                                <button type="button" class="btn" name="prospect-rate-cancel" id="prospect-rate-cancel" onclick="RateCancel()">Cancel</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                     </div>                      
               </div>                     
                     
                     
                     
                          <!-- checkin form -->
                          <div class="span6" id="checkin-view" style="display:none">
                            <div class="box">
                              <div class="box-title">
                                <h3 id="checkin-label"></h3>
                              </div>
                              <div id='checkins-box' >
                                <div class="row-fluid">
                                  <div class="box">
                                    <div class="box-content nopadding">
                                      <form method="POST" class='form-horizontal form-bordered' id='checkin-form'>
                                      <div class="control-group">
                                          <label for="textfield" class="control-label">Comment</label>
                                          <div class="controls">
                                            <textarea name="checkin-comment" id="checkin-comment" class="input-block-level span12"></textarea>
                                          </div>
                                        </div>
                                        <input type="hidden" name="client-id" id="client-id" value="<?php echo $id; ?>">
                                        <input type="hidden" name="checkin-id" id="checkin-id" value="-1">
                                        <div class="form-actions">
                                          <button type="button" class="btn btn-primary" name="checkin-save" id="checkin-save" onclick="CheckinSave()">Save</button>
                                          <button type="button" class="btn" name="checkin-cancel" id="checkin-cancel" onclick="CheckinCancel()"> Cancel</button>
                                        </div>
                                      </form>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                      <!-- end of checkin form -->

                      <!-- payment form -->
                          <div class="span6" id="payment-view" style="display:none">
                            <div class="box">
                              <div class="box-title">
                                <h3 id="payment-label"></h3>
                               </div>
                               <div id='payment-box' >
                                 <div class="row-fluid">
                                  <div class="box">
                                    <div class="box-content nopadding">
                                            <form method="POST" class='form-horizontal form-bordered' id='payment-form'>
                                                <div class="control-group">
                                                    <label for="textfield" class="control-label">Date</label>
                                                    <div class="controls">
                                                        <input type="text" name="ledger-date" id="ledger-date" class="input-large datepicker">
                                                    </div>
                                                </div>
                                                <div class="control-group debit-group">
                                                    <label for="textfield" class="control-label">Entry</label>
                                                    <div class="controls">
                                                         <select name="ledger-debitentry" id="ledger-debitentry" class="select2-me input-large">
                                                            <?php echo $debitentries; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="control-group credit-group">
                                                    <label for="textfield" class="control-label">Entry</label>
                                                    <div class="controls">
                                                         <select name="ledger-creditentry" id="ledger-creditentry" class="select2-me input-large">
                                                            <?php echo $creditentries; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label for="textfield" class="control-label">Amount</label>
                                                    <div class="controls">
                                                        <input type="text" name="ledger-amount" id="ledger-amount" class="input-large" />
                                                    </div>
                                                </div>
                                                <div class="control-group credit-group">
                                                    <label for="textfield" class="control-label">Method</label>
                                                    <div class="controls">
                                                        <select name="ledger-paymentmethod" id="ledger-paymentmethod" class="select2-me input-large">
                                                            <?php echo $paymentmethods; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="control-group credit-group">
                                                    <label for="textfield" class="control-label">Memo</label>
                                                    <div class="controls">
                                                        <textarea name="ledger-memo" id="ledger-memo" class="input-block-level"></textarea>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="ledger-column" id="ledger-colum" value="">
                                                <input type="hidden" name="client-id" id="client-id" value="<?php echo $id; ?>">
                                                <input type="hidden" name="ledger-id" id="ledger-id" value="">
                                                <div class="form-actions">
                                                    <button type="submit" class="btn btn-primary" name="ledger-save" id="ledger-save" onclick="PaymentSave()">Save</button>
                                                    <button type="button" class="btn" name="ledger-cancel" id="ledger-cancel" onclick="PaymentCancel()">Cancel</button>
                                                </div>
                                            </form>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                      <!-- end of checkin form -->
                    </div>
				</div>

			</div>
		</div>


<div id='jqxWindow-confirm' style="display:none">
<div></div>
<div>
    <span>Confirm</span>
    <button type="button" class="btn" id="confirm-no">No</button>
	<button type="button" class="btn" id="confirm-yes">Yes</button>
    <input type="hidden" name="confirm-type" id="confirm-type" value="">
</div>
</div>

<div id='jqxWindow-communications' style="display:none">
<div></div>
<div>
    <div class="row-fluid">
	    <div class="span12">
		    <div class="box-content nopadding">
			    <form method="POST" class='form-vertical form-bordered' id='communications-form'>
                    <div class="alert info" id="twilio-status"></div>
				    <div class="control-group">
					    <label for="textfield" class="control-label">Phone Number</label>
						<div class="controls">
						    <input type="text" name="communications-phone" id="communications-phone" value="" class="input-large mask_phone span12">
							<span class="help-block">Format: (###) ###-####</span>
						</div>
					</div>
                    <div class="control-group">
					    <label for="textfield" class="control-label">Message</label>
						<div class="controls">
                            <textarea name="communications-message" id="communications-message" class="input-block-level"></textarea>
						</div>
					</div>
                    <input type="hidden" name="communications-type" id="communications-type" value="">
                    <input type="hidden" name="client-id" id="client-id" value="">
                    <div class="form-actions">
					    <button type="button" class="btn btn-primary" name="communications-save" id="communications-save" onclick="CommunicationsSave()"></button>
						<button type="button" class="btn" name="communications-cancel" id="communications-cancel" onclick="CommunicationsCancel()">Cancel</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
</div>


<!-- automated call model window -->

<div id='jqxWindow-client-automatedCall' style="display:none">
<div></div>
<div>
    <div class="row-fluid">
	    <div class="span12">
		    <div class="box-content nopadding">
            <div id="call-status" class="" style="display:none"></div>
			    <form method="POST" class='form-vertical form-bordered' id='rate-form'>
				    <div class="control-group">
					    <label for="textfield" class="control-label">Phone Number</label>
						<div class="controls">
                              <input id="automatedCall" type="text"  class="input-large  span12">

						</div>
					</div>
                     <div class="form-actions">
                    <button id="automated-call" class="btn btn-primary" type="button"   onclick="automated_call_action()" >Call</button>
                    <button id="automated-cancel" class="btn btn-primary" type="button"  onclick="automated_cancel()" >Cancel</button>
                    </div>
              </form>

			</div>
		</div>
	</div>
</div>
</div>
<!-- End automated call model window -->



<div id="modal-error" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<form method="post" id="error-form">
    <div class="modal-header">
	    <h3 id="modal-title-error"></h3>
	</div>
	<div id="modal-body-error">
    </div>
    <div class="modal-footer">
	    <button type="button" class="btn" data-dismiss="modal" aria-hidden="true">Ok</button>
	</div>
</form>
</div>


<div id="modal-dl" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<form method="post" id="dl-document-form" enctype="multipart/form-data">
    <div class="modal-header">
	    <h3 id="modal-title">Document DL</h3>
	</div>
	<div class="modal-body">
        <div class='form-vertical'>
        <div class="control-group">
            <label for="textfield" class="control-label">Name</label>
            <div class="controls">
                <input type="text" name="dl-friendly-name" id="dl-friendly-name" class="input-large span4" onkeyup="documentValidate()" onblur="documentValidate()" onclick="documentValidate()" sytle="height:30px;">
            </div>
        </div>
        <div class="control-group">
            <label for="textfield" class="control-label">Upload File</label>
            <div class="controls">
                <input type="file" name="dl-upload" id="dl-upload" onchange="documentValidate()" />
            </div>
        </div>
        </div>
        <input type="hidden" name="action" id="action" value="dl">
        <input type="hidden" name="dl-client-id" id="dl-client-id" value="<?php echo $id ?>">
    </div>
    <div class="modal-footer">
	    <button type="button" class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
		<button type="submit" id="dl-upload-save" class="btn btn-primary" data-dismiss="modal" onclick="dlDoc(<?php echo $id; ?>)">Save</button>
	</div>
</form>
</div>


<div id="modal-employer" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<form method="post" id="employer-document-form" enctype="multipart/form-data">
    <div class="modal-header">
	    <h3 id="modal-title">Document Employer</h3>
	</div>
	<div class="modal-body">
        <div class='form-vertical'>
        <div class="control-group">
            <label for="textfield" class="control-label">Name</label>
            <div class="controls">
                <input type="text" name="employer-friendly-name" id="employer-friendly-name" class="input-large span4" onkeyup="documentValidate()" onblur="documentValidate()" onclick="documentValidate()" sytle="height:30px;">
            </div>
        </div>
        <div class="control-group">
            <label for="textfield" class="control-label">Upload File</label>
            <div class="controls">
                <input type="file" name="employer-upload" id="employer-upload" onchange="documentValidate()" />
            </div>
        </div>
        </div>
        <input type="hidden" name="action" id="uplaod-action" value="employer">
        <input type="hidden" name="employer-client-id" id="employer-client-id" value="<?php echo $id ?>">
    </div>
    <div class="modal-footer">
	    <button type="button" class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
		<button type="submit" id="employer-upload-save" class="btn btn-primary" data-dismiss="modal" onclick="EmployerDoc(<?php echo $id; ?>)">Save</button>
	</div>
</form>
</div>



<div id="modal-posted" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <form method="post" id="posted-document-form" enctype="multipart/form-data">
    <div class="modal-header">
	    <h3 id="modal-title">Document Posted</h3>
	</div>
	<div class="modal-body">
        <div class='form-vertical'>
        <div class="control-group">
            <label for="textfield" class="control-label">Name</label>
            <div class="controls">
                <input type="text" name="posted-friendly-name" id="posted-friendly-name" class="input-large span4" onkeyup="documentValidate()" onblur="documentValidate()" onclick="documentValidate()" sytle="height:30px;">
            </div>
        </div>
        <div class="control-group">
            <label for="textfield" class="control-label">Upload File</label>
            <div class="controls">
                <input type="file" name="posted-upload" id="posted-upload" onchange="documentValidate()" />
            </div>
        </div>
        </div>
        <input type="hidden" name="action" id="uplaod-action" value="posted">
        <input type="hidden" name="posted-client-id" id="posted-client-id" value="<?php echo $id; ?>">
    </div>
    <div class="modal-footer">
	    <button type="button" class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
		<button type="submit" id="posted-upload-save" class="btn btn-primary" data-dismiss="modal" onclick="PostedDoc(<?php echo $id; ?>)">Save</button>
	</div>
</form>
</div>



<?php
include("footer.php");
?>
