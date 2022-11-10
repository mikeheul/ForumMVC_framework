<?php $categories = $result["data"]["categories"]; ?>

<h1>Categories</h1>

<table>
    <thead>
        <tr>
            <th>Category name</th>
        </tr>
    </thead>
    <tbody>

    <?php
    foreach($categories as $cat) { ?>
        <tr>
            <td><a href="index.php?ctrl=forum&action=listTopicsByCategory&id=<?= $cat->getId() ?>"><?= $cat ?></a></td>
        </tr>
    <?php } ?>
    </tbody>
</table>
