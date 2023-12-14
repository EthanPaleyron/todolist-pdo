// EVENEMENT POUR VOIR NOTRE CHAINE DE CARACTERE DU MOTS DE PASSE
const eye = document.querySelector(".eye i");
const password = document.querySelector("#password");
document.querySelector(".eye").addEventListener("click", (e) => {
  e.preventDefault();
  if (eye.className == "fa-solid fa-eye-slash") {
    eye.className = "fa-solid fa-eye";
    password.setAttribute("type", "text");
  } else {
    eye.className = "fa-solid fa-eye-slash";
    password.setAttribute("type", "password");
  }
});
