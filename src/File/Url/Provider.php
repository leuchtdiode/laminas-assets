<?php
namespace Assets\File\Url;

use Assets\Db\File\Entity;
use Assets\File\Type\Type;
use Laminas\Router\Http\TreeRouteStack;

class Provider
{
	public function __construct(private array $config, private TreeRouteStack $router)
	{
	}

	/**
	 * @return Url[]
	 */
	public function get(Entity $entity, ?array $types = null): array
	{
		$types = $types ?? [ Type::ORIGINAL ];

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

		$typeConfig = $this->config['assets']['file']['processor'][$type];

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
					'extension' => $typeConfig['extension'] ?? $extension,
				],
				[
					'name' => 'assets/file/single-item/content',
				]
			)
		);
	}
}
