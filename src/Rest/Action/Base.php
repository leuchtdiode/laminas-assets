<?php
namespace Assets\Rest\Action;

use Laminas\Http\PhpEnvironment\Response;
use Laminas\Mvc\Controller\AbstractRestfulController;
use Laminas\Stdlib\ResponseInterface;

/**
 */
abstract class Base extends AbstractRestfulController
{
	abstract public function executeAction();

	protected function forbidden(): Response|ResponseInterface
	{
		return $this
			->getResponse()
			->setStatusCode(403);
	}
}
