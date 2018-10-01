<?php

namespace Anax\User;

use \Anax\Configure\ConfigureInterface;
use \Anax\Configure\ConfigureTrait;
use \Anax\DI\InjectionAwareInterface;
use \Anax\Di\InjectionAwareTrait;
use \Anax\User\User;
use \Anax\Question\Question;
use \Anax\Question\Tags;
use \Anax\Comment\Comment;
use \Anax\User\HTMLForm\UserLoginForm;
use \Anax\User\HTMLForm\CreateUserForm;
use \Anax\User\HTMLForm\UserEditForm;

/**
 * A controller class.
 */
class UserController implements
    ConfigureInterface,
    InjectionAwareInterface
{
    use ConfigureTrait,
        InjectionAwareTrait;



    /**
     * @var $view, view class
     * @var $session, session class
     * @var $pageRender, pageRender class
     */
    public $view;
    public $session;
    public $pageRender;


    /**
     * mini constructor.
     * Give varibale classes, for easier and cleaner coding
     *
     * @return void
     */
    public function construct()
    {
        $this->view       = $this->di->get("view");
        $this->session    = $this->di->get("session");
        $this->pageRender = $this->di->get("pageRender");
    }

    public function checkLogin()
    {
        $result = [];
        $this->construct();

        $result["user"] = $this->session->get("current_user", null);
        $result["id"] = $this->session->get("user_id", null);
        return $result;
    }
    /**
     * Description.
     *
     * @param datatype $variable Description
     *
     * @throws Exception
     *
     * @return void
     */
    public function getIndex()
    {
        $this->construct();

        $user = new User();

        $user->setDb($this->di->get("db"));

        $user = $user->findAll();
        $allUsers = [];
        foreach ($user as $key) {
            $question = new Question();
            $question->setDb($this->di->get("db"));

            $amount = $question->findAllWhere("userId = ?", $key->id);
            $key->questions = count($amount);

            $comment = new Comment();
            $comment->setDb($this->di->get("db"));

            $amount = $comment->findAllWhere("userId = ?", $key->id);
            $key->comments = count($amount);
        }

        $data = [ "users" => $user, ];

        $this->view->add("incl/header", ["title" => ["Book", "css/style.css", '../htdocs/img/pumpkin.jpg']]);
        $this->view->add("incl/side-bar1");
        $this->view->add("user/viewAll", $data);
        $this->view->add("incl/side-bar2");
        $this->view->add("incl/footer");

        $this->pageRender->renderPage(["title" => "View | Users"]);
    }

    //get user by id and display user post history
    public function getIndexUser($id = null)
    {
        $this->construct();
        $user = new User();

        $user->setDb($this->di->get("db"));
        $user = $user->findById($id);

        if (!$user) {
            return;
        }

        $allUsers = [];

        $question = new Question();
        $question->setDb($this->di->get("db"));

        $questions = $question->findAllWhere("userId = ?", $user->id);
        $user->questions = $questions;

        foreach ($user->questions as $ques) {
            $tags = new Tags();
            $tags->setDb($this->di->get("db"));
            $ques->tags = $tags->getNameById($ques->tagsId);
        }

        $comment = new Comment();
        $comment->setDb($this->di->get("db"));

        $comments = $comment->findAllWhere("userId = ?", $user->id);
        $user->comments = $comments;

        foreach ($user->comments as $com) {
            $question = new Question();
            $question->setDb($this->di->get("db"));
            $com->comQue = $question->findById($com->quesId);
            $temp = new User();
            $temp->setDb($this->di->get("db"));
            $com->comQue->user = $temp->findById($com->comQue->userId);


            $com->comCom = false;
            if ($com->comId != 0) {
                $comment = new Comment();
                $comment->setDb($this->di->get("db"));
                $com->comCom = $comment->findById($com->comId);

                $temp = new User();
                $temp->setDb($this->di->get("db"));
                $com->comCom->user = $temp->findById($com->comCom->userId);
            }
        }

        $data = [ "users" => $user, ];

        $val = ["", "../../css/style.css", '../../../htdocs/img/pumpkin.jpg'];
        $this->view->add("incl/header", ["title" => $val]);
        $this->view->add("incl/side-bar1");
        $this->view->add("user/viewUser", $data);
        $this->view->add("incl/side-bar2");
        $this->view->add("incl/footer");

        $this->pageRender->renderPage(["title" => "View | User"]);
    }

    /**
     * Description.
     *
     * @param datatype $variable Description
     *
     * @throws Exception
     *
     * @return void
     */
    public function getPostLogin()
    {
        $this->construct();
        $loginInfo = $this->checkLogin();

        if ($loginInfo["user"]) {
            $this->di->get("response")->redirect("");
        }

        $form = new UserLoginForm($this->di);

        $form->check();

        $data = [
            "content" => $form->getHTML(),
        ];
        $data2 = [
            "content" => "user/create",
        ];

        $this->view->add("incl/header", ["title" => ["Book", "../css/style.css", '../../htdocs/img/pumpkin.jpg']]);
        $this->view->add("incl/side-bar1");
        $this->view->add("default2/article", $data);
        $this->view->add("user/default3", $data2);
        $this->view->add("incl/side-bar2");
        $this->view->add("incl/footer");

        $this->pageRender->renderPage(["title" => "User | Login"]);
    }



    /**
     * Description.
     *
     * @param datatype $variable Description
     *
     * @throws Exception
     *
     * @return void
     */
    public function getPostCreateUser()
    {

        $this->construct();
        $form = new CreateUserForm($this->di);

        $form->check();

        $data = [
            "content" => $form->getHTML(),
        ];

        $this->view->add("incl/header", ["title" => ["Book", "../css/style.css", '../../htdocs/img/pumpkin.jpg']]);
        $this->view->add("incl/side-bar1");
        $this->view->add("default2/article", $data);
        $this->view->add("incl/side-bar2");
        $this->view->add("incl/footer");

        $this->pageRender->renderPage(["title" => "User | Create"]);
    }

    public function logoutUser()
    {
        $this->construct();
        $this->session->set("current_user", null);
        $this->session->set("user_mail", null);
        $this->session->set("user_id", null);
        $this->di->get("response")->redirect("");
    }

    public function editProfile()
    {
        $this->construct();
        if (!$this->session->get('user_id')) {
            $this->di->get("response")->redirect("");
        }

        $form = new UserEditForm($this->di);

        $form->check();

        $data = [
            "content" => $form->getHTML(),
        ];

        $this->view->add("incl/header", ["title" => ["", "../css/style.css", "../../htdocs/img/pumpkin.jpg"]]);
        $this->view->add("incl/side-bar1");
        $this->view->add("default/article", $data);
        $this->view->add("incl/side-bar2");
        $this->view->add("incl/footer");

        $this->pageRender->renderPage(["title" => "User | Edit"]);
    }
}
