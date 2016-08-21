$(document).ready(function() {
   
    //Zieht sich sofort die ID und nicht erst beim Klick. Dadurch kein einfaches Manipulieren via DevTool.
    var unternehmen = $("#rating-unternehmen").val();
    var user_rating = $("#rating").attr('class');
    var current_url = $(location).attr('href');
    
    $.ajaxSetup({ cache: true });
    $.getScript('//connect.facebook.net/en_US/sdk.js', function(){
        FB.init({
          appId: '457558261107050',
          version: 'v2.5' // or v2.0, v2.1, v2.2, v2.3
        });
        /*
        FB.ui(
         {
          method: 'share',
          href: current_url
        }, function(response){});
        */
    });
    
   
        
    $( ".f-rate" ).on({
        click: function() {
            
            var rating = $(this).val();
            
            insertRating(unternehmen, rating);
            $( ".f-rate" ).off();
          }, 
        mouseenter: function() {
            $(this).removeClass('star_off').addClass('star_on');
            $(this).prevAll('.star_off').removeClass('star_off').addClass('star_on');
            $(this).nextAll('.star_on').removeClass('star_on').addClass('star_off');
          }, 
        mouseleave: function() {
          //  $('.star_on').removeClass('star_on').addClass('star_off');
            setAusgangsbasis(user_rating);
          }
});
    
});


function setAusgangsbasis(rating){
    
    var ratingClass = "#li_" + rating;
    $(ratingClass).removeClass('star_off').addClass('star_on');
    $(ratingClass).prevAll('.star_off').removeClass('star_off').addClass('star_on');
    $(ratingClass).nextAll('.star_on').removeClass('star_on').addClass('star_off');
    
}


function insertRating(unternehmen, rating){
	//DIE VARIABLE templateUrl WIRD IM HEADER GESETZT!
	var rating_url =   templateUrl +  '/insert-rating.php';
	$.post(rating_url,
		{
		unternehmen : unternehmen,
        rating      : rating
		}
	).done(function( data ) {
	   $("#testausgabe").html(data);		
	});
}
