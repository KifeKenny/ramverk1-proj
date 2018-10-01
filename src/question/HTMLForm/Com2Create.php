<?php

namespace Anax\Question\HTMLForm;

use \Anax\HTMLForm\FormModel;
use \Anax\DI\DIInterface;
use \Anax\Comment\Comment;
use \Anax\Question\Tags;

/**
 * Form to create an item.
 */
class Com2Create extends FormModel
{
    public $infoId;
    /**
     * Constructor injects with DI container.
     *
     * @param Anax\DI\DIInterface $di a service container
     */
    public function __construct(DIInterface $dis, $infoId)
    {
        parent::__construct($dis);
        $this->infoId = $infoId;
        $session = $this->di->get("session");
        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Add Comment",
            ],
            [
                "Username" => [
                    "type" => "text",
                    "readonly" => true,
                    "value" => $session->get("current_user"),
                ],
                "Content" => [
                    "type" => "textarea",
                    "validation" => ["not_empty"],
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Submit Comment",
                    "callback" => [$this, "callbackSubmit"]
                ],
            ]
        );
    }


    /**
     *
     * @return boolean true if okey, false if something went wrong.
     */
    public function callbackSubmit()
    {
        $comment = new Comment();
        $comment->setDb($this->di->get("db"));
        $comment->content    = $this->form->value("Content");
        $comment->userId     = $this->di->get("session")->get("user_id");
        $comment->answers    = 0;
        $comment->quesId     = $this->infoId['quesId'];
        $comment->comId      = $this->infoId['comId'];

        if ($this->infoId['comId']) {
            $prevCom = new Comment();
            $prevCom->setDb($this->di->get("db"));
            $prevCom = $prevCom->findById($this->infoId['comId']);
            $prevCom->answers = $prevCom->answers + 1;

            $prevCom->save($prevCom);
        }
        // var_dump($prevCom);

        $comment->save();
        $this->di->get("response")->redirect("question/comment/answer/" . $comment->id);
    }
}
