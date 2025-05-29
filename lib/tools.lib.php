<?php

require_once('lib/TCPDF/tcpdf.php');
$htmlheader = '<!doctype html>
<html> 
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta charset="UTF-8">

<title> title </title>

<style type="text/css">
td, th 
{ color      : #000000;
  padding    : 6px;
  font-family: Arial, sans-serif;
  font-size  : 12px;
  border-bottom: 1px solid gray;
      vertical-align: top;
}

td.head 
{ color: white;
  font-weight: bold;
  background-color:  darkgrey;
}

td.sum
{ color      : #000000;
  background-color: #eeeeee;
}

td.sal 
{ color      : #000000;
  background-color: lightyellow;
}

.taL { text-align: left  ; }
.taR { text-align: right ; }
.taC { text-align: center; }

.headertxt 
{ text-align: left;
  font-family: Arial, sans-serif;
  font-size  : 12px;
  height: 50px;
  line-height: 95%;
}

.datetxt 
{ text-align: right;
  font-family: Arial, sans-serif;
  font-size  : 14px;
}

.betrefftxt
 { text-align: left;
   font-family: Arial, sans-serif;
   font-size  : 18px;
   font-weight: bold;
   margin-bottom: 20px;
   margin-top: 45px;
}

.fliestxt
{ text-align: left;
  font-family: Arial, sans-serif;
  font-size  : 12px;
  line-height: 150%;
}
</style>

 <script>

var oldInnerHTML;
function closeResult( h )
{         document.getElementById( h ).innerHTML    = window.oldInnerHTML; 
  var d = document.getElementById("livesearch");
  d.style.display = "none";
}
 
function showResult( str , h )
{ y_pos = getYPos( str );
  x_pos = 10;
       
  y_pos += 30;
 
  var d = document.getElementById( "livesearch" );
  d.style.position = "absolute";
  d.style.left     = x_pos + "px";
  d.style.top      = y_pos + "px"; 
  d.style.display  = "block";
           
  str = str.innerHTML;  
  str.replace( /<\/?[^>]+(>|$)/g, "" );
  
  if ( str.length == 0 )
  { document.getElementById( "livesearch" ).innerHTML    = "";
    document.getElementById( "livesearch" ).style.border = "0";
    return;
  }
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function()
  { if ( this.readyState == 4 && this.status == 200 )
    { document.getElementById( "livesearch" ).innerHTML    = this.responseText   ;
      document.getElementById( "livesearch" ).style.border = "1px solid #A5ACB2" ;
    }
  }
  
  xmlhttp.open( "GET" , "livesearch.php?q=" + str + "&h=" + h , true );
  xmlhttp.send();
}
 
function  getYPos(x)
{ let elem = document.querySelector( "#" + x.id );
  let rect = elem.getBoundingClientRect();
  return  rect[ "top" ] ;
}

function me( x )  // -- Make Element editable
{ x.contentEditable = "true";
  
  str = x.innerHTML;  
  str.replace(/<\/?[^>]+(>|$)/g, "");   
  window.oldInnerHTML = str;
}

function me2( x )  // -- Make Element editable
{ x.contentEditable = "true";
  
  str = x.innerHTML;  
  str.replace(/<\/?[^>]+(>|$)/g, "");   
  window.oldInnerHTML = str;
}

function setV2DB( t , k, v , c , i , n = 0 )   // -- Set Value to DataBase
{ if ( v.innerHTML.length == 0 )
  { v.innerHTML    = "";
    v.style.border = "0";
    return;
  }
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.open( "GET" , "setV2DB.php?t=" + t  + "&k=" + k  + "&v=" + v.innerHTML + "&c=" + c + "&i=" + i   , true );
  xmlhttp.send();
 }
</script>
</head>
<body>
';

$htmlfooter = '
</body>
</html>
';

// Erstellung des PDF Dokuments

function renderPDF($html, $title )
{
 ini_set('display_errors', '1');
 ini_set('display_startup_errors', '1');
 error_reporting(E_ALL);

 $pdfName = $title.".pdf";

 $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Dokumenteninformationen
$pdf->SetCreator(PDF_CREATOR);
# $pdf->SetAuthor($pdfAuthor);
 $pdf->SetTitle( $title );

// Header und Footer Informationen
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// Auswahl des Font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// Auswahl der MArgins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// Automatisches Autobreak der Seiten
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// Image Scale
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// Schriftart
$pdf->SetFont('dejavusans', '', 10);

// Neue Seite
$pdf->AddPage();

// Fügt den HTML Code in das PDF Dokument ein
$pdf->writeHTML($html, true, false, true, false, '');

//Ausgabe der PDF

//Variante 1: PDF direkt an den Benutzer senden:
#$pdf->Output($pdfName, 'I');

//Variante 2: PDF im Verzeichnis abspeichern:
$pdf->Output(dirname(__FILE__).'/'.$pdfName, 'F');
//echo 'PDF herunterladen: <a href="'.$pdfName.'">'.$pdfName.'</a>';
}


function getStundenbilanz( $db )
{ global $htmlheader, $htmlfooter;

  $g = checkGetInput();

  if( !isset( $output ) ) { $output =  $g[ 'output' ] ; }

  $dozent =  getDozentDB( $db, $g[ 'dozentKurz' ] );
  $title  =  'Stundenbilanz-'.$dozent['Name'].'-'.$dozent['Vorname'].'-'. $g[ 'semester' ].$g[ 'jahr' ];

  $html   =  renderStundenbilanz( $db, $g[ 'dozentKurz' ], $g[ 'jahr' ], $g[ 'semester' ] , false,  $output);
  $html   =  $htmlheader . $html  . $htmlfooter;;
  error_reporting(0 );

  if       ( $output == 'ohne' )  { return $html;                }
  else if  ( $output == 'pdf'  )  { renderPDF( $html, $title );  }
  else                            { echo $html;                  }
}

function getStandArbeitszeitkonto(   $db ,  $output = 'html' )
{
  $g = checkGetInput();
  # $g['dozentKurz'], $g['jahr'], $g['semester']
  global $htmlheader;

  $html = renderArbeitszeitkonto( $db, $g['dozentKurz'] );
  $html = $htmlheader . $html;
  error_reporting(0 );

  if ( $output == 'ohne' )      { return $html;       }
  else if ( $output == 'pdf' )  { renderPDF( $html ); }
  else                          { echo $html;         }
}

function getRenderAlleDozenten(  $db  )
{ global $htmlheader, $htmlfooter;
  $html = '';

  $html = renderDozentenListe( $db );
  $html = $htmlheader . $html . $htmlfooter;
  echo $html;
}

function getRenderAlleDozentenSem( $db )
{ $g = checkGetInput();
  global $htmlheader, $htmlfooter;
  $html = '';
  $html = renderDozentenListeSem( $db, getDozentenListeSemDB( $db ) );
  $html = $htmlheader . $html . $htmlfooter;
# error_reporting(0 );
  echo $html;
}

function getRenderAlleFaecher( $db  )
{ global $htmlheader, $htmlfooter;
  $header = $htmlheader;
  $html = '';

  $html = renderFaecherListe( $db );
  $html = $htmlheader . $html . $htmlfooter;
#  error_reporting(0 );
  echo $html;
}

function getRenderAlleDepartments(  $db )
{ global $htmlheader, $htmlfooter;
  $html = '';

  $html = renderDepartmentListe( $db );
  $html = $htmlheader . $html . $htmlfooter;
#  error_reporting(0 );
   echo $html;
}

function getRenderAlleStudiengang(  $db )
{ global $htmlheader, $htmlfooter;
  $html = '';

  $html = renderStudiengangListe( $db );
  $html = $htmlheader . $html . $htmlfooter;
#  error_reporting(0 );
  echo $html;
}

function getRenderAlleEntlastungsgruenden( $db )
{ global $htmlheader, $htmlfooter;
  $html = '';

  $html = renderEntlastungsgruendeListe( $db );
  $html = $htmlheader . $html . $htmlfooter;
# error_reporting(0 );
  echo $html;
}





function renderArbeitszeitkonto( $db, $dozentKurz )
{
    $alleDozenten = getDozentenListeDB($db );
    $arbeitszeitliste =  getArbeitszeitlisteDB( $db, $dozentKurz ,$alleDozenten );
    # mysqli_close($db);
    return renderZeitkontoTotalProf( $arbeitszeitliste );
}



function checkGetInput()
{ if (isset( $_GET[ 'jahr'       ]  ) ) { $g[ 'jahr'       ]  =  $_GET[ 'jahr'       ] ; $_SESSION[ 'aktuell' ][ 'jahr'     ] = $g[ 'jahr'        ];} #else  { $g[ 'jahr'       ]  =  0; }
  if (isset( $_GET[ 'semester'   ]  ) ) { $g[ 'semester'   ]  =  $_GET[ 'semester'   ] ; $_SESSION[ 'aktuell' ][ 'semester' ] = $g[ 'semester'    ];} #else  { $g[ 'semester'   ]  =  0; }
  if (isset( $_GET[ 'dozentKurz' ]  ) ) { $g[ 'dozentKurz' ]  =  $_GET[ 'dozentKurz' ] ; } else  { $g[ 'dozentKurz' ]  =  0; }
  if (isset( $_GET[ 'output'     ]  ) ) { $g[ 'output'     ]  =  $_GET[ 'output'     ] ; } else  { $g[ 'output'     ]  =  0; }
  return $g;
}

function deb($con, $kill = false)
{ echo "<pre>";
    print_r($con);
    echo "</pre>";
    if($kill) {die();}
}

?>