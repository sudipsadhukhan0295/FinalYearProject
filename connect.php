<?php

$host="localhost";
$user="root";
$pass="";
$database="patient_details";
$link=mysqli_connect($host,$user,$pass);
if(!$link)
	die("connection failed");
$db=mysqli_select_db($link,$database);
if(!$db)
	die("invalid database");

