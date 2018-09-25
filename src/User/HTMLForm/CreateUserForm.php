<?php

// namespace AnaxSERHTMLFORM;
namespace Anax\User\HTMLForm;

use \Anax\HTMLForm\FormModel;
use \Anax\DI\DIInterface;
use \Anax\User\User;

/**
 * Example of FormModel implementation.
 */
class CreateUserForm extends FormModel
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
                "legend" => "Create user",
            ],
            [
                "username" => [
                    "type"        => "text",
                ],
                "mail" => [
                    "type"        => "text",
                ],
                "password" => [
                    "type"        => "password",
                ],
                "password-again" => [
                    "type"        => "password",
                    "validation" => [
                        "match" => "password"
                    ],
                ],
                "submit" => [
                    "type" => "submit",
                    "value" => "Create user",
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
        $mail           = $this->form->value("mail");
        $password      = $this->form->value("password");
        $passwordAgain = $this->form->value("password-again");

        if (!$username && !$password && !$passwordAgain && !$mail) {
            $this->form->rememberValues();
            $this->form->addOutput("*Fields not filled in");
            return false;
        } elseif ($password !== $passwordAgain) {
            $this->form->rememberValues();
            $this->form->addOutput("Password did not match.");
            return false;
        }

        $user = new User();
        $user->setDb($this->di->get("db"));

        if ($user->valueExist($username)) {
            $this->form->rememberValues();
            $this->form->addOutput("Username already exists");
            return false;
        }

        $user->username = $username;
        $user->mail = $mail;
        $user->setPassword($password);
        $user->save();

        //  Save to database
        $this->form->addOutput("User was created.");
        return true;
    }
}
