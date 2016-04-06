<?php

$fStartTime = microtime( TRUE);

$aResourceUsage = getrusage();

$nCpuUsageAtStart = $aResourceUsage['ru_utime.tv_usec']
                  + $aResourceUsage['ru_stime.tv_usec'];

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

$kSensor = new SimpleSensor( $fStartTime);


Debug::message( 
   "DEPRECATED INFORMATION: '*_response_time' is deprecated, use '*_run_time'");

Debug::message( 
   "DEPRECATED INFORMATION: request_analytics->week is deprecated.");
   
Debug::message(  'ToDo: redesign for multi DB support');


$kSensor->header->project = "SeaCloudsProject";
$kSensor->header->component = "NURO/sensor.php";
$kSensor->header->milestone = "M30";
$kSensor->header->sourceversion = "D6.3.3";
$kSensor->header->release = "2015-03-14";
$kSensor->header->microtime = $fStartTime;
$kSensor->header->date = date( 'r', $fStartTime);

$kSensor->header->benchmark = new stdClass();
$kSensor->header->benchmark->cpu_used = 0;
$kSensor->header->benchmark->real_used = 0;
$kSensor->header->benchmark->db1_used = 0;
//$kSensor->header->benchmark->ResourceUsage = new stdClass();
//$kSensor->header->benchmark->ResourceUsage->Start = $aResourceUsage;


$kSensor->connectDb();

$kSensor->createLog();

$kSensor->getAverages();

$kSensor->updateLog();


$aResourceUsage = getrusage();

//$kSensor->header->benchmark->ResourceUsage->AfterDb = $aResourceUsage;

$x ="SomeStupidStuffTogenerateCpuUsage";
for( $i=0; $i < 8; $i++)
{
    $x = crypt( base64_encode ( $x));
}

$aResourceUsage = getrusage();

$nCpuUsed = $aResourceUsage['ru_utime.tv_usec']
            + $aResourceUsage['ru_stime.tv_usec']
            - $nCpuUsageAtStart;

//$kSensor->header->benchmark->ResourceUsage->End = $aResourceUsage;

$kSensor->header->benchmark->cpu_used = round( $nCpuUsed / 1000001, 10);

$kSensor->header->benchmark->real_used =
                                  round( (microtime( TRUE) - $fStartTime), 10);

$kSensor->header->benchmark->db1_used = $kSensor->header->benchmark->real_used
                                      - $kSensor->header->benchmark->cpu_used;
//                                      + $kSensor->database1->insert_log_time
//                                      + $kSensor->database1->analytics_time
//                                      + $kSensor->database1->update_log_time;

print $kSensor->toJson();

$kSensor->closeDb();
?>