<?php
session_start();
include_once( "lib/tools.lib.php"  );
include_once( "lib/db.lib.php"     );
include_once( "lib/render.lib.php" );

if (isset( $_GET[ 'action'      ]  ) )
{
if( $_GET['action'] == 'sb')
{ if (isset( $_GET[ 'jahr'       ]  ) ) { $jahr       =  $_GET[ 'jahr'       ] ; } else  { $jahr       =  0; }
  if (isset( $_GET[ 'semester'   ]  ) ) { $semester   =  $_GET[ 'semester'   ] ; } else  { $semester   =  0; }
  if (isset( $_GET[ 'dozentKurz' ]  ) ) { $dozentKurz =  $_GET[ 'dozentKurz' ] ; } else  { $dozentKurz =  0; }
  if (isset( $_GET[ 'output'     ]  ) ) { $output     =  $_GET[ 'output'     ] ; } else  { $output     =  0; }
  
  $_SESSION[ 'aktuell' ][ 'Jahr'     ] = $jahr;
  $_SESSION[ 'aktuell' ][ 'Semester' ] = $semester;
  
  getStundenbilanz( $jahr, $dozentKurz , $semester, $output );
}

if( $_GET['action'] == 'ad')
{ if (isset( $_GET[ 'jahr'       ]  ) ) { $jahr       =  $_GET[ 'jahr'      ] ; } else  { $jahr     =  0; }
  if (isset( $_GET[ 'semester'   ]  ) ) { $semester   =  $_GET[ 'semester'  ] ; } else  { $semester =  0; }
  
  $_SESSION[ 'aktuell' ][ 'Jahr'     ] = $jahr;
  $_SESSION[ 'aktuell' ][ 'Semester' ] = $semester;
  getRenderAlleDozentenSem();
}
  
  if( $_GET['action'] == 'edoz')
  {    getRenderAlleDozenten();
  }

  if( $_GET['action'] == 'ef')
  {  getRenderAlleFaecher();
  }
  
  if( $_GET['action'] == 'edep')
  {  getRenderAlleDepartments();
  }
  
  if( $_GET['action'] == 'esg')
  {  getRenderAlleStudiengang();
  }
}

else
{
 
 $html ='
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>

<style>

.dropbtn {
  font-family: Arial, sans-serif;
  background-color: #EFEFEF;
  color: white;
  font-size: 22px;
}

.dropdown {
  position: relative;
  display: inline-block;
    font-family: Arial, sans-serif;
  font-size: 25px;
 
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f1f1f1;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.dropdown-content a {
    font-family: Arial, sans-serif;
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

.dropdown-content a:hover {background-color: #ddd; }
.dropdown:hover .dropdown-content {display: block;}
.dropdown:hover .dropbtn {background-color: #EEEEEE; }

</style>
</head>
<body style="background-color:white;">



<div class="dropdown" style="width: 49%;">
  <div class="dropbtn"  id="Button2" >Basis Tabellen</div>
  <div class="dropdown-content">
    <a href="index.php?action=edoz"  target="rechts"  onclick="document.querySelector(\'#Button2\').innerHTML = \'Dozenten\'   ; ">Dozenten</a>
    <a href="index.php?action=ef"    target="rechts"  onclick="document.querySelector(\'#Button2\').innerHTML = \'Fach\'       ; ">Fach</a>
    <a href="index.php?action=esg"   target="rechts"  onclick="document.querySelector(\'#Button2\').innerHTML = \'Studiengang\'; ">Studiengang</a>
    <a href="index.php?action=edep"  target="rechts"  onclick="document.querySelector(\'#Button2\').innerHTML = \'Department\' ; ">Department</a>
  </div>
</div>



<div class="dropdown"  style="width: 49%;">
  <div class="dropbtn" id="Button1">Semester</div>
  <div class="dropdown-content">
    <a href="index.php?action=ad&jahr=2023&semester=S"  target="links" onclick="document.querySelector(\'#Button1\').innerHTML = \'2023 S\'; ">2023 S</a>
    <a href="index.php?action=ad&jahr=2022&semester=W"  target="links" onclick="document.querySelector(\'#Button1\').innerHTML = \'2022 W\';" >2022 W</a>
    <a href="index.php?action=ad&jahr=2022&semester=S"  target="links" onclick="document.querySelector(\'#Button1\').innerHTML = \'2022 S\';" >2022 S</a>
    <a href="index.php?action=ad&jahr=2021&semester=W"  target="links" onclick="document.querySelector(\'#Button1\').innerHTML = \'2021 W\';" >2021 W</a>
    <a href="index.php?action=ad&jahr=2021&semester=S"  target="links" onclick="document.querySelector(\'#Button1\').innerHTML = \'2021 S\';" >2021 S</a>
    <a href="index.php?action=ad&jahr=2020&semester=W"  target="links" onclick="document.querySelector(\'#Button1\').innerHTML = \'2020 W\';" >2020 W</a>
    <a href="index.php?action=ad&jahr=2020&semester=S"  target="links" onclick="document.querySelector(\'#Button1\').innerHTML = \'2020 S\';" >2020 S</a>
    <a href="index.php?action=ad&jahr=2019&semester=W"  target="links" onclick="document.querySelector(\'#Button1\').innerHTML = \'2019 W\';" >2019 W</a>
    <a href="index.php?action=ad&jahr=2019&semester=S"  target="links" onclick="document.querySelector(\'#Button1\').innerHTML = \'2019 S\';" >2019 S</a>
    <a href="index.php?action=ad&jahr=2018&semester=W"  target="links" onclick="document.querySelector(\'#Button1\').innerHTML = \'2018 W\';" >2018 W</a>
    <a href="index.php?action=ad&jahr=2018&semester=S"  target="links" onclick="document.querySelector(\'#Button1\').innerHTML = \'2018 S\';" >2018 S</a>
  </div>
</div>


';
  
  
  
  echo $html;
  
  
  
  echo '<iframe width="49%" height="800px" name="rechts" ></iframe>';
  echo '<iframe width="49%" height="800px" name="links" src="index.php?action=ad&jahr=2023&semester=S&"></iframe>';
  
  echo '</body></html>';


}

?>

