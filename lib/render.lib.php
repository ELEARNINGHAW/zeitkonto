<?php
function renderFaecherListe( $db )
{ $faecherliste = getFaecherListeDB( $db );
  
  $r = '<table  style="width: 100%;   position: relative;" >';
  $r .='<tr style="background-color: #cccccc; padding:5px; position: sticky; top: 0;">
              <th  style="width: 20%;" class="taC head" > Kurz      </th>
              <th  style="width: 50%;" class="taC head" > Name      </th>
              <th  style="width: 10%;" class="taC head" > Typ       </th>
              <th  style="width: 20%;" class="taC head" > Kommentar </th>
              </tr> ' ;
  
  foreach ( $faecherliste  as $fl )
  { $r .= '<tr>
                 <td class="taC">' . $fl[ "Kurz"      ] . ' </td>
                 <td class="taL" onClick = "me( this );" oninput = "setV2DB(  \'fach\'  , \'Name\'       ,  this , \'Kurz\'  ,  \''.  $fl[ "Kurz"  ]. '\'   ); " >' . $fl[ "Name"       ]  . '</td>
                 <td class="taL" onClick = "me( this );" oninput = "setV2DB(  \'fach\'  , \'Typ\'        ,  this , \'Kurz\'  ,  \''.  $fl[ "Kurz"  ]. '\'   ); " >' . $fl[ "Typ"        ]  . '</td>
                 <td class="taL" onClick = "me( this );" oninput = "setV2DB(  \'fach\'  , \'Kommentar\'  ,  this , \'Kurz\'  ,  \''.  $fl[ "Kurz"  ]. '\'   ); " >' . $fl[ "Kommentar"  ]  . '</td>
</tr>';
  }
  $r .= '</table>';
  $r .= '</table>';
 # mysqli_close($db);
  return $r;
}

function renderStudiengangListe( $db )
{ $studiengangliste = getStudiengangListeDB( $db );
  
  $r = '<table   style="width: 100%;   position: relative;" >';
  $r .='<tr style="background-color: #cccccc; padding:5px; position: sticky; top: 0;">
          <th  style="width: 25%;" class="taC head" > Kurz      </th>
          <th  style="width: 50%;" class="taC head" > Name      </th>
          <th  style="width: 25%;" class="taC head" > DepKurz   </th>
         </tr> ' ;
  
  foreach ( $studiengangliste  as $dl )
  { $r .= '<tr>
             <td class="taC"   >' . $dl[ "Kurz"      ] . ' </td>
             <td class="taL" onClick = "me( this );" oninput = "setV2DB(  \'studiengang\'  , \'Name\'  ,  this , \'Kurz\'  ,  \''.  $dl[ "Kurz"  ]. '\'           );   " >' . $dl[ "Name"  ]    .  '</td>
             <td class="taC"   >' . $dl[ "DepKurz"      ] . ' </td>
           </tr>';
  }
  $r .= '</table>';
 # mysqli_close($db);
  return $r;
}


function renderEntlastungsgruendeListe( $db )
{ $entlastungsliste = getEntlastungsgruendeListeDB( $db );
    $r = '<table   style="width: 100%;   position: relative;" >';
    $r .='<tr style="background-color: #cccccc; padding:5px; position: sticky; top: 0;">
          <th  style="width: 25%;" class="taC head" > Grund      </th>
          <th  style="width: 50%;" class="taC head" > Text      </th>
         </tr> ' ;

    foreach ( $entlastungsliste  as $dl )
    { $r .= '<tr>
             <td class="taC"   >' . $dl[ "Grund"      ] . ' </td>
             <td class="taL" onClick = "me( this );" oninput = "setV2DB(  \'auslastungsgrund\'  , \'Text\'  ,  this , \'Grund\'  ,  \''.  $dl[ "Grund"  ]. '\'           );   " >' . $dl[ "Text"  ]    .  '</td>
           </tr>';
    }
    $r .= '</table>';
   # mysqli_close($db);
    return $r;
}


function renderDepartmentListe( $db )
{ $departmentliste = getDepartmentListeDB( $db );
  
  $r = '<table   style="width: 100%;   position: relative;" >';
  $r .='<tr style="background-color: #cccccc; padding:5px; position: sticky; top: 0;">
          <th  style="width: 50%;" class="taC head" > Kurz      </th>
          <th  style="width: 50%;" class="taC head" > Name      </th>
         </tr> ' ;
  
  foreach ( $departmentliste  as $dl )
  { $r .= '<tr>
             <td class="taC">' . $dl[ "Kurz"      ] . ' </td>
             <td class="taL" onClick = "me( this );" oninput = "setV2DB(  \'department\'  , \'Name\'       ,  this , \'Kurz\'  ,  \''.  $dl[ "Kurz"  ]. '\'   ); " >' . $dl[ "Name"       ]  . '</td>
            </tr>';
  }
    $r .= '</table>';
#  mysqli_close($db);
  return $r;
}

function renderDozentenListe( $db )
{ $dozentenliste   = getDozentenListeDB( $db );

    $r = '<table   style="width: 100%;   position: relative;" >';
  $r .='<tr style="background-color: #cccccc; padding:5px; position: sticky; top: 0;">
          <th  style="width: 5%"                  > Kurz    </th>
          <th  style="width: 10%;" class="taC head" > Vorname </th>
          <th  style="width: 15%;" class="taC head" > Name    </th>
          <th  style="width: 10%;" class="taC head" > Ges     </th>
          <th  style="width: 10%;" class="taC head" > Status  </th>
          <th  style="width: 15%;" class="taC head" > Mail    </th>
          <th  style="width: 5%; " class="taC head" > Zust.   </th>
          <th  style="width: 5%;" class="taC head" > Pflicht </th>
         </tr> ' ;





    foreach ( $dozentenliste  as $dl )
  { $r .= '<tr>
             <td class="taL">' . $dl[ "Kurz" ] . ' </td>
             <td class="taL" onClick = "me( this );" oninput = "setV2DB(  \'dozent\'  , \'Vorname\'         ,  this , \'Kurz\'  ,  \''.  $dl[ "Kurz"  ]. '\'    );   " >' . $dl[ "Vorname"                     ] .  '</td>
             <td class="taL" onClick = "me( this );" oninput = "setV2DB(  \'dozent\'  , \'Name\'            ,  this , \'Kurz\'  ,  \''.  $dl[ "Kurz"  ]. '\'    );   " >' . $dl[ "Name"                        ] .  '</td>
             <td class="taL" onClick = "me( this );" oninput = "setV2DB(  \'dozent\'  , \'Geschlecht\'      ,  this , \'Kurz\'  ,  \''.  $dl[ "Kurz"  ]. '\'    );   " >' . $dl[ "Geschlecht"                  ] .  '</td>
             <td class="taL" onClick = "me( this );" oninput = "setV2DB(  \'dozent\'  , \'Status\'          ,  this , \'Kurz\'  ,  \''.  $dl[ "Kurz"  ]. '\'    );   " >' . $dl[ "Status"                      ] .  '</td>
             <td class="taL" onClick = "me( this );" oninput = "setV2DB(  \'dozent\'  , \'Mailadresse\'     ,  this , \'Kurz\'  ,  \''.  $dl[ "Kurz"  ]. '\'    );   " >' . $dl[ "Mailadresse"                 ] .  '</td>
             <td class="taL" onClick = "me( this );" oninput = "setV2DB(  \'dozent\'  , \'Mailzustellung\'  ,  this , \'Kurz\'  ,  \''.  $dl[ "Kurz"  ]. '\', 0 );   " >' . $dl[ "Mailzustellung"              ] .  '</td>
             <td class="taL" onClick = "me( this );" oninput = "setV2DB(  \'dozent\'  , \'Pflicht_weg\'     ,  this , \'Kurz\'  ,  \''.  $dl[ "Kurz"  ]. '\', 0 );   " >' .  number_format( $dl[ "Pflicht_weg" ], 2 ) .  '</td>
            </tr>';
  }



    $r .= '</table>';


    $r .= '<table   style="width: 100%;   position: relative;" >';
    $r .='<tr style="background-color: #cccccc; padding:5px; position: sticky; top: 0;">
          <th  style="width: 5%"                  > Kurz    </th>
          <th  style="width: 10%;" class="taC head" > Vorname </th>
          <th  style="width: 10%;" class="taC head" > Name    </th>
          <th  style="width: 5%;" class="taC head" > Ges     </th>
          <th  style="width: 10%;" class="taC head" > Status  </th>
          <th  style="width: 10%;" class="taC head" > Mail    </th>
          <th  style="width: 5%; " class="taC head" > Zust.   </th>
          <th  style="width: 5%; " class="taC head" > Prof   </th>
          <th  style="width: 5%; " class="taC head" > Department    </th>
          <th  style="width: 5%; " class="taC head" > Zeitkonto  </th>          
          <th  style="width: 10%;" class="taC head" > Pflicht </th>
         </tr> ' ;



    $r .= '<tr>
<form  action = "setV2Db.php">
             <td class="taL"  name=""  ><input type="text" style="width:100%;" name="kurz">           </td>
             <td class="taL"  name=""  ><input type="text" style="width:100%;" name="vorname">        </td>
             <td class="taL"  name=""  ><input type="text" style="width:100%;" name="name">           </td>
             <td class="taL"  name=""  ><input type="text" style="width:100%;" name="geschlecht">     </td>
             <td class="taL"  name=""  ><input type="text" style="width:100%;" name="status">         </td>
             <td class="taL"  name=""  ><input type="text" style="width:100%;" name="mailadresse">    </td>
             <td class="taL"  name=""  ><input type="text" style="width:100%;" name="mailzustellung"> </td>
             <td class="taL"  name=""  ><input type="text" style="width:100%;" name="professur">      </td>
             <td class="taL"  name=""  ><input type="text" style="width:100%;" name="department">     </td>
             <td class="taL"  name=""  ><input type="text" style="width:100%;" name="zeitkonto">      </td>          
             <td class="taL"  name=""  ><input type="text" style="width:40%;"  name="pflicht_weg">    <input type="hidden"  name="action" value="sado"> <input type="submit"  style="width:40%"; value="save"> </td>
 </form> </tr> ';




   # mysqli_close($db);
  return $r;
}


function getRenderLoading( $db  )
{
    $g = checkGetInput( );

echo "<style>
body
{ margin:0;
  padding:0;
  background:#262626;
}
.ring
{ position:absolute;
  top:50%;
  left:50%;
  transform:translate(-50%,-50%);
  width:150px;
  height:150px;
  background:transparent;
  border:3px solid #3c3c3c;
  border-radius:50%;
  text-align:center;
  line-height:150px;
  font-family:sans-serif;
  font-size:20px;
  color:#fff000;
  letter-spacing:4px;
  text-transform:uppercase;
  text-shadow:0 0 10px #fff000;
  box-shadow:0 0 20px rgba(0,0,0,.5);
}
.ring:before
{ content:'';
  position:absolute;
  top:-3px;
  left:-3px;
  width:100%;
  height:100%;
  border:3px solid transparent;
  border-top:3px solid #fff000;
  border-right:3px solid #fff000;
  border-radius:50%;
  animation:animateC 2s linear infinite;
}
span
{ display:block;
  position:absolute;
  top:calc(50% - 2px);
  left:50%;
  width:50%;
  height:4px;
  background:transparent;
  transform-origin:left;
  animation:animate 2s linear infinite;
}
span:before
{ content:'';
  position:absolute;
  width:16px;
  height:16px;
  border-radius:50%;
  background:#fff000;
  top:-6px;
  right:-8px;
  box-shadow:0 0 20px #fff000;
}
@keyframes animateC
{ 0%
  { transform:rotate(0deg);
  }
  100%
  { transform:rotate(360deg);
  }
}
@keyframes animate
{ 0%
  { transform:rotate(45deg);
  }
  100%
  { transform:rotate(405deg);
  }
}
</style>
";
 echo'<div class="ring">RECALC
 <span></span>
</div>';

echo '<script language="javascript" type="text/javascript"> document.location="index.php?action=lad"; </script>';
}

function renderDozentenListeSem( $db, $dozentenliste )
{
  #deb($dozentenliste,1);
  $r = '<table   style="width: 100%;   position: relative;" >';
  $r .='<tr style="background-color: #cccccc; padding:5px; position: sticky; top: 0;">' ;
  $r .='<th  style="width: 5% ;"                  > Kurz     </th>' ;
  $r .='<th  style="width: 10%;" class="taC head" > Vorname  </th>' ;
  $r .='<th  style="width: 15%;" class="taC head" > Name     </th>' ;
  $r .='<th  style="width: 5% ;" class="taC head" > Status   </th>' ;
  $r .='<th  style="width: 5% ;" class="taC head" > Pflicht  </th>' ;
  $r .='<th  style="width: 5% ;"                  > L:E      </th>' ;
  $r .='<th  style="width: 5% ;"                  > Bilanz   </th>' ;
  $r .='<th  style="width: 5% ;"                  > Konto    </th>' ;
  $r .='</tr> ' ;
  
  foreach ( $dozentenliste  as $dl )
  { $r .= '<tr>';
    $r .= '<td class="taL">' . $dl[ "Kurz"    ] . '</td>';
    $r .= '<td class="taC">' . $dl[ "Vorname" ] . '</td>';
    $r .= '<td class="taC">' . $dl[ "Name"    ] . '</td>';
    $r .= '<td class="taC">' . $dl[ "Status"         ] . '</td>';
    $r .= '<td class="taC">' . number_format( $dl[ "Pflicht_weg" ], 2 ) . '</td>';
    $r .= '<td class="taC">';
    $r .= '<span style="width:100%; height:100%; background-color:#EEEEEE; text-decoration: none; text-align: center; padding: 3px;">' . $dl[ "AnzV" ] . '</span>:';
    $r .= '<span style="width:100%; height:100%; background-color:#EEEEEE; text-decoration: none; text-align: center; padding: 3px;">' . $dl[ "AnzE" ] . '</span>';         $r .= '</td>';
    $r .= '<td class="taR"><a style="text-decoration: none;"  target="rechts" href="?action=sb&jahr='   . $_SESSION[ 'aktuell' ][ "jahr" ] . '&semester=' . $_SESSION[ 'aktuell' ][ 'semester' ]  . '&dozentKurz=' . $dl[ "Kurz" ] . '&output=html"><span style="width:100%; height:100%; background-color:#EEEEEE; text-decoration: none; text-align: center;">' .  number_format(  $dl['aktuell']['saldo'     ]  ,2 ) . '</span></a> <a style="text-decoration: none;"  target="rechts" href="?action=sb&jahr='   . $_SESSION[ 'aktuell' ][ "jahr" ] . '&semester=' . $_SESSION[ 'aktuell' ][ 'semester' ]  . '&dozentKurz=' . $dl[ "Kurz" ] . '&output=pdf" ><span style="width:100%; height:100%; background-color:#EEEEEE; text-decoration: none; text-align: center;">p</span></a> </td>';
    $r .= '<td class="taR"><a style="text-decoration: none;"  target="rechts" href="?action=azkt&jahr=' . $_SESSION[ 'aktuell' ][ "jahr" ] . '&semester=' . $_SESSION[ 'aktuell' ][ 'semester' ]  . '&dozentKurz=' . $dl[ "Kurz" ] . '&output=html"><span style="width:100%; height:100%; background-color:#EEEEEE; text-decoration: none; text-align: center;">' .  number_format(  $dl['aktuell']['saldoTotal']  ,2 ) . '</span></a> <a style="text-decoration: none;"  target="rechts" href="?action=azkt&jahr=' . $_SESSION[ 'aktuell' ][ "jahr" ] . '&semester=' . $_SESSION[ 'aktuell' ][ 'semester' ]  . '&dozentKurz=' . $dl[ "Kurz" ] . '&output=pdf" ><span style="width:100%; height:100%; background-color:#EEEEEE; text-decoration: none; text-align: center;">p</span></a>  </td>';
    $r .= '</tr>';
  }
  $r .= '</table>';
  #mysqli_close($db);
  return $r;
}

function renderStundenbilanz( $db, $dozentKurz, $jahr, $semester, $onlyData = false , $output = 'html' )
{
  $dozent = getDozentDB( $db, $dozentKurz );
 #   deb('1'); deb($dozent);
  $dozent[ 'aktuell' ][ 'veranstaltungsliste' ]  =  getVeranstaltungslisteDB( $db, $dozentKurz, $jahr, $semester );
 #   deb('2'); deb($dozent[ 'aktuell' ][ 'veranstaltungsliste' ] );
  $dozent[ 'aktuell' ][ 'entlastungsliste'    ]  =  getEntlastungslisteDB(    $db, $dozentKurz, $jahr, $semester );
 #   deb('3'); deb( $dozent[ 'aktuell' ][ 'entlastungsliste'    ]  );
  $dozent[ 'aktuell' ][ 'dozentLV'            ]  =  getDozentLVDB(            $db, $dozentKurz, $jahr, $semester );
 #   deb('4'); deb( $dozent[ 'aktuell' ][ 'dozentLV'            ] );
  $dozent[ 'aktuell' ][ 'beteiligung'         ]  =  getBeteiligungslisteDB(   $db, $dozent[ 'aktuell' ][ 'veranstaltungsliste' ] );
 #  deb('5'); deb($dozent[ 'aktuell' ][ 'beteiligung'         ]  );
  $dozent[ 'aktuell' ][ 'dozentLV'            ] +=  calcStundenbilanz(        $dozent );
  #deb(  $dozent[ 'aktuell' ][ 'entlastungsliste'    ]   ,1);
  if ( $onlyData )
  { $stundenbilanz = $dozent[ 'aktuell' ];
  }

  else
  { $stundenbilanz = renderZeitkontoProf( $dozent ,  $output );
  }

  return $stundenbilanz;
}

function calcStundenbilanz( $dozent )
{ $stunden = array();
  $stunden[ 'veranstaltungssumme' ] = 0;
  $stunden[ 'entlastungsumme1'    ] = 0;
  $stunden[ 'saldo'               ] = 0;

  foreach ($dozent['aktuell']['veranstaltungsliste'] as $vl )
  { $stunden[ 'veranstaltungssumme' ]  += ( $vl['LVS'] *  $vl['T']  *$vl['B'] );
  }
  foreach ($dozent['aktuell']['entlastungsliste'] as $vl )
  {
    if($vl[ 'Grund' ] == 'B' AND $vl[ 'LVS' ] > 4  )  { $vl['LVS-orig'] = $vl['LVS']; $vl['LVS'] = 4; }
       $stunden[ 'entlastungsumme1' ]  += ( $vl['LVS']  );
  }

  $stunden[ 'summeLuE' ] = $stunden[ 'entlastungsumme1' ]  +  $stunden[ 'veranstaltungssumme' ];
  $stunden[ 'saldo'    ] = $stunden[ 'entlastungsumme1' ]  +  $stunden[ 'veranstaltungssumme' ] - $dozent[ 'aktuell']['dozentLV'][ 'Pflicht' ];
  return $stunden;
}

function renderZeitkontoProf($dozent, $output = 'html' )
{
$html = '
<table style="width: 100%; height: 50px;  border-spacing: 0"><tr>
 <td style="border-bottom: 0 solid white; padding: 0;" > <div class="headertxt">Hochschule für Angewandte Wissenschaften<br/>Fakultät Life Sciences<br/>Dekanat</div><br>' .  date("d.m.Y")  .'   </td>
 <td style="text-align: right ; border-bottom: 0 solid white; padding: 0; ">  <img width="160;" alt="haw-logo"   src="img/HAW_Marke_grau_RGB.png"  > </td>
</tr></table>
<br>
<br> 
<div class="betrefftxt" >aktuelle Stundenbilanz für das Semester '. $dozent["aktuell"]["dozentLV"]["Semester"]  .' '  . $dozent["aktuell"]["dozentLV"]["Jahr"]  .'   </div>';


$html .=  '<div class="fliestxt" >' .$dozent["Anrede"].' '.$dozent["Name"].', <br/><br/> hiermit erhalten Sie die aktuelle Stundenbilanz für das zurückliegende Semester.</div><br/>' ;
$html .= '<table   style="width: 100%;"  >
<tr style="background-color: #cccccc;"   >
<td style="width: 90%"                   > </td>
<td style="width: 10%;" class="taC head" > Ihre LVS </td></tr>
<tr><td class="taL sum">Summe der Lehrveranstaltungen und Entlastungen:</td><td class="taC sum" >'.  number_format( $dozent[ "aktuell" ][ "dozentLV" ][ 'summeLuE' ] , 2 ) .'</td></tr>
<tr><td class="taL"    >Ihre Lehrverpflichtung:                        </td><td class="taC"     >'.  number_format( $dozent[ "aktuell" ][ "dozentLV" ][ 'Pflicht'  ] , 2 ) .'</td></tr>
<!--tr><td class="taL sal"><a href="index.php?action=azkt&dozentKurz='. $dozent["aktuell"]["dozentLV"]["DozKurz"]  .'&output=html">Ihr Saldo im Semester '. $dozent["aktuell"]["dozentLV"]["Semester"]  .' '  . $dozent["aktuell"]["dozentLV"]["Jahr"]  .' beträgt:</a> </td><td class="taC sal" >'.  number_format( $dozent[ "aktuell" ][ "dozentLV" ][ 'saldo'    ] , 2 ) .'</td></tr-->
<tr><td class="taL sal">Ihr Saldo im Semester '. $dozent["aktuell"]["dozentLV"]["Semester"]  .' '  . $dozent["aktuell"]["dozentLV"]["Jahr"]  .' beträgt:</td><td class="taC sal" >'.  number_format( $dozent[ "aktuell" ][ "dozentLV" ][ 'saldo'    ] , 2 ) .'</td></tr>

</table>';


$html .=  '<br/><div class="fliestxt"> Wir haben im Einzelnen für Sie folgende Leistungen notiert:</div><br/>';

$html .=  generateLuETable( $dozent );

$html .=  '<div class="fliestxt"><br/>
Ihr Überstundenkonto der letzten Jahre oder Ihr Arbeitszeitkonto wird Ihnen gesondert zugestellt.<br/>
Für weitere Fragen stehe ich Ihnen gerne zur Verfügung.<br/><br/>
Mit freundlichen Grüßen<br/>
Martin Holle, Prodekan LS
</div>';
  
$html .=  '<img width="300;" alt="sign-holle" src="img/sign-holle.png">';
if ($output == 'html')
$html .=  generateBeteiligung( $dozent );

return $html;
}

function renderZeitkontoTotalProf($arbeitszeitliste)
{
$html = '
<table style="width: 100%; height: 50px;  border-spacing: 0"><tr>
 <td style="border-bottom: 0 solid white; padding: 0;" > <div class="headertxt">Hochschule für Angewandte Wissenschaften<br/>Fakultät Life Sciences<br/>Dekanat</div><br>' .  date("d.m.Y")  .'   </td>
 <td style="text-align: right ; border-bottom: 0 solid white; padding: 0; ">  <img width="160;" alt="haw-logo"   src="img/HAW_Marke_grau_RGB.png"  > </td>
</tr></table>
<br>
<br> 
  <div class="betrefftxt" >aktueller Stand des Arbeitszeitkontos für das Semester '. $arbeitszeitliste["aktuell"]["Semester"]  .' '  . $arbeitszeitliste["aktuell"]["Jahr"]  .'   </div>';
    $html .=  '<div class="fliestxt" >' .$arbeitszeitliste["aktuell"]["Anrede"].' '.$arbeitszeitliste["aktuell"]["Name"].', <br/><br/> hiermit erhalten Sie den aktuellen Stand Ihres Zeitkontos für das zurückliegende Semester.</div><br/>' ;
    $html .=  generateAZKTTable( $arbeitszeitliste );
    $html .=  '<br/><div class="fliestxt">Der aktuelle Stand Ihres Arbeitszeitkontos beträgt  '.$arbeitszeitliste["aktuell"]["saldoTotal"].' Stunden.</div><br/>';
    $html .=  '<div class="fliestxt"><br/>
Bitte beachten Sie, dass das Arbeitszeitkonto auf 36 Stunden begrenzt ist.<br/>
Darüber hinaus geleistete Stunden können nicht in das Arbeitszeitkonto übernommen werden.<br/><br/>

Für weitere Fragen stehe ich Ihnen gerne zur Verfügung.<br/><br/>
Mit freundlichen Grüßen<br/>
Martin Holle, Prodekan LS
</div>';
    $html .=  '<img width="300;" alt="sign-holle" src="img/sign-holle.png">';
    return $html;
}

function generateLuETable( $dozent )
{  $r = '<div style="position: absolute; left:50%; top:100px; padding: 10px;  border: solid black 1px; font-family: Arial, sans-serif;  font-size  : 12px; background-color: #FAFAFA; display: none;"  id="livesearch"> </div>
<table  style="width: 100%;" >';
  $r .='<tr style="background-color: #cccccc; padding:5px;">
        <td  style="width: 50%"           > Titel der Veranstaltung </td>
        <td  style="width: 5%; " class="taC head" > T      </td>
        <td  style="width: 5%; " class="taC head" > B      </td>
        <!-- td  style="width: 3%; " class="taC head" > K      </td -->
        <td  style="width: 10%;" class="taC head" > Gruppe </td>
        <td  style="width: 10%;" class="taC head" > LVS V  </td>
        <td  style="width: 10%;" class="taC head" > Anteil </td>
        <td  style="width: 10%;" class="taC head" > Ihre LVS    </td></tr> ' ;
  
  foreach ( $dozent["aktuell"]["veranstaltungsliste"]   as $t )
  {  $r .= '<tr> <td class="taL" id = "'. strtr( $t[ "Fach" ], ' ', '_' ) .'" onClick = "me( this );" oninput = "showResult(this, \'' .  $t[ "Fach" ] .'\' ); "  >' . $t[ "FachL"] . ' (' .  $t[ "Fach" ] .') </td>
            <td class="taC">' . $t[ "T"] . '                               </td>
            <td class="taC">' . number_format( $t[ "B" ], 1 )  . '                               </td>
            <!-- td class="taC">' . $t[ "K"] . '                               </td-->
            <td class="taC">' . $t[ "Studiengang"] . '                     </td>   
            <td class="taC">' . number_format( $t[ "SWS" ], 2 ) . '</td>                 
            <td class="taC">' . $t[ "Anteil"] . '%                         </td>
            <td class="taC">' . number_format( ($t[ "LVS" ] * $t[ "T" ] * $t[ "B" ]  ), 2 ) . '</td></tr> '    ;
  }

  $r .='</table>';
  $r .= '<div class="fliestxt" >&nbsp; (T = Teilgruppen, B = Betreuungsfaktor, LVS V = LVS der Veranstaltung )  </div>';
  $r .= '<br/><table  style="width: 100%;" >';

  $r .= '<tr style="background-color: #cccccc; padding:5px;">
         <td  colspan="7"  style="width: 90%"    > Titel der Entlastung </td>
         <td  style="width: 10%;" class="taC head" > Ihre LVS </td></tr> ' ;
  
  foreach ( $dozent['aktuell']['entlastungsliste']  as $t )
  {
    if (isset( $t[ "LVS-orig" ]   ) AND $t[ "Grund" ] == 'B'  )
    { $t[ "auslastungsGrund" ] = $t[ "auslastungsGrund" ] .' = '.  $t[ "LVS-orig" ]. ' LVS  - Kappung nach § 7(2) LVVO auf maximal: ';
    }
    $r .= '<tr> <td colspan="7">' . $t[ "auslastungsGrund" ] . '</td>  <td  class="taC">' .  number_format( $t[ "LVS" ], 2) . '</td></tr> ' ;
  }


  $r .= '<tr><td colspan="7" class="sum"> Summe der Lehrveranstaltungen und Entlastungen: </td>  <td class="taC sum"> ' .    number_format($dozent["aktuell"][ "dozentLV" ][ "summeLuE" ]  , 2) . '</td></tr>' ;
  $r .= '</table>';

  return $r;
}

function generateBeteiligung( $dozent )
{
  $r =  '<div style="page-break-before:always;"></div>';
  $r .=  '<div  class="fliestxt">Anteile bei Veranstaltung mit Beteiligung</div><br/>';

  foreach ( $dozent["aktuell"]["beteiligung"]   as $beteiligung )
  {  $anteilGesamt = 0;
     $LVSGesamt = 0;

        $r .= '<table  style="width: 100%;" >';
        $r .='<tr style="background-color: #cccccc; padding:5px;">
              <td  style="width: 60%"                   >  ' . $beteiligung[0][ "FachL"] . ' (' .  $beteiligung[0][ "Fach" ] .')  ' . $beteiligung[0][ "Studiengang"] . ' </td>
              <td  style="width: 10%;" class="taC head" > Anteil </td>
              <td  style="width: 10%;" class="taC head" > LVS </td></tr> ' ;

        foreach ($beteiligung as $t )
        {
            $anteilGesamt += $t[ "Anteil"];
            $LVSGesamt += $t[ "LVS"];
        $r .= '<tr> <td class="taL" id = "'. strtr( $t[ "Fach" ], ' ', '_' ) .'" onClick = "me( this );" oninput = "showResult(this, \'' .  $t[ "Fach" ] .'\' ); "  >  '. $t['dozent'][ "Vorname" ]. '  '. $t['dozent'][ "Name" ]  .'  </td>
                 
                 <td class="taC">' . $t[ "Anteil"] . '% </td>
                 <td class="taC">' . number_format( $t[ "LVS" ], 2 ) . '</td></tr> '    ;

        }

        $r .= '<tr><td  class="sum"> Summe der Anteile und LVS: </td>  <td class="taC sum"> ' .    $anteilGesamt . '%</td><td class="taC sum">' .  number_format($LVSGesamt , 2) . '</td></tr>' ;
        $r .= '</table><br>';
    }
    return $r;
}

function generateAZKTTable( $dozent )
{ $r = '<table  style="width: 100%;" >';
  $r .='<tr style="background-color: #cccccc; padding:5px;">
            <td  style="width: 20%"  class="taC head" >Semester  </td>
            <td  style="width: 15%;" class="taR head" >Stunden   </td>
            <td  style="width: 15%;" class="taR head" >Pflicht   </td>
            <td  style="width: 15%;" class="taR head" >Saldo     </td>
            <td  style="width: 15%;" class="taR head" >Summe     </td>
            <td  style="width: 20%;" class="taR head" >Kommentar </td>
          </tr> ' ;

  unset( $dozent[ 'aktuell' ] );


  foreach ( $dozent   as $dVL )
  {
    $d = $dVL['dozentLV'];
    $r .= '<tr> 
           <td class="taC"><a href="http://localhost/zeitkonto/index.php?action=sb&jahr='. $d[ "Jahr"  ] . '&semester='.  $d[ "Semester" ] .'&dozentKurz='. $d[ "DozKurz"  ] . '&output=html">' .   $d[ "Jahr"   ]   . ' (' .  $d[ "Semester" ] .') </a> </td>
           <td class="taR">' . number_format( $d[ "summeLuE"   ] ,2 ) . ' </td>
           <td class="taR">' . number_format( $d[ "Pflicht"    ] ,2 ) . ' </td>
           <td class="taR">' . number_format( $d[ "saldo"      ] ,2 ) . ' </td>
           <td class="taR">' . number_format( $d[ "saldoTotal" ] ,2 )  . ' </td>
           <td class="taR">' .                $d[ "Kommentar"  ] . ' </td>
           </tr> '    ;
    }
    $r .= '</table>';
    return $r;
}


function init()
{ $_SESSION[ 'aktuell' ][ 'jahr'     ] = 2023;
  $_SESSION[ 'aktuell' ][ 'semester' ] = 'S';
  renderMainSide();
}

function renderMainSide()
{
$html ='
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
.dropbtn
{ font-family: Arial, sans-serif;
  background-color: #EFEFEF;
  color: black;
  font-size: 22px;
}

.dropdown 
{ position: relative;
  display: inline-block;
  font-family: Arial, sans-serif;
  font-size: 25px;
  margin-left: 15px;
}

.dropdown-content 
{ display: none;
  position: absolute;
  background-color: #f1f1f1;
  min-width: 160px;
  box-shadow: 0 8px 16px 0 rgba( 0 , 0 , 0 , 0.2 );
  z-index: 1;
}

.dropdown-content a 
{ font-family: Arial, sans-serif;
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

.dropdown-content a:hover         { background-color: #ddd    ; }
.dropdown:hover .dropdown-content { display         : block   ; }
.dropdown:hover .dropbtn          { background-color: #EEEEEE ; }

</style>
</head>
<body style="background-color:white;">

<div class="dropdown" style="width: 49%;">
  <div class="dropbtn"  id="Button2" >Basis Tabellen</div>
  <div class="dropdown-content">
    <a href="index.php?action=edoz"  target="rechts"  onclick="document.querySelector(\'#Button2\').innerHTML = \'Dozenten\'   ; ">Dozenten     </a>
    <a href="index.php?action=ef"    target="rechts"  onclick="document.querySelector(\'#Button2\').innerHTML = \'Fach\'       ; ">Fach         </a>
    <a href="index.php?action=esg"   target="rechts"  onclick="document.querySelector(\'#Button2\').innerHTML = \'Studiengang\'; ">Studiengang  </a>
    <a href="index.php?action=edep"  target="rechts"  onclick="document.querySelector(\'#Button2\').innerHTML = \'Department\' ; ">Department   </a>
    <a href="index.php?action=eeg"   target="rechts"  onclick="document.querySelector(\'#Button2\').innerHTML = \'Entlastung\' ; ">Entlastung   </a>
  </div>
</div>

<div class="dropdown" >
  <div class="dropbtn" id="Button1">2023 S</div>
  <div class="dropdown-content">
    <a href="index.php?action=ad&jahr=2024&semester=S"  target="links" onclick="document.querySelector(\'#Button1\').innerHTML = \'2024 S\'; ">2024 S</a>
    <a href="index.php?action=ad&jahr=2024&semester=W"  target="links" onclick="document.querySelector(\'#Button1\').innerHTML = \'2024 W\'; ">2024 W</a>
    <a href="index.php?action=ad&jahr=2023&semester=S"  target="links" onclick="document.querySelector(\'#Button1\').innerHTML = \'2023 S\'; ">2023 S</a>
    <a href="index.php?action=ad&jahr=2022&semester=W"  target="links" onclick="document.querySelector(\'#Button1\').innerHTML = \'2022 W\';" >2022 W</a>
    <a href="index.php?action=ad&jahr=2022&semester=S"  target="links" onclick="document.querySelector(\'#Button1\').innerHTML = \'2022 S\';" >2022 S</a>
    <a href="index.php?action=ad&jahr=2021&semester=W"  target="links" onclick="document.querySelector(\'#Button1\').innerHTML = \'2021 W\';" >2021 W</a>
    <a href="index.php?action=ad&jahr=2021&semester=S"  target="links" onclick="document.querySelector(\'#Button1\').innerHTML = \'2021 S\';" >2021 S</a>
    <a href="index.php?action=ad&jahr=2020&semester=W"  target="links" onclick="document.querySelector(\'#Button1\').innerHTML = \'2020 W\';" >2020 W</a>
    <a href="index.php?action=ad&jahr=2020&semester=S"  target="links" onclick="document.querySelector(\'#Button1\').innerHTML = \'2020 S\';" >2020 S</a>
    <a href="index.php?action=ad&jahr=2019&semester=W"  target="links" onclick="document.querySelector(\'#Button1\').innerHTML = \'2019 W\';" >2019 W</a>
    <a href="index.php?action=ad&jahr=2019&semester=S"  target="links" onclick="document.querySelector(\'#Button1\').innerHTML = \'2019 S\';" >2019 S</a>
    <a href="index.php?action=ad&jahr=2018&semester=W"  target="links" onclick="document.querySelector(\'#Button1\').innerHTML = \'2018 W\';" >2018 W</a>
    <a href="index.php?action=ad&jahr=2018&semester=S"  target="links" onclick="document.querySelector(\'#Button1\').innerHTML = \'2018 S\';" >2018 S</a>
  </div>
</div>

';
  $html .= '<iframe style="position: absolute; top:40px; left:10px; height: calc(100% - 50px) ; width: calc(50% - 20px); border: 1px black solid;"  name="rechts" src="index.php?action=ss"></iframe>';
  $html .= '<iframe style="position: absolute; top:40px; left: 50%; height: calc(100% - 50px) ; width: calc(50% - 20px); border: 1px black solid;"  name="links"  src="index.php?action=ad"></iframe>';

  $html .= '</body></html>';
  echo $html;
}

function getRenderSplashscreen()
{
$html ='
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">

</head>
<body style="background-color:white;">

<style> 
.object-fit   
{ width: 400px; height: 300px; margin: 4em auto;  border:1px solid green;
  position: absolute; left: 50%; top: 40%;  -webkit-transform: translate(-50%, -50%); transform: translate(-50%, -50%); 
} 
.object-fit img { object-fit: cover; width:  100%; height: 100%;}  </style>
<div class="object-fit" style="text-align:center;"> <img 
src="img/splashscreen.png" alt="splashscreen"> </div>
</body></html>';

echo $html;
}

function getRenderLoginscreen()
{
$html ='
<!DOCTYPE html>
<html lang="de" >
<head>
<meta charset="UTF-8">
<title>Login Form</title>
<style>
@import url("https://fonts.googleapis.com/css?family=Raleway:400,700");
*, *:before, *:after
{ box-sizing: border-box;
}

body
{ min-height: 100vh;
  font-family: "Raleway", sans-serif;
}

.container
{ position: absolute;
  width: 100%;
  height: 100%;
  overflow: hidden;
}

.container:hover .top:before, .container:hover .top:after, .container:hover .bottom:before, .container:hover .bottom:after, .container:active .top:before, .container:active .top:after, .container:active .bottom:before, .container:active .bottom:after
{ margin-left: 200px;
  transform-origin: -200px 50%;
  transition-delay: 0s;
}

.container:hover .center, .container:active .center
{ opacity: 1;
  transition-delay: 0.2s;
}

.top:before, .top:after, .bottom:before, .bottom:after
{ content: "";
  display: block;
  position: absolute;
  width: 200vmax;
  height: 200vmax;
  top: 50%;
  left: 50%;
  margin-top: -100vmax;
  transform-origin: 0 50%;
  transition: all 0.5s cubic-bezier(0.445, 0.05, 0, 1);
  z-index: 10;
  opacity: 0.65;
  transition-delay: 0.2s;
}

.top:before
{ transform: rotate(45deg);
  background: #000000;
}
.top:after
{ transform: rotate(135deg);
  background: #aaa;
}

.bottom:before
{ transform: rotate(-45deg);
  background: #ccc;
}

.bottom:after
{ transform: rotate(-135deg);
  background: #eee;
}

.center
{ position: absolute;
  width: 400px;
  height: 400px;
  top: 50%;
  left: 50%;
  margin-left: -200px;
  margin-top: -200px;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  padding: 30px;
  opacity: 0;
  transition: all 0.5s cubic-bezier(0.445, 0.05, 0, 1);
  transition-delay: 0s;
  color: #333;
}

.center input
{ width: 100%;
  padding: 15px;
  margin: 5px;
  border-radius: 1px;
  border: 1px solid #ccc;
  font-family: inherit;
}
</style>
<script>
  window.console = window.console || function(t) {};
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>
</head>
<body translate="no">
  <div class="container" onclick="onclick">
  <div class="top"></div>
  <div class="bottom"></div>
  <div class="center">
    <h2>Bitte einloggen</h2>
    <input type="email" placeholder="email"/>
    <input type="password" placeholder="password"/>
    <h2>&nbsp;</h2>
  </div>
</div>
</body>
/html>
';
echo $html;
}