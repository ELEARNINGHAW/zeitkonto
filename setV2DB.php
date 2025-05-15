<?php
/*

$v[ 'name'           ] ="Welte";
$v[ 'vorname'        ] ="Werner";
$v[ 'pflicht_weg'    ] ="12";
$v[ 'status'         ] ="Ami";
$v[ 'kurz'           ] ="www";
$v[ 'geschlecht'     ] ="m";
$v[ 'professur'      ] ="";
$v[ 'anrede'         ] ="x";
$v[ 'mailadresse'    ] ="werner.welte@haw-hamburg.de";
$v[ 'mailzustellung' ] ="1";
$v[ 'department'     ] ="VT";
$v[ 'zeitkonto'      ] ="1";

insertNewData( '$dozent',  $v );
*/

include_once( "lib/db.lib.php" );

$db   = connectDB();


if (isset( $_GET[ 'k' ]  ) ) { $key      =  $_GET[ 'k'  ] ; } else  { $key    =  0; }
if (isset( $_GET[ 'v' ]  ) ) { $value    =  $_GET[ 'v'  ] ; } else  { $value  =  0; }
if (isset( $_GET[ 't' ]  ) ) { $table    =  $_GET[ 't'  ] ; } else  { $table  =  0; }
if (isset( $_GET[ 'c' ]  ) ) { $col      =  $_GET[ 'c'  ] ; } else  { $col    =  0; }
if (isset( $_GET[ 'i' ]  ) ) { $id       =  $_GET[ 'i'  ] ; } else  { $id     =  0; }


if (isset($_GET[ 'action' ])  AND $_GET[ 'action' ] == 'sado' )
{
    if ( isset( $_GET[ 'name'           ] ) AND $_GET[ 'name'           ] != '' ) { $v[ 'name'           ] = $_GET[ 'name'           ]; } else { $v[ 'name'            ] = ''  ; }
    if ( isset( $_GET[ 'vorname'        ] ) AND $_GET[ 'vorname'        ] != '' ) { $v[ 'vorname'        ] = $_GET[ 'vorname'        ]; } else { $v [ 'vorname'        ] = ''  ; }
    if ( isset( $_GET[ 'pflicht_weg'    ] ) AND $_GET[ 'pflicht_weg'    ] != '' ) { $v[ 'pflicht_weg'    ] = $_GET[ 'pflicht_weg'    ]; } else { $v [ 'pflicht_weg'    ] = ''  ; }
    if ( isset( $_GET[ 'status'         ] ) AND $_GET[ 'status'         ] != '' ) { $v[ 'status'         ] = $_GET[ 'status'         ]; } else { $v [ 'status'         ] = ''  ; }
    if ( isset( $_GET[ 'kurz'           ] ) AND $_GET[ 'kurz'           ] != '' ) { $v[ 'kurz'           ] = $_GET[ 'kurz'           ]; } else { $v [ 'kurz'           ] = ''  ; }
    if ( isset( $_GET[ 'geschlecht'     ] ) AND $_GET[ 'geschlecht'     ] != '' ) { $v[ 'geschlecht'     ] = $_GET[ 'geschlecht'     ]; } else { $v [ 'geschlecht'     ] = ''  ; }
    if ( isset( $_GET[ 'professur'      ] ) AND $_GET[ 'professur'      ] != '' ) { $v[ 'professur'      ] = $_GET[ 'professur'      ]; } else { $v [ 'professur'      ] = ''  ; }
    if ( isset( $_GET[ 'anrede'         ] ) AND $_GET[ 'anrede'         ] != '' ) { $v[ 'anrede'         ] = $_GET[ 'anrede'         ]; } else { $v [ 'anrede'         ] = ''  ; }
    if ( isset( $_GET[ 'mailadresse'    ] ) AND $_GET[ 'mailadresse'    ] != '' ) { $v[ 'mailadresse'    ] = $_GET[ 'mailadresse'    ]; } else { $v [ 'mailadresse'    ] = ''  ; }
    if ( isset( $_GET[ 'mailzustellung' ] ) AND $_GET[ 'mailzustellung' ] != '' ) { $v[ 'mailzustellung' ] = $_GET[ 'mailzustellung' ]; } else { $v [ 'mailzustellung' ] = ''  ; }
    if ( isset( $_GET[ 'department'     ] ) AND $_GET[ 'department'     ] != '' ) { $v[ 'department'     ] = $_GET[ 'department'     ]; } else { $v [ 'department'     ] = ''  ; }
    if ( isset( $_GET[ 'zeitkonto'      ] ) AND $_GET[ 'zeitkonto'      ] != '' ) { $v[ 'zeitkonto'      ] = $_GET[ 'zeitkonto'      ]; } else { $v [ 'zeitkonto'      ] = ''  ; }

    insertNewData( $db , 'dozent' ,  $v );
    header('Location: index.php?action=edoz');

     #deb($v,1);
}


/**
 * @param $table
 * @param $key
 * @param $value
 * @param $col
 * @param $id
 * @return null
 */
function getValue($table, $key, $value, $col, $id)
{ return updateValue( $db , $table, $key, $value, $col, $id);
}

if ($col !=0 AND $table != 0 AND $key != 0  AND  $id != 0 )
{
if ($table == 'studiengang')
{  getValue($table, $key, $value, $col, $id);
}

if ($table == 'fach')
{ getValue($table, $key, $value, $col, $id);
}

if ($table == 'department')
{  getValue($table, $key, $value, $col, $id);
}

if ($table == 'dozent')
{  getValue($table, $key, $value, $col, $id);
}

if ($table == 'auslastungsgrund')
{  getValue($table, $key, $value, $col, $id);
}

}





function updateValue(  $db , $table,  $key, $value, $col, $id, $quote = true )
{
   $value = strip_tags( $value );
   if ( $quote )  $value  = '"' .$value .'"';
   $sql = ' UPDATE ' .$table. ' SET ' .$key. ' = '.$value. ' WHERE ' .$col . ' = "' .$id .'"';

   if ($db->query($sql) === TRUE) { $e = "Record updated successfully";            }
   else                           { $e =  "Error updating record: " . $db->error;  }

   $db->close();
   #echo $e;
   return $e;
}

function insertNewData(  $db ,$table,  $v )
{



    /*
$v[ 'name'           ] = checkInput($db, "name"           , $v['name'           ] );
$v[ 'vorname'        ] = checkInput($db, "vorname"        , $v['vorname'        ] );
$v[ 'pflicht_weg'    ] = checkInput($db, "pflicht_weg"    , $v['pflicht_weg'    ] );
$v[ 'status'         ] = checkInput($db, "status"         , $v['status'         ] );
$v[ 'kurz'           ] = checkInput($db, "kurz"           , $v['kurz'           ] );
$v[ 'geschlecht'     ] = checkInput($db, "geschlecht"     , $v['geschlecht'     ] );
$v[ 'professur'      ] = checkInput($db, "professur"      , $v['professur'      ] );
$v[ 'anrede'         ] = checkInput($db, "anrede"         , $v['anrede'         ] );
$v[ 'mailadresse'    ] = checkInput($db, "mailadresse"    , $v['mailadresse'    ] );
$v[ 'mailzustellung' ] = checkInput($db, "mailzustellung" , $v['mailzustellung' ] );
$v[ 'department'     ] = checkInput($db, "department"     , $v['department'     ] );
$v[ 'zeitkonto'      ] = checkInput($db, "zeitkonto"      , $v['zeitkonto'      ] );
*/
   # name  vorname pflicht_weg status kurz geschlecht professur anrede mailadresse mailzustellung department zeitkonto

  $sql = "INSERT INTO `dozent` (`Name`, `Vorname`, `Pflicht_weg`, `Status`, `Kurz`, `Geschlecht`, `Professur`, `Anrede`, `Mailadresse`, `Mailzustellung`, `Department`, `Zeitkonto`)";
  $sql .= " VALUES (  '".$v['name'] ."','". $v['vorname'] ."','". $v['pflicht_weg'] ."','". $v['status'] ."','". $v['kurz'] ."','". $v['geschlecht'] ."','". $v['professur'] ."','". $v['anrede'] ."','". $v['mailadresse'] ."','". $v['mailzustellung'] ."','". $v['department'] ."','". $v['zeitkonto']."')" ;


    if ($db->query($sql) === TRUE) { $e = "Record insert successfully";            }
    else                           { $e =  "Error inserting record: " . $db->error;  }

    $db->close();
    echo $e;

}


function deb($con, $kill = false)
{ echo "<pre>";
    print_r($con);
    echo "</pre>";
    if($kill) {die();}
}