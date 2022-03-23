<?php
namespace Assets\File;

use Assets\Db\File\Saver;
use Assets\File\Filesystem\PersistData;
use Assets\File\Filesystem\Persister;
use Exception;
use Assets\Db\File\Entity;

class Adder
{
	private Saver $entitySaver;

	private Provider $provider;

	private Persister $persister;

	public function __construct(Saver $entitySaver, Provider $provider, Persister $persister)
	{
		$this->entitySaver = $entitySaver;
		$this->provider    = $provider;
		$this->persister   = $persister;
	}

	/**
	 * @throws Exception
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