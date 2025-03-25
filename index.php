<?php
session_start();

include_once( "lib/tools.lib.php"  );
include_once( "lib/db.lib.php"     );
include_once( "lib/render.lib.php" );




if ( isset( $_GET[ 'action'      ]  ) )
{

if     ( $_GET[ 'action' ] == 'lad'  )    ## -- Hauptliste -- Liste mit allen Dozierenden --
{ getRenderAlleDozentenSem();
}

else if( $_GET[ 'action' ] == 'sb'   )    ## -- aktuelle Stundenbilanz eines Dozierenden --
{ getStundenbilanz( );
}

else if( $_GET[ 'action' ] == 'azkt' )    ## -- aktueller Stand des Arbeistzeitkontos eines Dozierenden --
{ getStandArbeitszeitkonto( );
}

else if( $_GET[ 'action' ] == 'edoz' )    ## -- Basisliste mit allen Dozierenden --
{ getRenderAlleDozenten();
}

else if( $_GET[ 'action' ] == 'ef'   )    ## -- Basisliste mit allen Fächern --
{ getRenderAlleFaecher();
}

else if( $_GET[ 'action' ] == 'edep' )    ## -- Basisliste mit allen Departments --
{ getRenderAlleDepartments();
}

else if( $_GET[ 'action' ] == 'esg'  )    ## -- Basisliste mit allen Studiengängen --
{ getRenderAlleStudiengang();
}

else if( $_GET[ 'action' ] == 'eeg'  )    ## -- Basisliste mit allen Entlastungsgründen --
{ getRenderAlleEntlastungsgruenden();
}

else if( $_GET[ 'action' ] == 'ad'   )    ## -- Login Spinwheel  --
{ renderLoading();
}

else if( $_GET[ 'action' ] == 'ls'   )    ## -- Login Screen  --
{ getRenderLoginscreen();
}

else if( $_GET[ 'action' ] == 'ss'   )    ## -- Spash Screen  --
{ getRenderSplashscreen();
}

}

else
{ init();                  ## -- Initialisierung, Startseite mit Menu und Content-Iframes --
}

?>