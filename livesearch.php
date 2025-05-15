<?php
include_once( "lib/db.lib.php" );

$db   = connectDB();

$q = strip_tags( $_GET[ "q" ]);
$h = strtr( strip_tags( $_GET[ "h" ] ), " ", "_" );
$liste = getFaecherListeForLiveSeachDB( $db );

$hint  = "";
$closer =  '<div style="text-align: right; cursor: pointer;" onclick="closeResult( \''.$h.'\' );">[ X ]</div>';

if ( strlen( $q ) > 0 )
{
foreach ( $liste as $li )
{  if ( stristr( $li[ 'Name' ], $q ) OR stristr( $li[ 'Kurz' ], $q ) )
   { if     ( $hint == "" ) { $hint =               "<a href='x.php?v=".$li[ "Kurz" ]. "'>".$li[ 'Name' ].' ('.$li[ 'Kurz' ]. ')'."</a>" ; }
     else                   { $hint =  $hint . "<br/><a href='x.php?v=".$li[ "Kurz" ]. "'>".$li[ 'Name' ].' ('.$li[ 'Kurz' ]. ')'."</a>" ; }
   }
}
}

if ( $hint == "" ) { $response = "kein Vorschlag"; }
else               { $response = $hint;            }

echo $closer .   $response;


?>