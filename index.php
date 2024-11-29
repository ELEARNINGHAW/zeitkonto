<style type="text/css">

    td {
        color: red;
        padding: 10px;
        font-family: Arial, sans-serif;
        font-size: 16px;
        border: solid 1px black;
    }
    .tal {text-align: left;}

    .tar {text-align: right};

</style>

<?php


$jahr       = "2023";
$dozentKurz = "Rei";
$semester   = "S";

renderStundenbilanz( $dozentKurz, $jahr, $semester );

function renderStundenbilanz($dozentKurz, $jahr, $semester)
{

$mysqli = new mysqli("localhost","zeitkonto","zeitkonto","zeitkonto");

// Check connection
if ($mysqli -> connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
    exit();
}

$liste = array();
$auslastung = array();

$veranstaltungssumme = 0.0;
$entlastungsumme     = 0.0;


$sql1 = "SELECT * FROM `beteiligung` WHERE Jahr = \"" . $jahr . "\" AND DozentKurz = \"". $dozentKurz ."\"  AND Semester = \"". $semester ."\" ORDER BY Fach";
$result = $mysqli -> query($sql1);

// Numeric array
$row = $result -> fetch_all(MYSQLI_ASSOC);

foreach ($row as $r1)
{


    $sql2 = "SELECT * FROM `lva` 
                     WHERE Jahr       = \"" . $jahr
              . "\"   AND Semester    = \"" . $semester
              . "\"  AND Studiengang  = \"" . $r1[ 'Studiengang' ]
              . "\"  AND FachKurz     = \"" . $r1[ 'Fach'        ]  ."\"";

    $result2 = $mysqli -> query($sql2);

    $row2 = $result2 -> fetch_all(MYSQLI_ASSOC);

    $r1['SWS'] = $row2[0]["SWS"];

    $sql3 = "SELECT * FROM `Fach` 
                     WHERE Kurz       = \"" .  $r1[ 'Fach'        ]  ."\"";

    $result3 = $mysqli -> query($sql3);

    $row3 = $result3 -> fetch_all(MYSQLI_ASSOC);

    $r1[ 'FachL'  ] = $row3[ 0 ][ "Name" ];
    $r1[ 'LVS'    ] = $r1[ 'K' ] *  $r1[ 'SWS' ]    ;
    $r1[ 'Anteil' ] = ( int ) ( $r1[ 'K' ] * 100 ) ;

    $veranstaltungsliste[] = $r1;

    $veranstaltungssumme += $r1['LVS'];
    #deb(gettype($veranstaltungssumme));

}


#deb($veranstaltungsliste);

$summen['veranstaltungssumme'] = $veranstaltungssumme;


$sql5 = "SELECT * FROM `auslastungsgrund`  ORDER BY Grund";
$result = $mysqli -> query($sql5);

$row = $result -> fetch_all(MYSQLI_ASSOC);

foreach ($row as $r2)
{
    $auslastung[$r2['Grund']] = $r2['Text'];

}


$sql4 = "SELECT * FROM `auslastung` WHERE Jahr = \"" . $jahr . "\" AND DozentKurz = \"". $dozentKurz ."\"  AND Semester = \"". $semester ."\" ORDER BY Grund";
$result = $mysqli -> query($sql4);

// Numeric array
$row = $result -> fetch_all(MYSQLI_ASSOC);

foreach ($row as $r3)
{$r3['auslastungsGrund'] = $auslastung[$r3['Grund']];

   $entlastungsliste[] =  $r3;
    $entlastungsumme += $r3['LVS'];

}
$summen['entlastungsumme'] = $entlastungsumme;
#deb($entlastungsliste);

#deb($entlastungsumme);



    $sql6 = "SELECT * FROM `dozent` WHERE  Kurz =\"". $r3['DozentKurz'] ."\"";
    $result = $mysqli -> query($sql6);

    $row = $result -> fetch_all(MYSQLI_ASSOC);

    foreach ($row as $r4)
    {
        $dozent = $r4;

    }


    $sql7 = "SELECT * FROM `lehrverpflichtung` WHERE Jahr = \"" . $jahr . "\" AND DozKurz = \"". $dozentKurz ."\"  AND Semester = \"". $semester ."\"";

    $result = $mysqli -> query($sql7);

    $row = $result -> fetch_all(MYSQLI_ASSOC);

    foreach ($row as $r7)
    {
        $dozentLV = $r7;
    }

#deb($dozentLV);

    echo "<div>Hochschule für Angewandte Wissenschaften<br/>Fakultät Life Sciences<br/>Dekanat</div>";

    echo "<div><img src='img/HAW-Logo.png'></div>";

    echo "<div>".  date("d.m.Y")  ."</div>";

    echo "<div>Stundenbilanz für ".$dozent['Vorname']." ". $dozent['Name']. ' im ' . $dozentLV['Semester']  ."". $dozentLV['Jahr']  ."  ". " </div>";
  echo "
  Lieber Kollege ".$dozent['Name']." <br/>
hiermit erhalten Sie die aktuelle Stundenbilanz für das zurückliegende Semester (alle Angaben in LVS)." ;

echo "<table>
<tr><td class='tal'>Ihre Lehrverpflichtung:                        </td><td class='tar'>".  number_format(  $dozentLV[ 'Pflicht' ],   2) ."</td></tr>
<tr><td class='tal'>Summe der Lehrveranstaltungen und Entlastungen:</td><td class='tar'>".  number_format($summen[ 'veranstaltungssumme' ]  + $summen[ 'entlastungsumme' ], 2)."</td></tr>
<tr><td class='tal'>Ihr Saldo im Sommersemester 2023 beträgt:      </td><td class='tar'>".  number_format(($summen[ 'veranstaltungssumme' ]  + $summen[ 'entlastungsumme' ]) - $dozentLV[ 'Pflicht' ], 2 )."</td></tr>
</table>";




    echo "<div> Wir haben im Einzelnen für Sie folgende Leistungen notiert:</div>";

echo gernateTable($veranstaltungsliste,$entlastungsliste, $summen);




    echo "
Ihr Überstundenkonto der letzten Jahre oder Ihr Arbeitszeitkonto wird Ihnen gesondert zugestellt.<br/>
Für weitere Fragen stehe ich Ihnen gerne zur Verfügung.<br/>
Mit freundlichen Grüßen<br/>
Martin Holle, Prodekan LS
";

    echo "<div><img src='img/sign-holle.png'></div>";


    mysqli_close($mysqli);


}




function gernateTable($veranstaltungsliste, $entlastungsliste,  $summen)
{
    $r = "<table>";
    $r .= "<tr><td class='taL'>Titel der Veranstaltung  </td><td class='taL'> Studiengruppe </td><td> SWS </td> <td class='taL'>   Anteil </td><td   class='taL' > LVS </td> "    ;
    foreach ($veranstaltungsliste as $t)
    {
      #  deb($t);
      $r .= "<tr> <td class='tal' >" . $t["FachL"] . " (" .  $t["Fach"]  .") </td><td class='tal'>" . $t["Studiengang"] . "</td><td class='tar' >" .  number_format($t["SWS"], 2) . "</td><td class='tar'>" . $t["Anteil"] . "% </td>  <td class='tar'>" .  number_format($t["LVS"], 2) . "</td> "    ;
    }

  #  $r .= "<tr><td colspan='5' > Summe LVS  </td>  <td>" . $summen['veranstaltungssumme'] . "</td> "    ;


  #  $r .= "<tr> <td colspan='4'>  Grund der Entlastung </td> <td> LVS </td> "    ;
    foreach ($entlastungsliste as $t)
    {
        #  deb($t);
        $r .= "<tr> <td colspan='4'>" . $t["auslastungsGrund"] . "</td>  <td>" .  number_format($t["LVS"], 2) . "</td> "    ;
    }

 #   $r .= "<tr><td colspan='5' > Summe LVS  </td>  <td>- " . $summen['entlastungsumme'] . "</td> "    ;


    $r .= "<tr><td colspan='4' > GESAMT LVS  </td>  <td> " . $summen['veranstaltungssumme']  + $summen['entlastungsumme'] . "</td> "    ;


    $r .= "</table>";


    return $r;
}


function deb($con)
{
    echo "<pre>";
    print_r($con);
    echo "</pre>";

}


?>