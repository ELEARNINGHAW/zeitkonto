<?php
session_start();

include_once( "lib/tools.lib.php"  );
include_once( "lib/db.lib.php"     );
include_once( "lib/render.lib.php" );

$db   = connectDB();



/*
$x = getAuslastungsListeDB($db );
#deb( $x);
foreach ($x as $k=>$v){
    if( $v['Grund'] ==  'P') {
        $r[ $v['DozentKurz'].$v['Jahr'].$v['Semester'].$v['Grund']  ]['L'] += $v['LVS'];
        $r[ $v['DozentKurz'].$v['Jahr'].$v['Semester'].$v['Grund'] ]['c']++ ;
    }
  if($r[ $v['DozentKurz'].$v['Jahr'].$v['Semester'].$v['Grund']  ]['L'] > 4) { deb($r[ $v['DozentKurz'].$v['Jahr'].$v['Semester'].$v['Grund']  ],1); }
}

deb( $r,1 );

*/

if ( isset( $_GET[ 'action'      ]  ) )
{

if     ( $_GET[ 'action' ] == 'lad'  )    ## -- Hauptliste -- Liste mit allen Dozierenden --
{ getRenderAlleDozentenSem( $db );
}

if     ( $_GET[ 'action' ] == 'rec'  )    ## -- Hauptliste -- Liste mit allen Dozierenden --
{ getRecalcAlleDozenten( $db );
}



else if( $_GET[ 'action' ] == 'sb'   )    ## -- aktuelle Stundenbilanz eines Dozierenden --
{ getStundenbilanz( $db );
}

else if( $_GET[ 'action' ] == 'azkt' )    ## -- aktueller Stand des Arbeistzeitkontos eines Dozierenden --
{ getStandArbeitszeitkonto( $db  );
}

else if( $_GET[ 'action' ] == 'edoz' )    ## -- Basisliste mit allen Dozierenden --
{ getRenderAlleDozenten( $db );
}

else if( $_GET[ 'action' ] == 'ef'   )    ## -- Basisliste mit allen Fächern --
{ getRenderAlleFaecher( $db );
}

else if( $_GET[ 'action' ] == 'edep' )    ## -- Basisliste mit allen Departments --
{ getRenderAlleDepartments( $db );
}

else if( $_GET[ 'action' ] == 'esg'  )    ## -- Basisliste mit allen Studiengängen --
{ getRenderAlleStudiengang( $db );
}

else if( $_GET[ 'action' ] == 'eeg'  )    ## -- Basisliste mit allen Entlastungsgründen --
{ getRenderAlleEntlastungsgruenden( $db );
}

else if( $_GET[ 'action' ] == 'ad'   )    ## -- Login Spinwheel  --
{ getRenderLoading( $db );
}

else if( $_GET[ 'action' ] == 'ls'   )    ## -- Login Screen  --
{ getRenderLoginscreen(  );
}

else if( $_GET[ 'action' ] == 'ss'   )    ## -- Spash Screen  --
{ getRenderSplashscreen( );
}

}

else
{ init();                  ## -- Initialisierung, Startseite mit Menu und Content-Iframes --
}

?>