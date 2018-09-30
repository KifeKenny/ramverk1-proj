<?php

// namespace AnaxSERHTMLFORM;
namespace Kifekenny\Comment\HTMLForm;

use \Anax\HTMLForm\FormModel;
use \Anax\DI\DIInterface;
use \Kifekenny\Comment\Comment;

/**
 * Example of FormModel implementation.
 */
class Com2Session extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Anax\DI\DIInterface $di a service container
     */
    public function __construct(DIInterface $dis)
    {
        parent::__construct($dis);
        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Set session",
            ],
            [
                "mail" => [
                    "type"        => "text",
                    "validation"  => ["not_empty"],
                ],
                "submit" => [
                    "type" => "submit",
                    "value" => "Set session",
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
         // Get values from the submitted form
        $mail = $this->form->value("mail");

        $session = $this->di->get("session");

        if (!$mail) {
            $this->form->addOutput("Can't be empty");
            return false;
        }
        $session->set("user_id", 1);
        $session->set("user_mail", $mail);
        $session->set("user_name", $mail);

        $this->form->addOutput("User was created.");
        return true;
    }
}
