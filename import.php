<?php

$facher = importFachCSV( "Zeitkontenerfassung.csv" );
#deb($facher);

importEntlastung( $facher );

#importLVA($facher); ## Importiert neue LVA in die DB

#importBeteiligung( $facher );

/*
foreach ($facher as $f) {
 $T[] = $f['Gruppen'];
 $B[] = $f['Betreuung'];
 $K[] = $f['Anteil'];
 $SG[] = $f[ 'Studiengruppe' ];
}
deb($SG);
deb($T);
deb($B);
deb($K);
*/
/**/




#$projekte   = importAbschlussarbeitenCSV( 'abschlussW23.csv' , 'W23' );

#$projekte   = importAbschlussarbeitenCSV( 'abschlussS24.csv' , 'S24' );






function checkDozent( $dozenten )
{ $db = connectDB();
  foreach ( $dozenten as $dozent )
  { $dozent = trim(strip_tags( $dozent ) , "   ");
    $sql = "SELECT COUNT(*) AS C FROM dozent WHERE Name LIKE LOWER('".$dozent."')";

    foreach ($db->query($sql) as $row)
    { if ( $row['C'] == 0 )
      {  $d[$dozent] = $dozent;
      }
    }
  }
$db->close();
}

function getAlleDozenten( $param = null )
{ $db = connectDB();
  $sql = "SELECT *  FROM dozent ";

  foreach ($db->query($sql) as $row)
  {
    if     ($param == 'K') { $dozenten[ $row['Kurz'] ] =  $row ; }
    else                   { $dozenten[ $row['Name'] ] =  $row ; }
  }
  $db->close();
  return $dozenten;
}


function importBeteiligung( $lvas )
{
  $db = connectDB();
  foreach ( $lvas as $lva ) {

## +----------------------------------------------------------------------------------------------------------------------------------------------
  $sql3 = "SELECT COUNT(*) AS C FROM `beteiligung`";

  $sql3 .= " WHERE `Jahr`     LIKE '" . ($lva['sem']['j'] + 2000) . "'";
  $sql3 .= " AND `Semester`   LIKE '" . $lva['sem']['s'] . "'";
  $sql3 .= " AND `DozentKurz`    LIKE '" . $lva['doz']['Kurz'] . "'";
  $sql3 .= " AND `Fach`     LIKE '" . $lva[ 'imp' ][ 'k-base' ] . "'";
  $sql3 .= " AND `Studiengang`     LIKE '" . $lva['Studiengruppe'] . "'";

  foreach ($db->query($sql3) as $row)
  { if ($row['C'] == 0) {
    $sql4 = "   INSERT INTO  `beteiligung`      (`DozentKurz`, `Jahr`, `Semester`, `Fach`, `Studiengang`, `Kommentar` , `T`, `B`, `K` , `Status` ) ";
    $sql4 .= " VALUES('" . $lva[ 'doz' ][ 'Kurz'   ] ."', '" .($lva[ 'sem' ][ 'j'      ] + 2000) ."', '" . $lva[ 'sem' ][ 's'      ] ."', '" . $lva[ 'imp' ][ 'k-base' ] ."', '" . $lva[ 'Studiengruppe' ]         ." ', '" . $lva[ 'Kommentar' ]         ." ', '" . $lva[ 'Gruppen' ]         ."', '" . $lva[ 'Betreuung' ]         ."', '" . ( $lva[ 'Anteil' ] / 100 ) . "' , '" . $lva[ 'doz' ][ 'Status'   ]      ."'); ";

    deb("Import Dataset LV ! " . $sql4 );
    $result = $db->query($sql4);
    }
    else
    {  deb("Dataset already exists in lehrverpflichtung! " . $sql3);
    }
  }
 }
}


function importEntlastung( $lvas )
{
  $db = connectDB();

 $entlastung = importEntlastungCSV( 'entlastung.csv' );

  $dozenten = getAlleDozenten( );

#deb($dozenten);

  foreach ( $entlastung as $ent ) {

 #   deb($dozenten);
    $ent['Grund']   =  'P' ;
    $ent['doz']['Kurz']   = ucfirst( $dozenten[ $ent['NameDoz'] ] ['Kurz'] );
    $ent['doz']['Status']   =  $dozenten[ $ent['NameDoz'] ] ['Status'] ;
  $ent['LVS'] = str_replace(  ',', '.' ,$ent['LVS']);


## +----------------------------------------------------------------------------------------------------------------------------------------------
    $sql3 = "SELECT COUNT(*) AS C FROM `auslastung`";

    $sql3 .= " WHERE `Jahr`     LIKE '" . ( $ent['sem']['j2']) . "'";
    $sql3 .= " AND `Semester`   LIKE '" . $ent['sem']['s'] . "'";
    $sql3 .= " AND `DozentKurz` LIKE '" . $ent['doz']['Kurz'] . "'";
     $sql3 .= " AND `Status`     LIKE '" . $ent['doz']['Status'] . "'";

    #deb($sql3,1);

    foreach ($db->query($sql3) as $row)
    { if ($row['C'] == 0) {

      $sql4  ="  INSERT INTO `auslastung` (  `Jahr`, `Semester`, `DozentKurz`, `LVS`, `Grund`, `Kommentar` , `Erfassung`  , `Status`)";
      $sql4 .=" VALUES                    (  '".$ent['sem']['j2']."', '".$ent['sem']['s']."'  , '".$ent['doz']['Kurz']."' , ".$ent['LVS'].", '".$ent['Grund']."'    , '".$ent['Thema']."', current_timestamp(), '".$ent['doz']['Status']."')";
      deb("Import Dataset auslastung ! " . $sql4  );
      $result = $db->query($sql4);
    }
    else
    {  deb("Dataset already exists in auslastung! " . $sql3);
    }
    }
  }
}



function importLVA( $lvas )
{ $db = connectDB();
  foreach ( $lvas as $lva )
  {

    ## +----------------------------------------------------------------------------------------------------------------------------------------------
    $sql3  = "SELECT COUNT(*) AS C FROM `lehrverpflichtung`";
    $sql3 .= " WHERE `Jahr`     LIKE '" . ($lva[ 'sem' ][ 'j'     ] + 2000 ) ."'";
    $sql3 .= " AND `Semester`   LIKE '" .  $lva[ 'sem' ][ 's'     ]  ."'";
    $sql3 .= " AND `DozKurz`    LIKE '" . $lva[ 'doz' ][ 'Kurz'   ]  ."'";
    $sql3 .= " AND `Status`     LIKE '" . $lva[ 'doz' ][ 'Status' ]  ."'";

    deb("lehrverpflichtung! " . $sql3 );
    foreach ( $db -> query( $sql3 ) as $row )
    { if ( $row[ 'C' ] == 0 )
    {

      $sql4 ="INSERT INTO `lehrverpflichtung` (`DozKurz` ,  `Status`  , `Jahr` , `Semester` , `Pflicht` ) ";
      $sql4 .= "VALUES                        ('" . $lva[ 'doz' ][ 'Kurz' ] ."' , '" . $lva[ 'doz' ][ 'Status' ] ."', '" . ($lva[ 'sem' ][ 'j'      ] + 2000 ) ."' , '" . $lva[ 'sem' ][ 's'  ] ."', '".$lva['doz']['Pflicht_weg']."' )";

      deb("Import Dataset LV ! ". $sql4 );
       $result = $db -> query( $sql4 );
     # deb( $result,1 );
    }
    else
    { deb("Dataset already exists in lehrverpflichtung! " . $sql3 );
    }
    }


    ## +----------------------------------------------------------------------------------------------------------------------------------------------
    $sql1 = "SELECT COUNT(*) AS C FROM `lva` WHERE `Jahr` = ". ( $lva['sem']['j']  + 2000 ) ." AND `Semester` LIKE '".$lva['sem']['s']."' AND `FachKurz` LIKE '".$lva['imp']['k-base']."' AND `Studiengang` LIKE '" .$lva['Studiengruppe']."'";

    foreach ( $db -> query( $sql1 ) as $row )
    { if ( $row[ 'C' ] == 0 )
      {
        $sql ="INSERT INTO `lva`  (`Jahr`, `Semester`, `Kommentar`, `FachKurz`, `Studiengang`, `SWS` , `DepartmentKurz`)  VALUES            (".($lva['sem']['j']  + 2000 ).",        '".$lva['sem']['s']."',       '".$lva['Kommentar']."', '".$lva['imp']['k-base']."',     '".$lva['Studiengruppe'] ."' , '".$lva['LVS-Prof']."',  NULL); ";
        deb("Import Dataset LVA! ". $sql );
        $result = $db->query($sql);
        deb($result,1);
      }
      else
      { deb("Dataset already exists in lva! " . $sql1 );
      }
    }
  #deb($sql);
  }

}

function getDozentKurzName( $dozent )
{ $db = connectDB();
  $kurz = '';
  $dozent = trim(strip_tags( $dozent ) , "   ");
  $sql = "SELECT Kurz AS K FROM dozent WHERE Name LIKE LOWER('" .$dozent. "')";

  foreach ($db->query($sql) as $row)
  {  $kurz =  $row['K'] ;
  }
  $db->close();
  return $kurz;
}

function getKurzNameDB( $db, $fachName )
{ $a[ 'k-base' ] ='';
   { $sql = "SELECT `Kurz` FROM `fach` WHERE Name LIKE '" .$fachName. "'";
     $res2 = $db -> query( $sql );
     foreach ( $res2 as $r )  {  $a['k-base'] =  $r[ 'Kurz' ] ; }
    }
    return  $a['k-base'];
}

function getStatusDB( $db, $fachName )
{ $a[ 'k-base' ] ='';
  { $sql = "SELECT `Status` FROM `fach` WHERE Name LIKE '" .$fachName. "'";
    $res2 = $db -> query( $sql );
    foreach ( $res2 as $r )  {  $a['k-base'] =  $r[ 'Status' ] ; }
  }
  return  $a['k-base'];
}


function getFachNameDB( $db,  $fachKurz )
{ $a[ 'n-base' ] ='';
  { $sql1 = "SELECT `Name` FROM `fach` WHERE LOWER( Kurz ) LIKE LOWER( '" .$fachKurz. "' )";
    $res1 = $db -> query( $sql1 );
    foreach ( $res1 as $r )  {  $a[ 'n-base' ] =  $r[ 'Name' ] ; }
  }
  return  $a[ 'n-base' ];
}

function importFachCSV( $filename )
{ $row = 0;
  if ( ( $handle = fopen( $filename, "r" ) ) !== FALSE )
  { while ( ( $data = fgetcsv( $handle, 2000, ";" ) ) !== FALSE )
     { $zk = null;
       if ( ++$row > 1 )
       { $zk[ trim( $h[ 0  ] )] = trim( $data[ 0  ]) ;
         $zk[ $h[ 1  ] ] = trim( $data[ 1  ]) ;
         $zk[ $h[ 2  ] ] = trim( $data[ 2  ]) ;
         $zk[ $h[ 3  ] ] = trim( $data[ 3  ]) ;
         $zk[ $h[ 4  ] ] = trim( $data[ 4  ]) ;
         $zk[ $h[ 5  ] ] = trim( $data[ 5  ]) ;
         $zk[ $h[ 6  ] ] = trim( $data[ 6  ]) ;
         $zk[ $h[ 7  ] ] = trim( $data[ 7  ]) ;
         $zk[ $h[ 8  ] ] = trim( $data[ 8  ]) ;
         $zk[ $h[ 9  ] ] = trim( $data[ 9  ]) ;
         $zk[ $h[ 10 ] ] = trim( $data[ 10  ]) ;
         $zk[ $h[ 11 ] ] = trim( $data[ 11  ]) ;
         $zk[ $h[ 12 ] ] = trim( $data[ 12  ]) ;
         $zk[ $h[ 13 ] ] = trim( $data[ 13  ]) ;

         $zeitkonten[] = $zk;

         $dozent[ $row ] = $data[ 0 ];
         $fach[   $row ] = $data[ 3 ];
      }
      else{  $h = $data; }
    }
   fclose( $handle );
  }

  $dozenten =  getAlleDozenten( );

  $db = connectDB();
  foreach ( $zeitkonten as $zk )
  {
    $zk[ 'LV-Name' ] =  trim( strip_tags( $zk[ 'LV-Name' ] ) , "   #+*'" );  ## unültige Zeichen aus Datum entfernen
    $zk[ 'LV-Kurz' ] =  trim( strip_tags( $zk[ 'LV-Kurz' ] ) , "   "     );

    $b[ 'doz'    ] = $zk[ 'Doz-Name' ] ;
    $b[ 'k-xlsx' ] = $zk[ 'LV-Kurz'  ];
    $b[ 'k-base' ] = getKurzNameDB( $db , $zk[ 'LV-Name' ] );
    $b[ 'n-xlsx' ] = $zk[ 'LV-Name' ];
    $b[ 'n-base' ] = getFachNameDB( $db , $zk[ 'LV-Kurz' ] );

    if ( $b[ 'n-base' ] != '' AND $b[ 'k-base' ] == '' )       ##  DB Fachname vorhanden aber KEIN DB Kurzname
    { $b[ 'k-base' ] =  getKurzNameDB( $db ,$b[ 'n-base' ] );  ##  DB Kurzname ermittelt aus DB Fachname
    }

    if ( $b[ 'k-base' ] != '' AND $b[ 'n-base' ] == '' )       ##  DB Kurzname vorhanden aber KEIN DB Fachname
    { $b[ 'n-base' ] =  getFachNameDB( $db ,$b[ 'k-base' ] );  ##  DB Fachname ermittelt aus DB Kurzname
    }

    $zk[ 'sem' ] = redefSemester( $zk[ 'Semester' ] );
    $zk[ 'imp' ] = $b;
    $zk[ 'doz' ] = $dozenten[ $zk[ 'Doz-Name' ] ];

    if ( $b[ 'k-base' ] != '' AND $b[ 'n-base' ] != '' )        ## Fehlerhafte und Fehlerfreie Datensätze trennen
    {  $g1[] = $zk['imp'];
    }
    else
    {  $g2[] = $zk['imp'];
    }
    $f[] = $zk;
  }

  #deb( $g1 );
   #deb( $g2 ,1);
  # deb($f);
    return $f;
    #$db->close();
}

function importEntlastungCSV( $filename )
{ $row = 0;
  if ( ( $handle = fopen( $filename, "r" ) ) !== FALSE )
  { while ( ( $data = fgetcsv( $handle, 2000, ";" ) ) !== FALSE )
  { $zk = null;
    if ( ++$row > 1 )
    { $zk[ trim( $h[ 0  ] ) ] = trim( $data[ 0  ]) ;
      $zk[ trim( $h[ 1  ] ) ] = $data[ 1  ];
      $zk[ trim( $h[ 2  ] ) ] = $data[ 2  ];
      $zk[ trim( $h[ 3  ] ) ] = $data[ 3  ];
      $zk[ trim( $h[ 4  ] ) ] = $data[ 4  ];
      $zk[ trim( $h[ 5  ] ) ] = $data[ 5  ];
      $zk[ 'sem' ] = redefSemester(  $zk[ trim( $h[ 1  ] ) ] );

      $zeitkonten[] = $zk;
    }
    else{  $h = $data; }
  }
    fclose( $handle );
  }

  #deb($zeitkonten);
return $zeitkonten;
}


function importAbschlussarbeitenCSV( $filename,$sem )
{ $row = 0;
  if ( ( $handle = fopen( $filename, "r" ) ) !== FALSE )
  { while ( ( $data = fgetcsv( $handle, 2000, ";" ) ) !== FALSE )
  { $zk = null;
    if ( ++$row > 1 )
    { $zk[ trim( $h[ 0  ] ) ] = trim( $data[ 0  ]) ;
      $zk[ trim( $h[ 1  ] ) ] = $data[ 1  ];
      $zk[ trim( $h[ 2  ] ) ] = $data[ 2  ];
      $zk[ trim( $h[ 3  ] ) ] = $data[ 3  ];
      $zk[ trim( $h[ 4  ] ) ] = $data[ 4  ];
      $zk[ trim( $h[ 5  ] ) ] = $data[ 5  ];
      $zk[ $h[ 6 ] ] = $data[ 6 ];
      $zk[ $h[ 7 ] ] = $data[ 7 ];

      $zeitkonten[] = $zk;

      if ( $data[ 2 ] != '' )
      { $curDoz = $data[ 2  ];
        $t[ trim( $h[ 2 ] ) ] = $data[ 2  ];
        $t[ trim( $h[ 1 ] ) ] = $data[ 1  ];
        $t[ 'Sem' ] = $sem;
      }

      $t[ trim( $h[ 7  ] ) ] = $data[ 7  ];

      $d[   $curDoz  ] =  $t;

    }
    else{  $h = $data; }
  }
    fclose( $handle );
  }

  deb($d);
  deb( $zeitkonten,1 );

}




function redefSemester( $sem )
{ if ( stristr($sem, 'WiSe' ) )   { $s[ 's' ] = 'W';  }
  if ( stristr($sem, 'SoSe' ) )   { $s[ 's' ] = 'S';  }

  $s[ 'j' ] = substr( $sem, 5, 2 );
  $s[ 'j2' ] =  $s[ 'j' ] + 2000 ;

  return $s;
}

function connectDB()
{ $db = new mysqli("localhost", "zeitkonto", "zeitkonto", "zeitkonto");
  if ($db -> connect_errno)
  { echo "Failed to connect to MySQL: " . $db->connect_error;
    exit();
  }
  return ($db);
}

function setP2Praktikum ( $fachKurz )
{ $sl = strlen( $fachKurz );
  if ( $sl > 0  AND $fachKurz[ $sl - 1  ] == 'P'  AND ( $fachKurz[ $sl - 2  ] != ' ' )   AND ( $sl > 2  ) )  ## Kurznamen mit P als letzer Buchstabe wird as Praktikum definiert und bekommt ein Leerzeichen als vorletztes Zeichen
  { $fachKurz[ strlen( $fachKurz ) - 1  ] = ' ';
    $fachKurz[ strlen( $fachKurz )      ] = 'P';
  }
  return $fachKurz;
}

function deb( $con, $kill = false )
{ echo "<pre>";
  print_r( $con );
  echo "</pre>";
  if($kill) {die(); }
}
?>
