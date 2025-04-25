
<?php
$row = 1;
if (($handle = fopen("Zeitkontenerfassung.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 2000, ";")) !== FALSE) {
        $num = count($data);
       # echo "<p> $num Felder in Zeile $row: <br /></p>\n";
        if (++$row > 2)
        $dozenten[$row] = $data[0];

        for ($c=0; $c < $num; $c++) {
          #    $dozenten[] = $data[$c];
          #  echo $data[$c] . "<br />\n";
        }
    }
    fclose($handle);
    checkDozent( $dozenten );
}



function checkDozent( $dozenten )
{  $db = connectDB();

    foreach ( $dozenten as $dozent )
    {

        $dozent = strip_tags( $dozent );


    $sql = "SELECT COUNT(*) AS C FROM `dozent` WHERE Name = '".$dozent."'";

   # echo $sql."<br>";


        foreach ($db->query($sql) as $row) {
           if ( $row['C'] == 0 ) {
               $d[$dozent] = $dozent;
               #echo "<br>" . $dozent;

             #  print_r($row['C']);
           }
        }




    }


    print_r($d);
    $db->close();
    #echo $e;

}

function connectDB()
{ $db = new mysqli("localhost", "zeitkonto", "zeitkonto", "zeitkonto");
    if ($db -> connect_errno)
    { echo "Failed to connect to MySQL: " . $db->connect_error;
        exit();
    }
    return ($db);
}



?>
