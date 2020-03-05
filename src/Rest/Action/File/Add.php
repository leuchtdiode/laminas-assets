<?php
namespace Assets\Rest\Action\File;

use Assets\File\Adder;
use Assets\File\AddData as FileAddData;
use Assets\Rest\Action\Base;
use Assets\Rest\Action\Response;
use Common\Hydration\ObjectToArrayHydrator;
use Exception;
use Laminas\View\Model\JsonModel;

class Add extends Base
{
	/**
	 * @var AddData
	 */
	private $data;

	/**
	 * @var Adder
	 */
	private $adder;

	/**
	 * @param AddData $data
	 * @param Adder $adder
	 */
	public function __construct(AddData $data, Adder $adder)
	{
		$this->data  = $data;
		$this->adder = $adder;
	}

	/**
	 * @return JsonModel
	 * @throws Exception
	 */
	public function executeAction()
	{
		$values = $this->data
			->setRequest($this->getRequest())
			->getValues();

		if ($values->hasErrors())
		{
			return Response::is()
				->unsuccessful()
				->errors($values->getErrors())
				->dispatch();
		}

		$result = $this->adder->add(
			FileAddData::create()
				->setContent(
					$values
						->get(AddData::CONTENT)
						->getValue()
				)
				->setFileName(
					$values
						->get(AddData::FILE_NAME)
						->getValue()
				)
				->setMimeType(
					$values
						->get(AddData::MIME_TYPE)
						->getValue()
				)
				->setSize(
					$values
						->get(AddData::SIZE)
						->getValue()
				)
		);

		if (!$result->isSuccess())
		{
			return Response::is()
				->unsuccessful()
				->errors($result->getErrors())
				->dispatch();
		}

		return Response::is()
			->successful()
			->data(
				ObjectToArrayHydrator::hydrate(
					$result->getFile()
				)
			)
			->dispatch();
	}
}
