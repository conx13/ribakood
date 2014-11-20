//Kui on otsime aktiivne, teem tabeli teist värvi
$(function(){
    if (localStorage["otsi"]==1) {
        $('#sTabel>tbody>tr').addClass("info");
    }
  });

//Liikudes hiirega üle rea, teeme muutmise jne nupud aktiivseks
$(document).ready(function() {
  $('.rData').hover(function() {
    $(this).parent().find('.peida1').show();
  }, function() {
    $(this).parent().find('.peida1').hide();
  });
});

// Vajutame tabelis Märkuse ikooni
$('.rMarkus').click(function(e){
    var tiitel = $(this).closest('tr').children().eq(2).text();
    var markus= $(this).closest('tr').children().eq(6).text();
    e.preventDefault();
    //console.log('vajuatasime Märkust');
    if (markus) {
      $('#markus_Modal #markus_markused').val(markus);
      $('#tehtud_markused_grupp').show();
    }else{
      $('#markus_Modal #markus_markused').val('');
      $('#tehtud_markused_grupp').hide();
    };
    $('#markus_Modal .modal-title').html(tiitel);
    $('#markus_Modal #markus_uus').val('');
    $('#markus_Modal').modal('show');

});

// võtame uue märkuse foocusesse
// Kui tekitame kohe fookuse, siis see ei toimi.
// Peame seda tegema alles siis kui modal on nähtav
$(function(){
  $('#markus_Modal').on('shown.bs.modal', function () {
    $('#markus_Modal #markus_uus').focus();
  });
})


//Kui vajutame tabelis kustutamise ikooni
$('.rKustuta').popover({
    html: true,
    title:'Kas kustutan rea?',
    trigger: 'manual',
    placement:"bottom",
    content: $('#kustuta').html()
  }).click(function (e) {
    var see=$(this);
    $('.rKustuta').not(this).popover('hide');
    $(this).popover('toggle');
    $('.delete').click(function (e) {
        kustu(see);
    });
    $('.kinni').click(function () {
        see.popover('toggle');
    });
    e.stopPropagation();
  });


//välistame hiirega ära minne, et aken lahti jääb
$('.rData').hover(function(){
  //console.log($(this).find('rKustuta'));
  $(this).find('.rKustuta').popover('hide'); 
  });


$(document).keydown(function (e) {
    if (e.keyCode === 27) $('.rKustuta').popover('hide');
});


//Kustutame rea ära
function kustu(see) {
  var rea_id=see.closest("tr").attr("id");
  var msg;
  //console.log(rea_id);
  see.click();
  $.ajax({
    type:"POST",
    url:"rKustuta.php",//kustutan rea
    data:{rida: rea_id},
    dataType: "html",
    async: false, //et saaks tulem kirja
    success: function(data)
    {
      msg=data;
    }
  });
  $(".rInfo").html(msg);
  $(".rInfo").addClass("alert alert-error");
  $(".rInfo").show();
  $(".rInfo").delay(2000).hide("slow",function(){
    taidaTabel();
    });
  };


//näitan infot kui midagi ei leidnud
function poleMiskit(){
    $(".rInfo").addClass("alert alert-error");
    $(".rInfo").html("Kahjuks ei leidnud midagi. <br>Proovi % ja ! märke. Näiteks '1304%'' leiab kõik '1204'-ga algavad lepingud jne");
    $(".rInfo").show();
}

//Täidame muutmise modal formi
$(function() {$('.rMuuda').click(function(){
  var lep_nr =$(this).closest('tr').children(':eq(0)').text();
  var grupp = $(this).closest('tr').children(':eq(1)').text();
  var job =$(this).closest('tr').children(':eq(2)').text();
  var yhik = $(this).closest('tr').children(':eq(4)').text();
  var kogus = $(this).closest('tr').children(':eq(5)').text();
  var ribakood=$(this).closest('tr').children(':eq(3)').text();
  var rea_id = $(this).closest('tr').attr("title");
    
$("#mLepNr").val(lep_nr);
$("#mToo").val(job);
$("#mID").val(rea_id);
$("#muudaGrupp option:contains(" + grupp + ")").prop("selected","selected");
    if (!(yhik) || !(kogus)) { //kui on mõlemad väljad täis
        $("#mKogus").val("");
        $("#mYhik").val(0);
    }else {
        $("#mYhik option:contains("+ yhik +")").prop("selected","selected");
        $("#mKogus").val(kogus);
    } //kui on mõlemad väljad täis lõpp
    
$('#modalMuuda').modal('show');
$("#mLepNr").focus();
})
});

$(function(){
  $("#nuppMuuda").click(function(){
      console.log("Vajutasid muuda nuppu");
      console.log($("form").serialize());
  });
});

$(function(){
  $("#fMuuda").submit(function(){
/*    console.log("vajutasid submitti");
    console.log($("#mID").val());
    console.log($("#mLepNr").val());
    console.log($("#muudaGrupp").val());
    console.log($("#mToo").val());
    console.log($("#mYhik").val());
    console.log($("#mKogus").val());*/
  });

});


