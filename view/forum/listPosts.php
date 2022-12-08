<?php

$posts = (!$result["data"]['posts']) ? [] : $result["data"]['posts'];
$topic = $result["data"]['topic'];

?>

<h1><a href="index.php?ctrl=forum&action=listTopicsByCategory&id=<?= $topic->getCategory()->getId() ?>"><?= $topic->getCategory() ?></a></h1>
<h2><?= $topic ?> <?= ($topic->getLocked()) ? "<span class='label label-warning'>Locked</span>" : "" ?></h2>

<p><?= ($topic->getUser()->getId() == App\Session::getUser()->getId())
    ?   ((!$topic->getLocked()) ? "<a href='index.php?ctrl=forum&action=lockTopic&id=" . $topic->getId() . "' class='btn btn-warning'>Lock</a>" : "<a href='index.php?ctrl=forum&action=unlockTopic&id=" . $topic->getId() . "' class='btn btn-success'>Unlock</a>")
    :   ""
?>
</p>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Post</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>

        <?php
        foreach ($posts as $post) : ?>
            <tr>
                <td class="small-col">By <a href=""><?= $post->getUser() ?></a><br><span class="small-text"><?= $post->getDatePost()->format("d-m-Y H:i") ?></span></td>
                <td><?= $post ?></td>
                <td class="small-col txt-center">
                    <?= ($post->getUser()->getId() == App\Session::getUser()->getId())
                        ?   "<a href='#'><i class='fa-regular fa-pen-to-square'></i></a>
                            <a href='#'><i class='fa-regular fa-trash-can'></i></a>"
                        : ""
                    ?>
                </td>
            </tr>
        <?php endforeach ?>

    </tbody>
</table>

<h2>Create a new post</h2>

<?php if ($topic->getLocked()) : ?>
    <p class="txt-warning">Locked topic !</p>
<?php else : ?>
    <form action="index.php?ctrl=forum&action=addPost&id=<?= $topic->getId() ?>" method="POST">
        <textarea class="form-control" name="textPost" id="textPost" cols="30" rows="10" placeholder="Message" required></textarea><br>
        <input class="btn" type="submit" name="submit" value="Post">
    </form>
<?php endif; ?>