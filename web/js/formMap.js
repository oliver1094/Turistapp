$("#textE").hide();
$("#textT").hide();

var map;
var transportMap;
    
var myCenter;
var transportLocation;

var eventLat = document.getElementById("evtmap-vc_latitude").value;
var eventLng = document.getElementById("evtmap-vc_longitude").value;

var transportLat = document.getElementById("evtmap-vc_latitudetransport").value;
var transportLng = document.getElementById("evtmap-vc_longitudetransport").value;

var marker = new google.maps.Marker({
    draggable: true
});

var markerT = new google.maps.Marker({
    draggable: true
});

function initialize()
{
    myCenter = getIniCenter(eventLat, eventLng);
    var mapProp = {
        center:myCenter,
        zoom:13,
        mapTypeId:google.maps.MapTypeId.ROADMAP
    };
    map = new google.maps.Map(document.getElementById("eventMap"),mapProp);
    var input = (document.getElementById("evtmap-searchbox"));
    var autocomplete = new google.maps.places.Autocomplete(input);
    autocomplete.bindTo("bounds", map);
    marker.setMap(map);
    marker.setVisible(true);
    var markerPlaces = new google.maps.Marker({
        map: map,
    });
    if (!eventLat == "") {
            marker.setPosition(myCenter);
    }
        
    google.maps.event.addListener(autocomplete, "place_changed", function() 
    {
        var place =  findPlace(autocomplete, map, marker);
        setLatLngVals("#evtmap-vc_latitude", "#evtmap-vc_longitude", place.geometry.location);
    });   

    google.maps.event.addListener(map, "click", function(event) 
    {
        clickMarker(event, marker);
        setLatLngVals("#evtmap-vc_latitude", "#evtmap-vc_longitude", event.latLng);

    });

    google.maps.event.addListener(marker, "dragend", function(evt) 
    {
        setLatLngVals("#evtmap-vc_latitude", "#evtmap-vc_longitude", evt.latLng);
    });
}
 
function initializeTranportMap()
{
    transportLocation = getIniCenter(transportLat, transportLng);
    var mapProp = {
      center:transportLocation,
      zoom:13,
      mapTypeId:google.maps.MapTypeId.ROADMAP
    };
    transportMap = new google.maps.Map(document.getElementById("transportMap"),mapProp);
    var inputT = (document.getElementById("evtmap-searchboxtransport"));
    var autocompleteT = new google.maps.places.Autocomplete(inputT);
    autocompleteT.bindTo("bounds", transportMap);
    markerT.setMap(transportMap);
    if (!transportLat == "") {
       markerT.setPosition(transportLocation);
    }
    var autocompleteT;
    google.maps.event.addListener(autocompleteT, "place_changed", function() {
        var place =  findPlace(autocompleteT, transportMap, markerT);
        setLatLngVals("#evtmap-vc_latitudetransport", "#evtmap-vc_longitudetransport", place.geometry.location);
    });   
    google.maps.event.addListener(transportMap, "click", function(event) {
        clickMarker(event, markerT);
        setLatLngVals("#evtmap-vc_latitudetransport", "#evtmap-vc_longitudetransport", event.latLng);
    });
    google.maps.event.addListener(markerT, "dragend", function(evt) {
        setLatLngVals("#evtmap-vc_latitudetransport", "#evtmap-vc_longitudetransport", evt.latLng);
    });
}

$("#currentLocationE").on("click", function () 
{
    geolocation();
    $("#evtmap-vc_latitude").val(null);
    $("#evtmap-vc_longitude").val(null);
    initialize();
})

$("#currentLocationT").on("click", function () {
    geolocationT();
    $("#evtmap-vc_latitudetransport").val(null);
    $("#evtmap-vc_longitudetransport").val(null);
    initializeTranportMap();
})

function getIniCenter(lat, lng)
{
    if (lat == "") {
        return new google.maps.LatLng(20.9663671,-89.6067274);
    } else {
        return new google.maps.LatLng(lat, lng);
    }
}

function setLatLngVals(lat, lng, value)
{
    $(lat).val(value.lat());
    $(lng).val(value.lng());
}
 
function findPlace(autoComplete, map, marker)
{
    var place = autoComplete.getPlace();
    marker.setVisible(false);
    if (!place.geometry) {
        return;
       }
    if (place.geometry.viewport) {
        map.fitBounds(place.geometry.viewport);
    } else {
        map.setCenter(place.geometry.location);
        map.setZoom(17);
    }
    marker.setPosition(place.geometry.location);
    marker.setVisible(true);
    return place;
}

function clickMarker(event, marker){
    marker.setVisible(false);
    var newlocation = new google.maps.LatLng(event.latLng.lat(), event.latLng.lng());
    marker.setPosition(newlocation);
    marker.setVisible(true);
}

function geolocation()
{
     if (geoPosition.init()) {
        geoPosition.getCurrentPosition(successE, errorHandler, {timeout:5000});
    } else {
        error("Perdón, no hemos podido encontrar tu ubicación");
    }
}

function geolocationT()
{
     if (geoPosition.init()) {
        geoPosition.getCurrentPosition(successT, errorHandler, {timeout:5000});
    } else {
        error("Perdón, no hemos podido encontrar tu ubicación");
    }
}

function successE(position) 
{
    currentPosMarker("#evtmap-vc_latitude", "#evtmap-vc_longitude", map, marker, position);
}
 
function successT(position) 
{
    currentPosMarker("#evtmap-vc_latitudetransport", "#evtmap-vc_longitudetransport", transportMap, markerT, position);
}

function currentPosMarker(lat, lng, map, marker, position){
    var latlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
    $(lat).val(position.coords.latitude);
    $(lng).val(position.coords.longitude);
    marker.setPosition(latlng);
    marker.setMap(map);
    marker.setVisible(true);
    map.setCenter(latlng);
    map.setZoom(12);
}
 
function errorHandler(err) {
    var s = document.querySelector("#statusE");
    s.innerHTML = typeof msg == "string" ? msg : "failed";
    s.className = "fail";  
}

google.maps.event.addDomListener(window, "load", initialize);

$("#transMapForm").hide();
$("#transportMapDiv").hide();

$("#buttonEvent").on("click", function () {
    $("#evtMapForm").show();
    $("#transMapForm").hide();
    $("#eventMapDiv").show();
    $("#transportMapDiv").hide();
})

$("#buttonTrans").on("click", function () {
    $("#evtMapForm").hide();
    $("#transMapForm").show();
    $("#transportMapDiv").show();
    $("#eventMapDiv").hide();
    initializeTranportMap();
})

$("#clearTransport").on("click", function () {
    $("#evtmap-vc_latitudetransport").val(null);
    $("#evtmap-vc_longitudetransport").val(null);
    $("#evtmap-vc_transporttag").val(null);
    initializeTranportMap();
})