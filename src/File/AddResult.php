<?php
namespace Assets\File;

use Assets\Common\ResultTrait;

class AddResult
{
	use ResultTrait;

	/**
	 * @var File|null
	 */
	private $file;

	/**
	 * @return File|null
	 */
	public function getFile(): ?File
	{
		return $this->file;
	}

	/**
	 * @param File|null $file
	 */
	public function setFile(?File $file): void
	{
		$this->file = $file;
	}
}