<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.tiny.cloud/1/zg3mwraazn1b2ezih16je1tc6z7gwp5yd4pod06ae5uai8pa/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="<?= PUBLIC_DIR ?>/css/style.css">
    <title>FORUM</title>
</head>

<body>
    <div id="wrapper">
        <h3 class="message message-warning"><?= App\Session::getFlash("error") ?></h3>
        <h3 class="message message-success"><?= App\Session::getFlash("success") ?></h3>

        <div id="mainpage">
            <header>
                <div class="color-picker">
                    <div class="colors-container">
                        <p>Select your color</p>
                        <div class="colors">
                            <span class="circle circle-default" data-color="#047eaa"><i class="fa-solid fa-rotate-right"></i></span>
                            <span class="circle circle-red" data-color="rgb(231, 79, 79)"></span>
                            <span class="circle circle-blue" data-color="rgb(96, 96, 225)"></span>
                            <span class="circle circle-green" data-color="rgb(81, 148, 81)"></span>
                            <span class="circle circle-purple" data-color="rgb(130, 75, 130)"></span>
                            <span class="circle circle-dark" data-color="rgb(71, 71, 71)"></span>
                        </div>
                    </div>
                    <div class="settings"><i class="fa-solid fa-gear"></i></div>
                </div>
                <nav>
                    <div class="nav" id="nav-left">
                        <i class="fa-solid fa-ghost"></i>
                        <a href="index.php">Home</a>
                        <?php if (App\Session::getUser()) : ?>
                            <a href="index.php?ctrl=forum">Topics</a>
                        <?php endif; ?>
                    </div>
                    <div class="nav" id="nav-right">
                        <?php

                        if (App\Session::getUser()) {
                        ?>
                            <a href="index.php?ctrl=security&action=viewProfile"><span class="fas fa-user"></span>&nbsp;<?= App\Session::getUser() ?></a>
                            <span> | </span>
                            <a href="index.php?ctrl=security&action=logout">Logout</a>
                        <?php
                        } else {
                        ?>
                            <a href="index.php?ctrl=security&action=login">Login</a>
                            <a href="index.php?ctrl=security&action=register">Register</a>
                        <?php
                        }
                        ?>
                    </div>
                </nav>
            </header>

            <main id="forum">
                <?= $page ?>
            </main>
        </div>
        <footer>
            <p>&copy; <script>
                    document.write(new Date().getFullYear())
                </script> - Forum - <a href="">Forum rules</a> - <a href="">Legal notices</a></p>
            <!--<button id="ajaxbtn">Surprise en Ajax !</button> -> cliqué <span id="nbajax">0</span> fois-->
        </footer>
    </div>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous">
    </script>
    <script>
        $(document).ready(function() {
            $(".message").each(function() {
                if ($(this).text().length > 0) {
                    $(this).slideDown(500, function() {
                        $(this).delay(3000).slideUp(500)
                    })
                }
            })
            $(".delete-btn").on("click", function() {
                return confirm("Etes-vous sûr de vouloir supprimer?")
            })
            tinymce.init({
                selector: '.post',
                menubar: false,
                plugins: [
                    'advlist autolink lists link image charmap print preview anchor',
                    'searchreplace visualblocks code fullscreen',
                    'insertdatetime media table paste code help wordcount'
                ],
                toolbar: 'undo redo | formatselect | ' +
                    'bold italic backcolor | alignleft aligncenter ' +
                    'alignright alignjustify | bullist numlist outdent indent | ' +
                    'removeformat | help',
                content_css: '//www.tiny.cloud/css/codepen.min.css'
            });
        })

        /*
        $("#ajaxbtn").on("click", function(){
            $.get(
                "index.php?action=ajax",
                {
                    nb : $("#nbajax").text()
                },
                function(result){
                    $("#nbajax").html(result)
                }
            )
        })*/
    </script>
    <script src="<?= PUBLIC_DIR ?>/js/script.js"></script>
</body>

</html>