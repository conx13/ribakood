/*jslint browser: true*/
/*global $, jQuery, alert*/

$(function () {
	$("#loginForm").submit(function(e) {
		console.log("vajutasin nuppu");
		//e.preventDefault();
		
		return false;
	});
});

$(function () {
    $(":text, :password").keyup(function () {
        if (($(this).val().length)==0){
            $(this).parent().addClass("has-error");
            //console.log($(this).parent());  
        }else{
            $(this).parent().removeClass("has-error");
        }
        if ((($("#kasutaja").val().length)>0) && (($("#parool").val().length)>0)){
            $("#loginEnter").removeClass("disabled");
        }else{
            $("#loginEnter").addClass("disabled");
        }
    })
})