<?php
namespace Assets\Common;

use Common\Error;

trait ResultTrait
{
	private bool $success;

	/**
	 * @var Error[]
	 */
	private array $errors = [];

	public function addError(Error $error): ResultTrait
	{
		$this->errors[] = $error;

		return $this;
	}

	/**
	 * @param Error[] $errors
	 */
	public function setErrors(array $errors): ResultTrait
	{
		$this->errors = $errors;
		return $this;
	}

	public function setSuccess(bool $success): ResultTrait
	{
		$this->success = $success;

		return $this;
	}

	public function isSuccess(): bool
	{
		return $this->success;
	}

	/**
	 * @return Error[]
	 */
	public function getErrors(): array
	{
		return $this->errors;
	}
}