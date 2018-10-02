<?php

namespace Anax\Question;

use \Anax\Database\ActiveRecordModel;

/**
 * A database driven model.
 */
class Tags extends ActiveRecordModel
{
    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "ramverk1ProjTags";

    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
    public $id;
    public $name;

    //take ids as ints, turn them into
    public function getNameById($ids)
    {
        $tagsArr = array_map('intval', str_split($ids));
        $result = [];
        for ($i=0; $i < count($tagsArr); $i++) {
            $temp = $this->findById($tagsArr[$i]);
            array_push($result, $temp->name);
        }

        return $result;
    }

    //take ids as ints, turn them into
    public function getIdByName($name)
    {
        $temp = $this->findAll();
        foreach ($temp as $key) {
            if ($key->name == $name) {
                return $key->id;
            }
        }
        return false;
    }
}
