<?php

namespace Kifekenny\Comment\HTMLForm;

use \Anax\HTMLForm\FormModel;
use \Anax\DI\DIInterface;
use \Kifekenny\Comment\Comment;

/**
 * Form to create an item.
 */
class Com2Create extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Anax\DI\DIInterface $di a service container
     */
    public function __construct(DIInterface $dis)
    {
        parent::__construct($dis);
        $session = $this->di->get("session");
        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Add Comment",
            ],
            [
                "userId" => [
                    "type" => "hidden",
                    "validation" => ["not_empty"],
                    "value" => $session->get("user_id"),
                ],
                "Mail" => [
                    "type" => "text",
                    "readonly" => true,
                    "value" => $session->get("user_mail"),
                ],
                "Title" => [
                    "type" => "text",
                    "validation" => ["not_empty"],
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
     * Callback for submit-button which should return true if it could
     * carry out its work and false if something failed.
     *
     * @return boolean true if okey, false if something went wrong.
     */
    public function callbackSubmit()
    {
        $comment = new Comment();
        $comment->setDb($this->di->get("db"));
        $comment->title      = $this->form->value("Title");
        $comment->content    = $this->form->value("Content");
        $comment->userMail  = $this->form->value("Mail");
        $comment->userId    = $this->form->value("userId");
        // $comment->user_id
        $comment->save();
        $this->di->get("response")->redirect("");
    }
}
