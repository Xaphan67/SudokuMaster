// Constantes
const HTML = document.documentElement;
const SWITCHES_MODE_SOMBRE = document.getElementsByClassName("mode_sombre");
const SWITCHES_MODE_DYSLEXIQUE = document.getElementsByClassName("mode_dyslexique");
const LOGOS = document.getElementsByClassName("logo");

// Mode sombre

// Une fois le contenu du DOM chargé...
document.addEventListener("DOMContentLoaded", () => {

    // Stocke le chemin du logo et celui du logo en version sombre
    const LOGOS_SRC =  LOGOS[0].src ;
    const LOGOS_SOMBRE_SRC = LOGOS_SRC.substring(0, LOGOS_SRC.length - 4) + "-Sombre.png";


    // Applique le thème enregistré par l'utilisateur dans le local storage, ou sa préférence système
    const THEME_LOCAL_STORAGE = localStorage.getItem("theme");
    const THEME_SYSTEME = window.matchMedia("(prefers-color-scheme: dark)").matches;
    if (THEME_LOCAL_STORAGE == "sombre" || THEME_LOCAL_STORAGE == null && THEME_SYSTEME) {
         setThemeSombre(LOGOS_SOMBRE_SRC);
    }

    // Pour les deux switches du mode sombre (normal + mobile)
    for (let element of SWITCHES_MODE_SOMBRE) {

        // Quand on clique sur le switch, ajoute ou retire la classe "sombre"
        element.addEventListener("change", (e) => {
            if (!HTML.classList.contains("sombre")) {
                setThemeSombre(LOGOS_SOMBRE_SRC);
                localStorage.setItem("theme", "sombre");
            }
             else {
                setThemeClair(LOGOS_SRC);
                localStorage.setItem("theme", "clair");
            }

            // Retire l'attribut "class" si aucune classe restante
            if (HTML.classList.length == 0) {
                HTML.removeAttribute("class");
            }
        });
    }

    // Applique la police dyslexique enregistrée par l'utilisateur dans le local storage
    const DYSLEXIQUE_LOCAL_STORAGE = localStorage.getItem("dyslexique");
    if (DYSLEXIQUE_LOCAL_STORAGE == "dyslexique") {
         setPoliceDyslexique();
    }

    // Pour les deux switches du mode dyslexique (normal + mobile)
    for (let element of SWITCHES_MODE_DYSLEXIQUE) {

        // Quand on clique sur le switch, ajoute ou retire la classe "dyslexique"
        element.addEventListener("change", (e) => {
            if (!HTML.classList.contains("dyslexique")) {
                setPoliceDyslexique();
                localStorage.setItem("dyslexique", "dyslexique");
            }
             else {
                setPoliceNormal();
                localStorage.setItem("dyslexique", "normal");
            }

            // Retire l'attribut "class" si aucune classe restante
            if (HTML.classList.length == 0) {
                HTML.removeAttribute("class");
            }
        });
    }
});


function setThemeSombre(logoSrc) {

    // Ajoute la classe sombre et check les autres switches pour les metre à jour
    HTML.classList.add("sombre");
    for (let element of SWITCHES_MODE_SOMBRE) {
        if (!element.checked) {
            element.checked = true;
        }
    }

    // Change les logos
    for (let logo of LOGOS) {
        logo.src  = logoSrc;
    }
}

function setThemeClair(logoSrc) {

    // Retire la classe sombre et check les autres switches pour les metre à jour
    HTML.classList.remove("sombre");
    for (let element of SWITCHES_MODE_SOMBRE) {
        if (element.checked) {
            element.checked = false;
        }
    }

    // Change les logos
    for (let logo of LOGOS) {
        logo.src  = logoSrc;
    }
}

function setPoliceDyslexique() {

    // Ajoute la classe dyslexique et check les autres switches pour les metre à jour
    HTML.classList.add("dyslexique");
    for (let element of SWITCHES_MODE_DYSLEXIQUE) {
        if (!element.checked) {
            element.checked = true;
        }
    }
}

function setPoliceNormal() {

    // Retire la classe dyslexique et check les autres switches pour les metre à jour
    HTML.classList.remove("dyslexique");
    for (let element of SWITCHES_MODE_DYSLEXIQUE) {
        if (element.checked) {
            element.checked = false;
        }
    }
}