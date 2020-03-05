<?php
namespace Assets\File\Url;

use Common\Hydration\ArrayHydratable;

class Url implements ArrayHydratable
{
	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @var string
	 */
	private $url;

	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @var string
	 */
	private $type;

	/**
	 * @param string $url
	 * @param string $type
	 */
	public function __construct(string $url, string $type)
	{
		$this->url  = $url;
		$this->type = $type;
	}

	/**
	 * @return string
	 */
	public function getUrl(): string
	{
		return $this->url;
	}

	/**
	 * @return string
	 */
	public function getType(): string
	{
		return $this->type;
	}
}