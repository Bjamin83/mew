$(document).ready(function(){
	
	$(".f-zeige-region").click(function(){
    	anzeige_region();
    });
	
	$(".f-zeige-media").click(function(){
    	anzeige_media();	
    });
	
	$(".f-check-all-media").click(function(){
		
    	check_all_media();
    });	
	
	$('#anzeige-media').on('click', '.f-update-media' , function() {
	 		
	 		//Jedem Button wurde der Slugname als Value mitgegeben und dient als eindeutige Zuweisung für die Datenbank.
	 		// Ueber .parent.find wird ausgehen vom geklickten Button in den uebergeordneten DIv und dann die Klasse description gesucht.
	 		update_media($(this).val(),$(this).parent().find('.description').val());
	 
	});
	$('#anzeige-media').on('click', '.f-delete-media' , function() {
	 		
	 		//Jedem Button wurde der Slugname als Value mitgegeben und dient als eindeutige Zuweisung für die Datenbank.
	 		delete_media($(this).val());
	 
	});

	
});

/**
 *	====================
 * 	FUNKTIONEN
 *  ====================
 */

//Durchsucht alle Ordner des Pfads und aktualisiert die DB entsprechend
// WICHTIG die Funktion bekommt JSON zurueck, siehe , "json"				!!
function anzeige_region(){
		//Steuert die PHP Datei zur Datenverwarbeitung an:
		var function_media_url = "../wp-content/plugins/media-verwaltung/function-media.php";
		$.post(function_media_url,
    		{
				region: $("#Regionenfilter").val(),
				type: "anzeige-region"
    		},
    		function(data){
    			$("#angelegte-unternehmen").html(data);
    		}
    	);	
} 
 
 
 
//Durchsucht alle Ordner des Pfads und aktualisiert die DB entsprechend
// WICHTIG die Funktion bekommt JSON zurueck, siehe , "json"				!!
function anzeige_media(){
		//Steuert die PHP Datei zur Datenverwarbeitung an:
		var function_media_url = "../wp-content/plugins/media-verwaltung/function-media.php";
		$.post(function_media_url,
    		{
				ordner: $("#angelegte-unternehmen :selected").text(),
				type: "anzeige-media"
    		},
    		function(data){
    			$("#anzeige-media").html(data.media); 	//JSON Notation
    			if (data.aktion != ""){
    				$("#mew-feedback").text(data.aktion);		//JSON Notation
    			}		
    		}, "json" // JSON 
    	);	
}


function update_media(aktuelles_Feld, desc){
		//Steuert die PHP Datei zur Datenverwarbeitung an:
		var function_media_url = "../wp-content/plugins/media-verwaltung/function-media.php";
		$.post(function_media_url,
			{
				slugname: 		aktuelles_Feld,
				describtion: 	desc,
				region: $("#Regionenfilter").val(),
				type: 			"update-media"
			},
			function(data){
	    			$("#mew-feedback").text(data);
	    	}
			  
		);
	
}

function delete_media(aktuelles_Feld){
	//Steuert die PHP Datei zur Datenverwarbeitung an:
		var function_media_url = "../wp-content/plugins/media-verwaltung/function-media.php";
		$.post(function_media_url,
			{
				slugname: 		aktuelles_Feld,
				type: 			"delete-media"
			},
			function(data){
	    			$("#mew-feedback").text(data);
	    	}
			  
		);
		
}

//Durchsucht alle Ordner des Pfads und aktualisiert die DB entsprechend
function check_all_media(){
		//Steuert die PHP Datei zur Datenverwarbeitung an:
		var function_media_url = "../wp-content/plugins/media-verwaltung/function-media.php";
		$.post(function_media_url,
		{
		ordner: $("#angelegte-unternehmen :selected").text(),
		region: $("#Regionenfilter").val(),	
		type: "check-all-media"
		},
		function(data){
    			$("#mew-feedback").text("Datenbank aktualisiert!");
    		}
			  
		);

}