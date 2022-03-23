<?php
namespace Assets\Db\File;

use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class RepositoryFactory implements FactoryInterface
{
	/**
	 * @inheritDoc
	 */
	public function __invoke(
		ContainerInterface $container,
		$requestedName,
		array $options = null
	): object
	{
		return $container
			->get(EntityManager::class)
			->getRepository(Entity::class);
	}
}
