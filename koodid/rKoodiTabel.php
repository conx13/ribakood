
    <script src="rKoodiTabel.js"></script>
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-lg-offset-2" id="sisuTabel">
          <div class="rInfo alert alert-warning text-center">asSasa</div>
            <div id="load_pic" style="position:absolute;margin-left:50%"><img src="../images/ajax-loader2.gif" /></div>
              <?php
                $otsi="";
                $path = $_SERVER['DOCUMENT_ROOT'];
                //Tekitame sql-i
                if (!($_GET["oLeping"]=="") && (!($_GET["oText"]=="")) && (!($_GET["oLeht"]==""))){
                  $oLeping=$_GET["oLeping"];
                  $oText=$_GET["oText"];
                  $oLeht=$_GET["oLeht"];
                  if ($oLeht==1){
                    $oRalgus=1;
                    $oRlopp=21;
                  }else{
                    $oRalgus=(($oLeht-1)*20+1);
                    $oRlopp=($oLeht*20)+1;
                  }
                  $params=array($oLeping,$oText,$oText,$oText,$oText,$oRalgus, $oRlopp);
                  include ($path .'/config.php'); //votame sealt sql andmed
                  $query ="SELECT * FROM ";
                  $query .="(SELECT Row_Number() OVER (ORDER by JID desc) as RowIndex, LEPNR, GNIMI, JOB, JID, IKOOD, Y, KOGUS, Markus ";
                  $query .="FROM JOB1 WHERE (LEPNR LIKE ?) AND ((JOB LIKE ?) OR(GNIMI LIKE ?) OR (JID LIKE ?) OR (IKOOD LIKE ?))) as Sub ";
                  $query .="WHERE Sub.RowIndex >= ? and Sub.RowIndex < ?";
                  $result =sqlsrv_query($conn, $query,$params);
                  if( $result === false ) {
                    echo ( "<div class='alert alert-danger'>"); 
                    print_r(sqlsrv_errors());
                    echo ( "</div>"); 
                    die();

                  };
                }else{
                  echo "<div class='alert alert-danger'>";
                  echo "<button type='button' class='close' data-dismiss='alert'>&times;</button>";
                  echo "Otsingu parameetrid on tühjad!.";
                  echo "</div>";
                  //echo "ei otsi";
                }
                if (sqlsrv_has_rows( $result )===false) { //kui ei ole andmeid siis näitame hoiatust
                  echo "<script>poleMiskit()</script>"; //näitame errorit js failist.
                }else{
              ?>
              <table class="table table-condensed table-hover table-bordered jooneta" id="sTabel">
                <thead>
                  <th width="10%">LepNr</th>
                  <th width="25%">GNimi</th>
                  <th>Töö</th>
                  <th width="10%">Ribakood</th>
                  <th width="5%">Ühik</th>
                  <th width="7%">Kogus</th>
                  <!--<th style="background-color: white" width="13%"></th> -->
                </thead>
              <tbody>
              <?php
                  while($row = sqlsrv_fetch_array($result)) //kui on miskit, siis täitame tabeli
                  {
                    echo "<tr class='rida' id=". $row["JID"] . ">";
                    echo "<td class='rData'>" . $row["LEPNR"] . "</td>";
                    echo "<td class='rData'>" . $row["GNIMI"] . "</td>";
                    echo "<td class='rData'><div class='peida1 pull-right'><a href='#'><i title='Märkus' class='icon-comment-alt rMarkus tume'></i></a></div><div class='peida1 pull-right'><a href='#'><i title='Muuda' class='icon-edit rMuuda tume'></i></a><a href='#'><i class='icon-trash rKustuta' rel='popover'></i></a><a href='../PrintKoodid.php?kood=".$row["JID"]."' target='_blank'><i class='icon-print tume' title='Trüki'></i></a></div>" . $row["JOB"] . "</td>";
                    echo "<td class='rData'>" . $row["IKOOD"] . "</td>";
                    echo "<td class='rData'>" . $row["Y"] . "</td>";
                    echo "<td class='rData'>" . $row["KOGUS"] . "</td>";
                    echo "<td class='hidden'>" . $row["Markus"] . "</td>";
                    echo "</tr>";
                  } //while
                } //if
              //sqlsrv_close($conn)
              ?>
            </tbody>
          </table>
        </div> <!-- span8 -->
      </div> <!--row-->
    </div> <!--container-->

    <!--Modal kustutamise form -->
    <div class="modal" id="modalKustuta">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3 class="modal-title">Kas kustutame rea?</h3>
          </div>
          <div class="modal-body">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-sm btn-default laius2" data-dismiss="modal">Tühista</button>
            <button type="submit" class="btn btn-sm btn-danger laius2" id="mKustuta"><i class='icon-trash'>  </i>Kustuta</button>
          </div>
        </div>
      </div>
    </div>

<!-- Kustutamise üle küsimise aken -->
<div class='hide' id='kustuta'>
    <button class="btn btn-success btn-xs kinni">Tühista!</button>
    <button class="btn btn-danger btn-xs delete">Kustuta!</button>
</div>
    
  <!-- Muutmise modal form   -->
  <div class="container">
      <div class="modal" id="modalMuuda" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modalLai">
        <div class="modal-content">
          <div class="modal-header text-center">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3 id="modal-title">Muudame rida.</h3>
          </div> <!--modalheader -->
            <form class="form-inline" id="fMuuda" role="form "metod="POST">
              <div class="modal-body text-center">
                <input type="hidden" id="mID">
                  <div class="form-group laius2">
                    <label class="sr-only" for="Leping">Leping</label>
                    <input type="text" class="form-control input-sm" id="mLepNr" name="nLepnr" placeholder="Lep Nr">
                  </div>
                  <div class="form-group laius3">
                    <label class="sr-only" for="Grupp">Grupp</label>
                    <select class="form-control input-sm" id="muudaGrupp" name="nGrupp">
                    <?php
                      include ($path .'/config.php'); //votame sealt sql andmed
                      $query = "SELECT GID, GNIMI ";
                      $query .= "FROM GRUPP ";
                      $query .= "ORDER BY GID";
                      $result =sqlsrv_query($conn, $query);
                      while($row = sqlsrv_fetch_array($result)) { //kui on miskit, siis täitame tabeli
                        echo "<option value='" . $row["GID"] . "'> ". $row["GNIMI"] . "</option>";
                      }
                    ?>  
                    </select>
                  </div>
                  <div class="form-group laius3">
                    <label class="sr-only" for="Job">Töö</label>
                    <input type="text" class="form-control input-sm" id="mToo" name="nToo" placeholder="Töö">
                  </div>
              <div class="form-group laius2">
                <label class="sr-only" for="Ühik">Ühik</label>
                <select class="form-control input-sm" id="mYhik" name="nYhik"  placeholder="Ühik">
                  <option></option>
                  <option>m2</option>
                  <option>m3</option>
                  <option>jm</option>
                  <option>tk</option>
                </select>
              </div>
              <div class="form-group laius2">
                <input type="text" class="form-control input-sm" id="mKogus" name="nKogus"  placeholder="Kogus">
              </div>
          </div> <!--modal-body-->
          <div class="modal-footer">
            <button type="button"class="btn btn-default btn-sm laius2" data-dismiss="modal" aria-hidden="true">Tühista</button>
            <input type="submit" id="nuppMuuda" class="btn btn-sm btn-success laius2" value="Kinnita" />
          </div> <!--modal-footer-->
            </form>
        </div> <!--modal-content-->
      </div> <!--modal-dialog-->
    </div> <!--modalMuuda--> 
    </div> <!-- Container Modal --> 

  <!-- Märkuste lisamise modal -->
  <div class="modal fade" id="markus_Modal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h3 class="modal-title text-center"></h3>
        </div> <!-- modal header -->
        <div class="modal-body">
          <div class="form-group" id="tehtud_markused_grupp">
            <label >Märkused:</label>
            <textarea id="markus_markused"class="form-control" rows="10" style="white-space:pre-wrap;"></textarea>
          </div> <!-- form group --> 
          <div class="form-group">
            <label>Lisa märkus:</label>
            <textarea id="markus_uus" class="form-control" rows="3"></textarea>
          </div>
        </div><!--modal body -->
        <div class="modal-footer">
          <button type="button" class="btn btn-sm btn-success" disabled="disabled" data-dismiss="modal" id="markus_salvesta">Salvesta</button>
          <button type="button" class="btn btn-sm btn-primary" disabled="disabled" data-dismiss="modal">Sulge</button>
        </div><!--modal footer -->
      </div> <!-- modal content -->
    </div> <!-- modal dialog -->
  </div> <!-- Märkus Modal -->
