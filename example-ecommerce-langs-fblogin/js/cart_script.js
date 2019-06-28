function removeItem(ID) {
    $.ajax({
        url: "/cartItems/" + ID,
        type: "DELETE",
        contentType: 'application/json',
        success: function (result) {
            console.log("cartItems update returned: " + result);
            if (!result) {
                alert("Error removing product from cart ");
            }
            $('#cartContainer').load('/cart');
        },
        error: function () {
            console.log("delete from cartItems FAILED");
            alert("Error removing product from cart ");
        }
    });
}
function changedQuantity(itemID) {
        
        var quantity = $('#'+itemID).val();
        if (quantity === "") return;
        var data = {quantity: quantity};
        $.ajax({
            url: "/cart/update/" + itemID,
            type: "PUT",
            data: JSON.stringify(data),
            contentType: 'application/json'
    }).done(function(){
        console.log("quantity upates " + quantity + " of item " + itemID);
        $('#cartContainer').load('/cart');
        }).fail(function(){
                console.log("cartItems update FAILED");
                alert("Error updating quantity of the product");
            });
    }
//FIXME validation for delete and update    
$(document).ready(function () {
    $('#cartContainer').load('/cart');
    
    
    /*
    $(".quanInput").bind('input', function () {
        alert("hello");
            var quantity = $(this).val();
            var itemID = $(this).attr('itemID');
            console.log("quantity changed: " + quantity + " of item " + itemID);
            if (quantity === "") return;
            
            var data = {quantity: quantity};
            $.ajax({
                url: "/ipd7/justcart/api.php/cartItems/" + itemID,
                type: "PUT",
                data: JSON.stringify(data),
                contentType: 'application/json',
                success: function (result) {
                    console.log("cartItems update returned: " + result);
                    if (!result) {
                        alert("Error updaing quantity of the product");
                    }
                },
                error: function() {
                    console.log("cartItems update FAILED");
                    alert("Error updaing quantity of the product");
                }
            });

        });
    /*
geocoder.geocode( { 'address': address}, function(results, status) {
		if (status === google.maps.GeocoderStatus.OK) {
			var latlng = results[0].geometry.location;
			map.setCenter(latlng);
			searchStores(latlng.lat(), latlng.lng());
			
		} else {
			alert('Geocode was failed: ' + status);
		}
	});
        */
       
        
});