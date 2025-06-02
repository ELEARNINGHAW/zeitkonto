<?php
session_start();

include_once( "lib/tools.lib.php"  );
include_once( "lib/db.lib.php"     );
include_once( "lib/render.lib.php" );

$db   = connectDB();


########## -------------------------------------------------------------------------------------
$dozentKurz  = 'Svd';
$jahr = '2019';
$semester = 'W';

$sb = renderStundenbilanz( $db, $dozentKurz, $jahr, $semester, $onlyData = true  ) ;

$x[ 'lehre'      ] = $sb[ 'dozentLV' ][ 'veranstaltungssumme' ];
$x[ 'entlastung' ] = $sb[ 'dozentLV' ][ 'entlastungsumme1'    ];
$x[ 'jahr'       ] = $sb[ 'dozentLV' ][ 'Jahr'                ];
$x[ 'semester'   ] = $sb[ 'dozentLV' ][ 'Semester'            ];
$x[ 'saldo'      ] = $sb[ 'dozentLV' ][ 'saldo'               ];
$x[ 'pflicht'    ] = $sb[ 'dozentLV' ][ 'pflicht'             ];
$x[ 'dozkurz'    ] = $sb[ 'dozentLV' ][ 'DozKurz'             ];

deb($x ,1);

# SELECT saldo FROM `konto` WHERE dozent = 'Svd' AND semester = '2019W';
# INSERT INTO `konto` (`ID`, `dozent`, `semester`, `saldo`, `lehre`, `entlastung`, `pflicht`, `datum`) VALUES (NULL, 'Svd', '2019W', '14.267', '19.267', '13', '18', current_timestamp());

########## -------------------------------------------------------------------------------------


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