<?php
namespace Assets\Rest\Action\File;

use Common\RequestData\Data;
use Common\RequestData\PropertyDefinition\PropertyDefinition;
use Common\RequestData\PropertyDefinition\Text;

class AddData extends Data
{
	const CONTENT   = 'content';
	const FILE_NAME = 'fileName';
	const MIME_TYPE = 'mimeType';
	const SIZE      = 'size';

	/**
	 * @return PropertyDefinition[]
	 */
	protected function getDefinitions()
	{
		return [
			Text::create()
				->setName(self::CONTENT)
				->setRequired(true),
			Text::create()
				->setName(self::FILE_NAME)
				->setRequired(true),
			Text::create()
				->setName(self::MIME_TYPE)
				->setRequired(true),
			Text::create()
				->setName(self::SIZE)
				->setRequired(true),
		];
	}
}