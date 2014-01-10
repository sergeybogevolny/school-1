<?php
include_once(dirname(dirname(__FILE__)) . '/classes/check.class.php');
protect("1,2");

include_once(dirname(__FILE__) . '/classes/functions-powers.php');

$title = 'agent';
$label = 'powers';
include_once('header.php');

$level = 'agent';

if(isset($_GET['type'])){
    $type = $_GET['type'];
} else {
    $type = 'summary';
}

include_once('classes/agent.class.php');
$id = $agent->getField('id');
?>
    <script src="js/agent-powers.js"></script>

    <script>
        var TYPE_LIST = '<?php echo $type ?>';
    </script>

    <div class="container-fluid" id="content">

            <?php include_once('pages/agent-nav-left.php'); ?>

			<div id="main">
				<div class="container-fluid">

                    <?php include_once('pages/agent-page-header.php'); ?>

					<div class="row-fluid">
						<div class="span12">
							<div class="box">
								<div class="box-title">
									<h3><i class="icon-list-alt"></i></h3>
                                    <select name="list-type" id="list-type" class='select2-me input-xlarge' onchange="getList(<?php echo $id; ?>)">
									    <option value="summary">Summary</option>
                                        <option value="available">Available</option>
                                        <option value="forfeited">Forfeited</option>
                                        <option value="distributed">Distributed</option>
                                        <option value="collected">Collected</option>
                                    </select>
								</div>
                               <div class="box-content">
                                    <?php list_powers($level."-".$type,$id); ?>
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
