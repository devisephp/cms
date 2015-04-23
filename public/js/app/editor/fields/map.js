devise.define(['require', 'jquery'], function (require, $) {

    var geocoder;

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

    function createMarker(latlng, map)
    {
        return new google.maps.Marker({
            position: latlng,
            map: map,
            zIndex: Math.round(latlng.lat()*-100000)<<5
        });
    }

    function findLatLngFromAddress(address)
    {
        var deferred = new $.Deferred;

        geocoder.geocode({ 'address': address }, function(results, status)
        {
            if (status !== google.maps.GeocoderStatus.OK)
            {
                return deferred.reject(results, status);
            }

            return deferred.resolve(results[0].geometry.location, address)
        });

        return deferred.promise();
    }

    function clearMarker(marker)
    {
        if (marker)
        {
            marker.setMap(null);
            marker = null;
        }
    }

    function fieldsForTheMapForm(form)
    {
        var fields = {};

        fields.address = form.find('[name="address"]');
        fields.lat = form.find('[name="latitude"]');
        fields.lng = form.find('[name="longitude"]');
        fields.mode = form.find('[name="mode"]');
        fields.startingZoom = form.find('[name="startingZoom"]');
        fields.minZoom = form.find('[name="minZoom"]');
        fields.maxZoom = form.find('[name="maxZoom"]');

        return fields;
    }

    function valuesForAllMapFields(fields)
    {
        var values = {
            address: '',
            lat: 25.7877,
            lng: -80.2241,
            mode: 'roadmap',
            startingZoom: 1,
            minZoom: 1,
            maxZoom: 19
        };

        // override any values that have been set
        values.address = fields.address.val() ? fields.address.val() : values.address;
        values.lat = fields.lat.val() ? parseFloat(fields.lat.val()) : values.lat;
        values.lng = fields.lng.val() ? parseFloat(fields.lng.val()) : values.lng;
        values.mode = fields.mode.val() ? fields.mode.val() : values.mode;
        values.startingZoom = fields.startingZoom.val() ? parseInt(fields.startingZoom.val()) : values.startingZoom;
        values.minZoom = fields.minZoom.val() ? parseInt(fields.minZoom.val()) : values.minZoom;
        values.maxZoom = fields.maxZoom.val() ? parseInt(fields.maxZoom.val()) : values.maxZoom;

        return values;
    }

    function adjustStartingZoomLevel(zoomLevel, fields, values, map)
    {
        values.startingZoom = zoomLevel;

        if (values.startingZoom > values.maxZoom)
        {
            values.startingZoom = values.maxZoom;
            redrawStartingZoomLevelField(fields, values);
        }

        if (values.startingZoom < values.minZoom)
        {
            values.startingZoom = values.minZoom;
            redrawStartingZoomLevelField(fields, values);
        }

        map.setZoom(values.startingZoom);
    }

    function redrawStartingZoomLevelField(fields, values)
    {
        var options = "";
        var selected = "";

        for (var i = values.minZoom; i <= values.maxZoom; i++)
        {
            selected = i == values.startingZoom ? "selected" : "";
            options += '<option value="' + i + '"' + selected + '>' + i + '</option>';
        }

        fields.startingZoom.html(options);

        setTimeout(function()
        {
            fields.startingZoom.change();
        }, 1000);
    }

    return {
        init: function()
        {
            // initialize the geocoder, we will need it later
            geocoder = new google.maps.Geocoder();

            $('.dvs-google-map').each(function(){

                var parentForm = $(this).parents('form');
                var fields = fieldsForTheMapForm(parentForm);
                var values = valuesForAllMapFields(fields);

                // creates a shiny new map to look at
                var map = new google.maps.Map($(this).get(0),{
                    zoom: values.startingZoom,
                    center: new google.maps.LatLng(values.lat, values.lng),
                    mapTypeId: values.mode,
                    streetViewControl: false,
                    mapTypeControl: false
                });

                // setup a marker for the map
                var marker = createMarker(new google.maps.LatLng(values.lat, values.lng), map);


                // handles setting the input fields when we click on a
                // location within the Google map and create a Marker
                google.maps.event.addListener(map, 'click', function(event)
                {
                    clearMarker(marker);
                    marker = createMarker(event.latLng, map);
                    // google.maps.event.trigger(marker, 'click'); // not sure why we need this
                    updateAddress(event.latLng.lat(), event.latLng.lng(), fields.address);
                    fields.lat.val(event.latLng.lat());
                    fields.lng.val(event.latLng.lng());
                });



                // handles starting zoom
                fields.startingZoom.on('change', function()
                {
                    values.startingZoom = parseInt(fields.startingZoom.val());
                    adjustStartingZoomLevel(values.startingZoom, fields, values, map);
                });



                // handles min zoom
                fields.minZoom.on('change', function()
                {
                    values.minZoom = parseInt(fields.minZoom.val());
                    adjustStartingZoomLevel(values.startingZoom, fields, values, map);
                });



                // handles max zoom
                fields.maxZoom.on('change', function()
                {
                    values.maxZoom = parseInt(fields.maxZoom.val());
                    adjustStartingZoomLevel(values.startingZoom, fields, values, map);
                });



                // handles setting the marker on the map when we update
                // fields like address, lat and lng
                fields.address.on('change', function()
                {
                    clearMarker(marker);
                    values.address = fields.address.val();
                    findLatLngFromAddress(values.address).then(function(latlng)
                    {
                        marker = createMarker(latlng, map);
                        fields.lat.val(latlng.lat());
                        fields.lng.val(latlng.lng());
                        map.panTo(latlng);
                    });
                });



                // handle when the user changes the lat/lng fields
                fields.lat.on('change', function()
                {
                    values.lat = fields.lat.val();
                    latlng = new google.maps.LatLng(values.lat, values.lng),
                    clearMarker(marker);
                    marker = createMarker(latlng, map);
                    updateAddress(latlng.lat(), latlng.lng(), fields.address);
                    map.panTo(latlng);
                });



                // handle when the user changes the lat/lng fields
                fields.lng.on('change', function()
                {
                    values.lng = fields.lng.val();
                    latlng = new google.maps.LatLng(values.lat, values.lng),
                    clearMarker(marker);
                    marker = createMarker(latlng, map);
                    updateAddress(latlng.lat(), latlng.lng(), fields.address);
                    map.panTo(latlng);
                });



                // handle when the user changes the map type (we call
                // it mode)
                fields.mode.on('change', function()
                {
                    values.mode = fields.mode.val();
                    map.setMapTypeId(values.mode);
                });
            });

        }
    };
});