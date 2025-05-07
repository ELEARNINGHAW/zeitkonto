<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
/*Klasse zur Behandlung von Ausnahmen und Fehlern*/

require '../PHPMailer/src/Exception.php';
/*PHPMailer-Klasse*/
require '../PHPMailer/src/PHPMailer.php';
/*SMTP-Klasse, die benötigt wird, um die Verbindung mit einem SMTP-Server herzustellen*/
require '../PHPMailer/src/SMTP.php';
/*Übergeben Sie beim Erstellen eines PHPMailer-Objekts den Parameter „true“, um Ausnahmen (Meldungen im Falle eines Fehlers) zu aktivieren*/
$email = new PHPMailer(true);