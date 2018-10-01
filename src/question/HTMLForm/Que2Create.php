<?php

namespace Anax\Question\HTMLForm;

use \Anax\HTMLForm\FormModel;
use \Anax\DI\DIInterface;
use \Anax\Question\Question;
use \Anax\Question\Tags;

/**
 * Form to create an item.
 */
class Que2Create extends FormModel
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
                "legend" => "Create question",
            ],
            [
                "Username" => [
                    "type" => "text",
                    "readonly" => true,
                    "value" => $session->get("current_user"),
                ],
                "Title" => [
                    "type" => "text",
                    "validation" => ["not_empty"],
                ],
                "Tags" => [
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



        $que = new Question();
        $que->setDb($this->di->get("db"));
        $que->title      = $this->form->value("Title");
        $que->content    = $this->form->value("Content");
        $que->comments   = 0;
        $que->userId     = $this->di->get("session")->get("user_id");


        $tagName = explode(",", $this->form->value("Tags"));
        $tagResult = "";

        for ($i=0; $i < count($tagName); $i++) {
            $tag = new Tags();
            $tag->setDb($this->di->get("db"));
            $tag = $tag->getIdByName($tagName[$i]);

            if ($tag) {
                $tagResult .= $tag;
            } else {
                $this->form->rememberValues();
                $this->form->addOutput("Tag not valid: " .  $this->form->value("Tags"));
                return false;
            }
        }

        $que->tagsId = intval($tagResult);

        if (strlen($que->content) > 200) {
            $this->form->rememberValues();
            $this->form->addOutput("Content to long max is 200 your was: " . strlen($que->content));
            return false;
        } elseif (strlen($que->title) > 20) {
            $this->form->rememberValues();
            $this->form->addOutput("Title to long max is 20 your was: " . strlen($que->title));
            return false;
        }
        $que->save();
        $this->di->get("response")->redirect("question/comments/" . $que->id);
    }
}
