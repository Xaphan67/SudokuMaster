<?php

namespace Xaphan67\SudokuMaster\Controllers;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

abstract class Controller {

    protected array $_donnees = [];

    protected object $_mailer;
    private static ?PHPMailer $_mailerInstance = null;

    protected object $_twig;
    private $loader;

    public function __construct() {

        // Récupère ou crée la connexion (singleton)
         if (self::$_mailerInstance === null) {
            try{
                self::$_mailerInstance = new PHPMailer();
                self::$_mailerInstance->IsSMTP();
                self::$_mailerInstance->CharSet = PHPMailer::CHARSET_UTF8;
                self::$_mailerInstance->Mailer = "smtp";
                self::$_mailerInstance->SMTPDebug = 0;
                self::$_mailerInstance->SMTPAuth = true;
                self::$_mailerInstance->SMTPSecure = "tls";
                self::$_mailerInstance->Port = $_ENV["MAILER_PORT"];
                self::$_mailerInstance->Host = $_ENV["MAILER_HOST"];
                self::$_mailerInstance->Username = $_ENV["MAILER_USER"];
                self::$_mailerInstance->Password = $_ENV["MAILER_PASS"];
                self::$_mailerInstance->isHTML(true);
                self::$_mailerInstance->setFrom($_ENV['MAILER_FROM_ADDRESS'], $_ENV['MAILER_FROM_NAME']);
            } catch(Exception $e) {
                echo "Échec : " . $e->getMessage();
            }
        }

        // Assigne la connexion
        $this->_mailer = self::$_mailerInstance;

        // Définition du dossier contenant les templates twig
        $this->loader = new FilesystemLoader("templates");

        // Définition de l'environnement twig
        $this->_twig = new Environment($this->loader, [
            'cache' => 'templates_c',
        ]);
        $this->_twig->addGlobal('session', $_SESSION);
        $this->_twig->addGlobal('get', $_GET);
        $this->_twig->addGlobal('post', $_POST);
    }

    // Affiche la page erreur 404 en cas de page non trouvée
    protected function _notFound() {

        // Affiche le gabarit erreurs
        // et lui indique les variables nécessaires
        $this->_twig->display("main/erreurs.html.twig",[
            'titre' => "La page semble ne pas exister",
            'texte' => "On a fait notre possible, mais impossible de retrouver cette page",
            'image' => "404"
        ]);
        exit;
    }

    // Affiche la page erreur 403 en cas de page non autorisée
    protected function _forbidden() {

        // Affiche le gabarit erreurs
        // et lui indique les variables nécessaires
        $this->_twig->display("main/erreurs.html.twig",[
            'titre' => "Vous n'avez pas accès à cette page",
            'texte' => "Cette page est accessible uniquement aux utilisateurs connectés",
            'image' => "403"
        ]);
        exit;
    }

    // Affiche une erreur 404
    public function erreur404() {

        // Appèle la fonction _notFound() du controller mère
        $this->_notFound();
    }
}