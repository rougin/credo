<?php

namespace Rougin\Credo;

/**
 * Model
 *
 * @package Credo
 * @author  Rougin Gutib <rougingutib@gmail.com>
 *
 * @property \CI_DB_query_builder $db
 */
class Model extends \CI_Model
{
    use Traits\CredoTrait;

    /**
     * Deletes the specified ID of the model from the database.
     *
     * @param  integer $id
     * @return void
     */
    public function delete($id)
    {
        $item = $this->find($id);

        $this->credo->remove($item);

        $this->credo->flush();
    }

    /**
     * Inserts a new row into the table.
     *
     * @param  array $data
     * @return integer
     */
    public function insert(array $data)
    {
        $metadata = $this->metadata((string) get_class($this));

        $this->db->insert($metadata->getTableName(), $data);

        $item = $this->find($lastId = $this->db->insert_id());

        $this->credo->refresh($item);

        return $lastId;
    }

    /**
     * Updates the selected row from the table.
     *
     * @param  integer $id
     * @param  array   $data
     * @return boolean
     */
    public function update($id, array $data)
    {
        $metadata = $this->metadata((string) get_class($this));

        $primary = $metadata->getSingleIdentifierColumnName();

        $this->db->where($primary, $id)->set((array) $data);

        $result = $this->db->update($metadata->getTableName());

        $this->credo->refresh($this->find((integer) $id));

        return $result;
    }

    /**
     * Returns the metadata of an entity.
     *
     * @param  string $class
     * @return \Doctrine\Common\Persistence\Mapping\ClassMetadata
     */
    protected function metadata($class)
    {
        return $this->credo->getMetadataFactory()->getMetadataFor($class);
    }
}
