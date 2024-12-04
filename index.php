<?php
session_start();
include_once( "lib/tools.lib.php"  );
include_once( "lib/db.lib.php"     );
include_once( "lib/render.lib.php" );


$jahr       =  $_GET[ 'jahr'       ] ;
$dozentKurz =  $_GET[ 'dozentKurz' ] ;
$semester   =  $_GET[ 'semester'   ] ;
$output     =  $_GET[ 'output'     ] ;


$_SESSION[ 'aktuell' ][ 'Jahr'     ] = '2023';
$_SESSION[ 'aktuell' ][ 'Semester' ] = 'S';


if( $_GET['action'] == 'sb')
{
 getStundenbilanz( $jahr, $dozentKurz , $semester, $output );
}

if( $_GET['action'] == 'ad')
{
  getRenderAlleDozenten();
}

?>