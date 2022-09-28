<?php

namespace Controller;

use App\Session;
use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\TopicManager;
use Model\Managers\PostManager;

class ForumController extends AbstractController implements ControllerInterface
{

    public function index()
    {
        $topicManager = new TopicManager();
        // $topics = $topicManager->findAll(['dateTopic', 'DESC']);
        $topics = $topicManager->findAllTopics(['dateTopic', 'DESC']);

        return [
            "view" => VIEW_DIR . "forum/listTopics.php",
            "data" => [
                "topics" => $topics
            ]
        ];
    }

    public function listPosts($id)
    {

        $postManager = new PostManager();
        $topicManager = new TopicManager();

        return [
            "view" => VIEW_DIR . "forum/listPosts.php",
            "data" => [
                "topic" => $topicManager->findOneById($id),
                "posts" => $postManager->findPostsByTopic($id)
            ]
        ];
    }

    public function addTopic()
    {
        $topicManager = new TopicManager();

        if ($_SESSION['user']) {


            $user = $_SESSION['user']->getId();

            if (isset($_POST['submit'])) {

                $title = filter_input(INPUT_POST, "titleTopic", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $text = filter_input(INPUT_POST, 'textTopic', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                // if (Session::getTokenCSRF() !== $_POST['csrfToken']) {
                //     $this->redirectTo("security", "logOut");
                // }
                if ($title && $text) {
                    //  je récuprere l'id de l'ajout pour le reutiliser 
                    $idTopic = $topicManager->add(["user_id" => $user, "title" => $title, "locked" => 0]);

                    if ($text) {
                        $postManager = new PostManager();
                        $postManager->add(["topic_id" => $idTopic, "user_id" => $user, "text" => $text]);

                        //var_dump($postManager->add(["topic_id" => $idTopic, "user_id" => $user, "text" => $text]));die;
                        $this->redirectTo("forum", "listPosts", $idTopic);
                    } else {
                        Session::addFlash("error", "Blank input !");
                    }
                    Session::addFlash("success", "Topic added successfully !");
                }
            } else {
                $this->redirectTo("forum", "index");
                Session::addFlash("error", "Blank input !");
            }
        }
    }

    public function addPost($id)
    {
        $postManager = new PostManager();

        if ($_SESSION['user']) {

            $user = $_SESSION['user']->getId();

            if (isset($_POST['submit'])) {

                if (isset($_POST["textPost"]) && (!empty($_POST["textPost"]))) {
                    $text = filter_input(INPUT_POST, "textPost", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    // if (Session::getTokenCSRF() !== $_POST['csrfToken']) {
                    //     $this->redirectTo("security", "logOut");
                    // }
                    $postManager->add(["topic_id" => $id, "user_id" => $user, "text" => $text]);
                    Session::addFlash("success", "Post added successfully !");
                    $this->redirectTo("forum", "listPosts", $id);
                } else {
                    Session::addFlash("error", "Blank input !");
                    $this->redirectTo("forum", "listPosts", $id);
                }
            } else {
                Session::addFlash("error", "Blank input !");
                $this->redirectTo("forum", "listPosts", $id);
            }
        }
    }
}
