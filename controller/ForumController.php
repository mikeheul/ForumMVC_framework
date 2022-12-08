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
        
        // control if logged user
        if(\App\Session::getUser()) {
            $categoryManager = new CategoryManager();
            
            return [
                "view" => VIEW_DIR . "forum/listCategories.php",
                "data" => [
                    "categories" => $categoryManager->findAll(["categoryName","ASC"])
                ]
            ];
        } else {
            Session::addFlash("error", "You have to sign in or sign up to access categories !");
            $this->redirectTo("security", "login");
        }
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

        // si l'utilisateur est connecté
        if (\App\Session::getUser()) {
            // récupération de l'id user pour l'affecter au nouveau topic / nouveau message
            $user = \App\Session::getUser()->getId();

            // si on soumet le formulaire
            if (isset($_POST['submit'])) {

                // filtrer les inputs du formulaire
                $title = filter_input(INPUT_POST, "titleTopic", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $text = filter_input(INPUT_POST, 'textTopic', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                // if (Session::getTokenCSRF() !== $_POST['csrfToken']) {
                //     $this->redirectTo("security", "logOut");
                // }
                // si les filtres sont valides
                if ($title && $text) {
                    //  récupération de l'id du topic pour l'affecter au premier message (grâce à lastInsertId) et insertion en bdd
                    $idTopic = $topicManager->add(["user_id" => $user, "title" => $title, "locked" => 0, "category_id" => $id]);

                    // si le filtre du premier message du topic est valide
                    if ($text) {
                        // insertion du 1er message lié au topic précédemment crée
                        $postManager = new PostManager();
                        $postManager->add(["topic_id" => $idTopic, "user_id" => $user, "text" => $text]);
                        // redirection vers le topic crée
                        $this->redirectTo("forum", "listPosts", $idTopic);
                    } else {
                        // message d'erreur si le texte du 1er message est vide
                        Session::addFlash("error", "Blank input !");
                    }
                    // message de confirmation d'insertion en bdd
                    Session::addFlash("success", "Topic added successfully !");
                }
            } else {
                $this->redirectTo("forum", "index");
                Session::addFlash("error", "Blank input !");
            }
        } else {
            $this->redirectTo("forum", "index");
            Session::addFlash("error", "You must sign in to create a new topic !");
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

        // si l'utilisateur est connecté
        if (\App\Session::getUser()) {
            // récupération de l'id de l'utilisateur connecté (pour l'affecter au post crée)
            $user = $_SESSION['user']->getId();

            // si on soumet le formulaire
            if (isset($_POST['submit'])) {
                // on vérifie que les données existent et qu'elles sont valides
                if (isset($_POST["textPost"]) && (!empty($_POST["textPost"]))) {
                    $text = filter_input(INPUT_POST, "textPost", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    // if (Session::getTokenCSRF() !== $_POST['csrfToken']) {
                    //     $this->redirectTo("security", "logOut");
                    // }
                    // si le filtre passe
                    if($text) {
                        // ajout du post en bdd + message de confirmation
                        $postManager->add(["topic_id" => $id, "user_id" => $user, "text" => $text]);
                        Session::addFlash("success", "Post added successfully !");
                        $this->redirectTo("forum", "listPosts", $id);
                    }
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
