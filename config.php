<?php
session_start();
// Database connection details
$host = "localhost";
$username = "root";
$password = "";
$database = "ello";

// Create a new mysqli object
$conn = new mysqli($host, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


function diffForHumans(DateTime $date){

    $currentDate = new DateTime;
  
    $difference = $currentDate->Diff($date);
  
  $unit = 'second';
  $count = $difference->s;
   
  switch (true){
    case $difference->y > 0;
    $unit = 'year';
    $count = $difference->y;
    break;
  
    case $difference->m > 0;
    $unit = 'month';
    $count = $difference->m;
    break;
  
    case $difference->d > 0;
    $unit = 'day';
    $count = $difference->d;
    break;
  
    case $difference->h > 0;
    $unit = 'hour';
    $count = $difference->h;
    break;
  
    case $difference->i > 0;
    $unit = 'minute';
    $count = $difference->i;
    break;
  }
  if ($count === 0) {
    $count = 1;
  }
  
  if ($count !== 1) {
    $unit .= 's';
  }
    
  $inversion = $difference->invert === 0 ? 'From now' : 'ago';
  
  return "{$count} {$unit} {$inversion}";
  
  }
?>