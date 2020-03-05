<?php
namespace Assets\File\Filesystem;

use function file_exists;
use function file_put_contents;
use function pathinfo;
use const PATHINFO_DIRNAME;

class Persister
{
	/**
	 * @var PathProvider
	 */
	private $pathProvider;

	/**
	 * @param PathProvider $pathProvider
	 */
	public function __construct(PathProvider $pathProvider)
	{
		$this->pathProvider = $pathProvider;
	}

	/**
	 * @param PersistData $data
	 * @return PersistResult
	 */
	public function persist(PersistData $data)
	{
		$result = new PersistResult();
		$result->setSuccess(false);

		$path = $this->pathProvider->byEntity(
			$data->getEntity()
		);

		$directory = pathinfo($path, PATHINFO_DIRNAME);

		$this->ensureDirectories($directory);

		$success = file_put_contents(
			$path,
			$data->getContent()
		) !== false;

		$result->setSuccess($success);

		return $result;
	}

	/**
	 * @param $directory
	 */
	private function ensureDirectories($directory): void
	{
		if (!file_exists($directory))
		{
			mkdir(
				$directory,
				0775,
				true
			);
		}
	}
}