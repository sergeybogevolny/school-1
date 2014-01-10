<?php
include_once(dirname(dirname(__FILE__)) . '/classes/check.class.php');
protect("1,2");

include_once('classes/client.class.php');
include_once('classes/functions-client.php');
/*include_once('classes/client_geo.class.php');*/

$stype = $client->getField('type');
if ($stype=='Prospect'){
    $title = 'prospect';
} else {
    $title = 'client';
}
$label = 'geo';
include("header.php");

$id = $client->getField('id');

?>
        <script>
          var CLIENT_GEO_ID = <?php echo $id; ?>;
        </script>

    	<script src="js/client-geo.js"></script>

        <div class="container-fluid" id="content">

            <?php include_once('pages/client-nav-left.php'); ?>

			<div id="main">
				<div class="container-fluid">

                    <?php include_once('pages/client-page-header.php'); ?>

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
            												</ul>
            										    </div>
                                                    </li>
                                                    <li class='darkblue extend'>
                										<img src='img/geo_file.png'>
                										<div class="details">
                											<span class="big">#</span>
                											<span>File</span>
                										</div>
                									</li>
                                                    <li class='darkblue extend'>
                										<img src='img/geo_history.png'>
                										<div class="details">
                											<span class="big">#</span>
                											<span>History</span>
                										</div>
                									</li>
                                                    <li class='darkblue extend'>
                										<img src='img/geo_portal.png'>
                										<div class="details">
                											<span class="big">#</span>
                											<span>Portal</span>
                										</div>
                									</li>
                                                    <li class='darkblue extend'>
                										<img src='img/geo_gps.png'>
                										<div class="details">
                											<span class="big">#</span>
                											<span>GPS</span>
                										</div>
                									</li>
                                                    <li class='darkblue extend'>
                										<img src='img/geo_range.png'>
                										<div class="details">
                											<span class="big">#</span>
                											<span>Range</span>
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
