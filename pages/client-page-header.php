<?php
$id = $client->getField('id');
$curpage = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
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

$srejected_FjYgia = $client->getfield('rejected');
if ($srejected_FjYgia!=""){
    $rejected = strtotime($srejected_FjYgia);
    $srejected_FjYgia  = date('F j, Y, g:i a', $rejected);
}

$smugshot=$client->getField('document_mugshot');

if( $smugshot != ''){
 $smugshot_img = 'documents/'.$id.'/root/'.$smugshot ;
}else{
 $smugshot_img = 'img/avatar.jpg';
}
$smugshotset = 0;
$smugshot = $client->getMugshot($id);
if (strpos($smugshot, '/default.png') == 0){
    $smugshotset = 1;
}
?>

             <script src="js/ajaxupload.js"></script>
             <script src="js/client-page-header.js"></script>

                    <div class="page-header">
						<div class="pull-left">
							<ul class="stats">
                                <li class="menu" id="client-menu">
                                    <div class="btn-group">
    								    <a href="#" data-toggle="dropdown" class="btn btn-inverse dropdown-toggle"><img src='img/client_menu.png'></a>
    									<ul class="dropdown-menu dropdown-inverse">
    										<li class='<?php echo ($label == "summary" ? "active" : "")?>'>
                        					    <a href="client.php?id=<?php echo $id; ?>">Summary</a>
                        					</li>
                                            <li class="<?php echo ($label == "bonds" ? "active" : "")?>">
                    							<a href="client-bonds.php?id=<?php echo $id; ?>">Bonds</a>
                    						</li>
                                            <li class="<?php echo ($label == "references" ? "active" : "")?>">
                    							<a href="client-references.php?id=<?php echo $id; ?>">References</a>
                    						</li>
                                            <?php if ($stype=='Client') {
                                            ?>
                                            <li class="<?php echo ($label == "account" ? "active" : "")?>">
                    							<a href="client-account.php?id=<?php echo $id; ?>">Account</a>
                    						</li>
                                            <li class="<?php echo ($label == "checkins" ? "active" : "")?>">
                    							<a href="client-checkins.php?id=<?php echo $id; ?>">Check Ins</a>
                    						</li>
                                            <?php
                                            }
                                            ?>
                                            <li class="<?php echo ($label == "notes" ? "active" : "")?>">
                    							<a href="client-notes.php?id=<?php echo $id; ?>">Notes</a>
                    						</li>
                                            <?php if ($stype=='Client') {
                                            ?>
                                            <li class="<?php echo ($label == "documents" ? "active" : "")?>">
                    							<a href="client-documents.php?id=<?php echo $id; ?>">Documents</a>
                    						</li>
                                            <li class="<?php echo ($label == "geo" ? "active" : "")?>">
                    							<a href="client-geo.php?id=<?php echo $id; ?>">Geo</a>
                    						</li>
                                            <?php
                                            }
                                            ?>
    									</ul>
    								</div>
                                </li>
                                <li class='lightgrey'>
									<i class="<?php echo ($stype == "Client" ? "icon-folder-open" : "icon-user")?>"></i>
									<div class="details">
										<span class="big"><strong><?php echo $sname; ?></strong></span>
                                        <?php if($stype=='Reject') { ?>
                                            <span>Rejected - <?php echo $srejected_FjYgia; ?></span>
                                        <?php } else { ?>
                                            <span><?php echo $stype; ?></span>
                                        <?php } ?>
									</div>
								</li>
							</ul>
                            <?php if ($stype=='Client') {
                                if ($curpage=='client-avatar.php'){
                                ?>
                                <img src="<?php echo $smugshot_img; ?>" style="width:56px; height:56px;border: 2px  solid #666666;">
                                <?php
                                } else {
                                ?>
                                <div class="btn-group">
                                    <a href="" data-toggle="dropdown" class="dropdown-toggle" id="mugshot-img">
                                        <img src="<?php echo $smugshot_img; ?>" style="width:56px; height:56px;border: 2px  solid #0099FF;">
                                    </a>
                                    <ul class="dropdown-menu dropdown-primary">
                                        <?php
                                            if ($smugshotset==1){
                                                ?>
                                                <li>
            							            <a href="<?php echo $smugshot; ?>" id="mugshot-view" target="_blank">Mugshot</a>
            							        </li>
                                                <?php
                                            }
                                        ?>
                                        <li>
            							    <a href="client-avatar.php?id=<?php echo $id; ?>" id="mugshot-camera"><i class="icon-camera"></i>  Camera</a>
            							</li>

                                        <li>
                                           <a href="#" onclick="Mugshotupload()" class="mugshot-upload"><i class="icon-upload"></i> Upload</a>
                                        </li>
                                    </ul>
                                </div>
                               <?php
                               }
                            }
                            ?>
						</div>
						<div class="pull-right">
							<ul class="stats datetime">
								<li class='grey'>
									<i class="icon-calendar"></i>
									<div class="details">
										<span class="big"></span>
										<span></span>
									</div>
								</li>
							</ul>
						</div>
					</div>


<div id="modal-mugshot" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<form method="post" id="mugshot-document-form" enctype="multipart/form-data">
    <div class="modal-header">
	    <h3 id="modal-title">Document Mugshot</h3>
	</div>
	<div class="modal-body">
        <div class='form-vertical'>

        <div class="control-group">
            <label for="textfield" class="control-label">Upload File</label>
            <div class="controls">
                <input type="file" name="mugshot-upload" id="mugshot-upload" onchange="Doc1Validate()" />
            </div>
        </div>
        </div>
        <input type="hidden" name="action" id="uplaod-action" value="mugshot">
        <input type="hidden" name="mugshot-client-id" id="mugshot-client-id" value="<?php echo $id ?>">
    </div>
    <div class="modal-footer">
	    <button type="button" class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
		<button type="submit" id="mugshot-upload-save" class="btn btn-primary" data-dismiss="modal" onclick="MugshotDoc(<?php echo $id; ?>)">Save</button>
	</div>
</form>
</div>
