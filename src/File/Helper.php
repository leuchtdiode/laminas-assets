<?php
namespace Assets\File;

class Helper
{
	/**
	 * @param string $fileName
	 * @return string
	 */
	public static function getExtensionByFileName($fileName)
	{
		$boom = explode('.', $fileName);

		return array_pop($boom);
	}
}