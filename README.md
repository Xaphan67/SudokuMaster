# Sudoku Master

Application de résolution de sudoku en ligne.

## Installation (avec docker):

Assurez-vous que docker est correctement installé, et que le plugin docker compose est présent également.

*Si docker n'est pas installé, voici la marche à suivre: (Exemple avec une machine ubuntu)*
```
# Installer les dépendances
sudo apt update
sudo apt install -y ca-certificates curl gnupg

# Ajouter la clé GPG Docker
sudo install -m 0755 -d /etc/apt/keyrings
curl -fsSL https://download.docker.com/linux/ubuntu/gpg | \
  sudo gpg --dearmor -o /etc/apt/keyrings/docker.gpg
sudo chmod a+r /etc/apt/keyrings/docker.gpg

# Ajouter le repository Docker
echo \
  "deb [arch=$(dpkg --print-architecture) signed-by=/etc/apt/keyrings/docker.gpg] \
  https://download.docker.com/linux/ubuntu \
  $(. /etc/os-release && echo "$VERSION_CODENAME") stable" | \
  sudo tee /etc/apt/sources.list.d/docker.list > /dev/null

# Installer Docker Engine
sudo apt update
sudo apt install -y docker-ce docker-ce-cli containerd.io docker-buildx-plugin docker-compose-plugin

# Vérifier l'installation
sudo docker run hello-world

# Ajouter l'utilisateur courant au groupe docker
sudo usermod -aG docker $USER

# Appliquer les changements (sans déconnexion)
newgrp docker
```

*Puis vérifiez avec:*
```
docker -v
docker compose version
```

Une fois docker installé, vous pouvez installer l'application proprement dite.

*Dans le dossier ou vous souhaitez installer l'application:*
```
git clone https://github.com/Xaphan67/SudokuMaster.git
cd SudokuMaster
```

*Recréer les .env (non versionnés):*
```
cp .env.example .env
nano .env                    # renseigner MYSQL_ROOT_PASSWORD, MYSQL_USER, MYSQL_PASSWORD

cd app
cp .env.example .env
nano .env                    # renseigner DB_USER, DB_PASS (identiques au .env racine), DB_HOST=mysql
cd ..
```

*Donner les droits sur le dossier templates_c pour que twig puisse y écrire son cache pour les templates:*
```
mkdir -p app/templates_c
chmod -R 777 app/templates_c
```

*Lancer le build:*
```
docker compose up -d --build
```

Par défaut, l'application est disponible sur http://localhost:8000, phpMyAdmin est disponible sur http://localhost:8081 et le serveur websocket écoute sur le port 8080.

## Connexion Admin:

*Identifiants de connexion par défaut du compte Admin:*
Email: admin@sudokumaster.com
Password: Admin@sudokumaster123

Pensez à changer ces identifiants une fois l'installation de l'application terminée