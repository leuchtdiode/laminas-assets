<?php
namespace Assets\File\Filesystem;

use Assets\Db\File\Entity;

class PersistData
{
	/**
	 * @var Entity
	 */
	private $entity;

	/**
	 * @var string
	 */
	private $content;

	/**
	 * @return PersistData
	 */
	public static function create()
	{
		return new self();
	}

	/**
	 * @return Entity
	 */
	public function getEntity(): Entity
	{
		return $this->entity;
	}

	/**
	 * @param Entity $entity
	 * @return PersistData
	 */
	public function setEntity(Entity $entity): PersistData
	{
		$this->entity = $entity;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getContent(): string
	{
		return $this->content;
	}

	/**
	 * @param string $content
	 * @return PersistData
	 */
	public function setContent(string $content): PersistData
	{
		$this->content = $content;
		return $this;
	}
}