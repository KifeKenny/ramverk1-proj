<?php

namespace Anax\Question;

use \Anax\Database\ActiveRecordModel;

/**
 * A database driven model.
 */
class Question extends ActiveRecordModel
{
    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "ramverk1Projquestion";

    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
    public $id;
    public $title;
    public $content;
    public $tagsId;
    public $userId;
}
