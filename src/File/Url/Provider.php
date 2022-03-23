<?php
namespace Assets\File\Url;

use Assets\Db\File\Entity;
use Laminas\Router\Http\TreeRouteStack;

class Provider
{
	private array $config;

	private TreeRouteStack $router;

	public function __construct(array $config, TreeRouteStack $router)
	{
		$this->config = $config;
		$this->router = $router;
	}

	/**
	 * @return Url[]
	 */
	public function all(Entity $entity): array
	{
		$types = [ 'original' ]; // all types for now, maybe more logic in future version

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

	private function getUrl(Entity $entity, string $type): string
	{
		[ $fileName, $extension ] = explode('.', $entity->getFileName());

		$fileName = preg_replace('#[^\w\-]+#', '-', $fileName);
		$fileName = preg_replace('#[\-]{2,}#', '', $fileName);

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
					'name' => 'assets/file/single-item/content',
				]
			)
		);
	}
}
