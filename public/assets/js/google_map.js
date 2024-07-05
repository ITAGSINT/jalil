

function loadMap(){
var mapOptions={
center:new google.maps.LatLng(25.253338 , 55.437973),
zoom:5,
mapTypeId:google.maps.MapTypeId.administrative,
mapTypeControl:true
};

/*


var mymap= new google.maps.Map(document.getElementById("map"),mapOptions);





*/
 var myStyle = [
       {
         featureType: "administrative",
         elementType: "labels",
         stylers: [
           { visibility: "off" }
         ]
       },{
         featureType: "poi",
         elementType: "labels",
         stylers: [
           { visibility: "off" }
         ]
       },{
         featureType: "water",
         elementType: "labels",
         stylers: [
           { visibility: "off" }
         ]
       },{
         featureType: "road",
         elementType: "labels",
         stylers: [
           { visibility: "off" }
         ]
       }
     ];

     var map = new google.maps.Map(document.getElementById('map'), {
       mapTypeControlOptions: {
         mapTypeIds: ['mystyle']
       },
       center: new google.maps.LatLng(30, 0),
       zoom: 3,
       mapTypeId: 'mystyle'
     });

     map.mapTypes.set('mystyle', new google.maps.StyledMapType(myStyle));
     var marker=new google.maps.Marker({
	position: new google.maps.LatLng(25.253338 , 55.437973),
	map:map,
		//icon:"assets/img/mark.png",
		
	draggable:true,

});





}











function placeMarker(mymap, loc,marker) {

 var infowindow = new google.maps.InfoWindow();
  	/*{
    content: 'Latitude: ' + loc.lat() +
    '<br>Longitude: ' + loc.lng()
  });*/
 /* infowindow.open(mymap, marker);*/
  latlng = {
    lat: loc.lat(),
    lng: loc.lng(),
  };
  geocoder = new google.maps.Geocoder();
  geocoder
    .geocode({ location: latlng })
    .then((response) => {


   if (response.results[0]) {
  // 	alert(response.results[0].address_components.length);
                    for (var i=0; i<response.results[0].address_components.length; i++) {
                    for (var b=0;b<response.results[0].address_components[i].types.length;b++) {
                    	//alert(response.results[0].address_components[i].types[b]);
                    if (response.results[0].address_components[i].types[b] == "country") {
                        //this is the object you are looking for
                        country= response.results[0].address_components[i];  
                        document.getElementById("country").value="";
                        document.getElementById("country").value=country.long_name;
                        //break;
                    }
                    if (response.results[0].address_components[i].types[b] == "locality") {
                        //this is the object you are looking for
                        area= response.results[0].address_components[i];  
                        document.getElementById("area").value="";
                        document.getElementById("area").value=area.long_name;
                        //break;
                    }
					                    }

                    
                  //  }
                     //alert(country.short_name);
                }
            }

      if (response.results[0]) {
      

        marker.setPosition(loc);

      } else {
        window.alert("No results found");
      }
    })
    .catch((e) => window.alert("Geocoder failed due to: " + e));
}



google.maps.event.addDomListener(window,'load',loadMap);










