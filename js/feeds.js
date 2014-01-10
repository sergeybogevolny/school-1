// JavaScript Document

function randomFeed(feed, count){ 
		var $el = $("#randomFeed");
		var random = feed,
		auto = $el.parents(".box").find(".box-title .actions .custom-checkbox").hasClass("checkbox-active");
		var randomIndex = Math.floor(Math.random() * parseInt(count));
		var newElement = random[randomIndex];
		if(auto){
			$el.prepend("<tr><td>"+newElement+"</td></tr>").find("tr").first().hide();
			$el.find("tr").first().fadeIn();
			if($el.find("tbody tr").length > 20){
				$el.find("tbody tr").last().fadeOut(400, function(){
					$(this).remove();
				});
			}
		}

		slimScrollUpdate($el.parents(".scrollable"));

		setTimeout(function(){
			randomFeed(feed, count);
		}, 3000);
	}
