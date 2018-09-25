<?php

// namespace AnaxSERHTMLFORM;
namespace Anax\User\HTMLForm;

use \Anax\HTMLForm\FormModel;
use \Anax\DI\DIInterface;
use \Anax\User\User;

/**
 * Example of FormModel implementation.
 */
class UserLoginForm extends FormModel
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
                "legend" => "User Login"
            ],
            [
                "username" => [
                    "type"        => "text",
                ],

                "password" => [
                    "type"        => "password",
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Login",
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
        $username      = $this->form->value("username");
        $password      = $this->form->value("password");

        $user = new User();
        $user->setDb($this->di->get("db"));
        $res = $user->verifyPassword($username, $password);

        if (!$res) {
            $this->form->rememberValues();
            $this->form->addOutput("User or password did not match.");
            return false;
        }

        $userInfo = $user->valueExist($username, true);

        $session = $this->di->get("session");
        $session->set("current_user", $username);
        $session->set("user_mail", $userInfo->mail);
        $session->set("user_id", $userInfo->id);

        $this->di->get("response")->redirect("");
    }
}
