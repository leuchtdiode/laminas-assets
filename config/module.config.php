<?php
namespace Assets;

use Common\Router\HttpRouteCreator;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Ramsey\Uuid\Doctrine\UuidType;

return [

	'router' => [
		'routes' => [
			'assets' => HttpRouteCreator::create()
				->setRoute('/assets')
				->setMayTerminate(false)
				->setChildRoutes(
					[
						'file' => include 'routes/file.php',
					]
				)
				->getConfig()
		],
	],

	'doctrine' => [
		'configuration' => [
			'orm_default' => [
				'types' => [
					UuidType::NAME => UuidType::class,
				],
			],
		],
		'driver'        => [
			'assets_entities' => [
				'class' => AnnotationDriver::class,
				'cache' => 'array',
				'paths' => [ __DIR__ . '/../src/Db' ],
			],
			'orm_default'        => [
				'drivers' => [
					'Assets' => 'assets_entities',
				],
			],
		],
	],

	'service_manager' => [
		'abstract_factories' => [
			DefaultFactory::class,
		],
	],

	'controllers' => [
		'abstract_factories' => [
			DefaultFactory::class,
		],
	],
];