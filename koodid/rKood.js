//Teeme menüüs vastava nupu aktiivseks
$(function() {
    $('.nav>li:contains("Koodid")').addClass('active');
    //console.log();
    //Peidame alerdi - vaikimisi kustub
    $('.alert .close').on('click', function() {
        $(".alert").hide();
    });
    $("#navText").html("Koodid.");
    esimeneAvamine();
    //$("#hulgiTagasiModal").modal("show");
});
/////////////////////////////////////////////////////
//Näitame koodi tabelit esimest korda kui laeme lk //
/////////////////////////////////////////////////////
function esimeneAvamine() {
    sessionStorage["otsi"] = 0;
    sessionStorage["leht"] = 1;
    if (($(window).height()) > 800) { //vastavalt ekraani kõrgusele anname read
        sessionStorage["tabeliRidu"] = 26;
    } else {
        sessionStorage["tabeliRidu"] = 20;
    };
    //console.log($(window).height());
    taida_tabel();
    pagin();
}
//////////////////////////
// uue tabeli näitamine //
//////////////////////////
function taida_tabel() {
    var otsiText = "%";
    var otsiLeping = "%";
    var lk = "%";
    var rida = "";
    var tulem5 = '';
    var tulem6 = '';
    var nupud = "<div class='reaNupud pull-right'>" + "<a href='#'><i title='Print' class='fa fa-print rPrint tume' rel='tooltip'></i></a>" + "<a href='#'><i title='Märkus' class='fa fa-comment-o rMarkus tume' rel='tooltip'></i></a>" + "<a href='#'><i title='Muuda' class='fa fa-edit rMuuda tume' rel='tooltip'></i></a>" + "<a href='#'><i title='Seotud' class='fa fa-link tume' rel='tooltip' id='rLink'></i></a>" + "<a href='#'><i title='Kustuta' class='fa fa-trash-o rKustuta' rel='tooltip'></i></a></div>";
    var nupud2 = "<div class='reaNupud pull-right'><a href='#'><i title='Kopeeri'kood class='fa fa-copy rCopy tume' rel='tooltip'></i></a>";
    if (sessionStorage["otsi"] == 1) {
        otsiText = sessionStorage["otsing"];
        otsiLeping = sessionStorage["leping"];
    }
    if (sessionStorage["leht"] > 0) {
        lk = sessionStorage["leht"];
    }
    // $(".rInfo").hide();
    $(".rError").hide();
    $("#pagin").hide();
    $('#sisuTabel tbody').empty();
    $('#load_pic').fadeIn(200, 0);
    //    $.ajaxSetup({ cache: false })
    $.getJSON('rTabel.php', {
        oLeping: otsiLeping,
        oText: otsiText,
        oLeht: lk,
        oRidu: sessionStorage["tabeliRidu"]
    }, function(data) {
        if (data !== "tyhi") {
            //console.log(data);
            $.each(data, function(jrk, array) {
                // Kustutame null väärtused
                tulem5 = array[5];
                tulem6 = array[6];
                //console.log(tulem5);
                if (tulem5 == null) {
                    tulem5 = '';
                    tulem6 = '';
                };
                rida += "<tr><td class='hidden'>" + array[0] + "</td><td>" + array[1] + "</td><td>" + array[2] + "</td><td class='nups'>" + array[3] + nupud + "</td><td>" + array[4] + nupud2 + "</td><td>" + tulem5 + "</td><td>" + tulem6 + "</td></tr>";
            }) //each
            //console.log(rida);    
            $("#sisuTabel tbody").html(rida); //näitame tabeli sisu
            $("#sisuTabel").show();
            $("#pagin").show();
        } else { //kui tabel on tühi nätame errorit
            $("#sisuTabel").hide();
            $(".rError").html("Kahjuks ei leidnud midagi. <br>Proovi % ja ! märke. Näiteks '1204%'' leiab kõik '1204'-ga algavad lepingud jne");
            $(".rError").fadeIn("slow");
        }; //if tyhi
        $('#load_pic').fadeOut('slow');
    }); //getJson
    //$.ajaxSetup({ cache: true })
}
/////////////////////////////
//Kopeeri kood lõikeklauale//
/////////////////////////////
$(function() {
    $("#sisuTabel").on("click", ".rCopy", function() {
        var text = $(this).closest("tr").children().eq(4).text();
        //console.log(text);
        window.prompt("Kopeeri tulemus lõikelauale: Ctrl+C, Enter", text);
    })
})
///////////////////////////
// Avame kustutamise akna//
///////////////////////////
$(function() {
    $("#sisuTabel").on("click", ".rKustuta", function() {
        var tex = "";
        var jid = "";
        tex = "<h4>" + $(this).closest("tr").children().eq(1).text() + " - " + $(this).closest("tr").children().eq(2).text() + " - " + $(this).closest("tr").children().eq(3).text() + "</h4>";
        $("#kasKustu .modal-body").html(tex);
        jid = $(this).closest("tr").children().eq(0).text();
        $("#kasKustu").data('jid', jid); //paneme data sildi alla jid tunnuse
        $("#kasKustu").modal("show");
    })
})
// Kustutame vajaliku rea
$(function() {
    $("#kasKustu #mKustu").click(function() {
        var info = "";
        var sql = {
            'rida': +$("#kasKustu").data('jid')
        };
        $("#kasKustu").modal('hide');
        $.post("rKustuta.php", sql, function(data) {
            //alert(data);
            $(".rInfo").html();
            $(".rInfo").html(data);
        })
        taida_tabel(); //täidame tabeli
        pagin(); //paneme paginatori paika
        $(".rInfo").show();
        setTimeout(function() {
            $(".rInfo").fadeOut(1000);
        }, 1000)
    })
})
///////////////////////////
// Avame printimise akna //
///////////////////////////
$(function() {
    $("#sisuTabel").on("click", ".rPrint", function() {
        var jid = $(this).closest("tr").children("td").eq(0).text();
        window.open('PrintKoodid.php?kood=' + jid, '', 'width=660,height=580');
    })
})
////////////////////////////////////////
//Siit edasi tegeleme muutmise formiga//
////////////////////////////////////////
// Avame muutmise formi
$(function() {
    $("#sisuTabel").on("click", ".rMuuda", function() {
        var jid = $(this).closest("tr").children("td").eq(0).text();
        var leping = $(this).closest("tr").children("td").eq(1).text();
        var grupp = $(this).closest("tr").children("td").eq(2).text();
        var job = $(this).closest("tr").children("td").eq(3).text();
        var yhik = $(this).closest("tr").children("td").eq(5).text();
        var kogus = $(this).closest("tr").children("td").eq(6).text();
        var select = $('#mGnimi');
        var options = select.prop('options');
        $('#mGnimi').empty();
        $("#muudaModal #mJID").val(jid);
        $("#muudaModal #mLeping").val(leping);
        $("#muudaModal #mLeping").prop('data-value', leping);
        $.getJSON('rGrupp.php', function(data) {
            $.each(data, function(Nr, array) {
                if (grupp == array[1]) {
                    options[options.length] = new Option(array[1], array[0], 'selected', 'selected');
                } else {
                    options[options.length] = new Option(array[1], array[0]);
                }
            });
        });
        $("#muudaModal #mJob").val(job);
        if (!(yhik) || !(kogus)) { //kui on mõlemad väljad täis
            $("#mKogus").val("");
            $("#mYhik").val(null);
        } else {
            $("#mYhik option:contains(" + yhik + ")").prop("selected", "selected");
            $("#mKogus").val(kogus);
        }
        $("#mSalvesta").prop("disabled", true);
        $("#muudaModal").modal("show");
        //console.log($(this));
    })
});
//Kui muuda form tuleb välja siis teeme esimese
//välja aktiivseks
$(function() {
    $("#muudaModal").on("shown.bs.modal", function() {
        $("#muudaModal #mLeping").focus();
    })
});
// Kui mõni väli on muutunud
$(function() {
    $("#fMuuda .input-sm").on('keyup change', function() {
        kasKoikOk("#fMuuda"); //kontrollime kas kõik on ok
    });
})
//Salvestame muudatused
$(function() {
    $("#fMuuda").submit(function(e) {
        var yhik = $("#fMuuda #mYhik").val().length;
        var kogus = $("#fMuuda #mKogus").val().length;
        var sql;
        var info;
        sql = $(this).serialize();
        $("#muudaModal").modal("hide");
        $.post("rMuuda.php", sql, function(data) {
            $(".rInfo").html();
            $(".rInfo").html(data);
            taida_tabel(); //täidame tabeli
            pagin(); //paneme paginatori paika
        })
        $(".rInfo").show();
        setTimeout(function() {
            $(".rInfo").fadeOut(1000);
        }, 1000)
        return false;
    });
});
///////////////////
// Lingitud tööd //
///////////////////
$(function() {
    $("#sisuTabel").on("click", "#rLink", function() {
        var tyhi = "Selle koodiga ei ole seotud tegevusi!";
        var sum = 0;
        var tunnid;
        var minutid;
        var kpv;
        var tabeli_pealkiri = "<tr class='active'><th>Nimi</th><th>Algus</th><th>Lõpp</th><th>Aeg</th></tr>";
        var jid = $(this).closest("tr").children("td").eq(0).text();
        var vormiPealkiri = $(this).closest("tr").children("td").eq(3).text() + "<br/><small>" + $(this).closest("tr").children("td").eq(1).text() + " - " + $(this).closest("tr").children("td").eq(2).text() + "</small>";
        $("#linkModal .panel tbody").empty();
        $("#linkModal #linkTabel tbody").append(tabeli_pealkiri);
        $.ajaxSetup({
            cache: false
        });
        $.getJSON("rLink.php", {
            oJID: +jid
        }, function(data) {
            if (data != 'tyhi') {
                $.each(data, function(nr, array) {
                    if (kpv == array.Algus.substring(9, 19)) {
                        kpv = array.Algus.substring(9, 19);
                        $("#linkModal #linkTabel tbody").append("<tr><td>" + array.Nimi + "</td><td>" + array.Algus.substr(0, 5) + "</td><td>" + array.Lopp.substr(0, 5) + "</td><td>" + array.Kokku + "</td></tr>");
                        sum = sum + array.Kokku;
                    } else {
                        kpv = array.Algus.substring(9, 19);
                        $("#linkModal #linkTabel tbody").append("<tr class='active'><td colspan='4'><strong>" + array.Algus.substring(9, 19) + "</strong></td></tr>");
                        $("#linkModal #linkTabel tbody").append("<tr><td>" + array.Nimi + "</td><td>" + array.Algus.substr(0, 5) + "</td><td>" + array.Lopp.substr(0, 5) + "</td><td>" + array.Kokku + "</td></tr>");
                        sum = sum + array.Kokku;
                    }
                    if ($.isNumeric(sum)) {
                        if (sum > 0) {
                            tunnid = Math.floor((sum) / 60);
                            minutid = sum % 60;
                            //console.log(tunnid +":" + minutid);
                        }
                        $("#linkModal .panel-heading").html("Kokku kulunud (h:m): " + tunnid + ":" + minutid);
                    };
                    $("#linkModal .modal-title").html(vormiPealkiri);
                    $("#linkModal").modal('show');
                });
            } else {
                alert(tyhi);
            };
        });
    });
});
////////////////////
//Paneme paika lk //
////////////////////
// loeme kokku palju on koode lk kaupa
function loeLehed() {
    var otsi = "%";
    var leping = "%"
    var msg;
    if (sessionStorage["otsi"] == 1) { //kui otsing aktiivne
        otsi = sessionStorage["otsing"]; //siis võtame andmed localist
        leping = sessionStorage["leping"];
    }
    $.ajax({
        type: "POST",
        url: "rLehtiKokku.php", //loen read kokku
        data: {
            oLeping: leping,
            oText: otsi
        },
        dataType: "json",
        async: false, //et saaks tulem kirja
        success: function(data) {
            msg = data;
        }
    });
    return msg;
}
//paginator
function pagin() {
    var ridu = sessionStorage["tabeliRidu"];
    var kokku = (Math.ceil(loeLehed() / ridu)); /*Loeme lehed kokku*/
    var hetkeLeht = 1;
    if (sessionStorage["leht"] > 1) {
        hetkeLeht = sessionStorage["leht"];
    };
    var options = {
        currentPage: hetkeLeht,
        totalPages: kokku,
        tooltipTitles: function(type, page, current) {
            switch (type) {
                case "first":
                    return "Esimene lk";
                case "prev":
                    return "Eelmine lk";
                case "next":
                    return "Järgmine lk";
                case "last":
                    return "Viimane lk";
                case "page":
                    return "Leht: " + page;
            }
        },
        size: 'small',
        alignment: 'center',
        onPageClicked: function(e, originalEvent, type, page) {
            sessionStorage["leht"] = page;
            taida_tabel();
        }
    };
    if (kokku > 1) {
        $('#Pagin').bootstrapPaginator(options);
    } else {
        $('#Pagin').empty();
    }
}
///////////////////////////////////
//Otsimisega seotud funktsioonid //
///////////////////////////////////
//Kui vajutame tabeli otsi nupule
$(function() {
    $("#pOtsi").click(function() {
        $("#Nupud").hide("fast");
        $("#otsiNupud").show("fast");
        $("#tabelLepingText").focus();
    })
});
//Kui vajutame tabeli näita kõiki nupule
$(function() {
    $("#tabelKoik").click(function() {
        $("#otsiNupud").hide("fast");
        $("#Nupud").show("fast");
        $("#tabelLepingText").val("");
        $("#tabelOtsiText").val("");
        $("#tabelOtsi").attr("disabled", "disabled");
        if (sessionStorage["otsi"] == 1) { //kui on enne miskit otsitud
            sessionStorage["leht"] = 1;
            sessionStorage["otsi"] = 0; //siis tühistame lipu
            taida_tabel(); //täidame tabeli
            pagin(); //paneme paginatori paika
            sessionStorage["otsing"] = 0;
            sessionStorage["leping"] = 0;
        }
    })
});
//Kui kirjutame otsingu lepingusse miskit
$(function() {
    $("#tabelLepingText").keyup(function() {
        if (($("#tabelLepingText").val() != "") || ($("#tabelOtsiText").val() != "")) {
            $("#tabelOtsi").removeAttr("disabled")
        } else {
            $("#tabelOtsi").attr("disabled", "disabled")
        }
    })
});
//Kui kirjutame otsingusse miskit
$(function() {
    $("#tabelOtsiText").keyup(function() {
        if (($("#tabelLepingText").val() != "") || ($("#tabelOtsiText").val() != "")) {
            $("#tabelOtsi").removeAttr("disabled")
        } else {
            $("#tabelOtsi").attr("disabled", "disabled")
        }
    })
});
//Kui vajutame otsiTabel nupule
$(function() {
    $("#tabelOtsi").click(function() {
        var lep = "%";
        var otsi = "%";
        if ($("#tabelLepingText").val() != "") {
            lep = $("#tabelLepingText").val();
        };
        if ($("#tabelOtsiText").val() != "") {
            otsi = $("#tabelOtsiText").val();
        };
        sessionStorage["otsi"] = 1; //paneme otsimise lipu maha
        sessionStorage["leht"] = 1; //nullime lehed
        sessionStorage["leping"] = lep; //paneme lep nr
        sessionStorage["otsing"] = otsi; //paneme otsi texti
        taida_tabel(); //täidame tabeli
        pagin(); //paneme paginatori paika
    })
});
/////////////////////////
//Uute andmete lisamine//
/////////////////////////
//Lisamise nupu vajutamine
$(function() {
    var select = $('#uGnimi');
    var options = select.prop('options');
    $("#pLisa").click(function() {
        $.getJSON('rGrupp.php', function(data) { //täidame gruppi nimekirja
            $.each(data, function(Nr, array) {
                options[options.length] = new Option(array[1], array[0]);
            });
        });
        $("#uusModal").modal("show");
    })
})
//Kui uus form tuleb välja siis teeme esimese välja aktiivseks
$(function() {
    $("#uusModal").on("shown.bs.modal", function() {
        $("#uusModal #uLeping").focus();
    })
});
//nullime igaksjuhuks kõik väljad
$(function() {
    $("#uusModal").on("hide.bs.modal", function() {
        //console.log("peidus");
        $("#fUus")[0].reset();
    })
})
// Kui mõni väli on muutunud
$(function() {
    $("#fUus .input-sm").on('keyup change', function() {
        kasKoikOk("#fUus");
    });
})
//lisame uued andmed
$(function() {
    $("#fUus").submit(function(e) {
        var sql = $(this).serialize();
        var txt;
        //event.preventDefault();
        $.post("rUusKood.php", sql, function(data) {
            $(".rInfo").html();
            $(".rInfo").html(data);
            $("#uusModal").modal("hide");
            taida_tabel(); //täidame tabeli
            pagin(); //paneme paginatori paika
        });
        //txt=data;
        $(".rInfo").show();
        setTimeout(function() {
            $(".rInfo").fadeOut(1500);
        }, 1500)
        //alert(txt);
        //return false;
    })
})
// Kontrollime, kas kõik vajalikud väljad on täidetud
// ja teeme muutmise nupu aktiivseks 
function kasKoikOk(formNimi) {
    var yhik = $(formNimi + " [id*=Yhik]").val().length;
    var kogus = $(formNimi + " [id*=Kogus]").val().length;
    var viga = 0;
    //console.log($(formNimi+" [id*=Kogus]").val());
    //nullime kõik vead
    $(formNimi + " .form-group").each(function() {
        $(this).removeClass('has-error');
    });
    // Kui on mõni väli tühi
    $(formNimi + " .kont").each(function() {
        if (!(($(this).val().length) > 0)) {
            $(this).parent().addClass('has-error');
            viga = +1; //kui on mõni väli tühi
        };
    });
    // Kui kogus ja ühik ei klapi
    if (!((yhik > 0) == (kogus > 0))) {
        $(formNimi + " [id*=Yhik]").parent().addClass('has-error');
        viga = +1; //Kui yhik ja kogus on erinavalt täidetud
    };
    // Kui kogus ei ole number
    if (kogus) {
        if (!($.isNumeric($(formNimi + " [id*=Kogus]").val()))) {
            viga = +1;
            $(formNimi + " [id*=Kogus]").parent().addClass('has-error');
        };
    };
    // Vastavalt vajadusele aktiveerime muuda nupu
    if (viga == 0) {
        $(formNimi + " [id*=Salvesta]").prop("disabled", false);
    } else {
        $(formNimi + " [id*=Salvesta]").prop("disabled", true);
    };
};
//////////////////
//Hulgi lisamine//
//////////////////
//täidame grupi selecti enne modali näitamist
$(function() {
    var select = $('#hGnimi');
    var options = select.prop('options');
    $("#pLisaHulgi").click(function() {
        $.getJSON('rGrupp.php', function(data) { //täidame gruppi nimekirja
            $.each(data, function(Nr, array) {
                options[options.length] = new Option(array[1], array[0]);
            });
        });
        $("#hLeping").val('');
        $("#hGnimi").val('');
        $("#hHulgi").val('');
        $("#hulgiModal").modal("show");
    })
})
//teeme lepingu aktiivseks
$(function() {
    $("#hulgiModal").on("shown.bs.modal", function() {
        $("#hulgiModal #hLeping").focus();
    })
})
//Teeme korrektse listi
function hulgiText(txt) {
    var error = 0;
    var grupp = $("#hGnimi").val();
    var leping = $("#hLeping").val();
    var txt = $("#hHulgi").val();
    var hulgiSql = "";
    txt = $("#hHulgi").val();
    txt = txt.replace(/,/g, '.'); //asendame koma punktiga
    txt = txt.replace(/^\s+|\s+$/g, ''); //asendame tühjad tabid
    txt = txt.replace(/\t/g, '\n');
    txt = txt.split('\n');
    if (txt.length % 2 == 0) { //kui on paaris arv text
        for (i = 0; i < txt.length; i += 2) { //tekitame sql
            if ($.isNumeric(txt[i + 1])) {
                //error=+0;
            } else {
                error++;
            }
            hulgiSql += "('" + leping + "'," + grupp + ",'" + txt[i] + "','m2'," + txt[i + 1] + "),";
        };
        hulgiSql = hulgiSql.replace(/,$/g, ''); //kaotame lõpust komad
        return {
            hulgiSql: hulgiSql,
            error: error
        };
    } else {
        return {
            error: 1
        };
    };
};
// lisame hulgi read
function hulgiSalvesta() {
    var ajaxTulem;
    txt = hulgiText(); //teeme listi korda
    //console.log(txt);
    //console.log("Hakks");
    if (txt.error == 0) {
        ajaxTulem = $.ajax({
            url: "rLisaHulgi.php",
            type: "POST",
            data: {
                hText: txt.hulgiSql,
                hRandom: txt.rand
            },
            dataType: "json"
        });
        $("#hulgiModal").modal("hide");
        ajaxTulem.success(function(data) { //kui läks lisamine korda
            hulgiLisaOk(data);
        })
        ajaxTulem.fail(function(data) { //kui tekkis miski php tõrge
            hLisaErr(data);
        });
    } else {
        alert("Miskit on valesti hulgi väljal!");
        $("#hulgiModal #hHulgi").focus();
        $("#hulgiModal #hHulgi").select();
        console.log("Erroreid kokku:" + txt.error);
    }
};
//peale lisamist anname infot ja värskendame tabelit
function hulgiLisaOk(data) {
    var err = 0;
    var list = [];
    var i = 0;
    $(".rError #errorText").empty();
    $(".rInfo").empty();
    $("#hulgiTagasiText").empty();
    $.each(data, function(nr, array) {
        if (array[0] == "Viga!") {
            $(".rError #errorText").append(array[1] + "</br>");
            err = 1;
        } else {
            list[i] = (array[1] + "\t" + array[2] + "\n");
            i = i + 1;
        }
    })
    if (err == 1) {
        $(".rError").show();
    } else {
        taida_tabel(); //täidame tabeli
        pagin();
        //console.log(list.join(''));
        $("#hulgiTagasiText").html(list.join(''));
        $("#hulgiTagasiModal").modal("show");
    }
}
//kui vajutame hulgi salvestamise nuppu
$(function() {
    $("#hSalvesta").click(function() {
        event.preventDefault();
        hulgiSalvesta();
    });
})
//Kui hulgi lisatud form tuleb välja siis välja aktiivseks
$(function() {
    $("#hulgiTagasiModal").on("shown.bs.modal", function() {
        $("#hulgiTagasiModal #hulgiTagasiText").focus();
        $("#hulgiTagasiModal #hulgiTagasiText").select();
    })
});

function hLisaErr(data) {
    $(".rError #errorText").empty();
    $(".rError #errorText").html("Miskit on katki!</br>Andmed võibolla lisati!");
    taida_tabel(); //täidame tabeli
    pagin();
    $(".rError").show();
}