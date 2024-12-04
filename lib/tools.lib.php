<?php

require_once('lib/TCPDF/tcpdf.php');

// Erstellung des PDF Dokuments

function renderPDF($html)
{
 $pdfName = "DAS PDF";
 
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Dokumenteninformationen
$pdf->SetCreator(PDF_CREATOR);
# $pdf->SetAuthor($pdfAuthor);
# $pdf->SetTitle('Rechnung '.$rechnungs_nummer);

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
$pdf->Output($pdfName, 'I');

//Variante 2: PDF im Verzeichnis abspeichern:
//$pdf->Output(dirname(__FILE__).'/'.$pdfName, 'F');
//echo 'PDF herunterladen: <a href="'.$pdfName.'">'.$pdfName.'</a>';
}












function getStundenbilanz($jahr, $dozentKurz , $semester, $output = 'html')
{
  $htmlheader = '
<style type="text/css">
    .logo { padding: 5px;   width: 250px;  float: right;  height:90px;  }

    td { color      : #000000;
         padding    : 6px;
         font-family: Arial, sans-serif;
         font-size  : 12px;
         border-bottom: 1px solid gray;
    }

    td.head {
        padding    : 6px;
        font-family: Arial, sans-serif;
        color: white;
        font-weight: bold;
        background-color:  darkgrey;
    }

    td.sum {
        color      : #000000;
        padding    : 6px;
        font-family: Arial, sans-serif;
        background-color: #eeeeee;
    }

    td.sal {
        color      : #000000;
        padding    : 6px;
        font-family: Arial, sans-serif;
        background-color: lightyellow;
    }
    
    .taL { text-align: left;  }
    .taR { text-align: right; }
    .taC { text-align: right; }

    .headertxt { text-align: left;
        font-family: Arial, sans-serif;
        font-size  : 12px;
        height: 110px;
        line-height: 95%;
    }

    .datetxt { text-align: right;
        font-family: Arial, sans-serif;
        font-size  : 14px;
    }

    .betrefftxt { text-align: left;
        font-family: Arial, sans-serif;
        font-size  : 18px;
        font-weight: bold;
        margin-bottom: 20px;
        margin-top: 45px;
    }

    .fliestxt { text-align: left;
        font-family: Arial, sans-serif;
        font-size  : 12px;
        line-height: 150%;
    }
</style>
';
  
  $db = connectDB();
  $html = renderStundenbilanz( $db, $dozentKurz, $jahr, $semester );
  $html = $htmlheader . $html;
  error_reporting(0 );
  
  if ( $output == 'ohne' )
  {
    return $html;
  }
  else if ( $output == 'pdf' )
  { renderPDF( $html );
  }
  else
  { echo $html;
  }
  
}




function getRenderAlleDozenten()
{
  $htmlheader = '
<style type="text/css">

#overlay {
  position: fixed; /* Sit on top of the page content */
  display: none; /* Hidden by default */
  width: 100%; /* Full width (cover the whole page) */
  height: 100%; /* Full height (cover the whole page) */
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: rgba(0,0,0,0.5); /* Black background with opacity */
  z-index: 2; /* Specify a stack order in case you\'re using a different order for other elements */
  cursor: pointer; /* Add a pointer on hover */
}



    .logo { padding: 5px;   width: 250px;  float: right;  height:90px;  }

    td, th { color      : #000000;
         padding    : 6px;
         font-family: Arial, sans-serif;
         font-size  : 12px;
         border-bottom: 1px solid gray;
    }

    td.head {
        color: white;
        font-weight: bold;
        background-color:  darkgrey;
    }

    td.sum {
        color      : #000000;
        background-color: #eeeeee;
    }

    td.sal {
        color      : #000000;
        background-color: lightyellow;
    }
    
    .taL { text-align: left;  }
    .taR { text-align: right; }
    .taC { text-align: right; }

    .headertxt { text-align: left;
        font-family: Arial, sans-serif;
        font-size  : 12px;
        height: 110px;
        line-height: 95%;
    }

    .datetxt { text-align: right;
        font-family: Arial, sans-serif;
        font-size  : 14px;
    }

    .betrefftxt { text-align: left;
        font-family: Arial, sans-serif;
        font-size  : 18px;
        font-weight: bold;
        margin-bottom: 20px;
        margin-top: 45px;
    }

    .fliestxt { text-align: left;
        font-family: Arial, sans-serif;
        font-size  : 12px;
        line-height: 150%;
    }
</style>
';
  $html = '';
  $db = connectDB();
  $html = renderDozentenListe( $db );
  $html = $htmlheader . $html;
  error_reporting(0 );
  
 # if ( $output == 'pdf' )
 # { renderPDF( $html );
 # }
 # else
  { echo $html;
  }
}


?>