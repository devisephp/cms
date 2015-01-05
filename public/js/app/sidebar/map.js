devise.define(['require', 'jquery', 'async!http://maps.google.com/maps/api/js?sensor=false'], function (require, $) {

    function updateAddress(lat, lng, target)
    {
        $.ajax({
            url:'https://maps.googleapis.com/maps/api/geocode/json?latlng='+lat+','+lng+'&key=AIzaSyBDD9ezHJOfgFUKbGtX88QaTNFyD7JS90U',
            type:'get',
            success:function(response)
            {
                if(response.results.length > 0 && response.results[0].hasOwnProperty('formatted_address')){
                    target.val(response.results[0]['formatted_address']);
                }
            }
        });
    }

    function createMarker(latlng, name, map) {
        var marker = new google.maps.Marker({
            position: latlng,
            map: map,
            zIndex: Math.round(latlng.lat()*-100000)<<5
        });

        google.maps.event.trigger(marker, 'click');
        return marker;
    }

    return {
        init: function()
        {
            $('.dvs-google-map').each(function(){
                var parentForm = $(this).parents('form');
                var addressField = parentForm.find('[name="address"]');
                var latField = parentForm.find('[name="latitude"]');
                var lngField = parentForm.find('[name="longitude"]');
                var marker;
                var map = new google.maps.Map($(this).get(0),{
                    zoom:7,
                    center: new google.maps.LatLng(25.7877, -80.2241),
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    streetViewControl: false,
                    mapTypeControl: false
                });

                google.maps.event.addListener(map, 'click', function(event) {
                    if (marker) {
                        marker.setMap(null);
                        marker = null;
                    }

                    marker = createMarker(event.latLng, "name", map);
                    updateAddress(event.latLng.lat(), event.latLng.lng(), addressField);
                    latField.val(event.latLng.lat());
                    lngField.val(event.latLng.lng());
                });
            });
        }
    };
});