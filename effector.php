<?php

$fStartTime = microtime( TRUE);

// ****************************************************************************
/**
 * Nurogames SeaClouds Casestudy Sensor
 *
 * sensor.php
 *
 * @author      Christian Tismer, Nurogames GmbH
 * 
 * @copyright   Copyright (c) 2014, Nurogames GmbH
 */
// ****************************************************************************

// HEADER =====================================================================

header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');
header('Access-Control-Allow-Origin: *');

// INCLUDES ===================================================================

include_once( 'config/config.php');
include_once( 'seaclouds-lib/JeDb.php');
include_once( 'seaclouds-lib/JeDbObject.php');
include_once( 'seaclouds-lib/Timer.php');
include_once( 'seaclouds-lib/Debug.php');
include_once( 'seaclouds-lib/SimpleLog.php');
include_once( 'seaclouds-lib/SimpleSensor.php');

//$sText = mysql_escape_string( $_REQUEST[ 'text']);
$sText = $_REQUEST[ 'text'];

if( !$sText)
{
    $sText = 'NoMessage';
}

$kEffector = new SimpleSensor( $fStartTime);


$kEffector->header->project = "SeaCloudsProject";
$kEffector->header->component = "NURO/effector.php";
$kEffector->header->milestone = "M30";
$kEffector->header->sourceversion = "D6.3.3";
$kEffector->header->release = "2015-03-15";
$kEffector->header->microtime = $fStartTime;
$kEffector->header->date = date( 'r', $fStartTime);

$kEffector->result->text = $sText;


$kEffector->connectDb();

$kEffector->createLog();

$kEffector->updateLog( $sText);


print $kEffector->toJson();

$kEffector->closeDb();
?>