<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);
ini_set("display_errors", 1);
ini_set("log_errors", 1);


$fStartTime = microtime( TRUE);

$aResourceUsage = getrusage();

$nCpuUsageAtStart = $aResourceUsage['ru_utime.tv_usec']
                  + $aResourceUsage['ru_stime.tv_usec'];

// ****************************************************************************
/**
 * Nurogames SeaClouds Casestudy Diagnostic
 *
 * diagnostic.php
 *
 * @author      Christian Tismer, Nurogames GmbH
 * 
 * @copyright   Copyright (c) 2016, Nurogames GmbH
 */
// ****************************************************************************

// HEADER =====================================================================

header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
//header('Content-type: application/text');
header('Access-Control-Allow-Origin: *');

print "<pre>";

print "NURO CaseStudy (http://seaclouds-project.eu/) Diagnostic\n\n";

// INCLUDES ===================================================================

include_once( 'config/config.php');
include_once( 'seaclouds-lib/JeDb.php');
include_once( 'seaclouds-lib/JeDbObject.php');
include_once( 'seaclouds-lib/Timer.php');
include_once( 'seaclouds-lib/Debug.php');
include_once( 'seaclouds-lib/SimpleLog.php');
include_once( 'seaclouds-lib/SimpleSensor.php');

ini_set("display_errors", 1);

print "Check php version\n";

if ( phpversion() >= 5.2)
{
    print "OK " . phpversion() . " >= 5.2 \n";
}
else
{
    print "ERROR < 5.2 \n";
}

print "\nCheck mysqli\n";

if ( function_exists('mysqli_connect'))
{
    print "OK - mysqli(" . phpversion( 'mysqli') . "): detected\n";

    print "\nTry connection\n";

    print "User:" . g_DatabaseUser
    . "\nHost:" . g_DatabaseHost
    . "\nDb:" . g_DatabaseName . "\n";

    $kDb = JeDb::getInstance();
    
    $kDb->query( 'SHOW TABLES;');

    print "Ok\n";

    $kAutoCommit = $kDb->fetchFirstRow( 'SELECT @@autocommit, NOW();');

    print_r( $kAutoCommit);

    $kGrants = $kDb->fetchAllRows( 'SHOW GRANTS;');

    print_r( $kGrants);

//    $kDb->insert( 'INSERT INTO logs SET log_text = "Diagnostic1", log_request_start = NOW(), log_php_start = NOW();');
//    $kAutoCommit = $kDb->fetchAllRows( 'SELECT COUNT(*) FROM logs WHERE log_text = "Diagnostic1";');
//
//    print_r( $kAutoCommit);
}
else
{
  print "ERROR - mysqli: missing\n";
}

print "\n\nOS by uname:\n"
      . `uname -a` 
      . "\n";

print "OS by /etc/os-release:\n"
      . `cat /etc/os-release`
      . "\n";

print "OS by /etc/*version*:\n"
      . `ls -ld /etc/*version*` 
      . `cat /etc/*version*` 
      . "\n\n";

print "df:\n" . `df -h` . "\n\n";

print "RAM:\n" . `free -m` . "\n\n";

print "CPU:\n" . `cat /proc/cpuinfo` . "\n\n";

print "\ntop:\n" . `top -bn1` . "\n\n";

phpinfo();
?>