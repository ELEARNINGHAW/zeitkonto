<?php

#$facher = importFachCSV( "Zeitkontenerfassung.csv" );
#deb($facher);

#$entlastung = importEntlastungCSV( 'entlastung.csv' );

#$projekte   = importAbschlussarbeitenCSV( 'abschlussW23.csv' , 'W23' );

$projekte   = importAbschlussarbeitenCSV( 'abschlussS24.csv' , 'S24' );


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

function getAlleDozenten( )
{ $db = connectDB();
  $sql = "SELECT *  FROM dozent ";

  foreach ($db->query($sql) as $row)
  { $dozenten[ $row['Name']] =  $row ;
  }
  $db->close();
  return $dozenten;
}

function getDozentKurzName( $dozent )
{ $db = connectDB();
  $kurz = '';
  $dozent = trim(strip_tags( $dozent ) , "   ");
  $sql = "SELECT Kurz AS K FROM dozent WHERE Name LIKE LOWER('".$dozent."')";

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
         $zk[ $h[ 1  ] ] = $data[ 1  ];
         $zk[ $h[ 2  ] ] = $data[ 2  ];
         $zk[ $h[ 3  ] ] = $data[ 3  ];
         $zk[ $h[ 4  ] ] = $data[ 4  ];
         $zk[ $h[ 5  ] ] = $data[ 5  ];
         $zk[ $h[ 6  ] ] = $data[ 6  ];
         $zk[ $h[ 7  ] ] = $data[ 7  ];
         $zk[ $h[ 8  ] ] = $data[ 8  ];
         $zk[ $h[ 9  ] ] = $data[ 9  ];
         $zk[ $h[ 10 ] ] = $data[ 10 ];
         $zk[ $h[ 11 ] ] = $data[ 11 ];
         $zk[ $h[ 12 ] ] = $data[ 12 ];
         $zk[ $h[ 13 ] ] = $data[ 13 ];

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

  # deb( $g1 );
  # deb( $g2 );
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
 #     $zk[ $h[ 6  ] ] = $data[ 6  ];
 #     $zk[ $h[ 7  ] ] = $data[ 7  ];
 #     $zk[ $h[ 8  ] ] = $data[ 8  ];
 #     $zk[ $h[ 9  ] ] = $data[ 9  ];
 #     $zk[ $h[ 10 ] ] = $data[ 10 ];
 #     $zk[ $h[ 11 ] ] = $data[ 11 ];
 #     $zk[ $h[ 12 ] ] = $data[ 12 ];
 #     $zk[ $h[ 13 ] ] = $data[ 13 ];

      $zeitkonten[] = $zk;

 #     $dozent[ $row ] = $data[ 0 ];
 #     $fach[   $row ] = $data[ 3 ];
    }
    else{  $h = $data; }
  }
    fclose( $handle );
  }
  deb($zeitkonten,1);

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
      #     $zk[ $h[ 8  ] ] = $data[ 8  ];
      #     $zk[ $h[ 9  ] ] = $data[ 9  ];
      #     $zk[ $h[ 10 ] ] = $data[ 10 ];
      #     $zk[ $h[ 11 ] ] = $data[ 11 ];
      #     $zk[ $h[ 12 ] ] = $data[ 12 ];
      #     $zk[ $h[ 13 ] ] = $data[ 13 ];

      $zeitkonten[] = $zk;

      #     $dozent[ $row ] = $data[ 0 ];
      #     $fach[   $row ] = $data[ 3 ];

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
