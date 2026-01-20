<?php

namespace Xaphan67\SudokuMaster\Controllers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

abstract class Controller {

    protected array $_donnees = [];

    protected object $_mailer;
    private static ?PHPMailer $_mailerInstance = null;

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
    }

    // Appelle la vue demandée
    protected function display($vue) {

        // Pour chaque variable stockée dans le tableau $donnes,
        // déclare une variable avec la valeur correspondante
        foreach ($this->_donnees as $variable => $valeur){
            $$variable = $valeur;
        }

        // Appelle les partials et la vue
        require_once("view/_partials/head.php");
        require_once("view/_partials/header.php");
        include("view/" . $vue . ".php");
        require_once("view/_partials/footer.php");
    }

    // Affiche la page erreur 404 en cas de page non trouvée
    protected function _notFound() {

        // Indique à la vue les variables nécessaires
        $this->_donnees["titre"] = "La page semble ne pas exister";
        $this->_donnees["texte"] = "On a fait notre possible, mais impossible de retrouver cette page";
        $this->_donnees["image"] = "404";

        // Affiche la vue erreurs
        $this->display("main/erreurs");
        exit;
    }

    // Affiche la page erreur 403 en cas de page non autorisée
    protected function _forbidden() {

        // Indique à la vue les variables nécessaires
        $this->_donnees["titre"] = "Vous n'avez pas accès à cette page";
        $this->_donnees["texte"] = "Cette page est accessible uniquement aux utilisateurs connectés";
        $this->_donnees["image"] = "403";

        // Affiche la vue erreurs
        $this->display("main/erreurs");
        exit;
    }

    // Affiche une erreur 404
    public function erreur404() {

        // Appèle la fonction _notFound() du controller mère
        $this->_notFound();
    }
}