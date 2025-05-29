<?php
$timepice = true;   ## Laufzeitmessung der DB Zugriffe
if( $timepice ) { $count = 0; $st = hrtime(false )[0]; }

function connectDB()
{   $user = 'zeitkonto';
    $pass = 'zeitkonto';
    $database = 'zeitkonto';
    $host = 'localhost';

    # $db = new mysqli("141.22.110.33", "zeitkonto", "d4p0t2tLS", "zeitkonto");
    $db = new mysqli("localhost", "zeitkonto", "zeitkonto", "zeitkonto");
    #$db = new PDO('mysql:host=localhost;dbname=zeitkonto', $user, $pass);
    # if ($db -> connect_errno)
 # { echo "Failed to connect to MySQL: " . $db->connect_error;
 #   exit();
 # }
  return ($db);
}

function checkInput($name, $value)
{
  if     ( $name == 'dozentKurz' )  { if( strlen( $value ) > 7 )    die("ERROR: Malformed SQL statement: 001-". strlen( $value ));   }
  else if( $name == 'jahr'       )  { if( strlen( $value ) > 4 )    die("ERROR: Malformed SQL statement: 002-". strlen( $value ));   }
  else if( $name == 'semester'   )  { if( strlen( $value ) > 1 )    die("ERROR: Malformed SQL statement: 003-". strlen( $value ));   }
}


function getArbeitszeitlisteDB( $db, $dozentKurz ,$alleDozenten )
{ global $count;
  global $st;
  global $tim1;
  global $tim2;
  global $timepice;

  checkInput("dozentKurz", $dozentKurz);
  $arbeitszeitliste = array();
  $saldoTotal = 0;
  $sql1   = "SELECT DISTINCT  Jahr, Semester  FROM `beteiligung` WHERE  DozentKurz = \"". $dozentKurz
        . "\"  ORDER by Jahr ASC, Semester ASC ";

  $result = $db -> query( $sql1 );
  $row    = $result -> fetch_all( MYSQLI_ASSOC );   ## Alle Semester in dem der Dozent aktiv war

  $arbeitszeitliste[ 'aktuell' ][ "saldo"    ] = 0;
  $arbeitszeitliste[ 'aktuell' ][ "semester" ] = 0;
  $arbeitszeitliste[ 'aktuell' ][ "jahr"     ] = 0;
  $overflow = '';

  if( $timepice ){
     # deb($row);
     #echo( "<h1>".$dozentKurz. '</h1>'  );
    }

  foreach ( $row as $r1 )
  { if( $timepice ){ $tim2 = $tim1; $tim1 = ( hrtime(false )[ 0 ] - $st ); echo '<br>'.' azl: '.  $count++  .' '.$tim1; }    #Zeitmessung der DB Zugriffe
   # deb($r1 );
    $sb =  renderStundenbilanz( $db , $dozentKurz , $r1[ 'Jahr' ], $r1[ 'Semester' ] , true );
   # deb($sb,1 );

    $arbeitszeitliste[ 'aktuell' ] =  $sb[ 'dozentLV' ];
    $arbeitszeitliste[ $r1[ 'Jahr' ]. $r1[ 'Semester' ]  ] =  $sb;
    $saldo =  $arbeitszeitliste[ $r1[ 'Jahr' ]. $r1[ 'Semester' ] ] [ 'dozentLV' ][ "saldo" ];
    $saldoTotal +=  $saldo;

    if ( $saldoTotal > 36 )
    { $overflow = $saldoTotal - 36 ;
      $arbeitszeitliste[ $r1[ 'Jahr' ]. $r1[ 'Semester' ] ] [ 'dozentLV' ][ "Kommentar" ] .=  "LVS verfallen: ". number_format( $overflow,1 );
      $saldoTotal = 36;
    }
    $arbeitszeitliste[ $r1[ 'Jahr' ]. $r1[ 'Semester' ] ] [ 'dozentLV' ][ "saldoTotal" ] = $saldoTotal;
  }

  $arbeitszeitliste[ 'aktuell' ][ "saldoTotal" ] = $saldoTotal;
  # $arbeitszeitliste[ 'aktuell' ] +=  getDozentDB( $db, $dozentKurz ) ;
  $arbeitszeitliste[ 'aktuell' ] +=  $alleDozenten[ $dozentKurz ] ;
  # $alleDozenten = getDozentenListeDB($db );
  return $arbeitszeitliste;
}

function getVeranstaltungslisteDB( $db, $dozentKurz, $jahr, $semester )
{checkInput("dozentKurz" , $dozentKurz );
 checkInput("jahr"       , $jahr       );
 checkInput("smester"    , $semester   );

 #   $sql1   = "SELECT * FROM `beteiligung` WHERE Jahr     = :jahr "
 #       . " AND DozentKurz = :dozentKurz "
 #       . " AND Semester   = :semester "
 #       . " ORDER BY Fach" ;#

 #   $sql1   = "SELECT * FROM `beteiligung` WHERE Jahr     = 2023 "
 #       . " AND DozentKurz = 'P6UV' "
 #       . " AND Semester   = 'S' "
 #       . " ORDER BY Fach" ;

 #   $stmt = $db->prepare($sql1);

 #   $stmt->bindParam( ':jahr',  $jahr );
 #   $stmt->bindParam(':dozentKurz', $dozentKurz);
 #   $stmt->bindParam(':semester', $semester );

 #  $stmt->execute();

 #  foreach ($stmt as $row) {
 #      print_r($row);
 #  }

 $sql1   = "SELECT * FROM `beteiligung` WHERE Jahr     = \"" . $jahr
                                   . "\" AND DozentKurz = \"". $dozentKurz
                                   . "\" AND Semester   = \"". $semester
                                   . "\" ORDER BY Fach";

  #$result = ;
  $stmt    = $db -> query( $sql1 ) -> fetch_all( MYSQLI_ASSOC );
  /*  */

  $veranstaltungsliste = array();
  foreach ( $stmt as $beteiligung )
  { #deb($beteiligung);
      $veranstaltungsliste[] =  getVeranstaltungDB( $db, $beteiligung, $jahr, $semester );
  }

#  deb($veranstaltungsliste );
  return $veranstaltungsliste;
}

function getVeranstaltungDB( $db , $r1 , $jahr , $semester )
{ checkInput("jahr"       , $jahr       );
  checkInput("smester"    , $semester   );

  #$stmt = $db->prepare("SELECT * FROM REGISTRY where name = ?");
  #$stmt->execute([$_GET['name']]);

/*
    $sql2 = "SELECT * FROM `lva`  WHERE Jahr       = ?"
        . "  AND Semester     = ?"
        . "  AND Studiengang  = ?"
        . "  AND FachKurz     = ?";
*/

 $sql2  = "SELECT * FROM `lva` WHERE Jahr     = \"" . $jahr
        . "\" AND Studiengang = \"". $r1[ 'Studiengang' ]
        . "\" AND Semester   = \"". $semester
        . "\" AND FachKurz   = \"". $r1[ 'Fach'        ]
    . "\"";

  # deb($sql2);

/*
    $stmt = $db->prepare($sql2);
    $stmt->bindParam(1, $jahr);
    $stmt->bindParam(2, $semester);
    $stmt->bindParam(3,  $r1[ 'Studiengang' ]);
    $stmt->bindParam(4,  $r1[ 'Fach'        ]);
    $stmt->execute();
*/
    $result2 = $db -> query( $sql2 );
    $row2    = $result2 -> fetch_all( MYSQLI_ASSOC );

  #   deb($row2);
    if (!empty($row2))
    {
    $r1[ 'SWS' ] = $row2[ 0 ][ "SWS" ];

    }
    $r1[ 'SWS' ]  = -1;


    $sql3 = "SELECT * FROM `fach`  WHERE Kurz       = \"" .  $r1[ 'Fach'        ]  ."\"";

    $result3 = $db -> query($sql3);
    $row3 = $result3 -> fetch_all( MYSQLI_ASSOC );
deb($row3);
    $r1[ 'FachL'  ] = $row3[ 0 ][ "Name" ];
    $r1[ 'LVS'    ] = $r1[ 'K' ] *  $r1[ 'SWS' ]    ;
    $r1[ 'Anteil' ] = ( int ) ( $r1[ 'K' ] * 100 ) ;
    return  $r1;
}

function getEntlastungslisteDB( $db , $dozentKurz , $jahr , $semester )
{ checkInput("dozentKurz" , $dozentKurz );
  checkInput("jahr"       , $jahr       );
  checkInput("smester"    , $semester   );

#  $alleEntlastungsGrunde = null;
   $entlastungsGrunde = getEntlastungsgruendeListeDB( $db );   ## ----------- Wird nur 1x gebraucht .-----
#
#  deb($entlastungsGrunde);

#  $sql5   = "SELECT * FROM `auslastungsgrund`  ORDER BY Grund";
#  $result = $db -> query( $sql5 );
#  $row    = $result -> fetch_all( MYSQLI_ASSOC );
  
#  foreach ( $row as $r2 )
#  { $auslastung[ $r2[ 'Grund' ] ] = $r2[ 'Text' ];
#  }

#    deb($auslastung,1);

  $sql4 = "SELECT * FROM `auslastung` WHERE Jahr =     \"" . $jahr
                                . "\" AND DozentKurz = \"" . $dozentKurz
                                . "\" AND Semester =   \"" . $semester
                                . "\" ORDER BY Grund";
  $result = $db -> query( $sql4 );

 # deb($sql4);

  $row = $result -> fetch_all( MYSQLI_ASSOC );
  $entlastungsliste = array();

  foreach ( $row as $r3 )
  { $entlastungsgrund[ $r3[ 'Grund' ]][ $r3[ 'ID' ]] = $r3;
  }

  #deb($entlastungsgrund );
if (isset($entlastungsgrund))
{
  foreach ( $entlastungsgrund as $eg )
  {
    $i = 0; $lvsG = 0;
    foreach ( $eg as $e )
    { $lvsG += $e['LVS'];
      $i++;
    }
    $e['LVSgesammt'] = $lvsG;
    $e['LVS']        = $lvsG;

    $e['anz'] = $i;
    $entGrund[] = $e;
  }

   #deb($entGrund);


   foreach ( $row as $r3 )
   {
    if ( $r3[ 'Grund' ] == 'B' AND  $r3[ 'LVS' ] > 4 )
    { $r3[ 'LVS-orig' ] = $r3[ 'LVS' ];  $r3[ 'LVS' ] = 4; }   ## ---- Beschränkung auf Maximal 4 LVS für Betreuung für Bachelor / Masterarbeiten möglich ----
      $r3[ 'auslastungsGrund' ] = $entlastungsGrunde[ $r3[ 'Grund' ] ]['Text'];
     $entlastungsliste[] =  $r3;
  }}
  return $entlastungsliste;

}

function getBeteiligungslisteDB($db, $veranstaltungsliste )
{ $beteiligungsliste = array();
  foreach ($veranstaltungsliste as $veranstaltung )
  { { $beteiligungsliste[] = getBeteiligungDB( $db, $veranstaltung );
    }
  }
  return $beteiligungsliste;
}



function getBeteiligungDB($db, $veranstaltung )
{   $beteiligungAlle = array();

    $sql6 = " SELECT * FROM beteiligung WHERE Fach = \"".$veranstaltung['Fach']."\" AND Studiengang = \"" . $veranstaltung['Studiengang'] . "\"  AND Jahr = \"".$veranstaltung ['Jahr']. "\" AND Semester = \"".$veranstaltung['Semester']."\" ORDER BY DozentKurz ASC;";
    $result = $db -> query( $sql6 );

    $row = $result -> fetch_all( MYSQLI_ASSOC );

    foreach ( $row as $beteiligung )
    { $beteiligung[ 'dozent' ]  = getDozentDB( $db , $beteiligung[ 'DozentKurz' ] ) ;
      $beteiligungAlle[ ]       = getVeranstaltungDB($db , $beteiligung, $beteiligung[ 'Jahr' ], $beteiligung[ 'Semester' ] );
    }

    return $beteiligungAlle;
}

function getFaecherListeDB( $db )
{ $faecherliste = array();
  $sql6 = "SELECT * FROM `fach` ORDER BY Name  ASC , Name  ";
  $result = $db -> query( $sql6 );
  
  $row = $result -> fetch_all( MYSQLI_ASSOC );
  
  foreach ( $row as $r4 )
  {  $faecherliste[] = $r4;
  }

  return $faecherliste;
}

function getStudiengangListeDB($db )
{
  $studiengangliste = array();
  $sql6 = "SELECT * FROM `studiengang` ORDER BY Name  ASC , Name  ";
  $result = $db -> query($sql6);
  
  $row = $result -> fetch_all(MYSQLI_ASSOC);
  
  foreach ($row as $r4)
  {  $studiengangliste[] = $r4;
  }
  return $studiengangliste;
}

function getEntlastungsgruendeListeDB($db )
{
    $entlastungsliste = array();
    $sql6 = "SELECT * FROM `auslastungsgrund` ORDER BY Grund  ASC , Grund  ";
    $result = $db -> query($sql6);

    $row = $result -> fetch_all(MYSQLI_ASSOC);

    foreach ($row as $r4)
    {  $entlastungsliste[ $r4[ 'Grund' ] ] = $r4;
    }

    return $entlastungsliste;
}

function getDepartmentListeDB($db )
{ $departmentliste = array();
  $sql6   = "SELECT * FROM `department` ORDER BY Name  ASC , Name  ";
  $result = $db -> query($sql6);
  $row    = $result -> fetch_all(MYSQLI_ASSOC);
  foreach ($row as $r4)
  {  $departmentliste[] = $r4;
  }
  return $departmentliste;
}

function getDozentenListeDB($db ) ## Array ALLER Dozierenden
{ $dozentenliste = array();
  
  $sql6   = "SELECT * FROM `dozent` ORDER BY Name  ";
  $result = $db -> query($sql6);
  $row    = $result -> fetch_all(MYSQLI_ASSOC);
  
  foreach ($row as $r4)
  { $r4[ 'Anrede' ] = setAnrede( $r4 );
    $dozentenliste[$r4[ 'Kurz' ] ] = $r4;
  }
  return $dozentenliste;
}

function getDozentenListeSemDB( $db )
{ $jahr     =  $_SESSION[ 'aktuell' ][ 'jahr'     ] ;
  $semester =  $_SESSION[ 'aktuell' ][ 'semester' ] ;

  $alleDozenten = getDozentenListeDB($db );
#deb($alleDozenten );
  $dozentenliste = array();
  
  $sql6 = "SELECT * FROM `dozent` ORDER BY Status DESC, Name  ";
  $stmt = $db->prepare( $sql6 );
  $stmt -> execute();
  $result = $stmt -> get_result();
  $stmt = $result ->  fetch_all( MYSQLI_ASSOC );;

  #$orderby = 'Status';
  #$desc = 'Name';
  # $stmt->bind_param("ss", $orderby, $desc);

  # $res = $db -> mysqli_query( $sql6 );
  # $stmt = mysqli_fetch_assoc($res);

  foreach ($stmt as $r4)
  {
   # deb($r4);
      $r4[ 'AnzV'    ] = sizeof( getVeranstaltungslisteDB( $db, $r4[ 'Kurz' ], $jahr, $semester ) );
    $r4[ 'AnzE'    ] = sizeof( getEntlastungslisteDB(    $db, $r4[ 'Kurz' ], $jahr, $semester ) );
    $r4[ 'aktuell' ] = getArbeitszeitlisteDB( $db, $r4[ 'Kurz' ] ,$alleDozenten )[ 'aktuell' ];   ;

    if ($r4[ 'AnzV'   ] > 0 OR   $r4[ 'AnzE'   ] > 0 )   # tmp-Liste 1: Dozenten mit Lehre oder Entlastung
    {  $tmpListe1[] = $r4;}
    else
    {  $tmpListe2[] = $r4;}                              # tmp-Liste 2: Dozenten ohne Lehre und ohne Entlastung
  }

  foreach ( $tmpListe2 as $tl2 )
  { $tmpListe1[] = $tl2;                                 # Liste 2 wird an die Liste 1 angehängt
  }
  $dozentenliste = $tmpListe1;

  return $dozentenliste;
}

function setAnrede($dozent)
{ if( $dozent [ 'Geschlecht' ] == 'm')
  {   $a = 'Sehr geehrter Herr ';
      if ( $dozent [ 'Status' ] == 'Prof' )
      {  $a = 'Lieber Kollege';
      }
  }
  
  else {   $a = 'Sehr geehrte Frau ';
    if ( $dozent [ 'Status' ] == 'Prof' )
    {  $a = 'Liebe Kollegin';
    }
  }
  return $a;
}




function getDozentDB($db, $dozentKurz )
{ checkInput("dozentKurz" , $dozentKurz );

  $sql6 = "SELECT * FROM `dozent` WHERE  Kurz =\"". $dozentKurz ."\"";
  $result = $db -> query($sql6);
  
  $row = $result -> fetch_all(MYSQLI_ASSOC);
  
  foreach ($row as $r4)
  {  $dozent = $r4;
  }

  return $dozent;
}


function getDozentLVDB($db, $dozentKurz, $jahr, $semester)
{  checkInput("dozentKurz" , $dozentKurz );
   checkInput("jahr"       , $jahr       );
   checkInput("smester"    , $semester   );

   $sql7 = "SELECT * FROM `lehrverpflichtung` WHERE Jahr = \"" . $jahr . "\" AND DozKurz = \"". $dozentKurz ."\"  AND Semester = \"". $semester ."\"";
   $result = $db -> query($sql7);
   $row = $result -> fetch_all(MYSQLI_ASSOC);

  foreach ($row as $r7)
  { $dozentLV = $r7;
  }

  if ( !isset( $dozentLV [ 'DozKurz'        ] ) ) { $dozentLV [ 'DozKurz'        ] = $dozentKurz ;}
  if ( !isset( $dozentLV [ 'Status'         ] ) ) { $dozentLV [ 'Status'         ] = null        ;}
  if ( !isset( $dozentLV [ 'Professur'      ] ) ) { $dozentLV [ 'Professur'      ] = null        ;}
  if ( !isset( $dozentLV [ 'Jahr'           ] ) ) { $dozentLV [ 'Jahr'           ] = 0           ;}
  if ( !isset( $dozentLV [ 'Semester'       ] ) ) { $dozentLV [ 'Semester'       ] = 0           ;}
  if ( !isset( $dozentLV [ 'Pflicht'        ] ) ) { $dozentLV [ 'Pflicht'        ] = 0           ;}
  if ( !isset( $dozentLV [ 'Kommentar'      ] ) ) { $dozentLV [ 'Kommentar'      ] = ''          ;}
  if ( !isset( $dozentLV [ 'Abfrage'        ] ) ) { $dozentLV [ 'Abfrage'        ] = null        ;}
  if ( !isset( $dozentLV [ 'grundfinanziert'] ) ) { $dozentLV [ 'grundfinanziert'] = null        ;}

  return $dozentLV;
}

function getFaecherListeForLiveSeachDB( $db )
{
  $faecherliste = array();
  $sql6 = "SELECT * FROM `fach` ORDER BY Name  ASC , Name  ";
  $result = $db -> query($sql6);

  $row = $result -> fetch_all(MYSQLI_ASSOC);

  foreach ($row as $r4)
  {  $faecherliste[] = $r4;
  }

  return $faecherliste;
}
