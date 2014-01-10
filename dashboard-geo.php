<?php
include_once(dirname(dirname(__FILE__)) . '/classes/check.class.php');
protect("1,2");

$title = 'dashboard';
$label = 'geo';
include_once('header.php');
?>

        <!-- [RISAN] Dashboard Geo -->
    	<script src="js/dashboard-geo.js"></script>

        <div class="container-fluid" id="content">

            <?php include_once('pages/dashboard-nav-left.php'); ?>

			<div id="main">
				<div class="container-fluid">

                    <?php include_once('pages/dashboard-page-header.php'); ?>

					<div class="row-fluid">
						<div class="span12">
							<div class="box">
								<div class="box-title">
									<h3><i class="glyphicon-global"></i>Geo - All</h3>
								</div>
								<div class="box-content">
                                    <div class="row-fluid">
						                <div class="span12">
                                            <div class="pull-left">
                                                <ul class="stats">
                                                    <li class="button">
                                                        <div class="btn-group">
            												<a href="#" data-toggle="dropdown" class="btn btn-primary dropdown-toggle"><img src='img/geo_filter.png'></a>
            												<ul class="dropdown-menu dropdown-primary">
            													<li>
        														    <a href="#" id="filter-all">All</a>
        													    </li>
                                                                <li>
        														    <a href="#" id="filter-custom">Custom</a>
        													    </li>
            												</ul>
            										    </div>
                                                    </li>
                                                    <li class='darkblue extend'>
                										<img src='img/geo_marker.png'>
                										<div class="details">
                											<span class="big">#</span>
                											<span>Markers</span>
                										</div>
                									</li>

                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                      		        <div id="map3" style="margin-top:20px;"></div>
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
