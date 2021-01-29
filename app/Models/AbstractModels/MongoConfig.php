<?php

namespace App\Models\AbstractModels;

use DB;

abstract class MongoConfig
{
    protected $connection = 'mongodb';
    protected $collection = 'mongo_config';
    protected $doc_index = '';

    /**
     * @param $name
     */
    public function createOption($name)
    {
        if(!DB::connection($this->connection)->collection($this->collection)
            ->where(['_id' => $name])->count()){
            DB::connection($this->connection)->collection($this->collection)
                ->insert(['_id' => $name]);
        }
    }

    /**
     * Create empty collection with doc_index
     */
    public function deleteDocument()
    {
        DB::connection($this->connection)->collection($this->collection)
            ->where('_id', $this->doc_index)->delete();
    }

    /**
     * Insert new data into config collection
     * @param $opt_name
     * @param $data
     */
    public function insert($opt_name, $data)
    {
        DB::connection($this->connection)->collection($this->collection)
            ->where('_id', $this->doc_index)
            ->update([$opt_name => $data],['upsert' => true]);
    }
    /**
     * clone option from config
     */
    public function cloneFromConfig()
    {
        $this->createOption($this->doc_index);
        $config = config($this->doc_index);
        if((is_array($config))&&(count($config))){
            foreach ($config as $key => $cc){
                $this->insert($key,$cc);
            }
        }
    }
    /**
     * Get config array for all entries.
     */
    public function getAll()
    {
        $config = DB::connection($this->connection)->collection($this->collection)
            ->where(['_id' => $this->doc_index])
            ->first();
        unset($config['_id']);
        return $config;
    }

    /**
     * Get config array for entry by id
     * @param $id
     * @return mixed|null
     */
    public function get($id)
    {
        if (!isset($id)) return null;
        $check = DB::connection($this->connection)->collection($this->collection)
            ->where(['_id' => $this->doc_index])
            ->where($id, 'exists', true)->count();
        if ($config = DB::connection($this->connection)->collection($this->collection)
             ->where(['_id' => $this->doc_index])
             ->where($id, 'exists', true)->count()){
            $config = DB::connection($this->connection)->collection($this->collection)
                ->where(['_id' => $this->doc_index])
                ->select([$id])
                ->first()[$id];
            return $config;
        }
        return null;
    }

    /**
     * Adding/replacing data in doc with $id
     * @param $id
     * @param $key
     * @param $value
     * @return null
     */
    public function update($id, $key, $value)
    {
        if(!isset($id)) return null;
        $data = $this->get($id);
        if ( $data ) {
            $data[$key] = $value;
            DB::connection($this->connection)->collection($this->collection)
                ->where('_id', $this->doc_index)
                ->update([$id => $data],['upsert' => true]);
        }
        return null;
    }

    /**
     * Delete client with $id
     * @param $id
     * @return null
     */
    public function delete($id)
    {
        if(!isset($id)) return null;
        DB::connection($this->connection)->collection($this->collection)
            ->where('_id', $this->doc_index)
            ->unset($id);
        return null;
    }
}

