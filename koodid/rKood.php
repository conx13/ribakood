<!DOCTYPE html>
<html lang="et">
  <head>
    <meta charset="utf-8">
    <title>Ribakoodid</title>
    <!-- Bootstrap -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../bootstrap3/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <!-- <link href="../bootstrap3/css/bootstrap-responsive.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="../font-awesome/css/font-awesome.min.css">
    <link href="../pais/navibar.css" rel="stylesheet">
    <link href="../css/rKood.css" rel="stylesheet">

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="../bootstrap3/js/bootstrap.min.js"></script>
    <script src="../scriptid/bootstrap-paginator.min.js"></script>
    <!--<script src="../scriptid/respond.min.js"></script> --> <!--IE8 jaoks-->
    <script src="rKood.js"></script>

  </head>
  <body>
    <?php
      $path = $_SERVER['DOCUMENT_ROOT'];
      require_once($path .'/login/kont.php'); //kas on lubatud kasutaja
      include_once ($path .'/pais/navibar.php'); //võtame päise külge
      if (isset($_POST["nOtsi"]) && (!($_POST["tOtsi"]==""))){
        $otsi=$_POST["tOtsi"];
      }else{
        $otsi="";
      }
    ?>

<!-- Kustutamise üle küsimise aken -->
<div class="modal" id="kasKustu" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title text-center">Kas kustame rea?</h4>
      </div>
      <div class="modal-body text-center" >
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-sm laius2" data-dismiss="modal">Tühista</button>
        <button type="button" class="btn btn-danger btn-sm laius2" id="mKustu">Kustuta</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Lisatud hulgi tööd -->
<div class="modal fade" id="hulgiTagasiModal" tabindex="-1" role="dialog" aria-labelly="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title text-center">Lisatud tööd</h4>
        </div>
        <div class="modal-body">
          <textarea class="form-control" id="hulgiTagasiText" rows="15"></textarea>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default btn-sm laius2" data-dismiss="modal">Sulge</button>
        </div>
      </div>
    </div>
</div> 
<!--modal-->

<!-- Lisa hulgi -->
<div class="modal fade" id="hulgiModal" tabindex="-1" role="dialog" aria-labelly="hulgiModal" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title text-center">Lisa hulgi</h4>
        </div>
        <form class="form" id="fLisaHulgi" role="form" method="POST">
          <div class="modal-body">
            <div class="row">
              <div class="form-group col-lg-5">
                <label class="control-label" for="hLeping">Leping:</label>
                <input type="text" class="form-control input-sm kont" id="hLeping" name="hLeping" placeholder="Lepingu nr" maxlength="10"/>
              </div>
              <div class="form-group col-lg-7">
                <label class="control-label" for="hGnimi">Grupp:</label>
                <select class="form-control input-sm kont" id="hGnimi" name="hGrupp">
                <!-- Andmed tulevad js failist -->
                </select>
              </div>
            </div>
            <div class="row">
              <div class="form-group col-lg-12">
                <label class="control-label" for="hHulgi">Hulgi:</label>
                <textarea class="form-control input-sm kont" rows="10" id="hHulgi" name="hHulgi" placeholder="Element 23.4"></textarea>
              </div>
            </div>
          </div> <!-- modal-body -->
          <div class="modal-footer">
            <button type="button" class="btn btn-default btn-sm laius2" data-dismiss="modal">Sulge</button>
            <input type="submit" class="btn btn-primary btn-sm laius2" id="hSalvesta" value='lisa hulgi' />
          </div>
        </form>
      </div>
    </div>
</div> 
<!--modal-->

<!-- Lingitud tööd -->
<div class="modal fade" id="linkModal" tabindex="-1" role="dialog" aria-labelly="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title text-center">Seotud tööd</h4>
          </div>
          <div class="modal-body">
            <div class="panel panel-info" id="linkPaneel">
              <div class="panel-heading"></div>
               <div class="panel-body">
                  <table class="table table-condensed" id="linkTabel">
                    <tbody></tbody>
                  </table>  
               </div>
            </div>
          </div> <!-- modal body -->
          <div class="modal-footer">
              <button type="button" class="btn btn-default btn-sm laius2" data-dismiss="modal">Sulge</button>
          </div>
      </div>
    </div>
</div> 
<!--modal-->

<!--    muuda Modal aken-->
<div class="modal fade" id="muudaModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modalLai">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Muuda rida</h4>
      </div>
      <form class="form-inline" id="fMuuda" role="form "metod="POST">
        <div class="modal-body">
          <div class="form-group laius2">
            <label class="control-label" for="mLeping">Leping:</label>
            <input type="hidden" id="mJID" name="nJID">
            <input type="text" class="form-control input-sm kont laius2" id="mLeping" name="nLeping" placeholder="Lepingu nr" maxlength="10"/>
          </div>
          <div class="form-group laius3">
            <label class="control-label" for="mGnimi">Grupp:</label>
            <select class="form-control input-sm kont laius3" id="mGnimi" name="nGrupp">
            <!-- Andmed tulevad js failist -->
            </select>
          </div>
          <div class="form-group laius4">
            <label class="control-label" for="mJob">Töö:</label>
            <input type="text" class="form-control input-sm kont laius4" id="mJob" name="nJob" placeholder="Töö" maxlength="20">
          </div>
          <div class="form-group laius15">
            <label class="control-label" for="mYhik">Ühik:</label>
            <select class="form-control input-sm laius15" id="mYhik" name="nYhik">
              <option></option>
              <option>m2</option>
              <option>m3</option>
              <option>jm</option>
              <option>tk</option>
            </select>
          </div>
          <div class="form-group laius15">
            <label class="control-label" for="mKogus">Kogus:</label>              
            <input type="text" class="form-control input-sm laius15" id="mKogus" name="nKogus">
          </div>
        </div> <!-- modal-body -->
        <div class="modal-footer">
          <button type="button" class="btn btn-default btn-sm laius2" data-dismiss="modal">Tühista</button>
          <input type="submit" class="btn btn-primary btn-sm laius2" disabled="disabled" id="mSalvesta" value='Muuda'/>
        </div>
      </form> <!-- form -->
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!--    uus Modal aken-->
<div class="modal fade" id="uusModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modalLai">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Lisa rida</h4>
      </div>
      <form class="form-inline spetsLaius"  target="minuRaam" id="fUus" role="form "metod="POST">
        <div class="modal-body">
          <div class="form-group laius2">
            <label class="control-label" for="uLeping">Leping:</label>
            <input type="text" autocomplete="on" class="form-control laius2 input-sm kont" id="uLeping" name="uLeping" placeholder="Lepingu nr" maxlength="10"/>
          </div>
          <div class="form-group laius3">
            <label class="control-label" for="uGnimi">Grupp:</label>
            <select class="form-control laius3 input-sm kont" id="uGnimi" name="uGrupp">
            <!-- Andmed tulevad js failist -->
            </select>
          </div>
          <div class="form-group laius4">
            <label class="control-label" for="uJob">Töö:</label>
            <input type="text" class="form-control laius4 input-sm kont" id="uJob" name="uJob" placeholder="Töö" maxlength="20">
          </div>
          <div class="form-group laius15">
            <label class="control-label" for="uYhik">Ühik:</label>
            <select class="form-control laius15 input-sm" id="uYhik" name="uYhik">
              <option></option>
              <option>m2</option>
              <option>m3</option>
              <option>jm</option>
              <option>tk</option>
            </select>
          </div>
          <div class="form-group laius15">
            <label class="control-label" for="uKogus">Kogus:</label>              
            <input type="text" class="form-control laius15 input-sm" id="uKogus" name="uKogus">
          </div>
        </div> <!-- modal-body -->
        <div class="modal-footer">
          <button type="button" class="btn btn-default btn-sm laius2" data-dismiss="modal">Tühista</button>
          <input type="submit" class="btn btn-primary btn-sm laius2" disabled="disabled" id="uSalvesta" value='Lisa'/>
        </div>
      </form> <!-- form -->
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!--Nupud - Lisa ja Otsi -->
<div class="container" style="height:50px" id="Nupud"> 
  <div class="row">
    <div class="col-lg-8 col-lg-offset-2 text-center koodiNupud">
        <button class="btn btn-default btn-sm laius3"  id="pLisa" type="button">Lisa</button> <!--pNuppEsimene-->
        <button class="btn btn-default btn-sm laius3" id="pLisaHulgi" type="button">Lisa hulgi</button><!--pNupp-->
        <button class="btn btn-primary btn-sm laius3" title="Otsi" rel="tooltip" type="button" id="pOtsi"><i class="fa fa-search"></i> Otsi</button><!--pNupp-->
    </div>
  </div>
</div> 

<!-- Otsimise aken ja nupud -->
<div class="container" id="otsiNupud" style="height:50px">
  <div class="row text-center">
    <div class="col-lg-8 col-lg-offset-2">
      <form class="form-inline">
          <input type="text" title="Siia kirjuta ainult lep nr" class="form-control input-sm laius3" placeholder="Leping" id="tabelLepingText">
          <input type="text" class="form-control input-sm laius3" placeholder="otsing" id="tabelOtsiText">
          <button type="button" class="btn btn-success btn-sm laius3" disabled="disabled" id="tabelOtsi">Otsi</button>
          <button type="button" class="btn btn-primary btn-sm laius3" id="tabelKoik">Näita kõiki</button>
      </form>
    </div>
</div>
</div>


<!-- Siia tuleb tabel eraldi failist -->
<div id="koodi_tabel" class="container">
  <div class="row col-lg-8 col-lg-offset-2" >
    <div class="rError alert alert-danger text-center">
      <button type="button" class="close" aria-hidden="true">&times;</button>
      <strong>Viga!</strong><div id="errorText">dfdfd</div>
    </div> <!-- Näitame vajadusel errorit -->
    <div class="row col-lg-6 col-lg-offset-3" >
      <div class="rInfo alert alert-success text-center"></div> <!-- Näitame vajadusel infot -->
    </div>     
    <table class="table table-condensed table-hover table-bordered" id="sisuTabel">
      <thead>
        <tr>
          <th width="10%">LepNr</th>
          <th width="25%">GNimi</th>
          <th>Töö</th>
          <th width="12%">Ribakood</th>
          <th width="5%">Ühik</th>
          <th width="7%">Kogus</th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
  </div>
</div>
    
   
<!-- Siia tulevad paginatori nupud -->

<div class="container text-center">
  <ul id="Pagin"><a href=""></a></ul>
</div> 


<!-- Selleks et formi kinnitamine jätaks sisu meelde  -->
<iframe class="hidden" name="minuRaam" src="about:blank"></iframe>
	
  </body>
</html>