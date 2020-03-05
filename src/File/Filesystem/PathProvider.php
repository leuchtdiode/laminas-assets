<?php
namespace Assets\File\Filesystem;

use Assets\Db\File\Entity;
use Assets\File\Helper;

class PathProvider
{
	/**
	 * @var array
	 */
	private $config;

	/**
	 * @param array $config
	 */
	public function __construct(array $config)
	{
		$this->config = $config;
	}

	/**
	 * @param Entity $entity
	 * @return string
	 */
	public function byEntity(Entity $entity)
	{
		return sprintf(
			'%s/%s/%s/%s.%s',
			getcwd(),
			$this->config['assets']['storePath'],
			$entity->getCreatedDate()->format('Ym'),
			$entity->getId()->toString(),
			Helper::getExtensionByFileName(
				$entity->getFileName()
			)
		);
	}
}