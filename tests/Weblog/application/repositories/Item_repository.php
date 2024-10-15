<?php

use Rougin\Credo\Repository;

class Item_repository extends Repository
{
    /**
     * @param array<string, mixed> $data
     * @param \Item                $entity
     * @param integer|null         $id
     *
     * @return \Item
     */
    public function set($data, $entity, $id = null)
    {
        /** @var string */
        $name = $data['name'];
        $entity->set_name($name);

        return $entity;
    }
}
