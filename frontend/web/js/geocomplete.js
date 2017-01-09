$(document).ready(function(){ 

    $("#register-form-location").geocomplete({
      map: "#my_map_register",
      mapOptions: {
        scrollwheel: false,
        zoomControl: false,
        streetViewControl: false,
        scaleControl: false,
        panControl: false,
        overviewMapControl: false,
        mapTypeControl: false,
        keyboardShortcuts: false,
        fullscreenControl: false,
        draggable: false,
      },
      details: "form",
      detailsAttribute: "data-geo",
      types: ['(cities)'],
    }); 

});