<?php
namespace Assets\Rest\Action\File;

use Assets\File\Filesystem\PathProvider;
use Assets\File\Provider;
use Assets\Rest\Action\Base;
use function file_exists;
use function file_get_contents;
use function strlen;

class Content extends Base
{
	/**
	 * @var Provider
	 */
	private $fileProvider;

	/**
	 * @var PathProvider
	 */
	private $pathProvider;

	/**
	 * @param Provider $fileProvider
	 * @param PathProvider $pathProvider
	 */
	public function __construct(Provider $fileProvider, PathProvider $pathProvider)
	{
		$this->fileProvider = $fileProvider;
		$this->pathProvider = $pathProvider;
	}

	/**
	 *
	 */
	public function executeAction()
	{
		$file = $this->fileProvider->byId(
			$this
				->params()
				->fromRoute('fileId')
		);

		$response = $this->getResponse();

		if (!$file)
		{
			$response->setStatusCode(404);
			return $response;
		}

		$path = $this->pathProvider->byEntity(
			$file->getEntity()
		);

		if (!file_exists($path))
		{
			$response->setStatusCode(404);
			return $response;
		}

		$content = file_get_contents($path);

		$response->getHeaders()->addHeaders(
			[
				'Content-disposition' => 'inline; filename=' . $file->getFileName(),
				'Content-type'        => $file->getMimeType(),
				'Content-size'        => strlen($content),
			]
		);

		$response->setContent($content);

		return $response;
	}
}