<?php

namespace Anax\View;

$question = isset($question) ? $question : null;
$tags  = isset($tags) ? $tags : null;
$user  = isset($user) ? $user : null;
$mainUser  = isset($mainUser) ? $mainUser : null;
$comments  = isset($comments) ? $comments : null;

?>

<h1>Question</h1>
<hr>

<div class="quesFull fix">
    <div class="titleQuestion">
        <div class="userDiv left">
            <img class="quesImg" src="<?=$app->getGravatar($mainUser->mail, 80)?>">
            <p class="userName"><?=$mainUser->username?></p>
        </div>

        <h3 class="title" style="color: white"><?=$question->title?></h3>
        <div class="fix">
        <?php
        for ($i=0; $i < count($tags); $i++) {
            echo '<p class="tagUnder"><strong>' . $tags[$i]->name . '</strong></p>';
        }
        ?>
        </div>
        <p><em>Published: <?=$question->created?></em></p>
        <p class="right">
            <a href="<?=$app->url->create('create/' . $question->id . '/2')?>">
                Comment >>>
            </a>
        </p>
    </div>
    <p class="content">
        <?=$di->get("textfilter")->parse($question->content, ["markdown"])->text?>
    </p>
</div>

<h3 class="white"> Answers &#8595;</h3>
<?php foreach ($comments as $comment) : ?>

    <?php
    if ($comment->comId != 0) {
        continue;
    }

    $tempUser;
    foreach ($user as $users) {
        if ($users->id == $comment->userId) {
            $tempUser = $users;
            continue;
        }
    }
        ?>
        <div class="quesFull">
            <div class="titleQuestion">
            <div class="userDiv left">
                <img class="quesImg" src="<?=$app->getGravatar($tempUser->mail, 80)?>">
                <p class="userName"><?=$tempUser->username?></p>
            </div>
            <p class="published" style="padding-top: 75px">
                <em>Published: <?=$comment->created?></em>
            </p>

            <p class="right" style="padding-top: 78px">
                <a href="<?=$app->url->create('question/comment/answer/' . $comment->id)?>">
                    Answers: <?=$comment->answers?>
                </a>
            </p>
        </div>

        <p class="content"><?=$di->get("textfilter")->parse($comment->content, ["markdown"])->text?></p>
    </div>
<?php endforeach; ?>
