<?php

namespace Xaphan67\SudokuMaster\Controllers;

use Smarty\Smarty;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

abstract class Controller {

    protected array $_donnees = [];

    protected object $_mailer;
    private static ?PHPMailer $_mailerInstance = null;
    private static ?Smarty $_smartyInstance = null;

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

    protected function getSmarty() : Smarty
    {
        // Récupère ou crée l'instance de Smarty (singleton)
        if(self::$_smartyInstance == null) {
            self::$_smartyInstance = new Smarty();

            // Définition du chemin des répertoires utilisés
            // par Smarty (gabarits, gabarits compilés et cache)
            self::$_smartyInstance->setTemplateDir('templates/');
            self::$_smartyInstance->setCompileDir('templates_c/');
            self::$_smartyInstance->setCacheDir('cache/');

            // Activation ou non du cache Smarty
           self::$_smartyInstance->setCaching($_ENV['SMARTY_CACHE'] ? Smarty::CACHING_LIFETIME_CURRENT : Smarty::CACHING_OFF);
        }

        return self::$_smartyInstance;
    }

    // Appelle la vue demandée
    // (Sera supprimé une fois toutes les vues refactorisées en gabarits Smarty)
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

    // Appelle le gabarit Smarty demandé
    protected function _display($gabarit) {

        // Pour chaque variable stockée dans le tableau $donnes,
        // déclare une variable avec la valeur correspondante via la fonction assign() de Smarty
        foreach ($this->_donnees as $variable => $valeur){
            $this->getSmarty()->assign($variable, $valeur);
        }

        // Affiche le gabarit
        $this->getSmarty()->display($gabarit . ".tpl");
    }

    // Affiche la page erreur 404 en cas de page non trouvée
    protected function _notFound() {

        // Indique à la vue les variables nécessaires
        $this->_donnees["titre"] = "La page semble ne pas exister";
        $this->_donnees["texte"] = "On a fait notre possible, mais impossible de retrouver cette page";
        $this->_donnees["image"] = "404";

        // Affiche le gabarit erreurs
        $this->_display("main/erreurs");
        exit;
    }

    // Affiche la page erreur 403 en cas de page non autorisée
    protected function _forbidden() {

        // Indique à la vue les variables nécessaires
        $this->_donnees["titre"] = "Vous n'avez pas accès à cette page";
        $this->_donnees["texte"] = "Cette page est accessible uniquement aux utilisateurs connectés";
        $this->_donnees["image"] = "403";

        // Affiche le gabarit erreurs
        $this->_display("main/erreurs");
        exit;
    }

    // Affiche une erreur 404
    public function erreur404() {

        // Appèle la fonction _notFound() du controller mère
        $this->_notFound();
    }
}