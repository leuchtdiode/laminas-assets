<?php
namespace Assets\File;

class AddData
{
	/**
	 * @var string
	 */
	private $content;

	/**
	 * @var string
	 */
	private $fileName;

	/**
	 * @var string
	 */
	private $size;

	/**
	 * @var string
	 */
	private $mimeType;

	/**
	 * @return AddData
	 */
	public static function create()
	{
		return new self();
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
	 * @return AddData
	 */
	public function setContent(string $content): AddData
	{
		$this->content = $content;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getFileName(): string
	{
		return $this->fileName;
	}

	/**
	 * @param string $fileName
	 * @return AddData
	 */
	public function setFileName(string $fileName): AddData
	{
		$this->fileName = $fileName;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getSize(): string
	{
		return $this->size;
	}

	/**
	 * @param string $size
	 * @return AddData
	 */
	public function setSize(string $size): AddData
	{
		$this->size = $size;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getMimeType(): string
	{
		return $this->mimeType;
	}

	/**
	 * @param string $mimeType
	 * @return AddData
	 */
	public function setMimeType(string $mimeType): AddData
	{
		$this->mimeType = $mimeType;
		return $this;
	}
}