<?php

namespace Anax\Question;

use \Anax\Configure\ConfigureInterface;
use \Anax\Configure\ConfigureTrait;
use \Anax\DI\InjectionAwareInterface;
use \Anax\DI\InjectionAwareTrait;
use \Anax\Question\Question;
use \Anax\Question\Tags;
use \Anax\User\User;
use \Anax\Comment\Comment;
// use \Kifekenny\Comment\HTMLForm\Com2Create;
// use \Kifekenny\Comment\HTMLForm\Com2Update;
// use \Kifekenny\Comment\HTMLForm\Com2Delete;
// use \Kifekenny\Comment\HTMLForm\Com2Session;

/**
 * A controller class.
 */
class Question2Controller implements
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

    public function getClasses()
    {
        $this->session    = $this->di->get("session");
        $this->view       = $this->di->get("view");
        $this->pageRender = $this->di->get("pageRender");
    }

    public function getdatabases()
    {
        $this->question    = new Question();
        $this->tags        = new Tags();
        $this->user        = new User();

        $this->question->setDb($this->di->get("db"));
        $this->tags->setDb($this->di->get("db"));
        $this->user->setDb($this->di->get("db"));
    }

    //get quesion based by id and all its user and tag obj
    public function getquestion($id)
    {
        $question    = new Question();
        $user        = new User();
        // $tags        = new Tags();

        $question->setDb($this->di->get("db"));
        $question = $question->findById($id);

        if (!$question) { return false; }

        $tagsArr = array_map('intval', str_split($question->tagsId));
        $allTags = [];
        for ($i=0; $i < count($tagsArr); $i++) {
            $tempTags = new Tags();
            $tempTags->setDb($this->di->get("db"));
            $temp = $tempTags->findById($tagsArr[$i]);
            array_push($allTags, $temp);
        }

        $user->setDb($this->di->get("db"));
        $user = $user->findById($question->userId);

        return [$question, $allTags, $user];
    }
    /**
     * Show all questions.
     *
     * @return void
     */
    public function getIndex()
    {
        $this->getClasses();
        $this->getdatabases();

        $data = [
            "items" => $this->question->findAll(),
            "tags"  => $this->tags->findAll(),
            "user"  => $this->user->findAll(),
        ];

        $data2 = [
            "tags"  => $this->tags->findAll(),
        ];

        $this->view->add("incl/header", ["title" => ["Book", "css/style.css", '../htdocs/img/pumpkin.jpg']]);
        $this->view->add("question/side-bar1", $data2);
        $this->view->add("question/viewAll", $data);
        $this->view->add("incl/side-bar2");
        $this->view->add("incl/footer");

        $this->pageRender->renderPage(["title" => "View | Questions"]);
    }

    /**
     * Show all comments on questions.
     *
     * @return void
     */
    public function getQuesComments($id = null) {

        $this->getClasses();
        $quesValues = $this->getquestion($id);

        if (!$quesValues) { return; }

        $user = new User();
        $user->setDb($this->di->get("db"));

        $comment = new Comment();
        $comment->setDb($this->di->get("db"));
        $comment = $comment->findAllWhere("quesId = ?" , $quesValues[0]->id);

        $data = [
            "question"  => $quesValues[0],
            "tags"      => $quesValues[1],
            "user"      => $user->findAll(),
            "mainUser"  => $quesValues[2],
            "comments"  => $comment,
        ];

        $this->view->add("incl/header", ["title" => ["Book", "../../css/style.css", '../../../htdocs/img/pumpkin.jpg']]);
        $this->view->add("incl/side-bar1");
        $this->view->add("question/viewQues", $data);
        $this->view->add("incl/side-bar2");
        $this->view->add("incl/footer");

        $this->pageRender->renderPage(["title" => "View | Questions"]);

    }

    public function getComComments($id = null) {
        $this->getClasses();

        $comment = new Comment();
        $comment->setDb($this->di->get("db"));
        $mainComment = $comment->findById($id);

        if (!$comment) { return; }

        $mainUser = new User();
        $mainUser->setDb($this->di->get("db"));


        // ---- Question values
        $question = new Question();
        $question->setDb($this->di->get("db"));
        $mainQuestion = $question->findById($mainComment->quesId);

        $user = new User();
        $user->setDb($this->di->get("db"));
        $mainQuestion->user = $user->findById($mainQuestion->userId);

        $tags = new Tags();
        $tags->setDb($this->di->get("db"));
        $mainQuestion->tags = $tags->getNameById($mainQuestion->tagsId);
        // --

        // if this comment is an answer to another comment
        $mainComment->comCom = false;
        if ($mainComment->comId != 0) {
            $comment = new Comment();
            $comment->setDb($this->di->get("db"));
            $mainComment->comCom = $comment->findById($mainComment->comId);

            $temp = new User();
            $temp->setDb($this->di->get("db"));
            $mainComment->comCom->user = $temp->findById($mainComment->comCom->userId);
        }

        $comment = new Comment();
        $comment->setDb($this->di->get("db"));
        $allcomment = $comment->findAllWhere("comId = ?" , $mainComment->id);
        foreach ($allcomment as $com) {
            $user = new User();
            $user->setDb($this->di->get("db"));
            $com->user = $user->findById($com->userId);
        }

        $data = [
            "comment"         => $mainComment,
            "mainUser"        => $mainUser->findById($mainComment->userId),
            "question"        => $mainQuestion,
            "allComments"     => $allcomment,
        ];


        $why = ["Book", "../../../css/style.css", '../../../../htdocs/img/pumpkin.jpg'];
        $this->view->add("incl/header", ["title" => $why]);
        $this->view->add("incl/side-bar1");
        $this->view->add("question/viewcomment", $data);
        $this->view->add("incl/side-bar2");
        $this->view->add("incl/footer");

        $this->pageRender->renderPage(["title" => "View | Comment"]);
    }

    //get home all populare questions/tags, most posted users
    public function getHome()
    {
        $this->getClasses();

        $question = new Question();
        $question->setDb($this->di->get("db"));
        $question = $question->findAll();

        $tags = new Tags();
        $tags->setDb($this->di->get("db"));
        $allTags = $tags->findAll();

        $tagArr = [];
        foreach ($allTags as $key) {
            $tagArr[$key->name] = 0;
        }

        foreach ($question as $que) {
            $user = new User();
            $user->setDb($this->di->get("db"));
            $que->user = $user->findById($que->userId);

            $tags = new Tags();
            $tags->setDb($this->di->get("db"));
            $que->tags = $tags->getNameById($que->tagsId);

            foreach ($que->tags as $key) {
                foreach ($tagArr as $key2 => $value) {
                    if ($key == $key2) {
                        $tagArr[$key2] = $value + 1;

                    }
                }
            }
        }

        arsort($tagArr);

        foreach ($tagArr as $key => $value) {
            $tags = new Tags();
            $tags->setDb($this->di->get("db"));
            $tags = $tags->getIdByName($key);

            $tagArr[$key] = [$value, $tags];
        }

        $nque = array_slice($question, -5);
        $nque = array_reverse($nque);

         $user = new User();
         $user->setDb($this->di->get("db"));
         $user = $user->findAll();

         $temp = [];
         foreach ($user as $use) {
             $question = new Question();
             $question->setDb($this->di->get("db"));
             $amount = $question->findAllWhere("userId = ?", $use->id);
             $temp[$use->id] = count($amount);

         }

         arsort($temp);

         $allUsers = [];
         $counter = 0;
         foreach ($temp as $userId => $value) {
             $counter += 1;
             $user = new User();
             $user->setDb($this->di->get("db"));
             $user = $user->findById($userId);
             $user->questions = $value;

             array_push($allUsers, $user);

             if ($counter == 4) { break; }
         }

        $data = [
            "questions" => $nque,
            "users"     => $allUsers,
            "tags"      => $tagArr,
        ];

        $why = ["Book", "css/style.css", '../htdocs/img/pumpkin.jpg'];
        $this->view->add("incl/header", ["title" => $why]);
        $this->view->add("incl/side-bar1");
        $this->view->add("default/home", $data);
        $this->view->add("incl/side-bar2");
        $this->view->add("incl/footer");

        $this->pageRender->renderPage(["title" => "Home"]);
    }

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
