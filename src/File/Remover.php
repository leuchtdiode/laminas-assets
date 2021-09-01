<?php
namespace Assets\File;

use Assets\Db\File\Deleter;
use Assets\File\Filesystem\PathProvider;
use Exception;

class Remover
{
	/**
	 * @var Deleter
	 */
	private $entityDeleter;

	/**
	 * @var PathProvider
	 */
	private $pathProvider;

	public function __construct(Deleter $entityDeleter, PathProvider $pathProvider)
	{
		$this->entityDeleter = $entityDeleter;
		$this->pathProvider  = $pathProvider;
	}

	/**
	 * @param RemoveData $data
	 * @return RemoveResult
	 * @throws Exception
	 */
	public function remove(RemoveData $data): RemoveResult
	{
		$result = new RemoveResult();
		$result->setSuccess(false);

		$file = $data->getFile();

		$entity = $file->getEntity();

		$path = $this->pathProvider->byEntity($entity);

		if (file_exists($path))
		{
			unlink($path);
		}

		$this->entityDeleter->delete($entity);

		$result->setSuccess(true);

		return $result;
	}
}