<?php
function renderFaecherListe( $db )
{
  $faecherliste = getFaecherListeDB( $db );
  
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
  mysqli_close($db);
  return $r;
}

function renderStudiengangListe( $db )
{
  $studiengangliste = getStudiengangListeDB( $db );
  
  $r = '<table   style="width: 100%;   position: relative;" >';
  $r .='<tr style="background-color: #cccccc; padding:5px; position: sticky; top: 0;">
          <th  style="width: 25%;" class="taC head" > Kurz      </th>
          <th  style="width: 50%;" class="taC head" > Name      </th>
          <th  style="width: 25%;" class="taC head" > DepKurz      </th>
         </tr> ' ;
  
  foreach ( $studiengangliste  as $dl )
  { $r .= '<tr>
             <td class="taC"   >' . $dl[ "Kurz"      ] . ' </td>
             <td class="taL" onClick = "me( this );" oninput = "setV2DB(  \'studiengang\'  , \'Name\'  ,  this , \'Kurz\'  ,  \''.  $dl[ "Kurz"  ]. '\'           );   " >' . $dl[ "Name"  ]    .  '</td>
             <td class="taC"   >' . $dl[ "DepKurz"      ] . ' </td>
           </tr>';
  }
  $r .= '</table>';
  mysqli_close($db);
  return $r;
}

function renderDepartmentListe( $db )
{
  $departmentliste = getDepartmentListeDB( $db );
  
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
  mysqli_close($db);
  return $r;
}

function renderDozentenListe( $db )
{
  $dozentenliste   = getDozentenListeDB( $db );
  
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
  mysqli_close($db);
  return $r;
}

function
renderDozentenListeSem( $db )
{
  $dozentenliste   = getDozentenListeSemDB( $db );

  $r = '<table   style="width: 100%;   position: relative;" >';
  $r .='<tr style="background-color: #cccccc; padding:5px; position: sticky; top: 0;">' ;
  $r .='<th  style="width: 5% ;"                  > Kurz     </th>' ;
  $r .='<th  style="width: 10%;" class="taC head" > Vorname  </th>' ;
  $r .='<th  style="width: 15%;" class="taC head" > Name     </th>' ;
  $r .='<th  style="width: 5% ;" class="taC head" > Status   </th>' ;
  $r .='<th  style="width: 5% ;" class="taC head" > Pflicht  </th>' ;
  $r .='<th  style="width: 5% ;"                  > L:E      </th>' ;
  $r .='<th  style="width: 5% ;"                  > Konto    </th>' ;
  $r .='<th  style="width: 5% ;"                  > Bilanz   </th>' ;
  $r .='</tr> ' ;
  
  foreach ( $dozentenliste  as $dl )
  {
    $r .= '<tr>';
    $r .= '<td class="taL">' . $dl[ "Kurz"    ] . '</td>';
    $r .= '<td class="taC">' . $dl[ "Vorname" ] . '</td>';
    $r .= '<td class="taC">' . $dl[ "Name"    ] . '</td>';
    $r .= '<td class="taC">' . $dl[ "Status"         ] . '</td>';
    $r .= '<td class="taC">' . number_format( $dl[ "Pflicht_weg" ], 2 ) . '</td>';
    $r .= '<td class="taC">';
    $r .= '<span style="width:100%; height:100%; background-color:#EEEEEE; text-decoration: none; text-align: center; padding: 3px;">' . $dl[ "AnzV" ] . '</span>:';
    $r .= '<span style="width:100%; height:100%; background-color:#EEEEEE; text-decoration: none; text-align: center; padding: 3px;">' . $dl[ "AnzE" ] . '</span>';         $r .= '</td>';
    $r .= '<td class="taR"><a style="text-decoration: none;"  target="rechts" href="?action=sb&jahr='   . $_SESSION[ 'aktuell' ][ "Jahr" ] . '&semester=' . $_SESSION[ 'aktuell' ][ 'Semester' ]  . '&dozentKurz=' . $dl[ "Kurz" ] . '&output=html"><span style="width:100%; height:100%; background-color:#EEEEEE; text-decoration: none; text-align: center;">' .  number_format(  $dl['aktuell']['saldo'     ]  ,2 ) . '</span></a> <a style="text-decoration: none;"  target="rechts" href="?action=sb&jahr='   . $_SESSION[ 'aktuell' ][ "Jahr" ] . '&semester=' . $_SESSION[ 'aktuell' ][ 'Semester' ]  . '&dozentKurz=' . $dl[ "Kurz" ] . '&output=pdf" ><span style="width:100%; height:100%; background-color:#EEEEEE; text-decoration: none; text-align: center;">p</span></a> </td>';
    $r .= '<td class="taR"><a style="text-decoration: none;"  target="rechts" href="?action=azkt&jahr=' . $_SESSION[ 'aktuell' ][ "Jahr" ] . '&semester=' . $_SESSION[ 'aktuell' ][ 'Semester' ]  . '&dozentKurz=' . $dl[ "Kurz" ] . '&output=html"><span style="width:100%; height:100%; background-color:#EEEEEE; text-decoration: none; text-align: center;">' .  number_format(  $dl['aktuell']['saldoTotal']  ,2 ) . '</span></a> <a style="text-decoration: none;"  target="rechts" href="?action=azkt&jahr=' . $_SESSION[ 'aktuell' ][ "Jahr" ] . '&semester=' . $_SESSION[ 'aktuell' ][ 'Semester' ]  . '&dozentKurz=' . $dl[ "Kurz" ] . '&output=pdf" ><span style="width:100%; height:100%; background-color:#EEEEEE; text-decoration: none; text-align: center;">p</span></a>  </td>';
    $r .= '</tr>';
  }
  $r .= '</table>';
  mysqli_close($db);
  
  return $r;
}

function renderArbeitszeitkonto( $db, $dozentKurz, $jahr, $semester )
{
    $arbeitszeitliste =  getArbeitszeitlisteDB( $db, $dozentKurz, $jahr, $semester );
    mysqli_close($db);
    return renderZeitkontoTotalProf( $arbeitszeitliste );
}

function renderStundenbilanz( $db, $dozentKurz, $jahr, $semester, $onlyData = false )
{
  $dozent   = getDozentDB( $db, $dozentKurz );
  $dozent[ 'aktuell' ][ 'veranstaltungsliste' ]  =  getVeranstaltungslisteDB( $db, $dozentKurz, $jahr, $semester );
  $dozent[ 'aktuell' ][ 'entlastungsliste'    ]  =  getEntlastungslisteDB(    $db, $dozentKurz, $jahr, $semester );
  $dozent[ 'aktuell' ][ 'beteiligung'         ]  =  getBeteiligungslisteDB( $db,  $dozent[ 'aktuell' ][ 'veranstaltungsliste' ] );
  $dozent[ 'aktuell' ][ 'dozentLV'            ]  =  getDozentLVDB( $db, $dozentKurz, $jahr, $semester );
  $dozent[ 'aktuell' ][ 'dozentLV'            ] +=  calcStundenbilanz( $dozent );

  #mysqli_close($db);

  if ($onlyData)
  {   $stundenbilanz = $dozent['aktuell'];
  }

  else
  { $stundenbilanz = renderZeitkontoProf( $dozent );
  }
  return $stundenbilanz;
}



function calcStundenbilanz($dozent)
{ $stunden = array();
  $stunden[ 'veranstaltungssumme' ] = 0;
  $stunden[ 'entlastungsumme'     ] = 0;
  $stunden[ 'saldo'               ] = 0;

  foreach ($dozent['aktuell']['veranstaltungsliste'] as $vl )
  { $stunden[ 'veranstaltungssumme' ]  += $vl['LVS'];
  }
  
  foreach ($dozent['aktuell']['entlastungsliste'] as $vl )
  {  $stunden[ 'entlastungsumme' ]  += $vl['LVS'];
  }

  $stunden[ 'summeLuE' ] = $stunden[ 'entlastungsumme' ]  +  $stunden[ 'veranstaltungssumme' ];
  $stunden[ 'saldo'    ] = $stunden[ 'entlastungsumme' ]  +  $stunden[ 'veranstaltungssumme' ] - $dozent[ 'aktuell']['dozentLV'][ 'Pflicht' ];

  return $stunden;
}

function renderZeitkontoProf($dozent)
{
  $html = '
<table>
	<tr> <td style="border-bottom: 0 solid white;" >	<br /> <div class="headertxt">Hochschule für Angewandte Wissenschaften<br/>Fakultät Life Sciences<br/>Dekanat</div>   </td>
       <td style="text-align: right ; border-bottom: 0 solid white; ">  <img width="250px;" alt="haw-logo"   src="img/HAW_Marke_grau_RGB.svg"  ><br>' .  date("d.m.Y")  .' </td>
	</tr>
	
</table>
  <div class="betrefftxt" >aktuelle Stundenbilanz für das Semester '. $dozent["aktuell"]["dozentLV"]["Semester"]  .' '  . $dozent["aktuell"]["dozentLV"]["Jahr"]  .'   </div>';

$html .=  '<div class="fliestxt" >' .$dozent["Anrede"].' '.$dozent["Name"].', <br/><br/> hiermit erhalten Sie die aktuelle Stundenbilanz für das zurückliegende Semester.</div><br/>' ;
$html .= '<table   style="width: 100%;"  >
<tr style="background-color: #cccccc;"   >
<td style="width: 90%"                   > </td>
<td style="width: 10%;" class="taC head" > LVS </td></tr>
<tr><td class="taL sum">Summe der Lehrveranstaltungen und Entlastungen:</td><td class="taC sum" >'.  number_format( $dozent[ "aktuell" ][ "dozentLV" ][ 'summeLuE' ] , 2 ) .'</td></tr>
<tr><td class="taL"    >Ihre Lehrverpflichtung:                        </td><td class="taC"     >'.  number_format( $dozent[ "aktuell" ][ "dozentLV" ][ 'Pflicht'  ] , 2 ) .'</td></tr>
<tr><td class="taL sal">Ihr Saldo im Semester '. $dozent["aktuell"]["dozentLV"]["Semester"]  .' '  . $dozent["aktuell"]["dozentLV"]["Jahr"]  .' beträgt:      </td><td class="taC sal" >'.  number_format( $dozent[ "aktuell" ][ "dozentLV" ][ 'saldo'    ] , 2 ) .'</td></tr>
</table>';
  
$html .=  '<br/><div class="fliestxt"> Wir haben im Einzelnen für Sie folgende Leistungen notiert:</div><br/>';
$html .=  generateLuETable( $dozent );
$html .=  '<div class="fliestxt"><br/>
Ihr Überstundenkonto der letzten Jahre oder Ihr Arbeitszeitkonto wird Ihnen gesondert zugestellt.<br/>
Für weitere Fragen stehe ich Ihnen gerne zur Verfügung.<br/><br/>
Mit freundlichen Grüßen<br/>
Martin Holle, Prodekan LS
</div>';
  
$html .=  '<img width="300px;" alt="sign-holle" src="img/sign-holle.png">';

$html .=  generateBeteiligung( $dozent );


return $html;
}



function renderZeitkontoTotalProf($arbeitszeitliste)
{
   $html = '
<table>
	<tr> <td style="border-bottom: 0 solid white;" >	<br /> <div class="headertxt">Hochschule für Angewandte Wissenschaften<br/>Fakultät Life Sciences<br/>Dekanat</div>   </td>
       <td style="text-align: right ; border-bottom: 0 solid white; ">  <img width="250px;" alt="haw-logo"   src="img/HAW_Marke_grau_RGB.png"  ><br>' .  date("d.m.Y")  .' </td>
	</tr>
	
</table>
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

    $html .=  '<img width="300px;" alt="sign-holle" src="img/sign-holle.png">';

    return $html;
}



function generateLuETable( $dozent )
{ $r = '<div style="position: absolute; left:50%; top:100px; padding: 10px;  border: solid black 1px; font-family: Arial, sans-serif;  font-size  : 12px; background-color: #FAFAFA; display: none;"  id="livesearch"> </div>
<table  style="width: 100%;" >';
  $r .='<tr style="background-color: #cccccc; padding:5px;">
              <td  style="width: 60%"                  > Titel der Veranstaltung / Entlastung </td>
              <td  style="width: 10%;" class="taC head" > Gruppe </td>
              <td  style="width: 10%;" class="taC head" > SWS </td>
              <td  style="width: 10%;" class="taC head" > Anteil </td>
              <td  style="width: 10%;" class="taC head" > LVS </td></tr> ' ;
  
  foreach ( $dozent["aktuell"]["veranstaltungsliste"]   as $t )
  {  $r .= '<tr> <td class="taL" id = "'. strtr( $t[ "Fach" ], ' ', '_' ) .'" onClick = "me( this );" oninput = "showResult(this, \'' .  $t[ "Fach" ] .'\' ); "  >' . $t[ "FachL"] . ' (' .  $t[ "Fach" ] .') </td>
                 <td class="taC">' . $t[ "Studiengang"] . '</td>
                 <td class="taC">' . number_format( $t[ "SWS" ], 2 ) . '</td>
                 
                 <td class="taC">' . $t[ "Anteil"] . '% </td>
                 <td class="taC">' . number_format( $t[ "LVS" ], 2 ) . '</td></tr> '    ;
  }
  
  foreach ( $dozent['aktuell']['entlastungsliste']  as $t )
  { $r .= '<tr> <td colspan="4">' . $t[ "auslastungsGrund" ] . '</td>  <td  class="taC">' .  number_format( $t[ "LVS" ], 2) . '</td></tr> ' ;
  }
  
  $r .= '<tr><td colspan="4" class="sum"> Summe der Lehrveranstaltungen und Entlastungen: </td>  <td class="taC sum"> ' .    number_format($dozent["aktuell"][ "dozentLV" ][ "summeLuE" ]  , 2) . '</td></tr>' ;
  $r .= '</table>';
  return $r;
}



function generateBeteiligung( $dozent )
{
   # deb($dozent['aktuell']['beteiligung'],1);
    $r = '';

    $r =   '<br/<br/<br/<br/><div class="fliestxt">Anteile bei Veranstaltung mit Beteiligung</div><br/>';

    foreach ( $dozent["aktuell"]["beteiligung"]   as $beteiligung )
    {  $anteilGesamt = 0;
        $LVSGesamt = 0;
        #deb($beteiligung);
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
{   $r = '<table  style="width: 100%;" >';
    $r .='<tr style="background-color: #cccccc; padding:5px;">
              <td  style="width: 20%"  class="taC head" >Semester</td>
              <td  style="width: 15%;" class="taR head" >Stunden</td>
              <td  style="width: 15%;" class="taR head" >Pflicht</td>
              <td  style="width: 15%;" class="taR head" >Saldo</td>
              <td  style="width: 15%;" class="taR head" >Summe</td>
              <td  style="width: 20%;" class="taR head" >Kommentar</td>
           
              </tr> ' ;

    unset( $dozent[ 'aktuell' ] );

    foreach ( $dozent   as $dVL )
    {
        $d = $dVL['dozentLV'];

        $r .= '<tr> 
             <td class="taC">' .                $d[ "Jahr"       ]   . ' (' .  $d[ "Semester" ] .')  </td>
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

function renderMainSide()
{
$html ='
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>

<style>

.dropbtn {
  font-family: Arial, sans-serif;
  background-color: #EFEFEF;
  color: white;
  font-size: 22px;
}

.dropdown {
  position: relative;
  display: inline-block;
    font-family: Arial, sans-serif;
  font-size: 25px;
  margin-left: 15px;
 
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f1f1f1;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.dropdown-content a {
    font-family: Arial, sans-serif;
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

.dropdown-content a:hover {background-color: #ddd; }
.dropdown:hover .dropdown-content {display: block;}
.dropdown:hover .dropbtn {background-color: #EEEEEE; }

</style>
</head>
<body style="background-color:white;">

<div class="dropdown" style="width: 49%;">
  <div class="dropbtn"  id="Button2" >Basis Tabellen</div>
  <div class="dropdown-content">
    <a href="index.php?action=edoz"  target="rechts"  onclick="document.querySelector(\'#Button2\').innerHTML = \'Dozenten\'   ; ">Dozenten</a>
    <a href="index.php?action=ef"    target="rechts"  onclick="document.querySelector(\'#Button2\').innerHTML = \'Fach\'       ; ">Fach</a>
    <a href="index.php?action=esg"   target="rechts"  onclick="document.querySelector(\'#Button2\').innerHTML = \'Studiengang\'; ">Studiengang</a>
    <a href="index.php?action=edep"  target="rechts"  onclick="document.querySelector(\'#Button2\').innerHTML = \'Department\' ; ">Department</a>
  </div>
</div>

<div class="dropdown"  style="width: 49%;">
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

   # $html .= '<iframe style="position: absolute; top:40px; left: 50%; height: calc(100% - 50px) ; width: calc(50% - 20px); border: 1px black solid;"   name="links" src="index.php?action=ad&jahr=2023&semester=S&"></iframe>';
    $html .= '<iframe style="position: absolute; top:40px; left: 50%; height: calc(100% - 50px) ; width: calc(50% - 20px); border: 1px black solid;"   name="links" src="login.html"></iframe>';
    $html .= '<iframe style="position: absolute; top:40px; left:10px; height: calc(100% - 50px) ; width: calc(50% - 20px); border: 1px black solid;"   name="rechts" src="index.php?action=ss"                     ></iframe>';

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
  position: absolute; left: 50%; top: 50%;  -webkit-transform: translate(-50%, -50%); transform: translate(-50%, -50%); 
  } 
.object-fit img { object-fit: cover; width:  100%; height: 100%;}  </style>
<div class="object-fit" style="text-align:center;"> <img 
src="img/splashscreen.png" alt="splashscreen"> </div>
</body></html>';

echo $html;

}


function deb($con, $kill = false)
{   echo "<pre>";
  print_r($con);
  echo "</pre>";
  if($kill) {die();}
}
