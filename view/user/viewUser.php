<?php

namespace Anax\View;

$user  = isset($users) ? $users : null;

?>

<img style="margin-right: 5px" class="left" src="<?=$app->getGravatar($user->mail, 80)?>">
<h1><?=$user->username?></h1>
<br>
<hr>

<h3 class="white"> Posted questions &#8595;</h3>
<?php foreach ($user->questions as $que) : ?>
    <div class="question">
        <div class="titleQuestion">
            <div class="userDiv left">
                <img class="quesImg" src="<?=$app->getGravatar($user->mail, 80)?>">
                <p class="userName"><?=$user->username?></p>
            </div>

            <h3 class="title">
                <a href="<?=$app->url->create("question/comments/" . $que->id)?>">
                    <?=$que->title?>
                </a>

            </h3>
            <div class="fix">
            <?php
            for ($i=0; $i < count($que->tags); $i++) {
                echo '<p class="tagUnder"><strong>' . $que->tags[$i] . '</strong></p>';
            }
            ?>
            </div>
            <p><em>Published: <?=$que->created?></em></p>
        </div>
        <p class="content"><?=$que->content?></p>
    </div>
<?php endforeach; ?>

<h3 class="white"> Posted comments &#8595;</h3>

<?php foreach ($user->comments as $com) : ?>
    <div class="block">

    <?php if ($com->comQue) : ?>
        <div class="question" style="border-color:yellow;height:150px;width:50%;">
            <div class="titleQuestion" style="border-bottom-color:yellow;height:110px;">
                <div class="userDiv left">
                    <img class="quesImg" src="<?=$app->getGravatar($com->comQue->user->mail, 80)?>">
                    <p class="userName"><?=$com->comQue->user->username?></p>

                </div>
                <h3 class="title">
                    <a href="<?=$app->url->create("question/comments/" . $com->comQue->user->id)?>">
                        <?=$com->comQue->title?>
                    </a>
                </h3>
                <p class="published" style="padding-top: 20px;">
                    <em>Published: <?=$com->comQue->created?></em>
                </p>
            </div>

            <p class="content"><?=$com->comQue->content?></p>
        </div>
        <p><strong>Main question ↗ </strong></p>
    <?php endif; ?>

    <?php if ($com->comCom) : ?>
        <div class="question" style="border-color:green;height:150px;width:50%;">
            <div class="titleQuestion" style="border-bottom-color: green;height:110px;">
                <div class="userDiv left">
                    <img class="quesImg" src="<?=$app->getGravatar($com->comCom->user->mail, 80)?>">
                    <p class="userName"><?=$com->comCom->user->username?></p>
                </div>
                <p class="published" style="padding-top: 45px">
                    <em>Published: <?=$com->comCom->created?></em>
                </p>

                <p class="left">
                    <a href="<?=$app->url->create('question/comment/answer/' . $com->comCom->id)?>">
                        Answers: <?=$com->comCom->answers?>
                    </a>
                </p>
            </div>

            <p class="content"><?=$com->comCom->content?></p>
        </div>
        <p><strong>Comment for comment ↗ </strong></p>
    <?php endif; ?>

    <div class="question" style="border-width:5px;">
        <div class="titleQuestion">
            <div class="userDiv left">
                <img class="quesImg" src="<?=$app->getGravatar($user->mail, 80)?>">
                <p class="userName"><?=$user->username?></p>
            </div>
            <p class="published"><em>Published: <?=$que->created?></em></p>

            <p class="right" style="padding-top: 78px">
                <a href="<?=$app->url->create('question/comment/answer/' . $com->id)?>">
                    Answers: <?=$com->answers?>
                </a>
            </p>
        </div>

        <p class="content"><?=$com->content?></p>
    </div>

    </div>
<?php endforeach; ?>
