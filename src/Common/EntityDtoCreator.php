<?php
namespace Assets\Common;

use Common\Dto\Dto;
use Common\Db\Entity as DbEntity;

interface EntityDtoCreator
{
	public function byEntity(DbEntity $entity): Dto;
}