<?php

function validateDate($date, $format = 'Y-m-d') {
    $d = DateTime::createFromFormat($format, $date);
    // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
    return $d && $d->format($format) === $date;
}

function logged_only() {
		if (session_status() == PHP_SESSION_NONE) {
   		 session_start();
		}
		if(!isset($_SESSION['auth'])) {
		header('Location: ../index.php');
		exit();
		}
	}