<?php

return array(

	'connections' => array(

		'sqlanywhere' => array(
			'host'        => '{host=localhost;port=9505}',
			'username'    => 'CDTESTE',
			'password'    => '123sql',
			'database'    => 'CDTESTE',
			'auto_commit' => true,
			'persintent'  => false,
		),

		'mysql' => array(
			'driver'    => 'mysql',
			'host'      => 'localhost',
			'database'  => 'unittest',
			'username'  => 'travis',
			'password'  => '',
			'charset'   => 'utf8',
			'collation' => 'utf8_unicode_ci',
			'prefix'    => '',
		),
	)

);
