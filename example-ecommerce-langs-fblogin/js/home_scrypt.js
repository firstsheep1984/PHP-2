$(document).ready(function () {
               
               var ratingsResult = "";
               var reviewStars = Math.round($('#averageStars').text());
               for (var i=0; i< reviewStars; i++){
                   ratingsResult += "<span class='glyphicon glyphicon-star'></span>";                                   
               }
                for (var i=0; i< 5-reviewStars; i++){
                   ratingsResult += "<span class='glyphicon glyphicon-star-empty'></span>";                                   
               }
               ratingsResult += "&nbsp" + reviewStars + " stars";

               $('#averageStars').html(ratingsResult);
               });

