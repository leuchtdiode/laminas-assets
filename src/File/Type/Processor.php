<?php
namespace Assets\File\Type;

interface Processor
{
	public function process(ProcessData $data): ProcessResult;
}