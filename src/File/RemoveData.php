<?php
namespace Assets\File;

class RemoveData
{
	/**
	 * @var File
	 */
	private $file;

	/**
	 * @return RemoveData
	 */
	public static function create(): self
	{
		return new self();
	}

	public function getFile(): File
	{
		return $this->file;
	}

	public function setFile(File $file): RemoveData
	{
		$this->file = $file;
		return $this;
	}
}