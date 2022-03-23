<?php
namespace Assets\File;

use Assets\Common\EntityDtoCreator;
use Assets\Db\File\Entity;
use Assets\File\Url\Provider as UrlProvider;

class Creator implements EntityDtoCreator
{
	private UrlProvider $urlsProvider;

	public function __construct(UrlProvider $urlsProvider)
	{
		$this->urlsProvider = $urlsProvider;
	}

	public function byEntity($entity): File
	{
		return new File(
			$entity,
			$this->urlsProvider->all($entity)
		);
	}
}