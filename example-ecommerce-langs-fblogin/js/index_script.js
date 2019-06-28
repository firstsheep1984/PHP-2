 function changePage(pageNum){
             $('#index-products').load('/category/' + 1 + '/' + 0 + '/page/' + pageNum);
        }
var pageNum = 1;


$(document).ready(function () {

    //alert(categoryID);
    $('#index-products').load('/category/1/0/page/1');
    var categoryID = 1;
    var isVeget = 0;

    $("#cbVegetarian").on('change', function () {

        //alert('test');

        if ($("input[type='checkbox']").prop('checked')) {
            isVeget = 1;
        }
        else{
            isVeget = 0;
        }

        $('#index-products').load('/category/' + categoryID + '/' + isVeget + '/page/1');
    });


    $("#navCategory").on("click", "button", function () {

        categoryID = $(this).attr('id');
        spanValue = categoryID;
        //var isVeget = 0;
        if ($("input[type='checkbox']").prop('checked')) {
            isVeget = 1;
        }
        //alert(categoryID + isVeget);

        $('#index-products').load('/category/' + categoryID + '/' + isVeget + '/page/1');
    });

});