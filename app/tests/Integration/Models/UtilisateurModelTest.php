<?php

namespace Xaphan67\SudokuMaster\Tests\Integration\Models;

use PDO;
use Xaphan67\SudokuMaster\Entities\Utilisateur;
use Xaphan67\SudokuMaster\Models\Model;
use Xaphan67\SudokuMaster\Models\UtilisateurModel;
use Xaphan67\SudokuMaster\Tests\Integration\IntegrationTestCase;

class UtilisateurModelTest extends IntegrationTestCase {

    private UtilisateurModel $model;

    protected function setUp() : void {

        // Appelle la méthode setUp() de la classe parrente
        parent::setUp();

        // Injecte la connexion de test dans le singleton
        Model::setDbInstance($this->_db);

        // Instancie le modèle utilisateur
        $this->model = new UtilisateurModel;
    }

    protected function tearDown(): void {

        // Appelle la méthode tearDown() de la classe parrente
        parent::tearDown();

        // Reset l'instance de PDO entre chaque test
        Model::resetDbInstance();
    }

    // Crée un utilisateur réutilisable dans les tests
    private function createUser(
        string $pseudo = "Alice",
        string $email = "alice@example.com",
        string $mdp = "hash_mdp"
    ) : Utilisateur {
    
        $utilisateur = new Utilisateur;
        $utilisateur->hydrate(["pseudo" => $pseudo, "email" => $email, "mdp" => $mdp]);

        return $utilisateur;
    }

    // Tests : Méthode Add()

    // Test : Vérifie qu'un ID est retourné après une insertion d'un utilisateur en base de donnée
    public function testAddReturnID() : void {

        // Crée un utilisateur
        $utilisateur = $this->createUser();

        // Ajoute l'utilisateur en base de donnée et retourne son ID
        $id = $this->model->add($utilisateur);

        // Vérifie que l'id retournée est un nombre
        $this->assertIsInt($id);

        // Vérifie que l'id est supérieure à 0
        $this->assertGreaterThan(0, $id);
    }

    // Test : Vérifie qu'un utilisateur est correctement ajouté en base de donnée
    public function testAddInsereEnBase(): void
    {

        // Crée un utilisateur et récupèe son ID
        $utilisateur = $this->createUser();
        $id = $this->model->add($utilisateur);

        // Tente de récupérer l'utilisateur en BDD
        $query = "SELECT * FROM utilisateur WHERE id_utilisateur = :id_utilisateur";

        $prepare = $this->_db->prepare($query);
        $prepare->bindParam(":id_utilisateur", $id, PDO::PARAM_INT);
        $prepare->execute();

        $resultat = $prepare->fetch();

        // Vérifie que l'utilisateur à bien été récupéré
        $this->assertNotFalse($resultat);

        // Vérifie que l'utilisateur possède les bonnes données
        $this->assertEquals($utilisateur->getPseudo(), $resultat["pseudo_utilisateur"]);
        $this->assertEquals($utilisateur->getEmail(), $resultat["email_utilisateur"]);
    }

    // Test : Retourne false lors de l'insertion en base de donnée si l'email de l'utilisateur exite déjà
    public function testAddRetunFalseWithDuplicateEmail() {

        // Crée un utilisateur
        $utilisateur = $this->createUser();

        // Ajoute l'utilisateur en base de donnée
        $this->model->add($utilisateur);

        // Ajoute l'utilisateur une deuxième fois. L'email sera le même.
        $resultat = $this->model->add($utilisateur);
        
        // Vérifie que l'insertion retourne false
        $this->assertFalse($resultat);
    }

    // Tests : Méthode FindAll()

    // Test : Vérifie que tout les utilisateurs sont trouvés
    public function testFindAllReturnAllUser() : void {

        // Crée un utilisateur
        $utilisateur = $this->createUser();

        // Ajoute l'utilisateur en base de donnée
        $this->model->add($utilisateur);

        // Crée un deuxième utilisateur
        $utilisateur2 = $this->createUser(email: "alice2@example.com");

        // Ajoute le deuxième utilisateur en base de donnée
        $this->model->add($utilisateur2);

        // Récupére les utilisateurs en BDD
        $query = "SELECT * FROM utilisateur";

        $prepare = $this->_db->prepare($query);
        $prepare->execute();

        $donnesUtilisateurs = $prepare->fetchAll();

        // Vérifie que les deux utilisateurs ont bien étés récupérés ainssi que l'administrateur présent par défaut
        $this->assertCount(3, $donnesUtilisateurs);
    }

    // Tests : Méthode FindByMail()

    // Test : Vérifie qu'un utilisateur est bien trouvé
    public function testFindByMailReturnUser() : void {

        // Crée un utilisateur
        $utilisateur = $this->createUser();

        // Ajoute l'utilisateur en base de donnée
        $this->model->add($utilisateur);

        // Récupère l'utilisateur via son mail
        $resultat = $this->model->findByMail("alice@example.com");

        // Vérifie que l'utilisateur à bien été récupéré
        $this->assertNotFalse($resultat);

        // Vérifie que l'utilisateur est celui attendu
        $this->assertEquals($utilisateur->getPseudo(), $resultat["pseudo_utilisateur"]);
    }

    // Test : Retourne false si l'utilisateur n'existe pas
    public function testFindByMailUserNotExist() : void {

        // Récupère un utilisateur via son mail
        $resultat = $this->model->findByMail("inexistant@example.com");

        // Vérifie que false est retourné
        $this->assertFalse($resultat);
    }

    // Tests : Méthode Edit()

    // Test : Vérifie que le pseudo ou l'email d'un utilisateur peuvent être modifiés si le mot de passe est vide
    public function testEditPseudoOrMailOnly() : void {

        // Crée un utilisateur
        $utilisateur = $this->createUser();

        // Ajoute l'utilisateur en base de donnée et récupère son id
        $id = $this->model->add($utilisateur);

        // Crée un nouvel objet utilisateur
        $nouvelUtilisateur = new Utilisateur;

        // Hydrate le nouvel utilisateur et lui donne l'ID du premier utilisateur mais pas de mot de passe
        $nouvelUtilisateur->hydrate(["id" => $id, "pseudo" => "AliceModifiée", "email" => "alice_new@example.com", "mdp" => ""]);

        // Met à jour l'utilisateur en base de donnée
        $resultat = $this->model->edit($nouvelUtilisateur);

        // Vérifie que l'utilisateur à bien été modifié
        $this->assertTrue($resultat);

        // Récupére l'utilisateur en BDD
        $query = "SELECT * FROM utilisateur WHERE id_utilisateur = :id_utilisateur";

        $prepare = $this->_db->prepare($query);
        $prepare->bindParam(":id_utilisateur", $id, PDO::PARAM_INT);
        $prepare->execute();

        $donnesUtilisateur = $prepare->fetch();

        // Vérifie si les données de l'utilisateur on bien été modifiées
        $this->assertEquals($nouvelUtilisateur->getPseudo(), $donnesUtilisateur["pseudo_utilisateur"]);
        $this->assertEquals($nouvelUtilisateur->getEmail(), $donnesUtilisateur["email_utilisateur"]);
    }

    // Test : Vérifie que le mot de passe est modifié si renseigné
    public function testEditPassword() : void {
    
        // Crée un utilisateur
        $utilisateur = $this->createUser();

        // Ajoute l'utilisateur en base de donnée
        $id = $this->model->add($utilisateur);

        // Crée un nouvel objet utilisateur
        $nouvelUtilisateur = new Utilisateur;

        // Hydrate le nouvel utilisateur et lui donne l'ID du premier utilisateur
        $nouvelUtilisateur->hydrate(["id" => $id, "pseudo" => "AliceModifiée", "email" => "alice_new@example.com", "mdp" => "nouveau_hash"]);

        // Met à jour l'utilisateur en base de donnée
        $resultat = $this->model->edit($nouvelUtilisateur);
        
        // Vérifie que l'utilisateur à bien été modifié
        $this->assertTrue($resultat);

        // Récupére l'utilisateur en BDD
        $query = "SELECT * FROM utilisateur WHERE id_utilisateur = :id_utilisateur";

        $prepare = $this->_db->prepare($query);
        $prepare->bindParam(":id_utilisateur", $id, PDO::PARAM_INT);
        $prepare->execute();

        $donnesUtilisateur = $prepare->fetch();

        // Vérifie que le mot de passe à été modifié
        $this->assertEquals($nouvelUtilisateur->getMdp(), $donnesUtilisateur["mdp_utilisateur"]);
    }

    // Tests : Méthode Delete()

    // Test : Vérifie que l'utilisateur est correctement annonymisé
    public function testDeleteMakesUserAnonymous() {

        // Crée un utilisateur
        $utilisateur = $this->createUser();

        // Ajoute l'utilisateur en base de donnée et récupère son id
        $id = $this->model->add($utilisateur);

        // Crée un nouvel objet utilisateur
        $nouvelUtilisateur = new Utilisateur;

        // Hydrate le nouvel utilisateur avec l'ID du précédent
        $nouvelUtilisateur->setId($id);

        // Supprime l'utilisateur de la base de données
        $resultat = $this->model->delete($nouvelUtilisateur);

        // Vérifie que l'utilisateur à bien été annonymisé
        $this->assertTrue($resultat);

        // Récupére l'utilisateur en BDD
        $query = "SELECT * FROM utilisateur WHERE id_utilisateur = :id_utilisateur";

        $prepare = $this->_db->prepare($query);
        $prepare->bindParam(":id_utilisateur", $id, PDO::PARAM_INT);
        $prepare->execute();

        $donnesUtilisateur = $prepare->fetch();

        // Vérifie que les informations ont bien été annonylisées en base de donnée et que l'utilisateur est marqué comme inactif
        $this->assertEquals("Utilisateur supprimé", $donnesUtilisateur["pseudo_utilisateur"]);
        $this->assertEquals(1, $donnesUtilisateur["inactif"]);
    }
}