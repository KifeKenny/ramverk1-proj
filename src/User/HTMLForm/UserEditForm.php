<?php

// namespace AnaxSERHTMLFORM;
namespace Anax\User\HTMLForm;

use \Anax\HTMLForm\FormModel;
use \Anax\DI\DIInterface;
use \Anax\User\User;

/**
 * Example of FormModel implementation.
 */
class UserEditForm extends FormModel
{

    public $session;
    /**
     * Constructor injects with DI container.
     *
     * @param Anax\DI\DIInterface $di a service container
     */
    public function __construct(DIInterface $dis)
    {
        parent::__construct($dis);
        $this->session = $this->di->get("session");
        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "User Login"
            ],
            [
                "username" => [
                    "type"        => "text",
                    "value"       => $this->session->get("current_user"),
                    "validation" => ["not_empty"],
                ],
                "mail" => [
                    "type"        => "text",
                    "value"       => $this->session->get("user_mail"),
                    "validation" => ["not_empty"],
                ],
                "submit" => [
                    "type" => "submit",
                    "value" => "Edit",
                    "callback" => [$this, "callbackSubmit"]
                ],
            ]
        );
    }


    public function getItemDetails($id)
    {
        $user = new user();
        $user->setDb($this->di->get("db"));
        $user->find("id", $id);
        return $user;
    }
    /**
     * Callback for submit-button which should return true if it could
     * carry out its work and false if something failed.
     *
     * @return boolean true if okey, false if something went wrong.
     */
    public function callbackSubmit()
    {

        $user = new User();
        $user->setDb($this->di->get("db"));
        $user->find("id", $this->session->get('user_id'));

        if (!$user) {
            $this->di->get("response")->redirect("");
        }


        if ($user->username != $this->form->value("username")) {
            if ($user->valueExist($this->form->value("username"))) {
                $this->form->addOutput("Username already exist.");
                return false;
            }
        }

        $user->username       = $this->form->value("username");
        $user->mail           = $this->form->value("mail");

        $user->save();

        $session = $this->di->get("session");
        $session->set("current_user", $user->username);
        $session->set("user_mail", $user->mail);

        $this->form->addOutput("Profile was Edited.");
        return true;
    }
}
