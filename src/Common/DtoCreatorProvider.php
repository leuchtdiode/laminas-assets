<?php
namespace Assets\Common;

use Assets\File\Creator as FileCreator;

class DtoCreatorProvider
{
	/**
	 * @var FileCreator
	 */
	private $fileCreator;

	/**
	 * @param FileCreator $fileCreator
	 */
	public function __construct(FileCreator $fileCreator)
	{
		$this->fileCreator = $fileCreator;
	}

	/**
	 * @return FileCreator
	 */
	public function getFileCreator(): FileCreator
	{
		return $this->fileCreator;
	}
}