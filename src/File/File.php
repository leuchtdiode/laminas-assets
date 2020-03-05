<?php
namespace Assets\File;

use Assets\File\Url\Url;
use DateTime;
use Assets\Db\File\Entity;
use Common\Hydration\ArrayHydratable;
use Ramsey\Uuid\UuidInterface;

class File implements ArrayHydratable
{
	/**
	 * @var Entity
	 */
	private $entity;

	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @var Url[]
	 */
	private $urls;

	/**
	 * @param Entity $entity
	 * @param Url[] $urls
	 */
	public function __construct(Entity $entity, array $urls)
	{
		$this->entity = $entity;
		$this->urls   = $urls;
	}

	/**
	 * @return Url[]
	 */
	public function getUrls(): array
	{
		return $this->urls;
	}

	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @return UuidInterface
	 */
	public function getId()
	{
		return $this->entity->getId();
	}

	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @return string
	 */
	public function getFileName()
	{
		return $this->entity->getFileName();
	}

	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @return string
	 */
	public function getSize()
	{
		return $this->entity->getSize();
	}

	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @return string
	 */
	public function getMimeType()
	{
		return $this->entity->getMimeType();
	}

	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @return DateTime
	 */
	public function getCreatedDate()
	{
		return $this->entity->getCreatedDate();
	}

	/**
	 * @return Entity
	 */
	public function getEntity(): Entity
	{
		return $this->entity;
	}
}