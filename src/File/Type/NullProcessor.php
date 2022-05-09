<?php
namespace Assets\File\Type;

use Assets\File\Filesystem\PathProvider;

class NullProcessor implements Processor
{
	public function __construct(private PathProvider $pathProvider)
	{
	}

	public function process(ProcessData $data): ProcessResult
	{
		$result = new ProcessResult();

		$result->setContent(
			file_get_contents(
				$this->pathProvider->byEntity(
					$data
						->getFile()
						->getEntity()
				)
			)
		);

		return $result;
	}
}