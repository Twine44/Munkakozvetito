$(document).ready(function() {
    sitesForCompany();
});

//add Company site
function addItem() {
    var itemContainer = document.getElementById("siteContainer");
    var newItem = document.createElement("div");
    newItem.classList.add("site");

    newItem.innerHTML = `
    <h4>Telephely</h4>
    <label for="postcode">irányítószám:</label><br><input type="text" id="postcode" name="postcode[]"><br>
    <label for="cityname">településnév:</label><br><input type="text" id="cityname" name="cityname[]"><br>
    <label for="address">közterület neve:</label><br><input type="text" id="address" name="address[]"><br>
    <label for="houseNumber">házszám:</label><br><input type="text" id="houseNumber" name="houseNumber[]"><br>
    <button type="button" class="removeItem addremoveItemBtn" onclick="removeItem(this)">telephely törlése</button>
    `;

    itemContainer.appendChild(newItem);
}

//remove Company site
function removeItem(button) {
    var itemContainer = document.getElementById("siteContainer");
    var itemToRemove = button.parentNode;
    itemContainer.removeChild(itemToRemove);
}


//refresh sites based on the selected company
function refreshSites(compId) {
    $.ajax({
        type: 'POST',
        url: '../config/functions.php',
        data: { action: 'readCompanySites', cId: compId, sId : 0 },
        dataType: 'html',
        success: function(response) {
            $('#companySite').html(response);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error("AJAX Error:", textStatus, errorThrown);
        }
    });
}

//call refreshSites if the select is changed
function sitesForCompany(){
    $('#company').change(function() {
        var compId = $(this).val();
        refreshSites(compId);
    });
}

