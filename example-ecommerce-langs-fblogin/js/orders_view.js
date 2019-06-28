function saveDelivery(orderID) {
    var deliveryDate = $("input[name=deliveryDate]").val();
    var deliveryAmount = $("input[name=deliveryAmount]").val();
    // alert(deliveryDate);
    $.ajax({
        url: "/admin/orders/" + orderID,
        data: JSON.stringify({
            deliveryDate: deliveryDate,
            deliveryAmount: deliveryAmount
        }),
        type: "POST",
        dataType: "json"
    }).done(function () {
        alert("Addedd successfully");
        $("#itemrow" + orderID).remove();
    }).fail(function () {
        alert('delivery save Failed');
    });
}


