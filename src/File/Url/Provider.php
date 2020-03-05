<?php
namespace Assets\File\Url;

use Assets\Db\File\Entity;
use Laminas\Router\Http\TreeRouteStack;

class Provider
{
	/**
	 * @var array
	 */
	private $config;

	/**
	 * @var TreeRouteStack
	 */
	private $router;

	/**
	 * @param array $config
	 * @param TreeRouteStack $router
	 */
	public function __construct(array $config, TreeRouteStack $router)
	{
		$this->config = $config;
		$this->router = $router;
	}

	/**
	 * @param Entity $entity
	 * @return Url[]
	 */
	public function all(Entity $entity)
	{
		$types = ['original']; // all types for now, maybe more logic in future version

		$urls = [];

		foreach ($types as $type)
		{
			$urls[] = new Url(
				$this->getUrl($entity, $type),
				$type
			);
		}

		return $urls;
	}

	/**
	 * @param Entity $entity
	 * @param string $type
	 * @return string
	 */
	private function getUrl(Entity $entity, string $type)
	{
		list($fileName, $extension) = explode('.', $entity->getFileName());

		return sprintf(
			'%s://%s%s',
			$this->config['assets']['url']['protocol'],
			$this->config['assets']['url']['host'],
			$this->router->assemble(
				[
					'fileId'    => $entity
						->getId()
						->toString(),
					'type'      => $type,
					'fileName'  => $fileName,
					'extension' => $extension,
				],
				[
					'name' => 'assets/file/single-item/content'
				]
			)
		);
	}
}
