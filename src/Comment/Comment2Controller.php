<?php

namespace Anax\Comment;

use \Anax\Configure\ConfigureInterface;
use \Anax\Configure\ConfigureTrait;
use \Anax\DI\InjectionAwareInterface;
use \Anax\DI\InjectionAwareTrait;
use \Anax\Comment\Comment;
use \Anax\User\User;
// use \Kifekenny\Comment\HTMLForm\Com2Create;
// use \Kifekenny\Comment\HTMLForm\Com2Update;
// use \Kifekenny\Comment\HTMLForm\Com2Delete;
// use \Kifekenny\Comment\HTMLForm\Com2Session;


/**
 * A controller class.
 */
class Comment2Controller implements
    ConfigureInterface,
    InjectionAwareInterface
{
    use ConfigureTrait,
        InjectionAwareTrait;



    /**
     * @var $session to hold session class
     * @var $view to hold view class
     * @var $pageRender to hold pageRender class
     */
     public $session;
     public $view;
     public $pageRender;
     public $question;
     public $tags;
     public $user;
//
//     public function getClasses()
//     {
//         $this->session    = $this->di->get("session");
//         $this->view       = $this->di->get("view");
//         $this->pageRender = $this->di->get("pageRender");
//     }
//
//     public function getdatabases()
//     {
//         $this->question    = new Question();
//         $this->tags        = new Tags();
//         $this->user        = new User();
//
//         $this->question->setDb($this->di->get("db"));
//         $this->tags->setDb($this->di->get("db"));
//         $this->user->setDb($this->di->get("db"));
//     }
//
//     /**
//      * Show all items.
//      *
//      * @return void
//      */
//     public function getIndex()
//     {
//         $this->getClasses();
//
//         $question = new Question();
//         $question->setDb($this->di->get("db"));
//
//         $tags = new Tags();
//         $tags->setDb($this->di->get("db"));
//
//         $user = new User();
//         $user->setDb($this->di->get("db"));
//
//         $data = [
//             "items" => $question->findAll(),
//             "tags"  => $tags->findAll(),
//             "user"  => $user->findAll(),
//         ];
//
//         $data2 = [
//             "tags"  => $tags->findAll(),
//         ];
//
//         $this->view->add("incl/header", ["title" => ["Book", "css/style.css", '../htdocs/img/pumpkin.jpg']]);
//         $this->view->add("question/side-bar1", $data2);
//         $this->view->add("question/viewAll", $data);
//         $this->view->add("incl/side-bar2");
//         $this->view->add("incl/footer");
//
//         $this->pageRender->renderPage(["title" => "View | Questions"]);
//     }
    //
    // public function comment2Create()
    // {
    //     $session = $this->di->get("session");
    //     $userId = $session->get("user_id");
    //
    //     if (!$userId) {
    //         $this->di->get("response")->redirect("");
    //     }
    //
    //     $title      = "Create | Comment";
    //     $view       = $this->di->get("view");
    //     $pageRender = $this->di->get("pageRender");
    //     $comment2   = new Com2Create($this->di);
    //
    //     $comment2->check();
    //
    //     $data = [
    //         "form" => $comment2->getHTML(),
    //     ];
    //
    //
    //     $view->add("incl/header", ["title" => ["Book", "../css/style.css"]]);
    //     $view->add("incl/side-bar1");
    //     $view->add("comment/create", $data);
    //     $view->add("incl/side-bar2");
    //     $view->add("incl/footer");
    //
    //     $pageRender->renderPage(["title" => $title]);
    // }
    //
    // public function comment2Update($id)
    // {
    //     $session = $this->di->get("session");
    //     $userId = $session->get("user_id");
    //
    //     if (!$userId) {
    //         $this->di->get("response")->redirect("");
    //     }
    //
    //     $title      = "Create | Comment";
    //     $view       = $this->di->get("view");
    //     $pageRender = $this->di->get("pageRender");
    //     $comment2   = new Com2Update($this->di, $id);
    //
    //     $comment2->check();
    //
    //     $data = [
    //         "form" => $comment2->getHTML(),
    //     ];
    //
    //
    //     $view->add("incl/header", ["title" => ["Book", "../../css/style.css"]]);
    //     $view->add("incl/side-bar1");
    //     $view->add("comment/create", $data);
    //     $view->add("incl/side-bar2");
    //     $view->add("incl/footer");
    //
    //     $pageRender->renderPage(["title" => $title]);
    // }
    //
    // public function comment2Delete($id)
    // {
    //     $session = $this->di->get("session");
    //     $userId = $session->get("user_id");
    //
    //     if (!$userId) {
    //         $this->di->get("response")->redirect("");
    //     }
    //
    //     $title      = "Delete | Comment";
    //     $view       = $this->di->get("view");
    //     $pageRender = $this->di->get("pageRender");
    //     $comment2   = new Com2Delete($this->di, $id);
    //
    //     $comment2->check();
    //
    //     $data = [
    //         "form" => $comment2->getHTML(),
    //     ];
    //
    //
    //     $view->add("incl/header", ["title" => ["Book", "../../css/style.css"]]);
    //     $view->add("incl/side-bar1");
    //     $view->add("comment/create", $data);
    //     $view->add("incl/side-bar2");
    //     $view->add("incl/footer");
    //
    //     $pageRender->renderPage(["title" => $title]);
    // }
    //
    // public function setUser()
    // {
    //     $title      = "Set | Session";
    //     $view       = $this->di->get("view");
    //     $pageRender = $this->di->get("pageRender");
    //     $comment2   = new Com2Session($this->di);
    //
    //     $comment2->check();
    //
    //     $data = [
    //         "form" => $comment2->getHTML(),
    //     ];
    //
    //     $view->add("incl/header", ["title" => ["Book", "../../css/style.css"]]);
    //     $view->add("incl/side-bar1");
    //     $view->add("comment/default", $data);
    //     $view->add("incl/side-bar2");
    //     $view->add("incl/footer");
    //
    //     $pageRender->renderPage(["title" => $title]);
    // }
}
