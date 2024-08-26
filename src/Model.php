<?php

namespace Rougin\Credo;

/**
 * @property \CI_DB_query_builder $db
 *
 * @package Credo
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Model extends \CI_Model
{
    use Traits\CredoTrait;

    /**
     * Deletes the specified ID of the model from the database.
     *
     * @param integer $id
     *
     * @return void
     */
    public function delete($id)
    {
        $item = $this->find($id);

        if ($item)
        {
            $this->credo->remove($item);

            $this->credo->flush();
        }
    }

    /**
     * Inserts a new row into the table.
     *
     * @param array<string, mixed> $data
     *
     * @return integer
     */
    public function insert($data)
    {
        $meta = $this->metadata(get_class($this));

        $table = $meta->getTableName();

        $this->db->insert($table, $data);

        $lastId = $this->db->insert_id();

        $item = $this->find($lastId);

        $this->credo->refresh($item);

        return $lastId;
    }

    /**
     * Updates the selected row from the table.
     *
     * @param integer              $id
     * @param array<string, mixed> $data
     *
     * @return boolean
     */
    public function update($id, $data)
    {
        $meta = $this->metadata(get_class($this));

        $key = $meta->getSingleIdentifierColumnName();

        $table = $meta->getTableName();

        $this->db->where($key, $id)->set($data);

        $result = $this->db->update($table);

        $this->credo->refresh($this->find($id));

        return $result;
    }

    /**
     * Returns the metadata of an entity.
     *
     * @param class-string $class
     *
     * @return \Doctrine\ORM\Mapping\ClassMetadata
     */
    protected function metadata($class)
    {
        return $this->credo->getMetadataFactory()->getMetadataFor($class);
    }
}
