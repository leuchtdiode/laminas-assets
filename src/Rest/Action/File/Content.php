<?php
namespace Assets\Rest\Action\File;

use Assets\Common\MemoryUtil;
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
		private readonly array $config,
		private readonly ContainerInterface $container,
		private readonly Provider $fileProvider,
		private readonly PathProvider $pathProvider
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
		$params = $this->params();

		$file = $this->fileProvider->byId(
			$params->fromRoute('fileId')
		);

		$response = $this->getResponse();

		if (!$file)
		{
			$response->setStatusCode(404);
			return $response;
		}

		$type = $params->fromRoute('type');

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

		$memoryLimit       = MemoryUtil::getMemoryLimitInBytes();
		$fileSize          = (int)$file->getSize();
		$targetMemoryLimit = $fileSize * 2;

		// set memory limit twice the size of the file size to avoid memory leaks
		if ($targetMemoryLimit > $memoryLimit)
		{
			ini_set('memory_limit', $targetMemoryLimit);
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

		$outputFileName = $params->fromRoute('fileName') . '.' . $params->fromRoute('extension');

		$response
			->getHeaders()
			->addHeaders(
				[
					'Content-disposition' => 'inline; filename=' . $outputFileName,
					'Content-type'        => $typeConfig['mimeType'] ?? $file->getMimeType(),
					'Content-size'        => strlen($content),
				]
			);

		$response->setContent($content);

		return $response;
	}
}
