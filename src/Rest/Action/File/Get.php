<?php
namespace Assets\Rest\Action\File;

use Assets\File\Provider;
use Assets\Rest\Action\Base;
use Assets\Rest\Action\Response;
use Common\Hydration\ObjectToArrayHydrator;
use Exception;
use Laminas\View\Model\JsonModel;

class Get extends Base
{
	private Provider $provider;

	public function __construct(Provider $provider)
	{
		$this->provider = $provider;
	}

	/**
	 * @throws Exception
	 */
	public function executeAction(): JsonModel
	{
		$file = $this->provider->byId(
			$this
				->params()
				->fromRoute('fileId')
		);

		if (!$file)
		{
			return Response::is()
				->unsuccessful()
				->dispatch();
		}

		return Response::is()
			->successful()
			->data(
				ObjectToArrayHydrator::hydrate(
					$file
				)
			)
			->dispatch();
	}
}
