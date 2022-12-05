<?php

namespace Controller;

use App\Session;
use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\UserManager;

class HomeController extends AbstractController implements ControllerInterface
{

    public function index()
    {
        return [
            "view" => VIEW_DIR . "home.php"
        ];
    }

    /** 
     * Register in the forum
     */
    public function register()
    {
        if (isset($_POST['submitSignUp'])) {
            $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL, FILTER_VALIDATE_EMAIL);
            $nickname = filter_input(INPUT_POST, "nickname", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            // array(
            //     "options" => array("regexp"=>
            //     "/\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[0-9])(?=\S*[A-Z])(?=\S*[\d])\S*/")));
            $confirmPassword = filter_input(INPUT_POST, "confirmPassword", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // si les filtres passent
            if ($email && $nickname && $password) {
                $userManager = new UserManager();

                // si le mail n'existe pas
                if (!$userManager->findOneByEmail($email)) {
                    // si le pseudo n'existe pas
                    if (!$userManager->findOneByUser($nickname)) {
                        // si les 2 mots de passe concordent et que le mot de passe a une longueur minimale de 8 caractères
                        if (($password == $confirmPassword) and strlen($password) >= 8) {
                            // hashage du mot de passe
                            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                            // ajout en base de données
                            // $userManager->add(["email" => $email, "nickname" => $nickname, "password" => $passwordHash, "role" => json_encode(["ROLE_USER"])]);
                            $userManager->add(["email" => $email, "nickname" => $nickname, "password" => $passwordHash, "role" => "ROLE_USER"]);
                            $this->redirectTo("security", "login");
                        } else {
                            Session::addFlash("error", "Passwords do not match or password length is incorrect");
                        }
                    } else {
                        Session::addFlash("error", "This nickname is already taken");
                    }
                } else {
                    Session::addFlash("error", "This email already exists");
                }
            }

            $this->redirectTo("security", "index");
        }

        return ["view" => VIEW_DIR . "/security/register.php"];
    }

    /**
     * Login in the forum
     */
    public function login()
    {
        $userManager = new UserManager();

        if (isset($_POST['submitLogin'])) {
            $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL, FILTER_VALIDATE_EMAIL);
            $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            // if (Session::getTokenCSRF() !== $_POST['csrfToken']) {
            //     $this->logout();
            // }

            // si les filtres passent
            if ($email && $password) {
                // retrouver le mot de passe de l'utlisateur correspondant au mail
                $dbPass = $userManager->retrievePassword($email);
                // si le mot de passe est retrouvé
                if ($dbPass) {
                    // récupération du mot de passe
                    $hash = $dbPass->getPassword();
                    // retrouver l'utilisateur par son email
                    $user = $userManager->findOneByEmail($email);
                    // comparaison du hash de la base de données et le mot de passe renseigné
                    if (password_verify($password, $hash)) {
                        // si l'utilisateur n'est pas banni
                        if ($user->getStatus()) {
                            // placer l'utilisateur en Session
                            Session::setUser($user);
                            //initialisation d'un token pour toute la session user
                            Session::setTokenCSRF(bin2hex(random_bytes(32)));
                            // message de confirmation de connexion
                            Session::addFlash("success", "Login successfully");
                            return [
                                "view" => VIEW_DIR . "home.php",
                                "data" => [
                                    "user" => $user,
                                ]
                            ];
                        } else {
                            Session::addFlash('error', "You're banned !");
                            $this->redirectTo("security", "index");
                        }
                    } else {
                        Session::addFlash('error', "Invalid credentials");
                        $this->redirectTo("security", "index");
                    }
                } else {
                    Session::addFlash('error', "Invalid credentials");
                    $this->redirectTo("security", "login");
                }
            }
        }

        return ["view" => VIEW_DIR . "/security/login.php"];
    }

    /**
     * Logout from the forum
     */
    public function logout()
    {
        unset($_SESSION['tokenCSRF']);
        $_SESSION[] = session_unset();
        Session::addFlash("success", "Logout !");
        $this->redirectTo("security", "index");
    }
}