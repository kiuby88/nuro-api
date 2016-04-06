<?php

$fStartTime = microtime( TRUE);
// ****************************************************************************
/**
 * Nurogames SeaClouds Casestudy Sensor
 *
 * analytics.php
 *
 * @author      Christian Tismer, Nurogames GmbH
 * 
 * @copyright   Copyright (c) 2015, Nurogames GmbH
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

///////////////////////////////////////////////////////////////////////////////

$nInterval = 0 + $_REQUEST[ 'interval'];

if( $nInterval == 0)
{
    //$nInterval = 360000;
    $nInterval = 63;
}

$nPrecision = 0 + $_REQUEST[ 'precision'];

if( $nPrecision == 0)
{
    //$nPrecision = 13;
    $nPrecision = 19;
}

///////////////////////////////////////////////////////////////////////////////

Debug::message( "USAGE: 'http://.../analytics-php[?interval=N][&precision=N]'");


$kAnalytics = new SimpleSensor( $fStartTime);

$kAnalytics->header->project = "SeaCloudsProject";
$kAnalytics->header->component = "NURO/analytics.php";
$kAnalytics->header->milestone = "M30";
$kAnalytics->header->sourceversion = "D6.3.3";
$kAnalytics->header->release = "2015-12-30";
$kAnalytics->header->microtime = $fStartTime;
$kAnalytics->header->date = date( 'r', $fStartTime);


$kAnalytics->connectDb();

$kAnalytics->createLog();

$kAnalytics->getAnalytics( $nInterval, $nPrecision);

$kAnalytics->result->guides = $kAnalytics->analyticsGuide();

$kAnalytics->updateLog();

print $kAnalytics->toJson();

$kAnalytics->closeDb();
?>