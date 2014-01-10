// Wait for the DOM fully loaded
$(document).ready(function() {
	// Our map's div jQuery object
	var myMap = $("#map3");
	// Our dashboard geo class file
	var geo_class_file = './classes/dashboard_geo.class.php';

	// Excecute only when element node is exists
	if ( myMap.length > 0) {

		// AJAX call to fecth client's locations
		$.get(geo_class_file).done(function(data) {
			var myMarkers = $.parseJSON(data);	// Parse JSON output
			//console.log(myMarkers);

			var map = myMap.gmap3({
				// Maps options
				map: {
					options: {
						maxZoom: 14,
						zoom: 5
					}
				},
				// Our client markers
				marker: {
					values: myMarkers,
					cluster: {
						radius: 100,
						events: { // events trigged by clusters
							click: function(cluster) {
								myMap.gmap3({
									map: {
										options: {
											center: cluster.main.getPosition(),
											zoom: cluster.main.map.zoom+1
										}
									}
								})
							}
						},

						0: {
							content: "<div class='cluster cluster-1'>CLUSTER_COUNT</div>",
							width: 53,
							height: 52
						},

						20: {
							content: "<div class='cluster cluster-2'>CLUSTER_COUNT</div>",
							width: 56,
							height: 55
						},

						50: {
							content: "<div class='cluster cluster-5'>CLUSTER_COUNT</div>",
							width: 66,
							height: 65
						}
					}
				}
			});


		});

	}
});