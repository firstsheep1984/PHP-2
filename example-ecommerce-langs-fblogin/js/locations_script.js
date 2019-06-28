function initMap() {
        var myLatlng = new google.maps.LatLng(-25.363882, 131.044922);
        var mapOptions = {
            zoom: 7,
            center: myLatlng
        }
        var map = new google.maps.Map(document.getElementById("map"), mapOptions);

        var marker = new google.maps.Marker({
            position: myLatlng,
            title: "Hello World!"
        });

// To add the marker to the map, call setMap();
        marker.setMap(map);

    }
    var map;
$(document).ready(function () {
      /* $.ajax({
        url: '/markers',
        type: "GET",
        contentType: 'application/json',
    }).done(function (data){
        for(var i=0; i< data.length; i++){
            console.log(data['address']);
        }
    });        //initMap();*/

    
});