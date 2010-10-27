<?php

	// system/application/plugins/doctrine_pi.php
	
	// load the Doctrine Library
	require_once APPPATH.'/plugins/doctrine/lib/Doctrine/Doctrine.php';
	
	// load database config from CI
	require_once APPPATH.'/config/database.php';
	
	// this will allow Doctrine to load Model Classes automatically
	spl_autoload_register(array('Doctrine', 'autoload'));
	
	// we load our database connections into Doctrine Manager
	// this loop allows us to use multiple connections later on
	foreach ($db as $connection_name => $db_values) {
		
		// first we must convert to dsn format
		$dsn = $db[$connection_name]['dbdriver'] .
		'://' . $db[$connction_name]['username'] .
		':' . $db[$connection_name]['password'] .
		'@' . $db[$connection_name]['hostname'] .
		'/' . $db[$connection_name]['database'];
		
	Doctrine_Manager::connection($dsn,$connection_name);
		
	}
	
	// CodeIgniter's Model class needs to be loaded
	require_once BASEPATH. '/libraries/Model.php';
	
	// telling Doctrine where our models are located
	Doctrine::loadModels(APPPATH.'/models');
	
	// (OPTIONAL) Congifiguration below
	
	// this will allow us to use "mutators"
	Doctrine_Manager::getInstance()->setAttribute(
		Doctrine::ATTR_AUTO_ACCESSOR_OVERIDE, true);
	
	// this sets all table columns to notnull and unsigned (for ints) by default
	Doctrine_Manager::getInstance()->setAttribute(
		Doctrine::ATTR_DEFAULT_COLUMN_OPTIONS,
		array('notnull' => true, 'unsigned' => true));
	
	// set the default primary key to be named 'id', integer, 4 bytes
	Doctrine_Manager::getInstance()->setAttribute(
		Doctrine::ATTR_DEFAULT_IDENTIFIERS_OPTIONS,
		array('name' => 'id', 'type' => 'integer', 'length' => 4));
?>