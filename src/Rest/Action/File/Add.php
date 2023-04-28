<?php
namespace Assets\Rest\Action\File;

use Assets\File\AddData as FileAddData;
use Assets\File\Adder;
use Assets\Rest\Action\Base;
use Assets\Rest\Action\Response;
use Common\Hydration\ObjectToArrayHydrator;
use Laminas\View\Model\JsonModel;
use Throwable;

class Add extends Base
{
	private AddData $data;

	private Adder $adder;

	public function __construct(AddData $data, Adder $adder)
	{
		$this->data  = $data;
		$this->adder = $adder;
	}

	/**
	 * @throws Throwable
	 */
	public function executeAction(): JsonModel
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
