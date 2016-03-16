var map;
var myCenter;
var origin = "";
var destination;
var serviceRoutes = new google.maps.DirectionsService();
var directionsRenderer;
var transportLocation;
var transportLat;
var transportLng;
$("#text").hide();

function initViewMap()
{
    directionsRenderer = new google.maps.DirectionsRenderer();
    myCenter = new google.maps.LatLng(eventLat, eventLng);
    destination = myCenter;
    var mapProp = {
        center:myCenter,
        zoom:13,
        mapTypeId:google.maps.MapTypeId.ROADMAP
    };
    map = new google.maps.Map(document.getElementById("viewMap"),mapProp);
    directionsRenderer.setMap(map);
    var marker = new google.maps.Marker({
        map: map
    });
    marker.setPosition(myCenter);
    var infoWindowEvent = new google.maps.InfoWindow({
        content: eventTag
    });
    infoWindowEvent.open(map, marker);
    google.maps.event.addListener(marker, "click", function(){
        infoWindowEvent.open(map, marker);
    });
    var markerT = new google.maps.Marker({
        map: map,
    });
    if (!transportLat == "") {
        transportLocation = new google.maps.LatLng(transportLat, transportLng);
        markerT.setPosition(transportLocation);
        origin = transportLocation;
        var infoWindowT = new google.maps.InfoWindow({
            content: transportTag
        });
        google.maps.event.addListener(markerT, "click", function(){
            infoWindowT.open(map, markerT);
        });
    } 

}

var showingRoute = false;
$("#route").on("click", function () {
    var request = {
        origin: origin,
        destination: destination,
        travelMode: google.maps.TravelMode.DRIVING
    };
    if (!showingRoute){
       serviceRoutes.route(request, function(response, status) {
        if (status == google.maps.DirectionsStatus.OK) {
            directionsRenderer.setDirections(response);
            directionsRenderer.setMap(map);
            showingRoute = true;
        }
    });
    } else {
        showingRoute = false;
        directionsRenderer.setMap(null);
    }
})

$("#currentLocation").on("click", function () {
    if (geoPosition.init()) {
        geoPosition.getCurrentPosition(success, errorHandler, {timeout:5000});
    } else {
        error("Perdón, no hemos podido encontrar tu ubicación");
    }  
})
 
function success(position) 
{
    $("#text").show();
    var s = document.querySelector("#status");
    if (s.className == "success") {    
        return;
    }  
    s.innerHTML = "Estás aquí:";
    s.className = "success";    
    var latlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
    origin = latlng;
    var markerUser = new google.maps.Marker({
      position: latlng, 
        map: map, 
    });
    var infoWindowUser = new google.maps.InfoWindow({
        content: "Aquí estas tú"
    });
    infoWindowUser.open(map, markerUser);
    google.maps.event.addListener(markerUser, "click", function(){
        infoWindowT.open(map, markerUser);
    });
    map.setCenter(latlng);
    map.setZoom(12);
}
 
function errorHandler(err) 
{
    var s = document.querySelector("#status");
    s.innerHTML = typeof msg == "string" ? msg : "failed";
    s.className = "fail";  
}

google.maps.event.addDomListener(window, "load", initViewMap);