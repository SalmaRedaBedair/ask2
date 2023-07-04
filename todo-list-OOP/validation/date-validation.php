<?php
function date_vallidation($date)
{
    $date_format = 'Y-m-d';

    $valid_date = true;

    // Convert date string to date object
    $date_obj = DateTime::createFromFormat($date_format, $date);

    // Check if the date string matches the specified format and is a valid date
    if (!$date_obj || $date_obj->format($date_format) !== $date) {
        $valid_date = false;
    }

    if (!$valid_date) {
        $_SESSION['date']= "The date $date is not valid.";
    }
}
?>