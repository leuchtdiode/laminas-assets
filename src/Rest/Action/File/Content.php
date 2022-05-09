<?php
namespace Assets\Rest\Action\File;

use Assets\File\Filesystem\PathProvider;
use Assets\File\Provider;
use Assets\File\Type\ProcessData;
use Assets\File\Type\Processor;
use Assets\Rest\Action\Base;
use Exception;
use Laminas\Http\Response;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class Content extends Base
{
	public function __construct(
		private array $config,
		private ContainerInterface $container,
		private Provider $fileProvider,
		private PathProvider $pathProvider
	)
	{
	}

	/**
	 * @throws ContainerExceptionInterface
	 * @throws NotFoundExceptionInterface
	 * @throws Exception
	 */
	public function executeAction(): Response
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

		$type = $this
			->params()
			->fromRoute('type');

		$path = $this->pathProvider->byEntity(
			$file->getEntity()
		);

		if (!file_exists($path))
		{
			$response->setStatusCode(404);
			return $response;
		}

		if (!($typeConfig = $this->config['assets']['file']['processor'][$type] ?? null))
		{
			throw new Exception('Could not find processor config for type "' . $type . '"');
		}

		$processor = $this->container->get($typeConfig['processor']);

		if (!$processor instanceof Processor)
		{
			throw new Exception('Invalid processor given');
		}

		$pathWithType = $path . '.' . $type;

		if (!file_exists($pathWithType))
		{
			$processResult = $processor->process(
				ProcessData::create()
					->setFile($file)
					->setOptions($typeConfig['options'] ?? [])
			);

			$content = $processResult->getContent();

			file_put_contents($pathWithType, $content);
		}
		else
		{
			$content = file_get_contents($pathWithType);
		}

		$response->getHeaders()
			->addHeaders(
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