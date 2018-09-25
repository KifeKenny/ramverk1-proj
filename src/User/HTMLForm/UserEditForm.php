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
    /**
     * Constructor injects with DI container.
     *
     * @param Anax\DI\DIInterface $di a service container
     */
    public function __construct(DIInterface $dis, $id = null)
    {
        parent::__construct($dis);
        $session = $this->di->get("session");
        $currentUser = $session->get("current_user");
        if ($id != null && $currentUser = "admin") {
            $user = $this->getItemDetails($id);
        } else {
            $user = new User();
            $user->setDb($this->di->get("db"));
            $user = $user->valueExist($currentUser, true);
        }
        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "User Login"
            ],
            [
                "id" => [
                    "type"        => "hidden",
                    "value"       => $user->id,
                    //"description" => "Here you can place a description.",
                    //"placeholder" => "Here is a placeholder",
                ],

                "username" => [
                    "type"        => "text",
                    "value"       => $user->acronym,
                    //"description" => "Here you can place a description.",
                    //"placeholder" => "Here is a placeholder",
                ],

                "mail" => [
                    "type"        => "text",
                    "value"       => $user->mail,
                    //"description" => "Here you can place a description.",
                    //"placeholder" => "Here is a placeholder",
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
         // Get values from the submitted form
        $acronym       = $this->form->value("username");
        $mail          = $this->form->value("mail");

        if (!$mail) {
            $this->form->addOutput("All fields not filled in.");
            return false;
        }

        $user = new User();
        $user->setDb($this->di->get("db"));
        $user->find("id", $this->form->value("id"));

        if ($user->acronym != $acronym) {
            if ($user->valueExist($acronym)) {
                $this->form->addOutput("Username already exist.");
                return false;
            }
        }

        if ($user->mail != $mail) {
            if ($user->valueExistMail($mail)) {
                $this->form->addOutput("mail already exist.");
                return false;
            }
        }


        $user->acronym = $acronym;
        $user->mail = $mail;
        $user->save();

        $session = $this->di->get("session");
        if ($session->get("current_user") != "admin") {
            $session->set("current_user", $acronym);
            $session->set("user_mail", $mail);
        }
        $this->form->addOutput("Profile was Edited.");
        return true;
    }
}
