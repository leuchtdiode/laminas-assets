<?php
namespace Assets\File;

use Assets\Common\EntityDtoCreator;
use Assets\Db\File\Entity;
use Assets\File\Url\Provider as UrlProvider;

class Creator implements EntityDtoCreator
{
	/**
	 * @var UrlProvider
	 */
	private $urlsProvider;

	/**
	 * @param UrlProvider $urlsProvider
	 */
	public function __construct(UrlProvider $urlsProvider)
	{
		$this->urlsProvider = $urlsProvider;
	}

	/**
	 * @param Entity $entity
	 * @return File
	 */
	public function byEntity($entity)
	{
		return new File(
			$entity,
			$this->urlsProvider->all($entity)
		);
	}
}