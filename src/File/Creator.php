<?php
namespace Assets\File;

use Assets\Common\EntityDtoCreator;
use Assets\Db\File\Entity;
use Assets\File\Url\Provider as UrlProvider;
use Common\Dto\Dto;

class Creator implements EntityDtoCreator
{
	public function __construct(
		private readonly UrlProvider $urlsProvider
	)
	{
	}

	/**
	 * @param Entity $entity
	 * @return File
	 */
	public function byEntity($entity, ?CreateOptions $createOptions = null): Dto
	{
		return new File(
			$entity,
			$this->urlsProvider->get($entity, $createOptions?->getTypes())
		);
	}
}