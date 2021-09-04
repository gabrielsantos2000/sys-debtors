const baseUrl = window.location.origin + "/sys-debtors/app/";

$(document).on("change", "#nm_estado", function(){
    if($(this).val() <= 0) {
        return false;
    }

    ajaxGetCityByStateId($(this).val());
})

function ajaxGetCityByStateId($stateId) {
    $.ajax({
        url: baseUrl + "ajax/AjaxTransaction.php",
        type: "GET",
        dataType: "json",
        data: {
            model: "ItemStateCity", 
            method: "findAllCitiesByStateId", 
            params: $stateId
        },
        success: function(data){
            if(data.length > 0) {
                fillSelectCities(data);
                return;
            }

            alert("Cidades não encontratada para este estado.")
        },
        error: function(xhr) {
            alert("Error " + xhr.status + ": There was a failure to process your request.")
        }
    });
}

function fillSelectCities($cities) {
    let citiesSelect = $("#nm_cidade");
        citiesSelect.empty();  
    $.each($cities, function(index, dataCity){
        $('<option>').val(dataCity.id).text(dataCity.nm_cidade).appendTo(citiesSelect);
    });
}