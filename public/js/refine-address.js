
google.maps.event.addDomListener(window, 'load', initialize);

let autocomplete;

function initialize() {
    var input = document.getElementById('autocomplete');
    autocomplete = new google.maps.places.Autocomplete(input, {
        componentRestrictions: { country: ["ca"] },
        fields: ["address_components", "geometry", "formatted_address"],
        types: ["locality", "postal_code"],
    });


    autocomplete.addListener('place_changed', fillInAddress);
}

function fillInAddress() {
    var place = autocomplete.getPlace();
    console.log(place);
    let loc = place.formatted_address;
    let address1 = "";
    let postal_code = "";
    let city = "";
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

    var scope = angular.element(document.getElementById('refineCtrl')).scope();
    // scope.refineModel = {}
    // scope.refineModel.address = address1 ? address1 : null
    // scope.refineModel.location = loc ? loc: null
    scope.refineModel.suburb = city ? city: null
    let s_id = scope.getStateId(state);
    scope.refineModel.state_id = s_id ? s_id: null
    scope.refineModel.postal_code = postal_code ? postal_code: null
    // scope.refineModel.address.latitude = place.geometry['location'].lat()
    // scope.refineModel.address.longitude = place.geometry['location'].lng()
    scope.$apply()


}