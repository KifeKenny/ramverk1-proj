<?php

namespace Anax\View;

$comments     = isset($comment) ? $comment : null;
$mainUser     = isset($mainUser) ? $mainUser : null;
$question     = isset($question) ? $question : null;
$allComments  = isset($allComments) ? $allComments : null;

$qUrl = $app->url->create("question/comments/" . $question->id);
?>

<div class="block">

<div class="question fix" style="border-color:yellow;height:150px;width:50%;">
    <div class="titleQuestion" style="border-bottom-color:yellow;height:110px;">
        <div class="userDiv left">
            <img class="quesImg" src="<?=$app->getGravatar($question->user->mail, 80)?>">
            <p class="userName"><?=$question->user->username?></p>

        </div>
        <h3 class="title">
            <a href="<?=$app->url->create("question/comments/" . $question->id)?>">
                <?=$question->title?>
            </a>
        </h3>
        <p class="published" style="padding-top: 20px;">
            <em>Published: <?=$question->created?></em>
        </p>
    </div>

    <p class="content">
        <?=$di->get("textfilter")->parse($question->content, ["markdown"])->text?>
    </p>
</div>
<p><strong>Main question ↗ </strong></p>

<?php if ($comments->comCom) : ?>
    <div class="question fix" style="border-color:green;height:150px;width:50%;">
        <div class="titleQuestion" style="border-bottom-color: green;height:110px;">
            <div class="userDiv left">
                <img class="quesImg" src="<?=$app->getGravatar($comments->comCom->user->mail, 80)?>">
                <p class="userName"><?=$comments->comCom->user->username?></p>
            </div>
            <p class="published" style="padding-top: 45px">
                <em>Published: <?=$comments->comCom->created?></em>
            </p>

            <p class="left">
                <a href="<?=$app->url->create('question/comment/answer/' . $comments->comCom->id)?>">
                    Answers: <?=$comments->comCom->answers?>
                </a>
            </p>
        </div>

        <p class="content">
            <?=$di->get("textfilter")->parse($comments->comCom->content, ["markdown"])->text?>
        </p>
    </div>
    <p><strong>Comment for ↗ </strong></p>
<?php endif; ?>

<div class="quesFull">
    <div class="titleQuestion">
        <div class="userDiv left">
            <img class="quesImg" src="<?=$app->getGravatar($mainUser->mail, 80)?>">
            <p class="userName"><?=$mainUser->username?></p>
        </div>
        <div class="fix">
        </div>
        <p class="published"><em>Published: <?=$comment->created?></em></p>

        <p class="right" style="padding-top:75px">
            <strong>
            <a href="<?=$app->url->create('create/' . $comment->id . "/1")?>">
                Comment >>>
            </a>
            </strong>
        </p>
    </div>
    <p class="content">
        <?=$di->get("textfilter")->parse($comment->content, ["markdown"])->text?>
    </p>
</div>

</div>

<h3 class="white"> Answers &#8595;</h3>


<?php foreach ($allComments as $com) : ?>
    <div class="quesFull fix">
        <div class="titleQuestion">
            <div class="userDiv left">
                <img class="quesImg" src="<?=$app->getGravatar($com->user->mail, 80)?>">
                <p class="userName"><?=$com->user->username?></p>
            </div>
            <p class="published" style="padding-top: 75px">
                <em>Published: <?=$com->created?></em>
            </p>

            <p class="right" style="padding-top: 75px">
                <a href="<?=$app->url->create('question/comment/answer/' . $com->id)?>">
                    Answers: <?=$com->answers?>
                </a>
            </p>
        </div>

        <p class="content"><?=$di->get("textfilter")->parse($com->content, ["markdown"])->text?></p>
    </div>
<?php endforeach; ?>
