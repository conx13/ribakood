$(function() {
	console.log("taidaJob1");
	//$('option', select).remove();
	$.getJSON('/otsi_Grupp.php', {lepNr:'10038',valem1:1 }, function(data) {
        console.log(data);
    });
});
$(function() {
	console.log("taidaJob2");
	//$('option', select).remove();
	$.getJSON('/otsi_Grupp.php', {lepNr:'10038',GID:2,valem2:1 }, function(data) {
        console.log(data);
    });
});



/*$(function(){
	var esimene="";
	var tulem=$.ajax({
			  	type: "GET",
			  	url: "/otsi_Grupp.php",
			  	datatype:"json",
			  	asynch
			  	data: { lepNr:'10011',GID:4,valem1:1}
				});

	tulem.done(function(msg) {
  	esimene= (msg);

	});

	tulem.fail(function(jqXHR, textStatus) {
  	alert( "Request failed: " + textStatus );

  	console.log(esimene);
});

})

$(function(){
	var tulem=$.ajax({
			  	type: "GET",
			  	url: "/otsi_Grupp.php",
			  	datatype:"json",
			  	data: { lepNr:'10011',GID:4,valem1:1}
				});

	tulem.done(function(msg) {
  	console.log (msg);
	});

	tulem.fail(function(jqXHR, textStatus) {
  	alert( "Request failed: " + textStatus );
});

})*/


