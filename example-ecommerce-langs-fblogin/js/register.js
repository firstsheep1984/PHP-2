        function checkEmail() {
            var email = $('input[name=email]').val();
            if (email != '') {
                $('#result').load('/emailexists/' + email);
                $.ajax({
        url: '/emailexists/' + email,
        type: "GET",
        contentType: 'application/json',
    }).done(function (data){
        if(data){
        $('#emailExists').css('visibility', 'visible');
    } else {
        $('#emailExists').css('visibility', 'hidden');

    }
    });

            } else {
               $('#emailExists').css('visibility', 'hidden');
            }
        }
        
        $(document).ready(function() {
            $('#emailExists').css('visibility', 'hidden');
            $('input[name=email]').keyup(function() {
                checkEmail();
            });
            $('input[name=email]').bind('paste', function() {
                checkEmail();
            });
        });
