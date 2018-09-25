<?php
/**
 * Configuration file for DI container.
 */
return [

    // Services to add to the container.
    "services" => [
        "request" => [
            "shared" => true,
            "callback" => function () {
                $request = new \Anax\Request\Request();
                $request->init();
                return $request;
            }
        ],
        "response" => [
            "shared" => true,
            "callback" => function () {
                $obj = new \Anax\Response\ResponseUtility();
                $obj->setDI($this);
                return $obj;
            }
        ],
        "url" => [
            "shared" => true,
            "callback" => function () {
                $url = new \Anax\Url\Url();
                $request = $this->get("request");
                $url->setSiteUrl($request->getSiteUrl());
                $url->setBaseUrl($request->getBaseUrl());
                $url->setStaticSiteUrl($request->getSiteUrl());
                $url->setStaticBaseUrl($request->getBaseUrl());
                $url->setScriptName($request->getScriptName());
                $url->configure("url.php");
                $url->setDefaultsFromConfiguration();
                return $url;
            }
        ],
        "view" => [
            "shared" => true,
            "callback" => function () {
                $view = new \Anax\View\ViewCollection();
                $view->setDI($this);
                $view->configure("view.php");
                return $view;
            }
        ],
        "viewRenderFile" => [
            "shared" => true,
            "callback" => function () {
                $viewRender = new \Anax\View\ViewRenderFile2();
                $viewRender->setDI($this);
                return $viewRender;
            }
        ],
        "session" => [
            "shared" => true,
            "active" => true,
            "callback" => function () {
                $session = new \Anax\Session\SessionConfigurable();
                $session->configure("session.php");
                $session->start();
                return $session;
            }
        ],
        "textfilter" => [
            "shared" => true,
            "callback" => "\Anax\TextFilter\TextFilter",
        ],
        // "errorController" => [
        //     "shared" => true,
        //     "callback" => function () {
        //         $obj = new \Anax\Page\ErrorController();
        //         $obj->setDI($this);
        //         return $obj;
        //     }
        // ],
        "debugController" => [
            "shared" => true,
            "callback" => function () {
                $obj = new \Anax\Page\DebugController();
                $obj->setDI($this);
                return $obj;
            }
        ],
        // "comment" => [
        //     "shared" => true,
        //     "callback" => function () {
        //         $obj = new \Anax\Comment\Comment();
        //         $obj->inject($this->get("session"));
        //         return $obj;
        //     }
        // ],
        // "comController" => [
        //     "shared" => true,
        //     "callback" => function () {
        //         $obj = new \Anax\Comment\CommentController();
        //         $obj->injects($this->get("comment"), $this->get("pageRender"));
        //         return $obj;
        //     }
        // ],
        // "comment2Controller" => [
        //     "shared" => true,
        //     "callback" => function () {
        //         $obj = new \Kifekenny\Comment\Comment2Controller();
        //         $obj->setDI($this);
        //         return $obj;
        //     }
        // ],
        "flatFileContentController" => [
            "shared" => true,
            "callback" => function () {
                $obj = new \Anax\Page\FlatFileContentController();
                $obj->setDI($this);
                return $obj;
            }
        ],
        "pageRender" => [
            "shared" => true,
            "callback" => function () {
                $obj = new \Anax\Page\PageRender();
                $obj->setDI($this);
                return $obj;
            }
        ],
        "router" => [
            "shared" => true,
            "callback" => function () {
                $router = new \Anax\Route\Router();
                $router->setDI($this);
                $router->configure("route.php");
                return $router;
            }
        ],
        "userController" => [
            "shared" => true,
            "callback" => function () {
                $obj = new \Anax\User\UserController();
                $obj->setDI($this);
                // $obj->startSession($this->get("session"));
                return $obj;
            }
        ],
        "db" => [
            "shared" => true,
            "callback" => function () {
                $obj = new \Anax\Database\DatabaseQueryBuilder();
                $obj->configure("database.php");
                return $obj;
            }
        ],
        "questionController" => [
            "shared" => true,
            "callback" => function () {
                $obj = new \Anax\Question\Question2Controller();
                $obj->setDI($this);
                return $obj;
            }
        ],
        // "bookController" => [
        //     "shared" => true,
        //     "callback" => function () {
        //         $obj = new \Anax\Book\BookController();
        //         $obj->setDI($this);
        //         return $obj;
        //     }
        // ],
        // "Comment2Controller" => [
        //     "shared" => true,
        //     "callback" => function () {
        //         $obj = new \Anax\Comment2\Comment2Controller();
        //         $obj->setDI($this);
        //         return $obj;
        //     }
        // ],
    ],
];
