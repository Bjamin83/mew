$(document).ready(function(){
	           
        $( "#f-checkliste-date" ).datepicker({
            dateFormat: "dd.mm.yy",
            dayNamesMin: [ "So", "Mo", "Di", "Mi", "Do", "Fr", "Sa" ],
            monthNames: [ "Januar", "Februar", "März", "April", "Mai", "Juni", "Juli", "August", "September", "Oktober", "November", "Dezember" ],
			    showOn: "button",
    			buttonImage: templateUrl+ "/img/calendar2.png",
      			buttonImageOnly: true,
      			buttonText: "Select date"
        });
		//fügt neue Einträge je Klick hinzu
		$( "#f-add-checkliste" ).click(function() {
	
			//DB-Abfrage über Ajax. Rückgabe der letzten Row-ID + Übernahme in html Gerüst.
			insert_DB();

		});
		
		$("#f-checkliste-prio").on('click', function(e){
			$('#f-prio-check').toggleClass("glyphicon glyphicon-ok margin-left");
			if ($("#f-prio-hidden").val() == "") {
      			$("#f-prio-hidden").val('Dringend');
		
   			} else {
     	 		$("#f-prio-hidden").val('');
		   	} 
			
		});
		  	
		//löscht den jeweiligen Checklisteneintrag indem der parent-div gelöscht wird und speichert die neue Checkliste
		$('#checkliste-panel').on('click', '.f-delete' , function() {
            var id = $(this).parent().parent().find('.checkliste_id').attr('id');
	 		$(this).parent().parent().remove();
	 		deleteZeile(id);
		});
	
		// ducrh Klick auf den Button werden alle Werte aus den Div-Ordnern in ein asso. Array geschrieben.	
		$( "#test" ).click(function(){
			
			//$( "#test-ausgabe" ).append(getAllValues);
			 testfunktion();
		});
		
	
});

//testfunktion
function testfunktion() {
	
	$( "#test-ausgabe" ).append("Huuuuhuuu: " + getAllValues() );
}


function deleteZeile(id){
	var fcn = "check_delete_anzeige";
	//DIE VARIABLE templateUrl WIRD IM HEADER GESETZT!
    var checkliste_url  = templateUrl +  '/fcn-checkliste.php';
	
    $.post(checkliste_url,
		{
        fcn     : fcn,
		id 		: id
		}
	).done(function( data ) {
        $("#checkliste-panel").html(data);
	});
}

function insert_DB(){
            //Übergabeparameter
            var fcn = "check_insert_anzeige";
            var checkliste_url  = templateUrl +  '/fcn-checkliste.php';
    
            var prio 			= $("#f-prio-hidden").val();
			var beschreibung	= $("#f-checkliste-beschreibung").val();
			var datum			= $("#f-checkliste-date").val();
			var status 			= 1;
			
			if(prio != "Dringend"){
				prio = "";
			}
			
			if(!isDate(datum)){
			 $("#f-checkliste-date").css("border", "1px solid red");
            return;
       		}
			
			$.post(checkliste_url,
				{
				 
                 fcn            : fcn,               
				 prio 			: prio, 
				 beschreibung 	: beschreibung,
				 datum 			: datum,
				 status 		: status
					
				}).done(function( data ) {
					$("#checkliste-panel").html(data);
                    cleanInput();
			});
}

function XXneueZeile(latest_ID, prio, beschreibung, datum, status){
	
	var last_ID = latest_ID;
			
			if("Anmeldefehler" == last_ID){
				alert("Bitte überprüfe ob du angemeldet bist.");
				return;
			}
	
			//stellt das div-Konstrukt der einzelnen Checklisteneinträge dar
			var checklistenzeile = 	"<div class='col-md-12 panel-body f-checklist'>" +
										"<div id="+ last_ID +" class='gaesteliste_id'></div>"+
										"<div class='col-md-1 col-xs-1 f-liste_prio'>"+
										prio +
										"</div>"+
										"<div class='col-md-8 col-xs-11 f-liste-beschreibung'>"+
										beschreibung +
										"</div>"+
										"<div class='col-md-2 col-xs-6 f-liste-datum'><span class='glyphicon glyphicon-time margin-right' aria-hidden='true'></span>"+
										datum +
										"</div>"+
													"<div class='col-md-1 col-xs-6'><button type='button' class='btn btn-default float-right f-delete'>"+
							  				"<span class='glyphicon glyphicon-ok' aria-hidden='true'></span>"+
							  			"</button></div>"+
										"</div>"+
										
							  		"</div>";		
									
				
		  	//fügt das Div-Konstrukt dem parent Div hinzu
	 		$( "#checkliste-panel" ).append(checklistenzeile);
}

function cleanInput(){

	$("#f-prio-hidden").val(''),
	$("#f-checkliste-beschreibung").val(''),
	$("#f-checkliste-date").val(''),
	$("#f-prio-check").removeClass("glyphicon glyphicon-ok margin-left");

}


//Datumsvalidierung
function isDate(txtDate){
    
    var currVal = txtDate;
    if(currVal == '')
        return false;
    
    var rxDatePattern = /^(\d{1,2})(\.|-)(\d{1,2})(\.|-)(\d{4})$/; //Declare Regex /^(\d{1,2})(\/|-)(\d{1,2})(\/|-)(\d{4})$/
    var dtArray = currVal.match(rxDatePattern); // is format OK?
    
    if (dtArray == null) 
        return false;
    
    //Checks for mm/dd/yyyy format.
    dtDay = dtArray[1];
    dtMonth= dtArray[3];
    dtYear = dtArray[5];        
    
    if (dtMonth < 1 || dtMonth > 12) 
        return false;
    else if (dtDay < 1 || dtDay> 31) 
        return false;
    else if ((dtMonth==4 || dtMonth==6 || dtMonth==9 || dtMonth==11) && dtDay ==31) 
        return false;
    else if (dtMonth == 2) 
    {
        var isleap = (dtYear % 4 == 0 && (dtYear % 100 != 0 || dtYear % 400 == 0));
        if (dtDay> 29 || (dtDay ==29 && !isleap)) 
                return false;
    }
    return true;
}





