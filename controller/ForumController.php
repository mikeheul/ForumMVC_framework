<?php

namespace Controller;

use App\Session;
use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\TopicManager;
use Model\Managers\PostManager;
use Model\Managers\CategoryManager;

class ForumController extends AbstractController implements ControllerInterface
{

    public function index() {}

    // display all categories
    public function listCategories() {
        
        $categoryManager = new CategoryManager();
        
        return [
            "view" => VIEW_DIR . "forum/listCategories.php",
            "data" => [
                "categories" => $categoryManager->findAll(["categoryName","ASC"])
            ]
        ];
    }

    // display all topics by category
    public function listTopicsByCategory($id) {

        // control if logged user
        if(\App\Session::getUser()) {
            $topicManager = new TopicManager();
            $categoryManager = new CategoryManager();
            $category = $categoryManager->findOneById($id);
            $topics = $topicManager->findAllTopics(["dateTopic","DESC"], $id);
    
            return [
                "view" => VIEW_DIR . "forum/listTopics.php",
                "data" => [
                    "topics" => $topics,
                    "category" => $category
                ]
            ];
        } else {
            Session::addFlash("error", "You have to sign in or sign up to access topics !");
            $this->redirectTo("security", "login");
        }
    }

    // display all posts by topic
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

    // add a new topic (in category id)
    public function addTopic($id)
    {
        $topicManager = new TopicManager();

        if (\App\Session::getUser()) {

            $user = \App\Session::getUser()->getId();

            if (isset($_POST['submit'])) {

                $title = filter_input(INPUT_POST, "titleTopic", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $text = filter_input(INPUT_POST, 'textTopic', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                // if (Session::getTokenCSRF() !== $_POST['csrfToken']) {
                //     $this->redirectTo("security", "logOut");
                // }
                if ($title && $text) {
                    //  je récuprere l'id de l'ajout pour le reutiliser 
                    $idTopic = $topicManager->add(["user_id" => $user, "title" => $title, "locked" => 0, "category_id" => $id]);

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

    // lock topic (id)
    public function lockTopic($id) {

        $topicManager = new TopicManager();
        $topic = $topicManager->findOneById($id);

        if (\App\Session::getUser()) {
            $userId = $_SESSION['user']->getId();
            if($userId === $topic->getUser()->getId()) {
                $topicManager->lockTopic($id);
                $this->redirectTo("forum", "listTopicsByCategory", $topic->getCategory()->getId());
            } else {
                Session::addFlash("error", "Forbidden action !");
                $this->redirectTo("forum", "listPosts", $id);    
            }

        } else {
            Session::addFlash("error", "Forbidden action !");
            $this->redirectTo("forum", "");
        }
    }

    // unlock topic (id)
    public function unlockTopic($id) {

        $topicManager = new TopicManager();
        $topic = $topicManager->findOneById($id);

        if (\App\Session::getUser()) {
            $userId = $_SESSION['user']->getId();
            if($userId === $topic->getUser()->getId()) {
                $topicManager->unlockTopic($id);
                $this->redirectTo("forum", "listTopicsByCategory", $topic->getCategory()->getId());
            } else {
                Session::addFlash("error", "Forbidden action !");
                $this->redirectTo("forum", "listPosts", $id);    
            }

        } else {
            Session::addFlash("error", "Forbidden action !");
            $this->redirectTo("forum", "");
        }
    }

    // add a new post in the topic (id)
    public function addPost($id)
    {
        $postManager = new PostManager();

        if (\App\Session::getUser()) {

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
