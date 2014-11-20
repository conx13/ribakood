
// Muudame noolte suunda kui klikime
$(function(){$('.panelNool .panel-heading').on('click', function(e){
	//$('#ListPoleTool i').toggleClass('icon-double-angle-down icon-double-angle-up', 200);
	$(this).find("i").toggleClass('fa-angle-double-down fa-angle-double-up', 200);
	});
});


//kui on määramata töö, siis teeme punaseks

$(document).ready(function() {
	if ($("#sisuTabelPealk:contains('Määra')").length) {
		$("#sisuTabelPaneel").removeClass("panel-primary").addClass('panel-danger');
	};
	tana() //pameme pealkirja hetke aja
})


//Arvutame hetke aja
function tana() {
	var tana=new Date();
	var minutid=tana.getMinutes();
	minutid= minutid > 9 ? minutid : '0' + minutid;
	var date=tana.getHours() + ":" + minutid;
	$("#navText").html(date);
}


//täidame grupi grupi vastavlt lep nr ja aktiveerime gid järgi
function taidaGrupp(gid, jid) {
		var select = $('#fGrupp');
		var options = select.prop('options');
        $('option', select).remove();
		$.getJSON('/otsi_Grupp.php', {lepNr:$('#fLeping').val(),valem1:1 }, function(data) {
	        $.each(data, function(jrkNr,array) {
	            	if (gid==array[0]) {
	            		options[options.length] = new Option(array[1],array[0],'selected', 'selected');
	            	}else{
	            		options[options.length] = new Option(array[1],array[0]);
	            	}
	        });
        taidaJob(jid);
    });
};

//täidame töö vastava lepingu ja grupi järgi ja aktiveerime JID järgi
function taidaJob(jid) {
	var select = $('#fJob');
	var options = select.prop('options');
	$('option', select).remove();
	$.getJSON('/otsi_Grupp.php', {lepNr:$('#fLeping').val(),GID:$('#fGrupp').val(),valem2:1 }, function(data) {$.each(data, function(jrkNr,array) {
		if (jid==array[0]) {
        		options[options.length] = new Option(array[1],array[0],'selected', 'selected');
        	}else{
        		options[options.length] = new Option(array[1],array[0]);
        	}
		});
	});
};



// otsime vastava ID järgi lep nr ja töö grupi
function taidaId(id) {
	var otsiGrupp;
	var otsiLep;
	$.getJSON('/otsi_Grupp.php', {jid:id,valem3:1 }, function(data) {
		var otsiLep;
		var otsiGrupp;
		$.each(data, function(jrkNr,array) {
        	otsiLep=array[0];
        	otsiGrupp=array[1];
		});
		$('#fLeping option').filter(function() { return $.trim($(this).text()) == otsiLep; }).prop('selected','selected');
		taidaGrupp(otsiGrupp,id);
    });
}


$(function(){
	$('#fLeping').change(function() {
		taidaGrupp();
	})
});

//Muudame päsises Hetkel tööl aktiivseks
$(function(){
	$('#fGrupp').change(function() {
		taidaJob();
	})
});

$(function(){
	$('.nav>li:contains("Hetkel")').addClass('active');
});

// Selle kuu koguse kirjutamine, andmed saame php-st
$(function(){
	var kokku=0;
	var sisu="";
	$.getJSON("/tool/rSelleKuuKogus.php",function(data){
		$.each(data, function(nr,array){
			kokku=kokku + parseInt(array[1]); 
			sisu +="<li class='list-group-item'>"+ array[0] +" : <span class='sKogus'>"+ array[1] +"</span></li>";
		})//each
		$("#ul_listSeeKogus").html(sisu);
	$("#selleKuuKogus .panel-heading").html('<i class="fa fa-angle-double-down"></i> See kuu kokku: <span class="pull-right">' + kokku + ' m2.</span>');
	});//getJSON
	$("#selleKuuKogus").show();
})


// Eelmise kuu koguse kirjutamine, andmed saame php-st
$(function(){
	var kokku=0;
	var tana=new Date();
	var kuu = tana.getMonth()+1;
	var paev = tana.getDate();
	var aasta =tana.getFullYear();
	var tanaKpv =kuu+"."+aasta;

	if (sessionStorage['tanaKuu']==tanaKpv){
		arr=JSON.parse(sessionStorage['eelminem2']);
		$.each(arr, function(nr,array){
			kokku=kokku + parseInt(array[1]); 
			$("#ul_listEelmineKogus").append("<li class='list-group-item'>"+ array[0] +" : <span class='sKogus'>"+ array[1] +"</span></li>");
		})//each
		$("#eelmiseKuuKogus .panel-heading").html('<i class="fa fa-angle-double-down"></i> Eelmine kuu: <span class="pull-right">' + kokku + ' m2.</span>');
	}else{
		sessionStorage['tanaKuu']=tanaKpv;
		$.getJSON("/tool/rEelmiseKuuKogus.php",function(data){
			sessionStorage['eelminem2']=JSON.stringify(data);
			$.each(data, function(nr,array){
				kokku=kokku + parseInt(array[1]); 
				$("#ul_listEelmineKogus").append("<li class='list-group-item'>"+ array[0] +" : <span class='sKogus'>"+ array[1] +"</span></li>");
			})//each
			$("#eelmiseKuuKogus .panel-heading").html('<i class="fa fa-angle-double-down"></i> Eelmine kuu: <span class="pull-right">' + kokku + ' m2.</span>');
		})//getJSON
	}//else if
	$("#eelmiseKuuKogus").show();
	//console.log("Kogus kokku:" + kokku);
})

// Sünnipäevalised
$(function(){
	var kokku=0;
	var tana=new Date();
	var kuu = tana.getMonth()+1;
	var paev = tana.getDate();
	var aasta =tana.getFullYear();
	var tanaKpv =paev+"."+ kuu+"."+aasta;
	// kontrollime kas olema juba vaadanud andmeid
	// kui oleme siis võtama andmed sessionStoragest
	if (sessionStorage["synnaKpv"]==tanaKpv){
		arr=JSON.parse(sessionStorage['synna']);
		if (arr!=="tyhi"){			
			$.each(arr, function(nr,array){
				$("#ul_Synnip").append("<li class='list-group-item'><strong>" +array[0] + " ("+ array[1] +")</strong></li>");
			})//each
			$("#synnipaev").show();
		}//if			
	}else{
		sessionStorage["synnaKpv"]=tanaKpv;
		$.getJSON("/tool/rSynnip.php",function(data){
			sessionStorage["synna"]=JSON.stringify(data);
			if (data!=="tyhi"){	
				$.each(data, function(nr,array){
					$("#ul_Synnip").append("<li class='list-group-item'><strong>" +array[0] + " ("+ array[1] +")</strong></li>");
				})//each
			$("#synnipaev").show();
			}//if
		});//getJSON
	}//if else
})

// aktiivsed töötajad
$(function(){
	$.getJSON("/tool/rAktTootajad.php", function(data){
		if (data>0) {
			//console.log(data);
			$("#ListOnTool .panel-heading").html("On aktiivsed: <span class='pull-right badge'>" + data + "</span>");
			$("#ListOnTool").show()
		}else{
			//console.log("on väiksem");
			$("ListOnTool").hide();
		}
	})
})

//KLikkin pealkirja kellajal
$(function(){
	$("#navText").click(function(){;
		location.reload();
	})
})



// Mitte aktiivsed tootajad
$(function(){
	var kokku=0;
	var sisu="";
	//$.ajaxSetup({ cache: false });
	$.getJSON("/tool/rMitteAktTootajad.php",function(data){
		$.each(data, function(nr,array){
			kokku=kokku + 1;
			sisu +="<li class='list-group-item' data-id=" +array.TID +">"+ array.Nimi +"<span class='pull-right'><i class='fa fa-user'></i></span></li>";
		})//each
	$("#ul_listPole").html(sisu);
	$("#ListPoleTool .panel-heading").html('<i class="fa fa-angle-double-up"></i> Mitteaktiivseid:<span class="pull-right badge">' + kokku + '</span>');
	if (kokku > 5) {
			$("#ul_listPole").collapse();
	};//if
	$("#ListPoleTool").show();
	});//getJSON
})



$(document).on('click', '#ul_listPole .list-group-item', function(){
				console.log($(this).data("id"));
})


//kui vajutame lep nr peale siis otsime mitteaktiivset koodi
$(function() {
	$("#SisuTabel button").click(function(){
		var lepNr=$(this).text();
		var Grupp="Elemendiliin";
		var pealk=lepNr + " mitteaktiivsed koodid.";
		uus(lepNr, Grupp, pealk);
		//console.log(lepNr, Grupp, pealk);
	})
})


// Kui vajutame koodi otsimise nupule
$(function(){
	$("#nupp").click(function (e){
		var pealk;
		var otsiLep;
		var otsiGrupp;
		otsiLep= $('#lepNr').val();	    
	    pealk =otsiLep + " mitteaktiivsed koodid.";
	    otsiGrupp=($('input[name=radioLeping]:checked').val());
		e.preventDefault(); //tühistame vaikimisi tegevuse
		uus(otsiLep, otsiGrupp, pealk);
	});
})


// Otsime mitteaktiivseid koode
function uus(otsiLep, otsiGrupp, pealk){
		var tyhi="Kahjuks ei leidnud selle koodiga midagi!"
	    $("#aktKood_Modal .panel").empty();
		$.ajaxSetup({ cache: false });
		$.getJSON("/tool/rPoleToos.php",{oLeping:otsiLep,oGrupp:otsiGrupp}, function(data){
			//console.log(data);
			if (data!=='tyhi'){
				var sisu='';
				var pais='';
				var nimi='';
				var sum='';
				var jrk=0;
				$.each(data, function(nr, array){
					if (pais!==array[0]) {
						pais=array[0];
						tabel='tabel' + nr;
						paneel='paneel' + nr;
						sum=0;
						sum=sum+ parseFloat(array[3]);
						jrk=1;
						//nr=nr+1;
						$("#aktKood_Modal .panel").append("<div class='panel-heading' id='" + paneel +"'>" + array[0] + "</div>");
						$("#aktKood_Modal .panel").append("<table class='table table-striped table-condensed' id='" + tabel + "'><tbody><tr><td>" + jrk + "</td><td>" + array[1] + "</td><td width='45%'>"+ array[2]+"</td><td width='15%'>"+ array[3]+" m2</td></tr></tbody></table>");
						$("#aktKood_Modal .panel #" + paneel).html(pais + " <span class='pull-right'>" + sum + " m2.</span>");
					}else{
						sum=sum + parseFloat(array[3]);
						sum=Math.round(sum);
						jrk=jrk+1;
						$('#aktKood_Modal #' + tabel + " tbody").append("<tr><td>" + jrk + "</td><td>" + array[1] + "</td><td>"+ array[2]+"</td><td>"+ array[3]+" m2</td></tr>");
						$("#aktKood_Modal .panel #" + paneel).html(pais + " <span class='pull-right'>" + sum + " m2.</span>");
					} //if
				}); //each
			$('#aktKood_Modal').modal('show');
			$('#aktKood_Modal .modal-title').html(pealk);		
			}else{
				alert(tyhi);
			}; //if
		}); //function data
};

/*Kui täidame lepingu lahtrit, siis teeme
otsimise nupu aktiivseks. Kui on lahter tühi
siis on nupp mitteaktiivne*/
$(function () {
    var sisu = "";
    $('#lepNr').keyup(function () {
        if (!$('#lepNr').val()) {
            $("#nupp").prop('disabled', 'disabled')
        } else {
            $("#nupp").removeAttr('disabled')
        };
    });
});



// Kui vajutame märkuse peale, siis avame modal formi
$(function(){
	$('#SisuTabel td:nth-child(3) a').click(function(e){
		var tiitel=$(this).closest('tr').children().eq(2).text();
		var markus=$(this).closest('tr').children().eq(6).text();
		var id=$(this).closest('tr').children().eq(5).text();
		
		// peidame tehtud märkused kui neid ei ole
		if (markus) {
			$('#markus_Modal #markus_markused').val(markus);
			$('#markus_Modal #tehtud_markused_grupp').show();
		}else{
			$('#markus_Modal #markus_markused').val('');
			$('#markus_Modal #tehtud_markused_grupp').hide();
		};

		$('#markus_Modal .modal-title').html(tiitel);
		$('#markus_Modal #markus_uus').val('');
		// teeme salvestamise nupu mitte aktiivseks
		$('#markus_Modal #markus_salvesta').prop('disabled','disabled');
		// Keelame href edasised tegevused
		e.preventDefault();
		// lisame juurde job id
		$('#markus_Modal').data('id',id);
		$('#markus_Modal').modal('toggle');
	})
})

// võtame uue märkuse foocusesse
$(function(){
	$('#markus_Modal').on('shown.bs.modal', function () {
    $('#markus_Modal #markus_uus').focus();
	});
})


// Teeme tooltipi aktiivseks
$(function(){
		$('#SisuTabel td a').tooltip({
			container:'body',
			html:true
		});
})


// Kui on märkus siis näitame hüüu märki ja kirjutame tiitli
$(function(){
	$("#SisuTabel td:nth-child(7)").each(function(){
		var tiitel=	$(this).html();	
		if ($(this).text().length > 0) {
			$(this).parent().find(".markus_icon").removeClass("hidden");
			$(this).parent().find(".markus_title").attr('data-original-title', tiitel);
		}else{
			
		};
	});
})

// Kui täidame uut märkust, teeme salvetsamise nupu aktiivseks
$(function(){
	$("#markus_uus").keyup(function(){
		if (!$('#markus_uus').val()) {
            $("#markus_salvesta").prop('disabled', 'disabled')
        } else {
            $("#markus_salvesta").removeAttr('disabled')
        };
	})
})

//Lisame märkuse tööle
$(function(){
	$('#markus_salvesta').click(function(){
	var kasutaja = sessionStorage['Kasutaja'];
	var eesliide = ":" + kasutaja + ") ";
	var jid = $('#markus_Modal').data('id');
	var msg;
	var comm = eesliide + ($('#markus_Modal #markus_uus').val());
	  $.ajax({
	    type:"POST",
	    url:"rLisaMarkus.php",//kustutan rea
	    data:{JID: jid, markus: comm},
	    dataType: "html",
	    async: false, //et saaks tulem kirja
	    success: function(data)
	    {
	      msg=data; //tagasiside
	    }
	  }); //Ajax
	window.location.reload(true); //loeme lehe uuesti
	alert (msg); //Näitame kinnitust
	})
})


//proovilks uue tabeli nupp
$(function(){
	$("a[href='#uusTabel']").click(function(){
		var ajaxTulem;
		var tana=new Date();
		var tanaMinutid=(tana.getHours()*60)+tana.getMinutes(); //leiame hetke aja
		//$("#sisuTabel").hide();
		ajaxTulem=$.ajax({
			url:"rUusTabel.php",
			type:"GET",
			dataType:"json",
			cache:"false"
		});
		ajaxTulem.success(function(data){
			taidaUusTabel(data);
			sessionStorage['viimatiVaatasin']=tanaMinutid; //paneme aja sessioni kirja
			
		})
	})
})

$(function(){
	$("a[href='#sisuTabel']").click(function(){
		$("#uusTabel").empty();
		//console.log("teeme tyhjaks");
	})
})

//Lisame üksikule numbrile nulli ette 01 jne
function pad(n) {
	return ("0" + n).slice(-2); 
}

//arvutame hetke aja ja tööaja vahe minutites
function minutidToo (tooAeg){
    var too= new Date(tooAeg);
    var aeg= new Date();
    var tooMinutid=parseInt((too.getHours()*60)+(too.getMinutes()));
    var aegMinutid=parseInt((aeg.getHours()*60)+(aeg.getMinutes()));
    
    if (Date.parse(tooAeg)){
        if ((tooMinutid <= 690 ) && (aegMinutid >= 720)){
            aegMinutid=aegMinutid-30-tooMinutid;
            return(aegMinutid);
        }else{
            aegMinutid=aegMinutid-tooMinutid;
            return(aegMinutid);
        };
    }else{
        return(0);
    }
}
//////////////////////////////////////////
//Keskmise tabeli arvutamine ja kuvamine//
//////////////////////////////////////////

function taidaUusTabel(data) {
	var grupp;
	var leping;
	var too;
	var sisu;
	var uusPohiPaneel;
	var uusSisuPaneel;
	var uusPanelGrupp;
	var uusPanelTabel;
	var uusPanelPais;
	var uusSpan;
	var uusPanelTabelSisu;
	var uusTabel;
	var uusRida;
	var tooId=0;
	var akkordId=0;
	var tootjaId=0;
	var kogus=0;
	var LepingTooId=0;
	var kokkuTunnis='';
	var kokkuTunnisText='';
	var Nimi;
	var tid;

	
	$.each(data, function(nr, array){
	startKpv=new Date(array.Start.split("-").join("/")); //konverdime kuupäeva õigesse formaati
	//console.log(array.Start);
	Start=pad(startKpv.getHours()) + ":" + pad(startKpv.getMinutes());
	Start0=startKpv.getHours()*60+startKpv.getMinutes();
			Nimi=array.Nimi;
			tid=array.TID;
			Start1= minutidToo(array.Start.split("-").join("/"));
			if (array.Kogus==null){
				kogus='';
			}else{
				kogus=parseInt(array.Kogus);
			}
			aegKokku=parseFloat(Start1/60);
			if (array.AegKokku==null){
				aegKokkuEsimene=aegKokku;
			}else{
				aegKokkuEsimene=parseFloat((Start1+parseInt(array.AegKokku))/60); //aeg mis tuleb alusele juurde liita
			}
		if (grupp===array.Grupp){ //kui grupp muutub teeme uue paneeli
			tootjaId=tootjaId+1;
			uusSisuPaneelPaisDiv.children("#"+grupp +"Id").html("<span class='badge'>" +tootjaId + "</span>");
			if(LepingToo==(array.Leping+array.Too)){ //kui töö ja leping muutuvad teeme uue rea
				uusRida=$('<tr />');
				uusTabel.append(uusRida);
				aegKokkuK=aegKokkuK + aegKokku;
				if ((kogusK>0) && (aegKokku>0) ){
					kokkuAeg="Kokku: " + aegKokkuK.toFixed(2)+ " h.";
					kokkuTunnis=(kogus/aegKokkuK).toFixed(1);//arvutame m2 tunnis
					kokkuTunnisText=kokkuTunnis + " m2/h";
					//console.log(Too + " - on suurem III: " + kokkuTunnis);
				}else{
					kokkuAeg=aegKokkuK.toFixed(2)+ " tundi.";
					kokkuTunnis='';
					kokkuTunnisText='';
				}
				//uusPanelPais.children("#"+LepingTooId+"_aeg").text(kokkuAeg);
				uusPanelPais.children("#"+LepingTooId+"_aeg").text(kokkuAeg);
				uusPanelPais.children("#"+LepingTooId+"_kogus").text(kokkuTunnisText);	
				uusRida.append('<td data-tid='+tid+' data-leping='+Leping+' class="tootajaNimi" >'+Nimi+'</td><td>'+Start+'</td>');
				if (Start0>sessionStorage['viimatiVaatasin']){
					uusPanelTabel.removeClass('panel-default').addClass('panel-warning');
				}else{
					if((kokkuTunnis<1) && (kokkuTunnis>0)){
						uusPanelTabel.removeClass('panel-default').addClass('panel-danger');
					}
				}
			}else{ //teeme uue paneeli
				kogusK=kogusK + kogus;
				aegKokkuK=aegKokkuEsimene;
				tooId=tooId+1;
				Too=array.Too;
				Leping=array.Leping;
				LepingToo=Leping+Too;
				LepingTooId=LepingTooId+1;
				if (grupp=="Elemendiliin"){
					uusSisuPaneelPaisDiv.children("#"+grupp +"Kogus").text("Hetkel töös " + kogusK +" m2 elemente.");
				}else{
					uusSisuPaneelPaisDiv.children("#"+grupp +"Kogus").text("");
				}
				uusPanelTabel=$('<div />', {'class':'panel panel-default'});
				uusPanelPais=$('<div />', {
					'class':'panel-heading text-center',
					'data-toggle':'collapse',
					'data-parent':'#'+grupp, 
					'data-target':'#'+tooId});
				uusPanelPaisRow=$('<div />', {'class':'row'});
				uusPanelPais.append(uusPanelPaisRow);
				if (kogusK>0){
					kogusBar="<div class='col-lg-3 visible-lg'><div class='suurusTaust'><div class='suurus text-left' style='width:"+((kogus/23)*100)+"%'><small>"+kogus+"m2</small></div></div></div>";
				}else{
					kogusBar="<div class='col-lg-3 visible-lg'></div>";
				}
				if ((kogusK>0) && (aegKokku>0)){
					kokkuAeg="Kokku: " + aegKokkuK.toFixed(2)+ " h.";
					kokkuTunnis=(kogus/aegKokkuK).toFixed(1);//arvutame m2/h
					kokkuTunnisText=kokkuTunnis+" m2/h";
				}else{
					kokkuAeg=aegKokkuK.toFixed(2)+ " tundi.";
					kokkuTunnis='';
					kokkuTunnisText='';
				}
				uusPanelTabel=$('<div />', {'class':'panel panel-default'});
				uusPanelPaisRow.append("<div class='col-lg-3 col-xs-6'><strong>"+Too+"</strong></div>");
				uusPanelPaisRow.append("<div class='col-lg-2 col-xs-6 uRida'>"+Leping+"<div class='uRidaText'><i class='fa fa-question-circle'></i></div></div>");
				uusPanelPaisRow.append(kogusBar);
				uusPanelPaisRow.append("<div class='col-lg-2 visible-lg text-left' id="+LepingTooId+"_aeg>"+kokkuAeg+"</div>");
				uusPanelPaisRow.append("<div class='col-lg-2 visible-lg text-left' id="+LepingTooId+"_kogus>"+kokkuTunnisText+"</div>")
				uusPanelTabel.append(uusPanelPais);
				uusPanelTabelSisu=$('<div />', {'class':'panel panel-collapse collapse', 'id':tooId});
				uusTabel=$('<table />', {'class':'table table-condensed table-bordered'});
				uusRida=$('<tr />');
				uusPohiPaneel.append(uusPanelTabel);
				uusPanelTabel.append(uusPanelTabelSisu);
				uusPanelTabelSisu.append(uusTabel);
				uusTabel.append(uusRida);
				uusRida.append('<td data-tid='+tid+' data-leping='+Leping+' class="tootajaNimi">'+Nimi+'</td><td>'+Start+'</td>');
				if (Start0>sessionStorage['viimatiVaatasin']){
					uusPanelTabel.removeClass('panel-default');
					uusPanelTabel.addClass('panel-warning');
				}else{
					//console.log(kokkuTunnis);
					if((kokkuTunnis<1) && (kokkuTunnis>0)){
						//console.log(Too + " - on suurem II: " + kokkuTunnis);
						uusPanelTabel.removeClass('panel-default').addClass('panel-danger');
					}
				}	
			}
		}else{
			tootjaId=1;
			akkordId=akkordId+1;
			tooId=tooId+1
			grupp=array.Grupp;
			Too=array.Too;
			Leping=array.Leping;
			LepingToo=Leping+Too;
			LepingTooId=LepingTooId+1;
			kogusK=kogus;
			//console.log("KogusK: "+kogusK);
			aegKokkuK=aegKokkuEsimene;
			//Tekitame uue põhi paneeli
			uusPohiPaneel=$('<div />', {'class':'panel panel-group panel-primary','id':grupp});
			//tekitame uue päise paneeli
			uusSisuPaneelPais=$('<div />', {'class':'panel-heading text-center'});
			uusSisuPaneelPaisDiv=$('<div />', {'class':'row'});
			uusSisuPaneelPaisDiv.append("<div class='col-lg-6 text-left'><span>"+grupp+"</span></div>");
			if (grupp=="Elemendiliin"){
				uusSisuPaneelPaisDiv.append("<div class='col-lg-4' id="+grupp+"Kogus>Hetkel töös " + kogusK +" m2 elemente.</div>");
			}else{
				uusSisuPaneelPaisDiv.append("<div class='col-lg-4' id="+grupp+"Kogus></div>");
			}
			uusSisuPaneelPaisDiv.append("<div class='col-lg-2 text-right' id="+grupp+"Id><span class='badge'>"+tootjaId +"</span></div>");
			//tekitame uue nn päise rea
			uusSisuPaneelSisu=$('<div />', {'class':'panel panel-primary panelbody-madal text-center'});
			uusSisuPaneelSisuDiv=$('<div />', {'class':'row'});
			if (grupp=="Elemendiliin"){
				uusSisuPaneelSisuDiv.append("<div class='col-lg-3'><strong>Töö</strong></div>");
				uusSisuPaneelSisuDiv.append("<div class='col-lg-2'><strong>Leping</strong></div>");
				uusSisuPaneelSisuDiv.append("<div class='col-lg-3'><strong>Kogus</strong></div>");
				uusSisuPaneelSisuDiv.append("<div class='col-lg-2 text-left'><strong>Aeg kokku</strong></div>");
				uusSisuPaneelSisuDiv.append("<div class='col-lg-2 text-left'><strong>m2/h</strong></div>");
			}else{
				uusSisuPaneelSisuDiv.append("<div class='col-lg-3'><strong>Töö</strong></div>");
				uusSisuPaneelSisuDiv.append("<div class='col-lg-2'><strong>Leping</strong></div>");
				uusSisuPaneelSisuDiv.append("<div class='col-lg-3'><strong></strong></div>");
				uusSisuPaneelSisuDiv.append("<div class='col-lg-2 text-left'><strong>Aeg kokku</strong></div>");
				uusSisuPaneelSisuDiv.append("<div class='col-lg-2 text-left'><strong></strong></div>");
			}

			uusPanelPais=$('<div />', {'class':'panel-heading text-center','data-toggle':'collapse','data-parent':'#'+grupp, 'data-target':'#'+tooId});
			uusPanelPaisRow=$('<div />', {'class':'row'});
			uusPanelPais.append(uusPanelPaisRow);
			if ((kogusK>0) && (grupp=="Elemendiliin")){
				kogusBar="<div class='col-lg-3 visible-lg'><div class='suurusTaust'><div class='suurus text-left' style='width:"+((kogus/23)*100)+"%'><small>"+kogus+"m2</small></div></div></div>";
			}else{
				kogusBar="<div class='col-lg-3 visible-lg'></div>";
			}
			if ((kogusK>0) && (aegKokku>0) && (grupp=="Elemendiliin")){
				kokkuAeg="Kokku: " + aegKokkuK.toFixed(2)+ " h.";
				kokkuTunnis=(kogus/aegKokkuK).toFixed(1); //arvutame m2 tunnis
				kokkuTunnisText=kokkuTunnis + " m2/h";
			}else{
				kokkuAeg=aegKokkuK.toFixed(2)+ " tundi.";
				kokkuTunnis='';
				kokkuTunnisText='';
			}
			uusPanelTabel=$('<div />', {'class':'panel panel-default'});
			uusPanelPaisRow.append("<div class='col-lg-3 col-xs-6'><strong>"+Too+"</strong></div>");
			uusPanelPaisRow.append("<div class='col-lg-2 col-xs-6 uRida'>"+Leping+"<div class='uRidaText'><i class='fa fa-question-circle'></i></div></div>");
			uusPanelPaisRow.append(kogusBar);
			uusPanelPaisRow.append("<div class='col-lg-2 visible-lg text-left' id="+LepingTooId+"_aeg>"+kokkuAeg+"</div>");
			uusPanelPaisRow.append("<div class='col-lg-2 visible-lg text-left' id="+LepingTooId+"_kogus>"+kokkuTunnisText+"</div>");
			uusPanelTabel.append(uusPanelPais);
			uusPanelTabelSisu=$('<div />', {'class':'panel panel-collapse collapse', 'id':tooId});
			uusTabel=$('<table />', {'class':'table table-condensed table-bordered'});
			uusRida=$('<tr />');
			uusSisuPaneelPais.append(uusSisuPaneelPaisDiv);
			uusPohiPaneel.append(uusSisuPaneelPais);
			uusSisuPaneelSisu.append(uusSisuPaneelSisuDiv);
			uusPohiPaneel.append(uusSisuPaneelSisu);
			uusPohiPaneel.append(uusPanelTabel);
			uusPanelTabel.append(uusPanelTabelSisu);
			uusPanelTabelSisu.append(uusTabel);
			uusTabel.append(uusRida);
			if (Start0>sessionStorage['viimatiVaatasin']){
				uusPanelTabel.removeClass('panel-default').addClass('panel-warning');
			}else{
				//console.log(kokkuTunnis);
				if((kokkuTunnis<1) && (kokkuTunnis>0)){
					//console.log(Too + " - on suurem I: " + kokkuTunnis);
					uusPanelTabel.removeClass('panel-default').addClass('panel-danger');
				}
			}
			uusRida.append('<td data-tid='+tid+' data-leping='+Leping+' class="tootajaNimi">'+Nimi+'</td><td>'+Start+'</td>');
			//console.log(kokkuTunnis);
			$("#uusTabel").append(uusPohiPaneel);
		} 
	});

}

//Näitame mitteaktiivseid koode
$(document).on('click', '.uRidaText', function(e){
		var lepNr=$(this).parent().text();
		var Grupp="Elemendiliin";
		var pealk=lepNr + " mitteaktiivsed koodid.";
		uus(lepNr, Grupp, pealk);
	return false;
				//e.preventDefault();
})


//Kui vajutame töötaja nime peale

$(document).on('click', '.tootajaNimi', function(){
	var nimi=$(this).text();
	var leping=$(this).data('leping');
	var tid=$(this).data('tid');

	otsiTehtudTood(nimi, tid, leping);
});

//Otsime tehtud tööd selle lepinguga
function otsiTehtudTood (nimi, tid, leping){
	var job;
	var m2;
	var grupp;
	var keskM2;
	$("#tehtudTood_Modal .panel").empty();
	$.getJSON("/tool/tehtudTood.php", {tKood:tid, Leping:leping}, function(data){
		$.each(data, function(nr,array){
			if (grupp!==array.GNIMI){
				paneel='paneel_' + nr;
				tabel='tabel_' + nr;
				job=array.JOB;
				keskM2=array.AVG_m2H;
				m2=array.m2;
				grupp=array.GNIMI;
				$("#tehtudTood_Modal .panel").append("<div class='panel-heading' id='" + paneel +"'>" + grupp + "</div>");
				$("#tehtudTood_Modal .panel").append("<table class='table table-striped table-condensed' id='"+tabel+"'><tbody></tbody></table>");
				$("#tehtudTood_Modal #"+tabel).append("<tr><td>"+job+"</td><td>"+keskM2+"</td><td>"+m2+"</td></tr>");
			}else{
				job=array.JOB;
				keskM2=array.AVG_m2H;
				m2=array.m2;
				$("#tehtudTood_Modal #"+tabel).append("<tr><td>"+job+"</td><td>"+keskM2+"</td><td>"+m2+"</td></tr>");
			}
		})
	})
	$("#tehtudTood_Modal .modal-title").text(nimi);
	$("#tehtudTood_Modal").modal("show");
}


