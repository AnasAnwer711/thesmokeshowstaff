$(document).ready(function() {
    $("#latitude").addClass("d-none");
    $("#longitude").addClass("d-none");
});
google.maps.event.addDomListener(window, 'load', initialize);

let autocomplete;

function initialize() {
    var input = document.getElementById('autocomplete');
    autocomplete = new google.maps.places.Autocomplete(input, {
        componentRestrictions: { country: ["ca"] },
        fields: ["address_components", "geometry", "formatted_address"],
        types: ["postal_code"], //locality,address,
    });


    autocomplete.addListener('place_changed', fillInAddress);
}

function fillInAddress() {
    var place = autocomplete.getPlace();
    console.log(place);
    let loc = place.formatted_address;
    let address1 = "";
    let postal_code = "";
    for (const component of place.address_components) {
        const componentType = component.types[0];
        // console.log(component);
        switch (componentType) {
            case "street_number":
                {
                    address1 = `${component.long_name} ${address1}`;
                    break;
                }
            case "route":
                {
                    address1 += component.short_name;
                    break;
                }
            case "locality":
                {
                    city = component.long_name;
                    break;
                }
            
            case "administrative_area_level_1":
                {
                    state = component.short_name;
                    break;
                }
            case "country":
                {
                    country = component.long_name;
                    break;
                }
            case "postal_code_prefix":
                {
                    postal_code = component.long_name;
                    break;
                }
            case "postal_code":
                {
                    postal_code = component.long_name;
                    break;
                }

        }

    }

    var scope = angular.element(document.getElementById('profileDashboardCtrl')).scope();
    scope.profileModel.address = {}
    scope.profileModel.address.address_line1 = address1 ? address1 : city
    scope.profileModel.address.suburb = city ? city: null
    let s_id = scope.getStateId(state);
    scope.profileModel.address.state_id = s_id ? s_id: null
    scope.profileModel.address.postal_code = postal_code ? postal_code: null
    scope.profileModel.address.latitude = place.geometry['location'].lat()
    scope.profileModel.address.longitude = place.geometry['location'].lng()
    scope.$apply()

    // $('#address_line1').val(address1);
    // $('#location').val(loc);
    // $('#suburb').val(city);
    // $('#state').val(state);
    // $('#country').val(country);
    // $('#postal_code').val(postal_code);
    $('#latitude').val(place.geometry['location'].lat());
    $('#longitude').val(place.geometry['location'].lng());
    // --------- show lat and long ---------------
    // $("#lat_area").removeClass("d-none");
    // $("#long_area").removeClass("d-none");
}