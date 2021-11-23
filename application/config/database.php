<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$active_group = 'default';
$query_builder = TRUE;

// $db['default'] = array(
// 	'dsn'	=> '',
// 	'hostname' => 'skdigital.id',
// 	'username' => 'cares',
// 	'password' => 'turiawan',
// 	'database' => 'care_sys',
// 	'dbdriver' => 'postgre',
// 	'dbprefix' => '',
// 	'pconnect' => FALSE,
// 	'db_debug' => (ENVIRONMENT !== 'production'),
// 	'cache_on' => FALSE,
// 	'cachedir' => '',
// 	'char_set' => 'utf8',
// 	'dbcollat' => 'utf8_general_ci',
// 	'swap_pre' => '',
// 	'encrypt' => FALSE,
// 	'compress' => FALSE,
// 	'stricton' => FALSE,
// 	'failover' => array(),
// 	'save_queries' => TRUE
// );

// $db['default'] = array(
// 	'dsn'	=> '',
// 	'hostname' => '167.71.214.14',
// 	'username' => 'cane',
// 	'password' => 'c4n3',
// 	'database' => 'care_new',
// 	'dbdriver' => 'postgre',
// 	'dbprefix' => '',
// 	'pconnect' => FALSE,
// 	'db_debug' => (ENVIRONMENT !== 'production'),
// 	'cache_on' => FALSE,
// 	'cachedir' => '',
// 	'char_set' => 'utf8',
// 	'dbcollat' => 'utf8_general_ci',
// 	'swap_pre' => '',
// 	'encrypt' => FALSE,
// 	'compress' => FALSE,
// 	'stricton' => FALSE,
// 	'failover' => array(),
// 	'save_queries' => TRUE
// );

// $db['default'] = array(
// 	'dsn'	=> '',
// 	'hostname' => 'skdigital.id',
// 	'username' => 'cane',
// 	'password' => 'c4n3',
// 	'database' => 'care_new',
// 	'dbdriver' => 'postgre',
// 	'dbprefix' => '',
// 	'pconnect' => FALSE,
// 	'db_debug' => (ENVIRONMENT !== 'production'),
// 	'cache_on' => FALSE,
// 	'cachedir' => '',
// 	'char_set' => 'utf8',
// 	'dbcollat' => 'utf8_general_ci',
// 	'swap_pre' => '',
// 	'encrypt' => FALSE,
// 	'compress' => FALSE,
// 	'stricton' => FALSE,
// 	'failover' => array(),
// 	'save_queries' => TRUE
// );

$db['default'] = array(
	'dsn'			=> '',
	'hostname' 		=> 'localhost',
	'username' 		=> 'postgres',
	'password' 		=> 'm0n0w4ll',
	'database' 		=> 'care_lama',
	'dbdriver' 		=> 'postgre',
	'dbprefix' 		=> '',
	'pconnect' 		=> FALSE,
	'db_debug' 		=> (ENVIRONMENT !== 'production'),
	'cache_on' 		=> FALSE,
	'cachedir' 		=> '',
	'char_set' 		=> 'utf8',
	'dbcollat' 		=> 'utf8_general_ci',
	'swap_pre' 		=> '',
	'encrypt' 		=> FALSE,
	'compress' 		=> FALSE, 
	'stricton' 		=> FALSE,
	'failover' 		=> array(),
	'save_queries' 	=> TRUE
);

// koneksi ke databse HRD
$db['database_hrd'] = array(
	'dsn'			=> '',
	'hostname' 		=> 'skdigital.id',
	'username' 		=> 'hrd_temp',
	'password' 		=> 'haerde',
	// 'hostname' 		=> 'localhost',
	// 'username' 		=> 'postgres',
	// 'password' 		=> 'afif10',
	'database' 		=> 'hrd',
	'dbdriver' 		=> 'postgre',
	'dbprefix' 		=> '',
	'pconnect' 		=> FALSE,
	'db_debug' 		=> (ENVIRONMENT !== 'production'),
	'cache_on' 		=> FALSE,
	'cachedir' 		=> '',
	'char_set' 		=> 'utf8',
	'dbcollat' 		=> 'utf8_general_ci',
	'swap_pre' 		=> '',
	'encrypt' 		=> FALSE,
	'compress' 		=> FALSE,
	'stricton' 		=> FALSE,
	'failover' 		=> array(),
	'save_queries' 	=> TRUE
);