<?php

use PHPUnit\Framework\Attributes\AllowMockObjectsWithoutExpectations;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Xaphan67\SudokuMaster\Controllers\UtilisateurController;
use Xaphan67\SudokuMaster\Models\BannissementModel;
use Xaphan67\SudokuMaster\Models\ClasserModel;
use Xaphan67\SudokuMaster\Models\ParticiperModel;
use Xaphan67\SudokuMaster\Models\UtilisateurModel;
use Xaphan67\SudokuMaster\Services\ResponseService;
use Xaphan67\SudokuMaster\Services\TokenCSRFService;
use Xaphan67\SudokuMaster\Services\Validation\UtilisateurValidator;

class SignUpTest extends TestCase {

    private MockObject $validationMock;
    private MockObject $tokenCSRFServiceMock;
    private MockObject $responseServiceMock;
    private MockObject $utilisateurModelMock;
    private MockObject $classerModelMock;
    private MockObject $participerModelMock;
    private MockObject $bannissementModelMock;

    private UtilisateurController $controller;

    // Exécuté AVANT chaque test
    protected function setUp(): void
    {
        // Démarre une session propre pour chaque test
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION = [];
        $_POST = [];

        // Crée un mock pour chaque dépendance
        // createMock() génère une classe fantôme qui implémente
        // la même interface que l'originale, sans aucun comportement réel
        $this->validationMock = $this->createMock(UtilisateurValidator::class);
        $this->tokenCSRFServiceMock = $this->createMock(TokenCSRFService::class);
        $this->responseServiceMock = $this->createMock(ResponseService::class);
        $this->utilisateurModelMock = $this->createMock(UtilisateurModel::class);
        $this->classerModelMock = $this->createMock(ClasserModel::class);
        $this->participerModelMock = $this->createMock(ParticiperModel::class);
        $this->bannissementModelMock = $this->createMock(BannissementModel::class);

        // Injecte les mocks dans le controller via son constructeur
        $this->controller = new UtilisateurController(
            $this->validationMock,
            $this->tokenCSRFServiceMock,
            $this->responseServiceMock,
            $this->bannissementModelMock,
            $this->classerModelMock,
            $this->participerModelMock,
            $this->utilisateurModelMock
        );
    }

    // Exécuté APRES chaque test
    protected function tearDown(): void
    {
        $_SESSION = [];
        $_POST = [];
    }

    // Attribute #[AllowMockObjectsWithoutExpectations] utilisé car certains tests
    // n'attendent pas une action de tout les Mocks

    // Test : Utilisateur déja connecté -> Redirection vers son profil
    #[AllowMockObjectsWithoutExpectations]
    public function testRedirectIfUserConnected(): void 
{
        // Simule un utilisateur en session
        $_SESSION["utilisateur"] = ["id_utilisateur" => 1, "pseudo_utilisateur" => "Alice"];

        // Vérifie que l'utilisateur est redirigé vers la page profil
        $this->responseServiceMock
        ->expects($this->once())
        ->method('redirect')
        ->with("profil"); 

        // Vérifie qu'aucun modèle n'est appelé
        $this->utilisateurModelMock
            ->expects($this->never())
            ->method('add');

        // Appel de la méthode pour lancer le test
        $this->controller->signUp();
    }

    // Test : Formulaire soumis avec un token CSRF invalide -> Doit afficher une erreur
    #[AllowMockObjectsWithoutExpectations]
    public function testSubmitFormWithInvalidToken() : void {

        // Simule un token généré en session
        $_SESSION["tokenCSRF"]["token"] = "token_valide";

        // Simule l'envoi du formulaire
        $_POST = [
            "tokenCSRF" => "token_invalide",
            "pseudo" => "Alice",
            "email" => "alice@example.com",
            "mdp" => "MotDePasse1!",
            "mdp_confirm" => "MotDePasse1!",
            "conditions" => "on"
        ];

        // Vérifie que le check du token retourne false
        $this->tokenCSRFServiceMock
            ->expects($this->once())
            ->method('checkCSRFToken')
            ->with($_POST["tokenCSRF"])
            ->willReturn(false);

        // Vérifie qu'aucun modèle n'est appelé
        $this->utilisateurModelMock
            ->expects($this->never())
            ->method('add');

        // Appel de la méthode pour lancer le test
        $this->controller->signUp();
    }

    // Test : Formulaire soumis avec un token CSRF valide, mais des données invalides -> Doit afficher une erreur
    #[AllowMockObjectsWithoutExpectations]
    public function testSubmitFormWithInvalidData() : void {

        // Simule un token généré en session
        $_SESSION["tokenCSRF"]["token"] = "token_valide";

        // Simule l'envoi du formulaire
        $_POST = [
            "tokenCSRF" => "token_valide",
            "pseudo" => "",
            "email" => "pas_un_mail",
            "mdp" => "1234",
            "mdp_confirm" => "5678"
        ];

        // Vérifie que le check du token retourne true
        $this->tokenCSRFServiceMock
            ->expects($this->once())
            ->method('checkCSRFToken')
            ->with($_POST["tokenCSRF"])
            ->willReturn(true);

        // Vérifie que les validateurs renvoient un message d'erreur
        $this->validationMock
            ->method('validatePseudo')
            ->willReturn("Ce champ est obligatire");

        $this->validationMock
            ->method('validateEmail')
            ->willReturn("Adresse mail invalide");

        $this->validationMock
            ->method('validateMotDePasse')
            ->willReturn("Le mot de passe doit contenir au moins 8 caractères, une majuscule, un nombre et un caractère spécial");

        $this->validationMock
            ->method('validateMotDePasseConfirm')
            ->willReturn("Les mots de passe ne sont pas identiques");

        $this->validationMock
            ->method('validateConditions')
            ->willReturn("Vous devez accepter les conditions d'utilisation");

        // Vérifie qu'aucun modèle n'est appelé
        $this->utilisateurModelMock
            ->expects($this->never())
            ->method('add');

        // Appel de la méthode pour lancer le test
        $this->controller->signUp();
    }

    // Test : Formulaire soumis avec un token CSRF valide, mais l'email ets déjà présent en base de donnée -> Doit afficher une erreur
    #[AllowMockObjectsWithoutExpectations]
    public function testSubmitFormWithExistingEmail() : void {

        // Simule un token généré en session
        $_SESSION["tokenCSRF"]["token"] = "token_valide";

        // Simule l'envoi du formulaire
        $_POST = [
            "tokenCSRF" => "token_valide",
            "pseudo" => "Alice",
            "email" => "deja@utilise.com",
            "mdp" => "MotDePasse1!",
            "mdp_confirm" => "MotDePasse1!",
            "conditions" => "on"
        ];

        // Vérifie que le check du token retourne true
        $this->tokenCSRFServiceMock
            ->expects($this->once())
            ->method('checkCSRFToken')
            ->with($_POST["tokenCSRF"])
            ->willReturn(true);

        // Vérifie que les validateurs ne renvoient pas de messages d'erreur
        $this->validationMock
            ->method('validatePseudo')
            ->willReturn(null);

        $this->validationMock
            ->method('validateEmail')
            ->willReturn(null);

        $this->validationMock
            ->method('validateMotDePasse')
            ->willReturn(null);

        $this->validationMock
            ->method('validateMotDePasseConfirm')
            ->willReturn(null);

        $this->validationMock
            ->method('validateConditions')
            ->willReturn(null);

        // Vérifie que le modèle retoune false lors de la tentative d'insertion
        $this->utilisateurModelMock
            ->expects($this->once())
            ->method('add')
            ->willReturn(false);

        // Vérifie que classerModel n'est jamais appelé
        $this->classerModelMock
            ->expects($this->never())
            ->method('add');
        
        // Appel de la méthode pour lancer le test
        $this->controller->signUp();
    }

    // Test : Formulaire soumis avec un token CSRF valide et des données valides -> Doit enregistrer l'utilisateur en base de données
    #[AllowMockObjectsWithoutExpectations]
    public function testSubmitFormWithValidData() : void {

        // Simule un token généré en session
        $_SESSION["tokenCSRF"]["token"] = "token_valide";

        // Simule l'envoi du formulaire
        $_POST = [
            "tokenCSRF" => "token_valide",
            "pseudo" => "Alice",
            "email" => "alice@example.com",
            "mdp" => "MotDePasse1!",
            "mdp_confirm" => "MotDePasse1!",
            "conditions" => "on",
        ];

        // Vérifie que le check du token retourne true
        $this->tokenCSRFServiceMock
            ->expects($this->once())
            ->method('checkCSRFToken')
            ->with($_POST["tokenCSRF"])
            ->willReturn(true);

        // Vérifie que les validateurs ne renvoient pas de messages d'erreur
        $this->validationMock
            ->method('validatePseudo')
            ->willReturn(null);

        $this->validationMock
            ->method('validateEmail')
            ->willReturn(null);

        $this->validationMock
            ->method('validateMotDePasse')
            ->willReturn(null);

        $this->validationMock
            ->method('validateMotDePasseConfirm')
            ->willReturn(null);

        $this->validationMock
            ->method('validateConditions')
            ->willReturn(null);

        // Vérifie que l'insertion en base de données retourne l'ID assignée à l'utilisateur
        $this->utilisateurModelMock
            ->method('add')
            ->willReturn(42);

        // Vérifie que 3 enregistrements sont ajoutés dans la table classer (un par niveau de difficulté)
        $this->classerModelMock
            ->expects($this->exactly(3))
            ->method('add');

        // Vérifie que l'utilisateur est redirigé vers la page de connexion
        $this->responseServiceMock
        ->expects($this->once())
        ->method('redirect')
        ->with("connexion"); 

        // Appel de la méthode pour lancer le test
        $this->controller->signUp();
    }
}