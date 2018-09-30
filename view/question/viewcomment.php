<?php

namespace Anax\View;

$comments     = isset($comment) ? $comment : null;
$mainUser     = isset($mainUser) ? $mainUser : null;
$question     = isset($question) ? $question : null;
$allComments  = isset($allComments) ? $allComments : null;

$qUrl = $app->url->create("question/comments/" . $question->id);
?>

<div class="block">

<div class="question" style="border-color:yellow;height:150px;width:50%;">
    <div class="titleQuestion" style="border-bottom-color:yellow;height:110px;">
        <div class="userDiv left">
            <img class="quesImg" src="<?=$app->get_gravatar($question->user->mail, 80)?>">
            <p class="userName"><?=$question->user->username?></p>

        </div>
        <h3 class="title">
            <a href="<?=$app->url->create("question/comments/" . $question->user->id)?>">
                <?=$question->title?>
            </a>
        </h3>
        <p class="published" style="padding-top: 20px;">
            <em>Published: <?=$question->created?></em>
        </p>
    </div>

    <p class="content"><?=$question->content?></p>
</div>
<p><strong>Main question ↗ </strong></p>

<?php if ($comments->comCom): ?>
    <div class="question" style="border-color:green;height:150px;width:50%;">
        <div class="titleQuestion" style="border-bottom-color: green;height:110px;">
            <div class="userDiv left">
                <img class="quesImg" src="<?=$app->get_gravatar($comments->comCom->user->mail, 80)?>">
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

        <p class="content"><?=$comments->comCom->content?></p>
    </div>
    <p><strong>Comment for ↗ </strong></p>
<?php endif; ?>

<div class="quesFull">
    <div class="titleQuestion">
        <div class="userDiv left">
            <img class="quesImg" src="<?=$app->get_gravatar($mainUser->mail, 80)?>">
            <p class="userName"><?=$mainUser->username?></p>
        </div>
        <div class="fix">
        </div>
        <p class="published"><em>Published: <?=$comment->created?></em></p>
    </div>
    <p class="content"><?=$comment->content?></p>
</div>

</div>

<h3 class="white"> Answers &#8595;</h3>


<?php foreach ($allComments as $com): ?>
    <div class="quesFull">
        <div class="titleQuestion">
            <div class="userDiv left">
                <img class="quesImg" src="<?=$app->get_gravatar($com->user->mail, 80)?>">
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

        <p class="content"><?=$com->content?></p>
    </div>
<?php endforeach; ?>
