<?php

namespace Anax\User;

use \Anax\Configure\ConfigureInterface;
use \Anax\Configure\ConfigureTrait;
use \Anax\DI\InjectionAwareInterface;
use \Anax\Di\InjectionAwareTrait;
use \Anax\User\User;
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
        $title      = "A index page";
        $view       = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");

        $data = [
            "content" => "An index page",
        ];

        $view->add("default2/article", $data);

        $pageRender->renderPage(["title" => $title]);
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

    public function profile()
    {
        $loginInfo = $this->checkLogin();
        if (!$loginInfo["user"]) {
            $this->di->get("response")->redirect("");
        }

        $title      = "profile";
        $view       = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");
        $user = new User();
        $user->setDb($this->di->get("db"));

        $userInfo = $user->valueExist($loginInfo["user"], true);

        $view->add("incl/header", ["title" => ["Book", "../css/style.css"]]);
        $view->add("incl/side-bar1");
        $view->add("user/profile", ["userInfo" => $userInfo]);
        if ($loginInfo["user"] == "admin") {
            $view->add("user/admin");
        }
        $view->add("incl/side-bar2");
        $view->add("incl/footer");

        $pageRender->renderPage(["title" => $title]);
    }

    public function editProfile($id)
    {
        $loginInfo = $this->checkLogin();
        if (!$loginInfo["user"]) {
            $this->di->get("response")->redirect("");
        }

        $title      = "Profile | Edit";
        $view       = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");
        $form       = new UserEditForm($this->di, $id);

        $form->check();

        $data = [
            "content" => $form->getHTML(),
        ];

        $view->add("incl/header", ["title" => ["Book", "../../css/style.css"]]);
        $view->add("incl/side-bar1");
        $view->add("default2/article", $data);
        $view->add("incl/side-bar2");
        $view->add("incl/footer");

        $pageRender->renderPage(["title" => $title]);
    }

    public function adminIndex()
    {
        $loginInfo = $this->checkLogin();
        if ($loginInfo["user"] != "admin") {
            $this->di->get("response")->redirect("");
        }

        $title      = "Admin | profiles";
        $view       = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");
        $user = new User();
        $user->setDb($this->di->get("db"));

        $data = [
            "items" => $user->findAll(),
        ];


        $view->add("incl/header", ["title" => ["Admin", "css/style.css"]]);
        $view->add("incl/side-bar1");
        $view->add("admin/view-all", $data);
        $view->add("incl/side-bar2");
        $view->add("incl/footer");

        $pageRender->renderPage(["title" => $title]);
    }

    public function adminDelete($id)
    {
        $loginInfo = $this->checkLogin();
        if ($loginInfo["user"] != "admin") {
            $this->di->get("response")->redirect("");
        }

        $user = new user();
        $user->setDb($this->di->get("db"));
        $user->find("id", $id);
        $user->delete();
        $this->di->get("response")->redirect("user/admin/profiles");
    }
}
