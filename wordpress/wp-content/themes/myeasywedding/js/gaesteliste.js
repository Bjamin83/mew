$(document).ready(function(){
	

    
	$(".portion-kind").click(function(){
		$(this).toggleClass("portion-kind-checked");
	});


//fügt neue Einträge je Klick hinzu
	$( "#add-gaesteliste" ).click(function() {
			
		//DB-Abfrage über Ajax. Rückgabe der letzten Row-ID + Übernahme in html Gerüst.
		insertZeile();
		
				
	});
		  	
	
	/*
	*	Zusage, Absage und Löschen der Zeilen:
	*/
	
	//löscht den jeweiligen Listeneintrag indem der parent-div gelöscht wird und speichert die neue Checkliste
	$('#gaesteliste-panel').on('click', '.f-delete' , function() {
			var id = $(this).parent().parent().find('.gaesteliste_id').attr('id');
	 		$(this).parent().parent().remove();
			deleteZeile(id);
	});
	//Setzt die Hintergrundfarbe entsprechend dem Status glyphicon-thumbs-down
	$('#gaesteliste-panel').on('click', '.f-absage' , function() {
	 		$(this).parent().parent().removeClass( "bg-zusage" ).removeClass( "bg-offen" ).addClass( "bg-absage" );
			var id = $(this).parent().parent().find('.gaesteliste_id').attr('id');
	 		updateStatus(id, 'absage');
	});
	//Setzt die Hintergrundfarbe entsprechend dem Status glyphicon-thumbs-up
	$('#gaesteliste-panel').on('click', '.f-zusage' , function() {
	 		$(this).parent().parent().removeClass( "bg-absage" ).removeClass( "bg-offen" ).addClass( "bg-zusage" );
	 		var id = $(this).parent().parent().find('.gaesteliste_id').attr('id');
	 		updateStatus(id, 'zusage');
	});
	//Setzt die Hintergrundfarbe entsprechend dem Status glyphicon-thumbs-up
	$('#gaesteliste-panel').on('click', '.f-offen' , function() {
	 		$(this).parent().parent().removeClass( "bg-absage" ).removeClass( "bg-zusage" ).addClass( "bg-offen" );
	 		var id = $(this).parent().parent().find('.gaesteliste_id').attr('id');
	 		updateStatus(id, 'offen');
	});
	
});

function neueZeile(latest_ID){
			
			var last_ID = latest_ID;
			
			if("Anmeldefehler" == last_ID){
				alert("Bitte überprüfe ob du angemeldet bist.");
				return;
			}
			
			
			var vorname=$("#vorname").val();
			var nachname=$("#nachname").val();
			var portion="";
			//if Abfrage ob Erwachsener oder Kind
			if($( "#kind" ).hasClass( "portion-kind-checked" )){
				portion="Kind";
			} else {
				portion="Erwachsener";
			}
			
			
			var essen=$("#essen").val();
			
			//var entries= $( "#checkliste-panel .panel-body" ).length + 1;
			
			//stellt das div-Konstrukt der einzelnen Gaestenlisteneinträge dar
			var gaestelistenzeile = 	"<div class='gl-padding bg-offen f-gaesteliste'>" +
											"<div id="+ last_ID +" class='gaesteliste_id'></div>"+
											"<div class='col-md-4 col-xs-12'>"+
												"<button type='button' class='btn btn-default gast-icon-status float-left f-zusage'>"+
									  				"<span class='glyphicon glyphicon-thumbs-up' aria-hidden='true'></span>"+
									  			"</button>"+
												"<button type='button' class='btn btn-default gast-icon-status float-left f-absage'>"+
									  				"<span class='glyphicon glyphicon-thumbs-down' aria-hidden='true'></span>"+
									  			"</button>"+
												"<button type='button' class='btn btn-default gast-icon-status float-left f-offen'>"+
									  				"<span class='glyphicon glyphicon-hourglass' aria-hidden='true'></span>"+
									  			"</button>"+
												"<div class='float-left' id='gaesteliste_nachname'>"+
												"<p class='text-middle'>" + nachname + "</p>" +
												"</div>"+
												"<div class='float-left'>"+
												"<p>,&nbsp; </p>" +
												"</div>"+
												"<div class='float-left' id='gaesteliste_vorname'>"+
												"<p>" + vorname + "</p>" +
												"</div>"+
											"</div>"+
											"<div class='col-md-4 col-xs-12'>"+
												"<div class='float-left' id='gaesteliste_portion'>"+
												"<p>" + portion + "</p>" +
												"</div>"+
												"<div class='float-left'>"+
												"<p>&nbsp;&nbsp; - &nbsp;&nbsp;</p>"+
												"</div>"+
												"<div class='float-left' id='gaesteliste_essen'>"+
												"<p>" + essen + "</p>" +
												"</div>"+
											"</div>"+
											"<div class='col-md-4 col-xs-12'>"+	
												"<button type='button' class='btn btn-default float-right gast-icon-delete f-delete'>"+
									  				"<span class='glyphicon glyphicon-trash' aria-hidden='true'></span>"+
									  			"</button>"+
									  		"</div>"+
											"<div class='col-md-12 col-xs-12'>"+
											"<hr class='short-hr' />"+
											"</div>"+
								  			"<div class='clear-both'></div>"+
								  		"</div>";
				
		  	//fügt das Div-Konstrukt dem parent Div hinzu
	 		$( "#gaesteliste-panel" ).prepend(gaestelistenzeile);
}


function updateStatus(id, status){
	//DIE VARIABLE templateUrl WIRD IM HEADER GESETZT!
	var gaesteliste_url =   templateUrl +  '/update-guestlist.php';
	$.post(gaesteliste_url,
		{
		id 		: id, 
		status 	: status	
		}
	).done(function( data ) {
			updateGaeste();
	});
}

function deleteZeile(id){
	//DIE VARIABLE templateUrl WIRD IM HEADER GESETZT!
	var gaesteliste_url =   templateUrl +  '/delete-guestlist.php';
	$.post(gaesteliste_url,
		{
		id 		: id
		}
	).done(function( data ) {
			updateGaeste();
	});
}

//
function insertZeile(){
		
	//DIE VARIABLE templateUrl WIRD IM HEADER GESETZT!
	var gaesteliste_url =   templateUrl +  '/insert-guestlist.php';
	var portion="";
			//if Abfrage ob Erwachsener oder Kind
			if($( "#kind" ).hasClass( "portion-kind-checked" )) {
				portion="Kind";
			} else {
				portion="Erwachsener";
			}
	
	
	$.post(gaesteliste_url,
		{
		 
		 nachname 	: $('#nachname').val(), 
    	 vorname 	: $('#vorname').val(),
    	 portion 	: portion,
    	 essen 		: $('#essen').val()
    		
		}).done(function( data ) {
			neueZeile(data);
			cleanInput();
			updateGaeste();
	});

}

function updateGaeste(){
	//DIE VARIABLE templateUrl WIRD IM HEADER GESETZT!
	var gaesteliste_url =   templateUrl +  '/class/guestlist.php';
	$.post(gaesteliste_url,
		{
		 
		 	update			: 'overview'
			
		}).done(function( data ) {
            var json_ar = $.parseJSON(data);
			$('.f-gaeste').html(json_ar[0]);
            $('.f-essen').html(json_ar[1]);
			
	});
}

function cleanInput(){
	$('#nachname').val(''), 
   	$('#vorname').val('')
}

