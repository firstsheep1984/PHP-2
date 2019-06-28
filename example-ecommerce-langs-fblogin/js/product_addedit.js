function getProductsTable(ID) {
    $('#productForm').load('/admin/product_addedit/form/' + ID);
}
$(document).ready(function () {
    $('#productTable').load('/admin/product_addedit');
    $('#productForm').load('/admin/product_addedit/form');

//Ca sa faci acest buton sa prinda click event, in html ataseaza-i functie si functia o definesti sus, asa cum am facut si eu. 
    $("#btCancelProduct").click(function () {

        alert("CancelProduct button reaction");
    });


});
