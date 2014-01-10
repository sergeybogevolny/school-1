<?php
include_once(dirname(dirname(__FILE__)) . '/classes/check.class.php');
protect("1,2");

include_once(dirname(__FILE__) . '/classes/functions-bulletin.php');

$title = 'settings';
$label = 'bulletin';
include_once('header.php');

if (isset($_REQUEST['editor']) && !empty($_REQUEST['editor'])) {
	if (isset($_REQUEST['do_add']) && $_REQUEST['do_add'] == 'do_add') {
         editor_write($_REQUEST['editor']);
	}
}

?>
<script type="text/javascript" src="js/plugins/ckeditor/ckeditor.js"></script>
        <div class="container-fluid" id="content">

            <?php include_once('pages/settings-nav-left.php'); ?>

			<div id="main">
				<div class="container-fluid">

                    <?php include_once('pages/settings-page-header.php'); ?>

					<div class="row-fluid">
						<div class="span12">
							<div class="box">
								<div class="box-title">
									<h3><i class="glyphicon-settings"></i>Bulletin - Edit</h3>
								</div>
								<div class="box-content nopadding">
								<form method="POST" action="" name="editor_form" id="editor_name">
								<textarea cols="80" id="editor" name="editor" rows="10"><?php echo editor_read(); ?> </textarea>
								<script type="text/javascript">CKEDITOR.replace( 'editor',{toolbar : 'default'});</script>
								<input type="hidden" name="do_add" value="do_add" />
								</form>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>

<?php
include("footer.php");
?>
