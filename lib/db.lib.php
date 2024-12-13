<?php

function connectDB()
{ $db = new mysqli("localhost", "zeitkonto", "zeitkonto", "zeitkonto");
  if ($db -> connect_errno)
  { echo "Failed to connect to MySQL: " . $db->connect_error;
    exit();
  }
  return ($db);
}

function getArbeitszeitliste( $db, $dozentKurz, $jahr, $semester )
{  $arbeitszeitliste = array();
   $saldoTotal = 0;
   $sql1   = "SELECT DISTINCT  Jahr, Semester  FROM `beteiligung` WHERE  DozentKurz = \"". $dozentKurz
        . "\"  ORDER by Jahr ASC, Semester ASC ";

   $result = $db -> query( $sql1 );
   $row    = $result -> fetch_all( MYSQLI_ASSOC );

   $arbeitszeitliste[ 'aktuell' ][ "saldo"    ] = 0;
   $arbeitszeitliste[ 'aktuell' ][ "Semester" ] = 0;
   $arbeitszeitliste[ 'aktuell' ][ "Jahr"     ] = 0;

   foreach ( $row as $r1 )
   {
      $sb =  renderStundenbilanz( $db, $dozentKurz, $r1['Jahr'], $r1['Semester'], true);
      $arbeitszeitliste[ 'aktuell' ] =  $sb[ 'dozentLV' ];
      $arbeitszeitliste[ $r1[ 'Jahr' ]. $r1[ 'Semester' ]  ] =  $sb;
      $saldoTotal +=  $arbeitszeitliste[ $r1[ 'Jahr' ]. $r1[ 'Semester' ]  ] [ 'dozentLV' ][ "saldo" ];
      $arbeitszeitliste[ $r1[ 'Jahr' ]. $r1[ 'Semester' ]  ] [ 'dozentLV' ][ "saldoTotal" ] = $saldoTotal;
   }

   $arbeitszeitliste[ 'aktuell' ][ "saldoTotal" ] = $saldoTotal;
   $arbeitszeitliste[ 'aktuell' ] +=  getDozent( $db, $dozentKurz ) ;
  #

   return $arbeitszeitliste;
}

function getVeranstaltungsliste( $db, $dozentKurz, $jahr, $semester )
{
  
  $sql1   = "SELECT * FROM `beteiligung` WHERE Jahr     = \"" . $jahr
                                   . "\" AND DozentKurz = \"". $dozentKurz
                                   . "\" AND Semester   = \"". $semester
                                   . "\" ORDER BY Fach";
  
  $result = $db -> query($sql1);
  $row    = $result -> fetch_all( MYSQLI_ASSOC );

  $veranstaltungsliste = array();
  foreach ($row as $r1)

  {
      $veranstaltungsliste[] =  getVeranstaltung( $db, $r1, $jahr, $semester );
  }


  return $veranstaltungsliste;
}



function getVeranstaltung( $db, $r1, $jahr, $semester )
{  #  deb($r1,1);
     $sql2 = "SELECT * FROM `lva`  WHERE Jahr       = \"" . $jahr
        . "\"  AND Semester     = \"" . $semester
        . "\"  AND Studiengang  = \"" . $r1[ 'Studiengang' ]
        . "\"  AND FachKurz     = \"" . $r1[ 'Fach'        ]  ."\"";

    $result2 = $db -> query( $sql2 );
    $row2    = $result2 -> fetch_all( MYSQLI_ASSOC );
    $r1[ 'SWS' ] = $row2[ 0 ][ "SWS" ];

    $sql3 = "SELECT * FROM `Fach`  WHERE Kurz       = \"" .  $r1[ 'Fach'        ]  ."\"";
    $result3 = $db -> query($sql3);
    $row3 = $result3 -> fetch_all( MYSQLI_ASSOC );

    $r1[ 'FachL'  ] = $row3[ 0 ][ "Name" ];
    $r1[ 'LVS'    ] = $r1[ 'K' ] *  $r1[ 'SWS' ]    ;
    $r1[ 'Anteil' ] = ( int ) ( $r1[ 'K' ] * 100 ) ;

    return  $r1;

}

function getEntlastungsliste($db,  $dozentKurz, $jahr, $semester)
{
  $sql5   = "SELECT * FROM `auslastungsgrund`  ORDER BY Grund";
  $result = $db -> query( $sql5 );
  $row    = $result -> fetch_all( MYSQLI_ASSOC );
  
  foreach ( $row as $r2 )
  { $auslastung[ $r2[ 'Grund' ] ] = $r2[ 'Text' ];
  }
  
  $sql4 = "SELECT * FROM `auslastung` WHERE Jahr =     \"" . $jahr
                                . "\" AND DozentKurz = \"" . $dozentKurz
                                . "\" AND Semester =   \"" . $semester
                                . "\" ORDER BY Grund";
  $result = $db -> query( $sql4 );

  $row = $result -> fetch_all( MYSQLI_ASSOC );
  $entlastungsliste = array();
  foreach ($row as $r3)
  {  $r3[ 'auslastungsGrund' ] = $auslastung[ $r3[ 'Grund' ] ];
     $entlastungsliste[] =  $r3;
  }
  return $entlastungsliste;
}


function getBeteiligungsliste($db,  $veranstaltungsliste )
{
  $beteiligungsliste = array();

  foreach ($veranstaltungsliste as $veranstaltung )
  {
    if ($veranstaltung ['K'] < 1)
    { $beteiligungsliste[] = getBeteiligung( $db, $veranstaltung );

    }

  }

    /*
    $sql5   = "SELECT * FROM `auslastungsgrund`  ORDER BY Grund";
    $result = $db -> query( $sql5 );
    $row    = $result -> fetch_all( MYSQLI_ASSOC );

    foreach ( $row as $r2 )
    { $auslastung[ $r2[ 'Grund' ] ] = $r2[ 'Text' ];
    }

    $sql4 = "SELECT * FROM `auslastung` WHERE Jahr =     \"" . $jahr
        . "\" AND DozentKurz = \"" . $dozentKurz
        . "\" AND Semester =   \"" . $semester
        . "\" ORDER BY Grund";
    $result = $db -> query( $sql4 );

    $row = $result -> fetch_all( MYSQLI_ASSOC );
    $entlastungsliste = array();
    foreach ($row as $r3)
    {  $r3[ 'auslastungsGrund' ] = $auslastung[ $r3[ 'Grund' ] ];
        $entlastungsliste[] =  $r3;
    }
    */
    return $beteiligungsliste;
}



function getBeteiligung($db,  $veranstaltung )
{
    $beteiligungAlle = array();

  #  SELECT * FROM `fach` ORDER BY Name  ASC , Name  ";

    $sql6 = " SELECT * FROM beteiligung WHERE Fach = \"".$veranstaltung['Fach']."\" AND Studiengang = \"" . $veranstaltung['Studiengang'] . "\"  AND Jahr = \"".$veranstaltung ['Jahr']. "\" AND Semester = \"".$veranstaltung['Semester']."\" ORDER BY DozentKurz ASC;";


    $result = $db -> query($sql6);

    $row = $result -> fetch_all(MYSQLI_ASSOC);

    foreach ($row as $beteiligung)
    {

        $beteiligung['dozent']   =  getDozent($db,$beteiligung['DozentKurz'] ) ;

        $beteiligungAlle[] =   getVeranstaltung($db, $beteiligung, $beteiligung['Jahr'], $beteiligung['Semester']);
    }

    return $beteiligungAlle;
}





function getFaecherListe( $db )
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






function getStudiengangListe( $db )
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



function getDepartmentListe( $db )
{
  $departmentliste = array();
  $sql6 = "SELECT * FROM `department` ORDER BY Name  ASC , Name  ";
  $result = $db -> query($sql6);
  
  $row = $result -> fetch_all(MYSQLI_ASSOC);
  
  foreach ($row as $r4)
  {  $departmentliste[] = $r4;
  }
  
  return $departmentliste;
}



function getDozentenListe( $db )
{
  
  $dozentenliste = array();
  
  $sql6 = "SELECT * FROM `dozent` ORDER BY Name  ";
  $result = $db -> query($sql6);
  
  $row = $result -> fetch_all(MYSQLI_ASSOC);
  
  foreach ($row as $r4)
  {
    $r4[ 'Anrede' ] = setAnrede( $r4 );
    $dozentenliste[] = $r4;
  }
 
  return $dozentenliste;
}

function getDozentenListeSem( $db )
{ $jahr     =  $_SESSION[ 'aktuell' ][ 'Jahr'     ] ;
  $semester =  $_SESSION[ 'aktuell' ][ 'Semester' ] ;
  
  $dozentenliste = array();
  
  $sql6 = "SELECT * FROM `dozent` ORDER BY Status DESC, Name  ";
  $result = $db -> query( $sql6 );
  
  $row = $result -> fetch_all( MYSQLI_ASSOC );
  
  foreach ($row as $r4)
  {
    $r4[ 'AnzV'   ] = sizeof( getVeranstaltungsliste( $db, $r4[ 'Kurz' ], $jahr, $semester ) );
    $r4[ 'AnzE'   ] = sizeof( getEntlastungsliste(    $db, $r4[ 'Kurz' ], $jahr, $semester ) );
    $r4[ 'Anrede' ] = setAnrede( $r4 );

    $r4[ 'aktuell' ] =   getArbeitszeitliste( $db, $r4[ 'Kurz' ], $jahr, $semester )[ 'aktuell' ];   ;

    if ($r4[ 'AnzV'   ] > 0 OR   $r4[ 'AnzE'   ] > 0 )   # Liste 1: Dozenten mit Lehre oder Entlastung
    {  $tmpListe1[] = $r4;}
    else
    { $tmpListe2[] = $r4;}                                # Liste  2: Dozenten ohne Lehre und ohne Entlastung
    
  }
  foreach ($tmpListe2 as $tl2)
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
}

function getDozent( $db, $dozentKurz)
{ $sql6 = "SELECT * FROM `dozent` WHERE  Kurz =\"". $dozentKurz ."\"";
  $result = $db -> query($sql6);
  
  $row = $result -> fetch_all(MYSQLI_ASSOC);
  
  foreach ($row as $r4)
  {  $dozent = $r4;
  }
  return $dozent;
}


function getDozentLV( $db, $dozentKurz, $jahr, $semester)
{  $sql7 = "SELECT * FROM `lehrverpflichtung` WHERE Jahr = \"" . $jahr . "\" AND DozKurz = \"". $dozentKurz ."\"  AND Semester = \"". $semester ."\"";
   $result = $db -> query($sql7);
   $row = $result -> fetch_all(MYSQLI_ASSOC);

  foreach ($row as $r7)
  {
    $dozentLV = $r7;
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


function getFaecherListeForLiveSeach( )
{
    $db = connectDB();
    $faecherliste = array();
    $sql6 = "SELECT * FROM `fach` ORDER BY Name  ASC , Name  ";
    $result = $db -> query($sql6);

    $row = $result -> fetch_all(MYSQLI_ASSOC);

    foreach ($row as $r4)
    {  $faecherliste[] = $r4;
    }

    return $faecherliste;
}
