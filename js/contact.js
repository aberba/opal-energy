$(function() {
	 var container = $(".map-container");
     Contact.showMapIn(container);
});

Contact = {
	showMapIn: function(mapContainer) {
		if (mapContainer == null) throw "Contact.showMapIn(): mapContainer was not set";

		var $url = "get_map_settings=yes";

		$.get("/ajax/query.php", $url, function(e) {
			if(e == 0) {
				throw new Error("Error fetching map info, please check connection");
				return false;
			}
			var $data = JSON.parse("[" +e+ "]");
			var lat, lng, markerLabel, myKey;

			for(var i in $data) {
                lat         = $data[i].lat;
                lng         = $data[i].lng;
                markerLabel = $data[i].marker_label;
                myKey       = $data[i].api_key;
			}
			
			$positionLat = (lat != "") ? lat : -484848; // remember to change them
			$positionLng = (lng != "") ? lng : 484844;
			$markerLabel = (markerLabel != "") ? markerLabel : "Our Location";

			if(window.google) {
		        var myPosition = new google.maps.LatLng($positionLat, $positionLng);

				var mapOptions = {
					zoom: 18,
					center: myPosition,
					mapTypeId: google.maps.MapTypeId.ROADMAP
				};

				myMap = new google.maps.Map(mapContainer, mapOptions);
			    var container = new google.maps.InfoWindow({
			    	position: myPosition,
			    	content: $markerLabel
			    });

		    } else {
		    	try {
		    		console.log("google object not set in global namespace");
		    	} catch(e) {}
		    }
	    }); // end of ajax request
	}
}