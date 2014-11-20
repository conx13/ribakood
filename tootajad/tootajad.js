//Kui on dokument loetud
$(document).ready(function()
{
    sessionStorage.otsiTootaja=0;
    sessionStorage.otsiTootajaText="";
    sessionStorage.otsiTootajaLeht=1;
    taidaAeg();
    $("#muudaModal").on("shown.bs.modal",function(){
    	$("#muudaModal #muudaEnimi").focus();
    });
    
    /*$('#otsiText').keyup(function()
	{
		searchTable($(this).val());
	});*/
});

//Peidame alert kastikese
$(function(){
    $(".alert-close").click(function(){
        $(this).parent().hide();
    })
})

//Kui vajutame töötaja otsimise nuppu
$(function(){
	$("#otsiForm").submit(function(){
		var otsiText = $("#otsiText").val();
		if (otsiText == "") {
			otsi="%";
            sessionStorage.otsiTootaja=0;
		}else{
            sessionStorage.otsiTootaja=1;
			otsi=otsiText;
		};
		sessionStorage.otsiTootajaText=otsiText;
		taidaTabel();
        return(false);
	})
})


//täidame grupi selecti enne modali näitamist
function taidaAeg() {
    var select = $('#muudaAeg');
    var options = select.prop('options');
        $.getJSON('ajaGrupp.php', function(data) { //täidame gruppi nimekirja
            $.each(data, function(Nr, array) {
                options[options.length] = new Option(array.nimi, array.aid);
            });
        });
}


//Täidame tabeli 
function taidaTabel(){
    var otsi = sessionStorage.otsiTootajaText;
    if (otsi==""){
        otsi="%";
    };
    $("#tootTabel tbody").empty();
	$.getJSON("/tootajad/tootajadTabel.php", {otsi:otsi}, function(data){
		var nimi;
		var aeg;
		var akt;
		var nupud;

		if (data.error=="1") {
			console.log(data.Text);
            $("#tootajaAlertError .teade").html("<strong>Ei leia!</strong><br>Kahjuks ei leidnud midagi!");
            $("#tootajaAlertError").show();
		}else{
			nupud = "<a href='javascript:void(0)'><i title='Muuda' class='fa fa-edit rMuuda tume' rel='tooltip'></i></a>";
			nupud = nupud + "<a href='#'><i title='Seotud' class='fa fa-link tume rLink' rel='tooltip'></i></a>";
			nupud = nupud + "<a href='#'><i title='Kustuta' class='fa fa-trash-o rKustuta' rel='tooltip'></i></a>";
			$.each(data, function(nr, array){
				enimi=array.enimi;
				pnimi=array.pnimi;
				nimi=enimi + ' ' + pnimi;
				aeg=array.ajanimi;
				akt=array.aktiivne;
				ikood=array.ikood;
				tid=array.tid;
				ajagupp=array.ajagupp;
				tData="data-tid=" + tid;
				if (akt==1){
					akt="<i class='fa fa-check-square-o'></i>";
				}else{
					akt='';
				}
				$("#tootTabel tbody").append("<tr "+ tData+"><td>"+nimi+"<div class='reaNupud pull-right'>" + nupud + "</div></td><td>"+aeg+"</td><td class='text-center'>"+akt+"</td></tr>")
			})		
		};
	})
};

///////////////////////
//Muutmise modal form//
///////////////////////

// täidame töötaja muutmise modal formi
$(function() {
	$("#tootTabel").on("click", ".rMuuda", function() {
		var tid=$(this).closest('tr').data('tid');
		var onAkt=false;
		var f_grupp=$("#mTootajaForm .form-group");
        $("#muudaModal #muudatKood").val(tid);
        f_grupp.removeClass("has-error"); //tyhistame errorid
        $("#muudaModal #muudaModalSave").attr("disabled", "disabled");
        //nokime baasist data külge
        $.getJSON("/tootajad/otsiTootaja.php", {mTid:tid} ,function(data){
            //console.log(data);
            if (data.error==0) {
                $("#muudaModal .modal-title").html(data.enimi +' ' + data.pnimi);
                $("#muudaModal #muudaEnimi").val(data.enimi);
                $("#muudaModal #muudaPnimi").val(data.pnimi);
                $("#muudaModal #muudaIkood").val(data.ikood);
                $("#muudaModal #muudaAeg").val(data.ajagupp);
                if (data.aktiivne==1){
                    onAkt=true;
                };
                //console.log(data[0].aktiivne);
                $("#muudaModal #muudaAkt").prop('checked',onAkt);
                var start= $("#mTootajaForm").serialize();
                $("#muudaModal").data('start',start);
                $("#muudaModal").modal(); 
            }else {
               console.log(data.Text); 
            }
        });
    });
})

//Kontrollime kas on kõik väljad on täidetud
function kontrolliMuutustTyhi() {
    var tyhi = $("#mTootajaForm").find("input").filter(function() {
        return this.value === "";
    });
    if(tyhi.length) {
        //At least one input is empty
        tyhi.focus();
        tyhi.parent().addClass("has-error");
    }
}



//Kui vajutame väljas nupule
//siis kontrollime kas on ok
$(function(){
	$("#mTootajaForm input").keyup(function() {
		kasValjadOk($(this));
    });
});

//kui muudame formi välju select ja checkbox
//siis kontrollime kas on ok
$(function(){
	$("#mTootajaForm .kont").change(function() {
		kasValjadOk($(this));
    });
});

//Kontrollime kas muudetav väli on ok
//kui ei ole paneme error lipu püsti
function kasValjadOk(vali) {
    var vaartus=vali.val();
    if ($(vali).attr('name')=='muudaIkood') { //kui on ikoodi väli
        if (isikukood(vaartus)){
            $(vali).parent().removeClass("has-error");
        }else{
            $(vali).parent().addClass("has-error"); //kui ei ole ok kood
        };
    }else{
        $("#muudaModal .modal-title").html($("#muudaEnimi").val() + " " + $("#muudaPnimi").val());
        if (vaartus) {
            $(vali).parent().removeClass("has-error"); //kui väli ei ole tyhi
        }else{
            $(vali).parent().addClass("has-error"); //kui väli on tyhi
        };
    };
    kasFormOnOk(); //kontrollime teised väljad ka üle
};


//kontrollime kas on tehtud formis muutusi
//ja kas ei ole erroreid
function kasFormOnOk () {
    var formStart = $("#muudaModal").data("start");
    var formNyyd = $("#mTootajaForm").serialize();
    var errorList = $("#mTootajaForm .has-error");
    
    if (!(formStart===formNyyd) && (!errorList.length>0)) {
        $("#muudaModal #muudaModalSave").removeAttr("disabled");
    }else{
        $("#muudaModal #muudaModalSave").attr("disabled", "disabled");
    }
    
}

//Muutmise formi salvestamise nupp
$(function(){
    $("#mTootajaForm").submit(function(){
        var andmed=$("#mTootajaForm").serialize();
        muudaTootaja(andmed);
        return false;
    });
})

//Muudame töötaja andmeid
function muudaTootaja (andmed) {
    //$.post("proov.php", andmed, function(data){
    $.post("muudaTootaja.php", andmed, function(data){
        if (data.error==1) {
            $("#tootajaAlertError .teade").html("<strong>Viga!</strong><br>Midagi läks valesti ja andmeid ei muudetud!");
            console.log(data.Text);
            $("#tootajaAlertError").show();
        }else{
            taidaTabel();
            $("#tootajaAlertOk").html(data.Text);
            $("#tootajaAlertOk").show(0).delay(1500).hide("slow");
        }
    }, 'json');
    $("#muudaModal").modal("hide");
}

//////////////////////////
//Uue töötaja modal form//
//////////////////////////

//Uue töötaja lisamise nupp
$(function(){
    $("#lisa").click(function(){
 	$("#mTootajaForm")[0].reset();
 	$("#muudaModal .modal-title").html("Uus töötaja");
 	$("#muudaModal").modal();
    })
})



/////////////////////////
//Tegeleme paginatoriga//
/////////////////////////

//loeme kokku palju on lehti
function loeLehed (callback) {
	var otsi="%";
	var tulem;
	if (!sessionStorage.otsiTootajaText == "") { //kui otsing aktiivne
    	otsi = sessionStorage.otsiTootajaText; //siis võtame andmed localist
    };
    $.getJSON("/tootajad/tLehtiKokku.php", {oText:otsi}, function(data){
    	//console.log(data);
        if (data.error==="1"){
    		console.log(data.Text);
            tulem=data.Text;
    	}else{
    		$.each(data, function(nr, array){
              tulem=array.Kokku;
    		  //console.log(tulem);
            })
            callback(tulem);
            console.log(tulem);
    	}
    });
}



function searchTable(inputVal)
{
	var table = $('#tootTabel');
	table.find('tr').each(function(index, row)
	{
		var allCells = $(row).find('td');
		if(allCells.length > 0)
		{
			var found = false;
			allCells.each(function(index, td)
			{
				var regExp = new RegExp(inputVal, 'i');
				if(regExp.test($(td).text()))
				{
					found = true;
					return false;
				}
			});
			if(found == true)$(row).show();else $(row).hide();
		}
	});
}

////////////////////
//Abi funktsioonid//
////////////////////

/*
* Isikukoodi kontrollimse funktsioon
* Copyright (c) 2009 Mika Tuupola
*
* Licensed under the MIT license:
* http://www.opensource.org/licenses/mit-license.php
*/

function isikukood(kood) {
    var multiplier_1 = new Array(1, 2, 3, 4, 5, 6, 7, 8, 9, 1);
    var multiplier_2 = new Array(3, 4, 5, 6, 7, 8, 9, 1, 2, 3);
    var control = kood.charAt(10);
    var retval  = false;
    var mod   = 0;
    var total = 0;
    /* Do first run. */
    for (i=0; i < 10; i++) {
        total += kood.charAt(i) * multiplier_1[i];
    }
    mod = total % 11;
    /* If modulus is ten we need second run. */
    total = 0;
    if (10 == mod) { 
        for (i=0; i < 10; i++) {
            total += kood.charAt(i) * multiplier_2[i];
        }
        mod = total % 11;
        
        /* If modulus is still ten revert to 0. */
        if (10 == mod) {
            mod = 0;
        }
    }
    return control == mod;
}