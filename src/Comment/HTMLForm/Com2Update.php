<?php

namespace Kifekenny\Comment\HTMLForm;

use \Anax\HTMLForm\FormModel;
use \Anax\DI\DIInterface;
use \Kifekenny\Comment\Comment;

/**
 * Form to update an item.
 */
class Com2Update extends FormModel
{
    /**
     * Constructor injects with DI container and the id to update.
     *
     * @param Anax\DI\DIInterface $di a service container
     * @param integer             $id to update
     */
    public function __construct(DIInterface $dis, $id)
    {
        parent::__construct($dis);
        $currId = $this->di->get("session")->get("user_id");
        $comment2 = $this->isgetItemDetails($id);
        if ($currId != 1) {
            if ($comment2->userId != $currId) {
                $this->di->get("response")->redirect("");
            }
        }
        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Update details of the book",
            ],
            [
                "id" => [
                    "type" => "hidden",
                    "value" => $comment2->id,
                ],

                "Title" => [
                    "type" => "text",
                    "validation" => ["not_empty"],
                    "value" => $comment2->title,
                ],

                "Content" => [
                    "type" => "textarea",
                    "validation" => ["not_empty"],
                    "value" => $comment2->content,
                    "class" => "editText",
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Save",
                    "callback" => [$this, "callbackSubmit"]
                ],

                "reset" => [
                    "type"      => "reset",
                ],
            ]
        );
    }



    /**
     * Get details on item to load form with.
     *
     * @param integer $id get details on item with id.
     *
     * @return boolean true if okey, false if something went wrong.
     */
    public function isgetItemDetails($id)
    {
        $comment2 = new Comment();
        $comment2->setDb($this->di->get("db"));
        $comment2->find("id", $id);
        return $comment2;
    }



    /**
     * Callback for submit-button which should return true if it could
     * carry out its work and false if something failed.
     *
     * @return boolean true if okey, false if something went wrong.
     */
    public function callbackSubmit()
    {
        $comment = new Comment();
        $comment->setDb($this->di->get("db"));
        $comment->find("id", $this->form->value("id"));
        $comment->title = $this->form->value("Title");
        $comment->content = $this->form->value("Content");
        $comment->save();
        $this->di->get("response")->redirect("");
    }
}
