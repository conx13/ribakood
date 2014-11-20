<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9,chrome=1">
    <title>Hetkel tööl</title>
    <!-- Bootstrap -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../bootstrap3/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <!-- <link href="../bootstrap3/css/bootstrap-responsive.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="../font-awesome/css/font-awesome.min.css">
    <link href="../pais/navibar.css" rel="stylesheet">
    <link href="../css/rTool.css" rel="stylesheet">

    <!--<script src="scriptid/jquery-1.9.0.min.js"></script>-->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="../bootstrap3/js/bootstrap.min.js"></script>
    <script src="../scriptid/respond.min.js"></script> <!--IE8 jaoks-->
    <script src="rTool.js"></script>


  </head>
  <body>
    <?php //paneme kirja hetke aja -et jälgida muutusi
        $path = $_SERVER['DOCUMENT_ROOT'];
        include( $path ."/login/kont.php"); //kas on lubatud kasutaja
        if (!isset($_SESSION['kontroll'])) {
          $_SESSION ['kontroll'] = time();
        }
        else if (time() - $_SESSION['kontroll'] > 21600){ //kui on aeg liiga suur siis uuendame (6h)
          $_SESSION ['kontroll'] = time();
        }
        include ($path .'/pais/navibar.php');
        $aeg=date("H:i"); // võtame hetke aja
        ?>



   <!-- --> 
   <div class="container">
    <div class="row">
      <!--Vasak poolne tulp-->
      <div class="col-sm-3 col-lg-2 col-md-2 visible-lg">
         <!--Mitteaktiivsed koodid -->
        <div class="panel panelNool panel-info" id="mAktPaneel">
          <div class="panel-heading" data-toggle="collapse" href="#fMitteAkt"><i class="fa fa-angle-double-down"></i> Mitteaktiivsed koodid</div>
          <form class="collapse" role="form" id="fMitteAkt">
          <div class="panel-body">
            
            <div class="form-group">
              <label for="LepNr">Leping</label>
              <input type="text" class="form-control input-sm" id="lepNr" placeholder="Lepingu nr">
            </div>
            <div class="radio">
              <label>
                <input type="radio" name="radioLeping" value="Elemendiliin" checked>
                Elemendiliin
              </label>
            </div>
            <div class="radio">
              <label>
                <input type="radio" name="radioLeping" value="%">
                Kõik
              </label>
            </div>
            <button type="submit" id="nupp" class="btn btn-info btn-sm btn-block" disabled="disabled">Otsi</button>
          </div>
          </form>
        </div><!--Mitteaktiivsed koodid-->


        <!--m2 see kuu -->
        <div class="panel panelNool panel-success visible-lg peidus" id="selleKuuKogus">
          <div class="panel-heading" data-toggle="collapse" href="#ul_listSeeKogus">...</div>
          <ul class="list-group text-right collapse" id="ul_listSeeKogus">
          <!-- siia kirjutame js failist -->
          </ul>
        </div> <!--Selle kuu m2-->
      
       <!--Eelmise kuu kogus-->
      <div class="panel panelNool panel-success visible-lg peidus" id="eelmiseKuuKogus">
        <div class="panel-heading" data-toggle="collapse" href="#ul_listEelmineKogus">Eelmise kuu m2</div>
        <ul class="list-group text-right collapse" id="ul_listEelmineKogus">
          <!-- siia kirjutame js failist -->         
        </ul>
      </div><!--Eelmise kuu m2-->
    </div><!--Vasak tulp-->

      <!--Sisu tabel keskmine tulp-->
      <div class="col-lg-8 col-md-8 col-sm-6"> <!--keskmine tulp -->
		  <ul class="nav nav-tabs">
  			<li class="active"><a href="#sisuTabel" data-toggle="tab">Pikk tabel</a></li>
  			<li><a href="#uusTabel" data-toggle="tab">Lühike tabel</a></li>
		  </ul>
		  <div class="tab-content">
			  
		  <div class="tab-pane fade in active" id="sisuTabel">
            <?php
             $path = $_SERVER['DOCUMENT_ROOT'];
              include ($path .'/config.php');//võtame sealt andmed
              $query="SELECT GGRUPP, count(GGRUPP) AS Kokku FROM wLyhikeTanaTool_Kogus ";//wLyhikeTanaTool_Kogus PROOV2
              //$query="SELECT GGRUPP, count(GGRUPP) AS Kokku FROM paev ";//wLyhikeTanaTool_Kogus PROOV2
              $query .="GROUP BY GGRUPP, JRK ";
              $query .="ORDER BY JRK";
              $result =sqlsrv_query($conn, $query);
              while ($rows = sqlsrv_fetch_array($result)) {
            ?>
              <div class="panel panel-primary" id="sisuTabelPaneel">
                <div class="panel-heading" data=<?php echo ($rows['GGRUPP']); ?> id="sisuTabelPealk"><?php echo ($rows['GGRUPP'] .': ' .$rows['Kokku'].' töötajat.'); ?></div>
                <table class="table table-condensed table-hover table-bordered" id="SisuTabel">
                  <thead>
                    <th>Nimi</th>
                    <th width="15%">Leping</th>
                    <th width="40%">Töö</th>
                    <th width="10%">Algus</th>
                  </thead>
                  <tbody>
                    <?php
                    $queryr="SELECT NIMI, LEPNR, TOO, GNIMI, START, KOGUS, JRK, RID, JID, Markus FROM wLyhikeTanaTool_Kogus ";//wLyhikeTanaTool_Kogus
                    //$queryr="SELECT NIMI, LEPNR, TOO, GNIMI, START, KOGUS, JRK, RID, JID, Markus FROM paev ";//wLyhikeTanaTool_Kogus
                    $queryr .="WHERE GGRUPP='" . $rows['GGRUPP'] ."' ";
                    $queryr .="ORDER BY JRK, TOO, START";
                    $resultr=sqlsrv_query($conn, $queryr);
                    while ($rowsr=sqlsrv_fetch_array($resultr)) {
                    ?>
                    <tr <?php
                          if ($_SESSION['kontroll'] <= strtotime($rowsr['START'])){ //eristame viimati vaadatud andmeid
                            echo ("class='warning' ");
                          }
                      ?> >
                       <td><?php echo ($rowsr['NIMI']);?></td>
                      <td><button style="border:none; background:transparent; cursor: pointer;"><?php echo ($rowsr['LEPNR']);?></button></td>
                      <?php if ($rowsr["KOGUS"] > 0) {
                        echo "<td title=". round($rowsr["KOGUS"],1). "m2"." ><a href='#' data-toggle='tooltip' class='markus_title'><span class='pull-left suurus' style='width:" . round(($rowsr["KOGUS"] / 23) * 100) . "%;'>" . $rowsr["TOO"] . "</span><i class='markus_icon hidden fa fa-exclamation pull-right'> </i></a></td>";
                      }else {
                        echo "<td><a href='#' class='markus_title'>" . $rowsr["TOO"] . "<i class='markus_icon pull-right fa fa-exclamation hidden'> </i></a></td>";
                      };//if
                      ?>
                      <td><?php echo (date('H:i',strtotime($rowsr['START'])));?></td>
                      <td class="hidden"><?php echo ($rowsr['RID']);?></td>
                      <td class="hidden"><?php echo ($rowsr['JID']);?></td>
                      <td class="hidden"><?php echo ($rowsr['Markus']);?></td>
                    </tr>                      
                    <?php
                    }
                    ?>

                  </tbody>
                </table>
                </div>
          <?php 
          };
          sqlsrv_close($conn);
          ?>
      </div><!--Sisu tabel-->
			  
      <div class="tab-pane fade" id="uusTabel">
<!--      	<button type="button" class="btn btn-default" id="uusTabelNupp">Test-proovi tabel</button>-->
      </div><!--uusTabel-->
	</div>
      </div><!--keskmine tulp -->

		<!-- parem poolne tulp -->
      <div class="col-lg-2 col-sm-3 col-md-2">         
        <!--synnipaevad -->
        <div class="panel panel-warning peidus" id="synnipaev"> 
          <div class="panel-heading"><i class="fa fa-gift"></i> Täna sünnipäev:</div>
            <div>
			</div>
			<ul class="list-group text-left" id="ul_Synnip">
              <!-- siia kirjutame js andmed -->
            </ul>
        </div>

      <!--on tööl-->
        <div class="panel panel-info peidus" id="ListOnTool"> <!--Eelmise kuu kogus-->
          <div class="panel-heading">...</div>
        </div> <!--pole tööl-->

      <!--pole tööl-->
        <div class="panel panelNool panel-danger peidus" id="ListPoleTool"> <!--Eelmise kuu kogus-->
          <div class="panel-heading" data-toggle="collapse" id="PoleHetkelToolText" href="#ul_listPole">...</div>
            <ul class="list-group text-left collapse in" id="ul_listPole">
            <!-- siia kirjutame js failist -->
            </ul>
        </div> <!--pole tööl-->
      </div> <!--parempoolne tulp -->
</div> <!-- row -->
</div> <!-- container -->

<div class="modal" role="dialog" tabindex="-1"  aria-hidden="true" id="aktKood_Modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3 class="modal-title text-center"></h3>
      </div>
      <div class="modal-body">
        <div class="panel panel-info" id="mitteAkt_Paneel">
        </div> <!--panel  -->
      </div><!--modal body -->
      <div class="modal-footer text-center">
        <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Sulge</button>
      </div><!--modal footer -->
    </div><!--modal content -->
  </div><!--modal-dialog -->
</div><!--modal -->

<div class="modal" role="dialog" tabindex="-1"  aria-hidden="true" id="tehtudTood_Modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3 class="modal-title text-center"></h3>
      </div>
      <div class="modal-body">
        <div class="panel panel-info" id="tehtudTood_Paneel">
        </div> <!--panel  -->
      </div><!--modal body -->
      <div class="modal-footer text-center">
        <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Sulge</button>
      </div><!--modal footer -->
    </div><!--modal content -->
  </div><!--modal-dialog -->
</div><!--modal -->



    <div id="myModal" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 class="modal-title">Töötaja nimi. Töö algus 12:00</h3>
          </div>
          <div class="modal-body">
            <form class="form-inline">
              <table>
                <tr>
                  <td>
                    <select name="Leping" id="fLeping" class="col-lg-2 form-control">
                    <?php
                        include ($path .'/config.php');; //votame sealt sql andmed
/*                        $query = "SELECT DISTINCT(LEPNR) FROM JOB ORDER BY LEPNR";
                        $result =sqlsrv_query($conn, $query);
                          while($rows = sqlsrv_fetch_array($result)){
                              echo "<option>". $rows["LEPNR"] . "</option>";
                        }
                        sqlsrv_close($conn); */
                    ?>
                    </select>
                  </td>
                  <td>
                    <select class="col-lg-2 form-control" name="Grupp" id="fGrupp">Plaat</select>
                  </td>
                  <td>
                    <select class="col-lg-2 form-control" name="Job" id="fJob"></select>
                  </td>
                </tr>
              </table>
            </form>
            <div class="modal-footer">
              <div class="keskel_joondus">
                <button type="button" class="btn" data-dismiss="modal" aria-hidden="true">Sulge</button>
                <button type="button" class="btn btn-primary">Salvesta</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div> <!--Modal-->

<div class="modal fade" role="dialog" aria-hidden="true" tabindex="-1" id="markus_Modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3 class="modal-title text-center"></h3>
      </div>
      <div class="modal-body">
        <div class="form-group" id="tehtud_markused_grupp">
        <label >Tehtud märkusd:</label>
        <textarea id="markus_markused"class="form-control" disabled rows="10" style="white-space:pre-wrap;"></textarea>
        </div> <!-- form group -->
        <div class="form-group">
        <label>Lisa märkus:</label>
        <textarea id="markus_uus" class="form-control" rows="3"></textarea>
        </div>
        
      </div><!--modal body -->
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-success" disabled="disabled" data-dismiss="modal" id="markus_salvesta">Salvesta</button>
        <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Sulge</button>
      </div><!--modal footer -->
    </div><!--modal content -->
  </div><!--modal-dialog -->
</div><!--modal -->

<!-- paneme hetke aja kirja -->
<?php
  $_SESSION['kontroll'] = time();
?>
  </body>
</html>