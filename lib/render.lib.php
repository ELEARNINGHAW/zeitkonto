<?php

function renderDozentenListe( $db )
{
  $dozentenliste   = array();
  $dozentenliste   = getDozentenListe( $db);
  
$r = '<table cellpadding="5" cellspacing="0" style="width: 50%;   position: relative;" >';
  $r .='<tr style="background-color: #cccccc; padding:5px; position: sticky; top: 0;">
              <th  style="width: 10%"                   > Anz.V </th>
              <th  style="width: 10%"                   > Kurz </th>
              <th  style="width: 15%;" class="taC head" > Vorname </th>
              <th  style="width: 15%;" class="taC head" > Name </th>
              <th  style="width: 10%;" class="taC head" > Ges </th>
              <th  style="width: 10%;" class="taC head" > Status </th>
              <th  style="width: 20%;" class="taC head" > Mail </th>
              <th  style="width: 5%; " class="taC head" > Zust. </th>
              <th  style="width: 10%;" class="taC head" > Pflicht </th>
              </tr> ' ;
  
 
  foreach ( $dozentenliste  as $dl )
  {
    $r .= '<tr>
                 <td class="taC">
                 <a   style="text-decoration: none;"  target="stunenbilanz" href="https://localhost/zeitkonto/?action=sb&jahr=' . $_SESSION[ 'aktuell' ][ "Jahr" ] . '&semester=' . $_SESSION[ 'aktuell' ][ 'Semester' ]  . '&dozentKurz=' . $dl[ "Kurz" ] . '&output=html"><span style="width:100%; height:100%; background-color:#EEEEEE; text-decoration: none; text-align: center; padding: 3px;">' . $dl[ "AnzV" ] . '</span></a>
                 <a   style="text-decoration: none;"  target="stunenbilanz" href="https://localhost/zeitkonto/?action=sb&jahr=' . $_SESSION[ 'aktuell' ][ "Jahr" ] . '&semester=' . $_SESSION[ 'aktuell' ][ 'Semester' ]  . '&dozentKurz=' . $dl[ "Kurz" ] . '&output=pdf"><span style="width:100%; height:100%; background-color:#EEEEEE; text-decoration: none; text-align: center; padding: 3px;">' . $dl[ "AnzV" ] . '</span></a> </td>
                 <td class="taL">' . $dl[ "Kurz" ] . ' </td>
                 <td class="taC">' . $dl[ "Vorname" ] . '</td>
                 <td class="taC">' . $dl[ "Name" ] . '</td>
                 <td class="taC">' . $dl[ "Geschlecht" ] . '</td>
                 <td class="taC">' . $dl[ "Status" ] . '</td>
                 <td class="taC">' . $dl[ "Mailadresse" ] . '</td>
                 <td class="taC">' . $dl[ "Mailzustellung" ] . '</td>
                 <td class="taC">' . number_format( $dl[ "Pflicht_weg" ], 2 ) . '</td></tr> '    ;
  }
  
  $jahr       = '2023';
  $dozentKurz = 'Gtt';
  $semester   = 'S';
  
 # deb(getStundenbilanz( $jahr, $dozentKurz , $semester, 'ohne' ),1);

#  $r .= '<div id="overlay" onclick="off()"><iframe width="100%" height="100%" srcdoc = "'.  getStundenbilanz( $jahr, $dozentKurz , $semester, 'ohne' ) .'">';
  #$r .= '<div id="overlay" onclick="off();">';
  $r .= '<iframe  name="stunenbilanz" style=" position: sticky; top: 30px; left: 50%;" onclick="off();" width="50%" height="100%" srcdoc = "ABDC"></iframe></div>';
  #$r .= '<script>
  #function on()  { document.getElementById("overlay").style.display = "block";  }
  #function off() { document.getElementById("overlay").style.display = "none";  }
  #</script>';
  
  mysqli_close($db);
  
  return $r;
}

function renderStundenbilanz( $db, $dozentKurz, $jahr, $semester )
{
  $liste               = array();
  $auslastung          = array();
  $veranstaltungssumme = 0.0;
  $entlastungsumme     = 0.0;
  
  $veranstaltungsliste =  getVeranstaltungsliste( $db, $dozentKurz, $jahr, $semester );
  $entlastungsliste    =  getEntlastungsliste(    $db, $dozentKurz, $jahr, $semester );
  
  $dozentLV = getDozentLV( $db, $dozentKurz, $jahr, $semester );
  $dozent   = getDozent( $db, $dozentKurz );

  $dozent[ 'aktuell' ][ 'veranstaltungsliste' ]  = $veranstaltungsliste ;
  $dozent[ 'aktuell' ][ 'entlastungsliste'    ]  = $entlastungsliste;
  $dozent[ 'aktuell' ][ 'dozentLV'            ]  = $dozentLV;
  $dozent[ 'aktuell' ][ 'dozentLV'            ] +=  calcStundenbilanz( $dozent );
  
  # deb($dozent);
 
  return renderZeitkontoProf( $dozent );
  
  mysqli_close($db);
}

function calcStundenbilanz($dozent)
{ $stunden = array();
  $stunden[ 'veranstaltungssumme' ] = 0;
  $stunden[ 'entlastungsumme'     ] = 0;
  
 # deb($dozent[ 'aktuell']['dozentLV'][ 'Pflicht' ]);
  
  #deb($dozent);
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
  $html = '';
  $html = '
<table>
	<tr> <td style="border-bottom: 0 solid white;" >	<br /> <div class="headertxt">Hochschule für Angewandte Wissenschaften<br/>Fakultät Life Sciences<br/>Dekanat</div>   </td>
       <td style="text-align: right ; border-bottom: 0 solid white; ">  <img width="250px;"  src="img/haw-logo.png"><br>' .  date("d.m.Y")  .' </td>
	</tr>
	
</table>
  <div class="betrefftxt" >aktuelle Stundenbilanz für das Semester '
    . $dozent["aktuell"]["dozentLV"]["Semester"]  .'    '
    . $dozent["aktuell"]["dozentLV"]["Jahr"]  .'
 </div>';
$html .=  '';
 
$html .=  '<div class="fliestxt" >
Lieber Kollege '.$dozent["Name"].', <br/><br/>
hiermit erhalten Sie die aktuelle Stundenbilanz für das zurückliegende Semester.</div><br/>' ;
 $html .= '<table cellspacing="0" style="width: 100%;" >

<tr style="background-color: #cccccc;">
              <td  style="width: 90%"                  > </td>
              <td  style="width: 10%;" class="taC head" > LVS </td></tr>
<tr><td class="taL"    >Ihre Lehrverpflichtung:                        </td><td class="taC"     >'.  number_format( $dozent[ "aktuell" ][ "dozentLV" ][ 'Pflicht'  ] , 2 ) .'</td></tr>
<tr><td class="taL sum">Summe der Lehrveranstaltungen und Entlastungen:</td><td class="taC sum" >'.  number_format( $dozent[ "aktuell" ][ "dozentLV" ][ 'summeLuE' ] , 2 ) .'</td></tr>
<tr><td class="taL sal">Ihr Saldo im Sommersemester 2023 beträgt:      </td><td class="taC sal" >'.  number_format( $dozent[ "aktuell" ][ "dozentLV" ][ 'saldo'    ] , 2 ) .'</td></tr>
</table>';
  
 $html .=  '<br/><div class="fliestxt"> Wir haben im Einzelnen für Sie folgende Leistungen notiert:</div><br/>';
 $html .=  generateLuETable( $dozent );
 $html .=  '<div class="fliestxt"><br/>
Ihr Überstundenkonto der letzten Jahre oder Ihr Arbeitszeitkonto wird Ihnen gesondert zugestellt.<br/>
Für weitere Fragen stehe ich Ihnen gerne zur Verfügung.<br/><br/>
Mit freundlichen Grüßen<br/>
Martin Holle, Prodekan LS
</div>';
  
  $html .=  '<img width="300px;"  src="img/sign-holle.png">';
  return $html;
}

function generateLuETable( $dozent )
{ $r = '<table cellpadding="5" cellspacing="0" style="width: 100%;" >';
  $r .='<tr style="background-color: #cccccc; padding:5px;">
              <td  style="width: 60%"                  > Titel der Veranstaltung / Entlastung </td>
              <td  style="width: 10%;" class="taC head" > Gruppe </td>
              <td  style="width: 10%;" class="taC head" > SWS </td>
              <td  style="width: 10%;" class="taC head" > Anteil </td>
              <td  style="width: 10%;" class="taC head" > LVS </td></tr> ' ;
  
  foreach ( $dozent["aktuell"]["veranstaltungsliste"]   as $t )
  {  $r .= '<tr> <td class="taL">' . $t[ "FachL"] . ' (' .  $t[ "Fach" ] .')  </td>
                 <td class="taC">' . $t[ "Studiengang"] . '</td>
                 <td class="taC">' . number_format( $t[ "SWS" ], 2 ) . '</td>
                 
                 <td class="taC">' . $t[ "Anteil"] . '% </td>
                 <td class="taC">' . number_format( $t[ "LVS" ], 2 ) . '</td></tr> '    ;
  }
  
  foreach ( $dozent['aktuell']['entlastungsliste']  as $t )
  { $r .= '<tr> <td colspan="4">' . $t[ "auslastungsGrund" ] . '</td>  <td  class="tar">' .  number_format( $t[ "LVS" ], 2) . '</td></tr> ' ;
  }
  
  $r .= '<tr><td colspan="4" class="sum"> Summe der Lehrveranstaltungen und Entlastungen: </td>  <td class="taC sum"> ' .    number_format($dozent["aktuell"][ "dozentLV" ][ "summeLuE" ]  , 2) . '</td></tr>' ;
  $r .= '</table>';
  return $r;
}

function deb($con, $x = false)
{   echo "<pre>";
  print_r($con);
  echo "</pre>";
  if($x) {die();}
}
