<?php
namespace Assets\File;

use Assets\Db\File\Saver;
use Assets\Db\File\Entity;
use Assets\File\Filesystem\PersistData;
use Assets\File\Filesystem\Persister;
use Throwable;

class Adder
{
	public function __construct(
		private readonly Saver $entitySaver,
		private readonly Provider $provider,
		private readonly Persister $persister
	)
	{
	}

	/**
	 * @throws Throwable
	 */
	public function add(AddData $data): AddResult
	{
		$result = new AddResult();
		$result->setSuccess(false);

		$entity = new Entity();
		$entity->setFileName($data->getFileName());
		$entity->setMimeType($data->getMimeType());
		$entity->setSize($data->getSize());

		$this->entitySaver->save($entity);

		$persistResult = $this->persister->persist(
			PersistData::create()
				->setEntity($entity)
				->setContent($data->getContent())
		);

		if (!$persistResult->isSuccess())
		{
			$result->setErrors(
				$persistResult->getErrors()
			);

			return $result;
		}

		$result->setFile(
			$this->provider->byId($entity->getId())
		);
		$result->setSuccess(true);

		return $result;
	}
}