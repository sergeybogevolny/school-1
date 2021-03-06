<?php
include_once(dirname(dirname(__FILE__)) . '/classes/check.class.php');
protect("1,2");

include_once(dirname(__FILE__) . '/classes/functions-powers.php');

$title = 'powers';
$label = '';
include_once('header.php');

if(!isset($_SESSION['level'])) {
    $_SESSION['level'] = 'agency';
}
$level = $_SESSION['level'];

if(isset($_GET['type'])){
    $type = $_GET['type'];
} else {
    $type = 'summary';
}

?>
    <script src="js/powers.js"></script>

    <script>
        var TYPE_LIST = '<?php echo $type ?>';
    </script>

        <div class="container-fluid" id="content">

            <?php include_once('pages/powers-nav-left.php'); ?>

			<div id="main">
				<div class="container-fluid">

                    <?php include_once('pages/powers-page-header.php'); ?>

					<div class="row-fluid">
						<div class="span12">
							<div class="box">
								<div class="box-title">
									<h3><i class="icon-list-alt"></i></h3>
                                    <select name="list-type" id="list-type" class='select2-me input-xlarge' onchange="getList()">
                                        <?php
                                            if ($level=='agency'){
                                                ?>
                                                <option value="summary">Summary</option>
                                                <option value="available">Available</option>
                                                <option value="executed">Executed</option>
                                                <option value="intaken">Intaken</option>
                                                <option value="reported">Reported</option>
                                                <?php
                                            }
                                            if ($level=='general'){
                                                ?>
                                                <option value="summary">Summary</option>
                                                <option value="available">Available</option>
                                                <option value="forfeited">Forfeited</option>
                                                <option value="ordered">Ordered</option>
                                                <option value="didstributed">Distributed</option>
                                                <option value="collected">Collected</option>
                                                <option value="reported">Reported</option>
                                                <?php
                                            }
                                        ?>
                                    </select>
								</div>
                               <div class="box-content">
                                    <?php list_powers($level."-".$type,-1); ?>
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
