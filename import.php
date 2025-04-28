7
<?php
$row = 0;
if ( ( $handle = fopen("Zeitkontenerfassung.csv", "r" ) ) !== FALSE )
{ while ( ( $data = fgetcsv( $handle, 2000, ";" ) ) !== FALSE )
  {  $num = count( $data );
     # echo "<p> $num Felder in Zeile $row: <br /></p>\n";
     if ( ++$row > 1 )
     {
        $zeitkonto[ $row ] = $data;
        $dozent[ $row ] = $data[ 0 ];
        $fach[   $row ] = $data[ 3 ];
      }
   }
   fclose( $handle );
   # checkDozent( $dozent );
   checkFach( $zeitkonto );
}

function checkDozent( $dozenten )
{ $db = connectDB();
  foreach ( $dozenten as $dozent )
  {  $dozent = trim(strip_tags( $dozent ) , "   ");
     $sql = "SELECT COUNT(*) AS C FROM LOWER(`dozent`) WHERE Name LIKE LOWER('".$dozent."')";

     foreach ($db->query($sql) as $row)
    {  if ( $row['C'] == 0 )
       {  $d[$dozent] = $dozent;
       }
   }
}

deb($d);
$db->close();
}

function checkFach( $zeitkonten )
{  $db = connectDB();
   foreach ( $zeitkonten as $zk )
   {  $fachKurz = trim( strip_tags( $zk[3] ) , "   ");
      $sl = strlen($fachKurz);

      if ( $sl > 0  AND $fachKurz[ $sl - 1  ] == 'P'  AND ( $fachKurz[ $sl - 2  ] != ' ' )   AND ( $sl > 2  ) )
      {  $fachKurz[ strlen($fachKurz) - 1  ] = ' ';
         $fachKurz[ strlen($fachKurz)   ] = 'P';

      }
      $zk[3] = $fachKurz;

      $fachName = trim( strip_tags( $zk[2] ) , "   #+*'");

      $zk[ 2 ] = $fachName;

      $sql1 = "SELECT COUNT( * ) AS C1 FROM `fach` WHERE LOWER(Kurz) LIKE LOWER('".$fachKurz."')";
      $sql2 = "SELECT COUNT( * ) AS C2 FROM `fach` WHERE LOWER(Name) LIKE LOWER('".$fachName."')";

      $b['doz'] = $zk[0];

      $res1 = $db -> query( $sql1 );   foreach ( $res1 as $r )  { $c1 = $r[ 'C1' ]; }  $zk[ 'k' ] = $c1;
      $a['n-base'] ='';
      #if( $c1 > 0 )
      { $sql1 = "SELECT `Name` FROM `fach` WHERE LOWER(Kurz) LIKE LOWER('".$fachKurz."')";
       # deb($sql1);
        $res1= $db -> query( $sql1 );
        foreach ( $res1 as $r )  {  $a['n-base'] =  $r['Name'] ; }
      }


      $a['k-base'] ='';
      $res2 = $db -> query( $sql2 );   foreach ( $res2 as $r )  { $c2 = $r[ 'C2' ]; }  $zk[ 'n' ] = $c2;
      #if( $c2 > 0 )
      { $sql = "SELECT `Kurz` FROM `fach` WHERE Name LIKE '".$zk[2]."'";
        $res2 = $db -> query( $sql );
        foreach ( $res2 as $r )  {  $a['k-base'] =  $r['Kurz'] ; }
      }

      $b[ 'k-xlsx' ] = $zk[ 3 ];
      $b[ 'k-base' ] = ''      ;
      if ( isset( $a[ 'k-base' ] ) ) { $b[ 'k-base'] = $a[ 'k-base' ]; }
      $b[ 'n-xlsx' ] = $zk[ 2 ];
      $b[ 'n-base' ] = ''      ;
      if ( isset( $a[ 'n-base' ] ) ) { $b[ 'n-base'] = $a[ 'n-base' ]; }

      $zk[ 13 ] = $b;


      $f[ $zk[ 3 ] ] = $zk;

   }

   # deb($z);
    deb( $f );
    $db->close();
}




function connectDB()
{ $db = new mysqli("localhost", "zeitkonto", "zeitkonto", "zeitkonto");
    if ($db -> connect_errno)
    { echo "Failed to connect to MySQL: " . $db->connect_error;
        exit();
    }
    return ($db);
}


function deb($con, $kill = false)
{ echo "<pre>";
    print_r($con);
    echo "</pre>";
    if($kill) {die();}
}




?>
