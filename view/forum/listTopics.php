<?php

$topics = (!$result["data"]['topics']) ? [] : $result["data"]['topics'];
$category = $result["data"]['category'];

?>

<h1>Topics of « <?= $category ?> »</h1>

<?php if (!$topics) { ?>
    <p class="txt-warning">No topics in this category !</p>
<?php } else { ?>

<table>
    <thead>
        <tr>
            <th>Status</th>
            <th>Topic</th>
            <th>Posts</th>
            <th>Actions</th>
            <th>Lock</th>
        </tr>
    </thead>
    <tbody>

    <?php
    foreach($topics as $topic) : ?>
        <tr>
            <td class="small-col txt-center"><?= ($topic->getLocked()) ? "<i class='fa-solid fa-lock red'></i>" : "<i class='fa-solid fa-lock-open green'></i>" ?></td>
            <td>
                <a href="index.php?ctrl=forum&action=listPosts&id=<?= $topic->getId() ?>"><?= $topic ?></a><br>
                <span class="small-text">By <a href=""><?= $topic->getUser() ?></a> &diams; <?= $topic->getDateTopic()->format("d-m-Y H:i") ?></span>
            </td>
            <td class="small-col txt-center"><i class="fa-regular fa-message"></i> <?= $topic->getNbPosts() ?></td>
            <td class="small-col txt-center">
                <?= ($topic->getUser()->getId() == App\Session::getUser()->getId()) 
                    ?   "<a href='#'><i class='fa-regular fa-pen-to-square'></i></a>
                        <a href='#'><i class='fa-regular fa-trash-can'></i></a>" 
                    :   "" ?>
            </td>
            <td class="small-col txt-center">
                <?= ($topic->getUser()->getId() == App\Session::getUser()->getId()) 
                    ?   ((!$topic->getLocked()) ? "<a href='index.php?ctrl=forum&action=lockTopic&id=".$topic->getId()."' class='btn btn-warning'>Lock</a>" : "<a href='index.php?ctrl=forum&action=unlockTopic&id=".$topic->getId()."' class='btn btn-success'>Unlock</a>")
                    :   ""
                ?>
            </td>
        </tr>
    <?php endforeach ?>

    </tbody>
</table>

<?php } ?>

<h2>Create a new topic</h2>
<form action="index.php?ctrl=forum&action=addTopic&id=<?= $category->getId() ?>" method="POST">
    <input class="form-control" type="text" name="titleTopic" id="titleTopic" placeholder="Title" required><br>
    <textarea class="form-control" name="textTopic" id="textTopic" cols="30" rows="10" placeholder="First message" required></textarea><br>
    <input class="btn" type="submit" name="submit" value="Create">
</form>



  
