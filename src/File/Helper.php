<?php
namespace Assets\File;

class Helper
{
	public static function getExtensionByFileName(string $fileName): string
	{
		$boom = explode('.', $fileName);

		return array_pop($boom);
	}
}