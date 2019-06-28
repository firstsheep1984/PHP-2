function changePage(pageNum) {
    $('#reviewList').load('/reviews/product/' + productID + '/page/' + pageNum);
}

var pageNum = 1;

$(document).ready(function () {
    productID = $('#productID').text();
    $('#reviewList').load('/reviews/product/' + productID + '/page/' + 1);
    $('#ratingsProduct').load('/rating/' + productID);

    var selectedRating = 0;
    $(".error").text("");
    $('#reviewForm').hide();
    $('#leaveReview').show();

    $('#leaveReview').click(function () {
        $('#reviewForm').show();
        $('#leaveReview').hide();
    });
    $('.reviewEmptyStar').click(function () {
        for (var i = 1; i <= 5; i++) {
            $('#star' + i).removeClass('glyphicon-star').addClass('glyphicon-star-empty');
        }
        var id = $(this).attr('id').slice(-1);
        selectedRating = id;
        for (var i = 1; i <= selectedRating; i++) {
            $('#star' + i).removeClass('glyphicon-star-empty').addClass('glyphicon-star');
        }
    });

    $("#postReview").click(function () {
        var review = $("textarea[name=reviewText]").val();
        var rating = selectedRating;
        //FIXME get the current date and time for mysql format
        var currentdate = new Date();
        var date2 = currentdate.getDate() + "-"
                + (currentdate.getMonth() + 1) + "-"
                + currentdate.getFullYear() + " "
                + currentdate.getHours() + ":"
                + currentdate.getMinutes() + ":"
                + currentdate.getSeconds();

        var date = (new Date()).toISOString().substring(0, 19).replace('T', ' ')
        var productID = $('#productID').text();
        //FIXME: validate input for stars
        if (review.length < 1 || review.length > 500) {
            $(".error").text("You cannot send an empty message");
            return;
        } else {
            $(".error").text("");
        }

        $.ajax({
            url: "/reviews/product/" + productID,
            data: JSON.stringify({
                productID: productID,
                date: date,
                rating: rating,
                review: review,
            }),
            type: "POST",
            dataType: "json"
        }).done(function () {
            //Refresh fields  
            selectedRating = 0;
            $("textarea[name=reviewText]").val("");
            // var reviewCount = (int)($('#reviewCount').html())+1;
            // $('#reviewCount').html(reviewCount);
            // $('#reviewCount').val("");
            $('#reviewForm').hide();
            $('#leaveReview').show();
            for (var i = 1; i <= 5; i++) {
                $('#star' + i).removeClass('glyphicon-star').addClass('glyphicon-star-empty');
            }
            $('#reviewList').load('/reviews/product/' + productID + '/page/' + 1);
            $('#ratingsProduct').load('/rating/' + productID);
        });

    });
});

