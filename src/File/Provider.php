<?php
namespace Assets\File;

use Assets\Common\DtoCreatorProvider;
use Assets\Db\File\Entity;
use Assets\Db\File\Repository;

class Provider
{
	/**
	 * @var Repository
	 */
	private $repository;

	/**
	 * @var DtoCreatorProvider
	 */
	private $dtoCreatorProvider;

	/**
	 * @param Repository $repository
	 * @param DtoCreatorProvider $dtoCreatorProvider
	 */
	public function __construct(Repository $repository, DtoCreatorProvider $dtoCreatorProvider)
	{
		$this->repository         = $repository;
		$this->dtoCreatorProvider = $dtoCreatorProvider;
	}

	/**
	 * @param string $id
	 * @return File|null
	 */
	public function byId($id)
	{
		return ($entity = $this->repository->find($id))
			? $this->createDto($entity)
			: null;
	}

	/**
	 * @param Entity $entity
	 * @return File
	 */
	private function createDto(Entity $entity)
	{
		return $this->dtoCreatorProvider
			->getFileCreator()
			->byEntity($entity);
	}
}