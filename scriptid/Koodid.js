
function tyhistaNupp(nupuNimi){
//var nupuNimi=$(this).attr("id");
//alert(nupuNimi);
switch (nupuNimi)
{
case mCancel:
alert("mCancel");
case uCancel:
alert ("uCancel");
case oCancel:

}
};

function otsiForm(aken){
localStorage["aken"]=aken;
};

$(document).ready(function () {
	if (localStorage["aken"]==1) {
		$("#Otsi_koodi").css({"display":"block"});
		$("div.RKoodid_nupud").css({"display":"none"});
		$("input[tabindex=1]").focus();
	}else{
		$("#Otsi_koodi").css({"display":"none"});
		$("div.RKoodid_nupud").css({"display":"block"});
	}
	var nil=localStorage["aken"];
	var n=$("div.RKoodid_nupud").css("display");
	console.log(nil);
	console.log(n);
});




//kui vajutame esc nuppu:
$(function(){$(document).keyup(function(e) {
	if(e.keyCode==27){
		if ($("#UusRida").not(":hidden")){
			$("#UusRida").hide("fast");
		}
		if ($("#MuudaRida").not(":hidden")){
			$("#MuudaRida").hide("fast");
		}	
	}
})

});

//Kutsub esile rea lisamise formi
$(function(){$("#Lisa_kood").click(function () {
	$("#UusRida").show("fast");
	$("input[tabindex=1]").focus();
	})
});

 //Kutsub esile otsimise formi
$(function(){$("#Otsi_nupp").click(function () {
	$("#Otsi_koodi").show("fast");
	$("#Otsi_nupud").hide("fast");
	$("input[tabindex=1]").focus();
	})
});

//Kas soovime salvestada
$(function(){$("#FUusRida").submit(function() {
	var vastus=confirm("Kas lisame uue rea?");
	if (!vastus) {
		return false;
	}
	})
});

//Paneb rea lisamise formi kinni
$(function(){$("#uCancel").click(function () {
	$("#UusRida").hide("fast");
	})
});

//Paneb rea muutmise formi kinni
$(function(){$("#mCancel").click(function () {
	$("#MuudaRida").hide("fast");
	})
});

//Paneb rea otsimise formi kinni
$(function(){$("#oCancel").click(function () {
	// var lep="%";
	// var otsi="%";
	// $("#oLep").val(lep);
	// $("#oOtsi").val(otsi);
	$("#Otsi_koodi").hide("fast");
	$("#Otsi_nupud").show("fast");
	console.log(localStorage["aken"],"On aktiivne");
	if (localStorage["aken"]==1) {
		$("#Fotsi").submit();
	}
})
});



//Kas soovime muuta
$(function(){$("#FMuudaRida").submit(function() {
	var vastus=confirm("Kas muudame rida?");
	if (!vastus) {
		return false;
	}
})
});

//Kui prindime
$(function(){$("#mPrindi").click(function () {
	var ribakood=$("#mRibakood").val();
	var leping=$("#mLep").val();
	var job=$("#mToo").val();
	var grupp=$("#mGrupp option:selected").text();
	$("#MuudaRida").hide("fast");
	window.open("PrintKoodid.php?rkood="+ribakood+"&leping=" +leping+"&job="+job+"&grupp="+grupp).print();
	})
});


//kontrollib uue rea lisamisel andmeid
function kontrAndmed() {
	//kontrollime kas on väli täidetud
	var kontLep = $("#Lep").val();
	var kontToo = $("#Too").val();

		if ((!kontLep) || (!kontToo)) {
		//kui on tyhi väli
		$("#Salvesta").attr("disabled","disabled");
		//alert("Palun täida väljad!");
		return false;	
	}else{
		$("#Salvesta").removeAttr("disabled");
		return true;
	}
}; //kontrollib uue rea lisamisel andmeid

//täidame muudetava vormi kui teeme dbl cliki
$(document).ready(function(){
$("#KoodiRead>tbody>tr").dblclick(function(){ 
	var lep_nr = $("td:eq(0)",this).text();
	var grupp = $("td:eq(1)",this).text();
	var job = $("td:eq(2)",this).text();
	var yhik = $("td:eq(4)",this).text();
	var kogus = $("td:eq(5)",this).text();
	var ribakood=$("td:eq(3)", this).text();
	var rea_id = $(this).attr("title");
	var y = $(this).offset();

	if ((yhik) || (kogus)) { //kui on mõlemad väljad täis
		$("#mYhik option:contains("+ yhik +")").attr("selected","selected");
		$("#mKogus").val(kogus);
	}else {
			$("#mKogus").val("");
	} //kui on mõlemad väljad täis lõpp

	$("#mLep").val(lep_nr);
	$("#mToo").val(job);
	$("#mID").val(rea_id);
	$("#mGrupp option:contains(" + grupp + ")").attr("selected","selected");
	$("#mRibakood").val(ribakood);


	// alert("Korgus on" + "; " + y.top);
	$(MuudaRida).css({
		"top":(y.top - 48) +"px"
	});
	$("#MuudaRida").show("fast");
	$("input[tabindex=1]").focus();
})
});



//kui teeme tabelis koodi peal klopsu
$(document).ready(function(){ 
	$("#KoodiRead>tbody>tr>td:nth-child(4)").click(function() {
		// $(this).selectText();
		var text= $(this).text();
		window.prompt("Kopeeri tulemus lõikelauale: Ctrl+C, Enter", text);
	});
});