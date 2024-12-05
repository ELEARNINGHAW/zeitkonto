<?php

function connectDB()
{ $db = new mysqli("localhost", "zeitkonto", "zeitkonto", "zeitkonto");
  if ($db -> connect_errno)
  { echo "Failed to connect to MySQL: " . $db->connect_error;
    exit();
  }
  return ($db);
}

function getVeranstaltungsliste( $db, $dozentKurz, $jahr, $semester )
{ $veranstaltungsliste = array();
  
  $sql1   = "SELECT * FROM `beteiligung` WHERE Jahr     = \"" . $jahr
                                   . "\" AND DozentKurz = \"". $dozentKurz
                                   . "\" AND Semester   = \"". $semester
                                   . "\" ORDER BY Fach";
  
  $result = $db -> query($sql1);
  $row    = $result -> fetch_all( MYSQLI_ASSOC );
  
  foreach ($row as $r1)
  {  $sql2 = "SELECT * FROM `lva`  WHERE Jahr       = \"" . $jahr
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

    $veranstaltungsliste[] = $r1;
  }
 
 # deb($veranstaltungsliste); die();
  return $veranstaltungsliste;
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
  $result = $db -> query($sql6);
  
  $row = $result -> fetch_all(MYSQLI_ASSOC);
  
  foreach ($row as $r4)
  { $r4[ 'AnzV'   ] = sizeof( getVeranstaltungsliste( $db, $r4[ 'Kurz' ], $jahr, $semester ) );
    $r4[ 'AnzE'   ] = sizeof( getEntlastungsliste(    $db, $r4[ 'Kurz' ], $jahr, $semester ) );
    $r4[ 'Anrede' ] = setAnrede( $r4 );
    
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
  {  $dozentLV = $r7;
  }
  return $dozentLV;
}
