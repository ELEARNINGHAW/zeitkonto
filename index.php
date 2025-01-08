<?php
session_start();
include_once( "lib/tools.lib.php"  );
include_once( "lib/db.lib.php"     );
include_once( "lib/render.lib.php" );

if ( isset( $_GET[ 'action'      ]  ) )
{
if( $_GET[ 'action' ] == 'sb' )  ## -- aktuelle Stundenbilanz eines Dozierenden --
{ $g = checkGetInput();
  getStundenbilanz( $g['jahr'], $g['dozentKurz'] , $g['semester'], $g['output'] );
}

if( $_GET[ 'action' ] == 'azkt' )  ## -- aktuelle Stand des Arbeistzeitkontos eines Dozierenden --
{ $g = checkGetInput();
  getStandArbeitszeitkonto(  $g['jahr'], $g['dozentKurz'] , $g['semester'], $g['output']  );
}

if( $_GET[ 'action' ] == 'ad' )  ## -- Hauptliste -- Liste mit allen Dozierenden --
{ if (isset( $_GET[ 'jahr'       ]  ) ) { $jahr       =  $_GET[ 'jahr'      ] ; } else  { $jahr     =  0; }
  if (isset( $_GET[ 'semester'   ]  ) ) { $semester   =  $_GET[ 'semester'  ] ; } else  { $semester =  0; }

  $_SESSION[ 'aktuell' ][ 'Jahr'     ] = $jahr;
  $_SESSION[ 'aktuell' ][ 'Semester' ] = $semester;
  getRenderAlleDozentenSem();
}
  if( $_GET[ 'action' ] == 'ls' )   ## -- Spash Screen  --
  {  getRenderLoginscreen();
  }

  if( $_GET[ 'action' ] == 'ss' )   ## -- Spash Screen  --
  {  getRenderSplashscreen();
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

/*
function checkGetInput()
{
    if (isset( $_GET[ 'jahr'       ]  ) ) { $g[ 'jahr'       ]  =  $_GET[ 'jahr'       ] ; } else  { $g[ 'jahr'       ]  =  0; }
    if (isset( $_GET[ 'semester'   ]  ) ) { $g[ 'semester'   ]  =  $_GET[ 'semester'   ] ; } else  { $g[ 'semester'   ]  =  0; }
    if (isset( $_GET[ 'dozentKurz' ]  ) ) { $g[ 'dozentKurz' ]  =  $_GET[ 'dozentKurz' ] ; } else  { $g[ 'dozentKurz' ]  =  0; }
    if (isset( $_GET[ 'output'     ]  ) ) { $g[ 'output'     ]  =  $_GET[ 'output'     ] ; } else  { $g[ 'output'     ]  =  0; }

    $_SESSION[ 'aktuell' ][ 'Jahr'     ] = $g[ 'jahr'        ];
    $_SESSION[ 'aktuell' ][ 'Semester' ] = $g[ 'semester'    ];

    return $g;
}
*/
?>