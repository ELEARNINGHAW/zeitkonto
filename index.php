<?php
session_start();
include_once( "lib/tools.lib.php"  );
include_once( "lib/db.lib.php"     );
include_once( "lib/render.lib.php" );

if ( isset( $_GET[ 'action'      ]  ) )
{
if( $_GET[ 'action' ] == 'sb' )  ## -- aktuelle Stundenbilanz eines Dozierenden --
{ if (isset( $_GET[ 'jahr'       ]  ) ) { $jahr       =  $_GET[ 'jahr'       ] ; } else  { $jahr       =  0; }
  if (isset( $_GET[ 'semester'   ]  ) ) { $semester   =  $_GET[ 'semester'   ] ; } else  { $semester   =  0; }
  if (isset( $_GET[ 'dozentKurz' ]  ) ) { $dozentKurz =  $_GET[ 'dozentKurz' ] ; } else  { $dozentKurz =  0; }
  if (isset( $_GET[ 'output'     ]  ) ) { $output     =  $_GET[ 'output'     ] ; } else  { $output     =  0; }
  
  $_SESSION[ 'aktuell' ][ 'Jahr'     ] = $jahr;
  $_SESSION[ 'aktuell' ][ 'Semester' ] = $semester;
  
  getStundenbilanz( $jahr, $dozentKurz , $semester, $output );
}

if( $_GET[ 'action' ] == 'azkt' )  ## -- aktuelle Stand des Arbeistzeitkontos eines Dozierenden --
{ if (isset( $_GET[ 'jahr'       ]  ) ) { $jahr       =  $_GET[ 'jahr'       ] ; } else  { $jahr       =  0; }
  if (isset( $_GET[ 'semester'   ]  ) ) { $semester   =  $_GET[ 'semester'   ] ; } else  { $semester   =  0; }
  if (isset( $_GET[ 'dozentKurz' ]  ) ) { $dozentKurz =  $_GET[ 'dozentKurz' ] ; } else  { $dozentKurz =  0; }
  if (isset( $_GET[ 'output'     ]  ) ) { $output     =  $_GET[ 'output'     ] ; } else  { $output     =  0; }

  $_SESSION[ 'aktuell' ][ 'Jahr'     ] = $jahr;
  $_SESSION[ 'aktuell' ][ 'Semester' ] = $semester;

  getStandArbeitszeitkonto( $jahr, $dozentKurz , $semester, $output );
}

if( $_GET[ 'action' ] == 'ad' )  ## -- Hauptliste -- Liste mit allen Dozierenden --
{ if (isset( $_GET[ 'jahr'       ]  ) ) { $jahr       =  $_GET[ 'jahr'      ] ; } else  { $jahr     =  0; }
  if (isset( $_GET[ 'semester'   ]  ) ) { $semester   =  $_GET[ 'semester'  ] ; } else  { $semester =  0; }
  
  $_SESSION[ 'aktuell' ][ 'Jahr'     ] = $jahr;
  $_SESSION[ 'aktuell' ][ 'Semester' ] = $semester;
  getRenderAlleDozentenSem();
}
  
  if( $_GET[ 'action' ] == 'edoz' )  ## -- Basisliste mit allen Dozierenden --
  {    getRenderAlleDozenten();
  }

  if( $_GET[ 'action' ] == 'ef' )    ## -- Basisliste mit allen Fächern --
  {  getRenderAlleFaecher();
  }
  
  if( $_GET[ 'action' ] == 'edep' )  ## -- Basisliste mit allen Departments --
  {  getRenderAlleDepartments();
  }

  if( $_GET[ 'action' ] == 'esg' )   ## -- Basisliste mit allen Studiengängen --
  {  getRenderAlleStudiengang();
  }
}

else
{  renderMainSide();                  ## -- Startseite mit Menu und Content-Iframes --
}

?>