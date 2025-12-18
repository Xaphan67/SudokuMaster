<?php
	if (session_status() === PHP_SESSION_NONE){
		session_start();
	}
?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, viewport-fit=cover"
    />
    <!-- ajout de viewport-fit=cover pour permettre les safeareas, permet au contenu de s'étendre dans la zone de sécurité-->
    <meta name="”theme-color”" content="#########insérer_hexa##########" />
    <!-- Indique le thème de couleur du site, qui apparait sur les navigateurs compatibles-->
    <title>
      #########insérer_titre##########
    </title>
    <meta
      name="description"
      content="#########insérer_description_max_160_caractères##########"
    />

    <!-- Pour afficher un aperçu personnalisé quand partage le lien du site sur les plateformes comme Messenger ou Whatsapp -->
    <meta
      property="og:title"
      content="#########insérer_titre##########"
    />
    <meta property="og:description" content="#########insérer_très_courte_description##########" />
    <meta
      property="og:image"
      content="#########insérer_image_format rectangle_de_préférence##########"
    />
    <meta
      property="og:url"
      content="#########insérer_url_page_accueil##########"
    />
    <meta property="og:type" content="website" />


    <link
      rel="icon"
      type="image/png"
      href="#########insérer_chemin_favicon##########"
    />
    
    <link href="#########insérer_chemin_fichier_style.css##########" rel="stylesheet" type="text/css" />
  </head>