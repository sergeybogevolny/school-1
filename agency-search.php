<?php
include_once(dirname(dirname(__FILE__)) . '/classes/check.class.php');
protect("1,2");

$title = 'search';
$label = 'simple';
include_once('header.php');
?>

    <script src="js/search-simple.js"></script>

        <div class="container-fluid" id="content">

            <?php include_once('pages/search-nav-left.php'); ?>

			<div id="main">
				<div class="container-fluid">

                    <?php include_once('pages/search-page-header.php'); ?>

					<div class="row-fluid">
						<div class="span12">

                            <div class="box">
    							<div class="box-title">
    								<h3><i class="icon-search"></i> Search</h3>
    							</div>
    							<div class="box-content">
                                    <div class="row-fluid">
                                            <form method="post" id="search-form">

                                                <input type="text" name="search-value" id="search-value" class="input-large" style="float:left;margin-right:2px;height:30px;width:157px;" onKeyPress="SearchStatus(event);">

                                                <div id='jqxDropDownList-search-target' style="float:left;margin-right:2px;margin-bottom:10px;"></div>
                                                <button type="submit" class="btn btn-success" name="search-simple" id="search-simple" style="float:left"><i class="icon-arrow-right"></i> Go</button>
                                            </form>
                                    </div>
                                    <div class="box-content" id="search-results"></div>
                                </div>
                            </div>
						</div>
					</div>

				</div>
			</div>
		</div>


<div id='jqxWindow-status' style="display:none">
<div></div>
<div></div>
</div>

<?php
include("footer.php");
?>
