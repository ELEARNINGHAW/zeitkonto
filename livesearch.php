<?php
include_once( "lib/db.lib.php" );

$q = strip_tags( $_GET[ "q" ]);
$h = strtr( strip_tags( $_GET[ "h" ] ), " ", "_" );
$liste = getFaecherListeForLiveSeach( );

$hint  = "";
$closer =  '<div style="text-align: right; cursor: pointer;" onclick="closeResult( \''.$h.'\' );">[ X ]</div>';

if ( strlen( $q ) > 0 )
{
foreach ( $liste as $li )
{  if ( stristr( $li[ 'Name' ], $q ) OR stristr( $li[ 'Kurz' ], $q ) )
   { if     ( $hint == "" ) { $hint =                   $li[ 'Name' ].' ('.$li[ 'Kurz' ]. ')' ; }
     else                   { $hint =  $hint . "<br />".$li[ 'Name' ].' ('.$li[ 'Kurz' ]. ')' ; }
   }
}
}

if ( $hint == "" ) { $response = "kein Vorschlag"; }
else               { $response = $hint;            }

echo $closer .   $response;


?>