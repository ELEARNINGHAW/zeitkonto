<?php

if (isset( $_GET[ 'k' ]  ) ) { $key      =  $_GET[ 'k'  ] ; } else  { $key    =  0; }
if (isset( $_GET[ 'v' ]  ) ) { $value    =  $_GET[ 'v'  ] ; } else  { $value  =  0; }
if (isset( $_GET[ 't' ]  ) ) { $table    =  $_GET[ 't'  ] ; } else  { $table  =  0; }
if (isset( $_GET[ 'c' ]  ) ) { $col      =  $_GET[ 'c'  ] ; } else  { $col    =  0; }
if (isset( $_GET[ 'i' ]  ) ) { $id       =  $_GET[ 'i'  ] ; } else  { $id     =  0; }


/**
 * @param $table
 * @param $key
 * @param $value
 * @param $col
 * @param $id
 * @return null
 */
function getValue($table, $key, $value, $col, $id)
{ return updateValue($table, $key, $value, $col, $id);
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


function updateValue( $table,  $key, $value, $col, $id, $quote = true )
{  $db = connectDB();
   $value = strip_tags( $value );
   if ( $quote )  $value  = '"' .$value .'"';
   $sql = ' UPDATE ' .$table. ' SET ' .$key. ' = '.$value. ' WHERE ' .$col . ' = "' .$id .'"';

   if ($db->query($sql) === TRUE) { $e = "Record updated successfully";            }
   else                           { $e =  "Error updating record: " . $db->error;  }

   $db->close();
   echo $e;
   return $e;
}

function connectDB()
{ $db = new mysqli("localhost", "zeitkonto", "zeitkonto", "zeitkonto");
  if ($db -> connect_errno)
  { echo "Failed to connect to MySQL: " . $db->connect_error;
    exit();
  }
  return ($db);
}
