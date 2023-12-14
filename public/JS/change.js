// AFFICHAGE DU FORM UPDATE DU LI, SUR CHAQUE BOUTON MODIFIER
const todolist = document.querySelectorAll(".todoList li");
// J'AJOUTE DES ID A TOUT MES LI
todolist.forEach((todo, i) => {
  todo.setAttribute("id", "id" + i);
});

// JE BOUCLE SUR CHAQUE LI
let lastId = 0;
for (let i = 0; i < todolist.length; i++) {
  document
    .querySelector(`.todoList #id${i} .buttonsChange`)
    .addEventListener("click", () => {
      // POUR RESTAURER LA DERNIERE TODO CLIQUER
      document.querySelector(`.todoList #id${lastId} .change`).style.display =
        "none";
      document.querySelector(`.todoList #id${lastId} time`).style.display =
        "flex";
      document.querySelector(`.todoList #id${lastId} .contents`).style.display =
        "flex";
      document.querySelector(
        `.todoList #id${lastId} .contentButtons`
      ).style.display = "flex";
      // POUR RETIRER TOUT CE QUI CE TROUVE DANS LE LI ET AFFICHER LE FORMULAIRE DE MODIFICATION
      document.querySelector(`.todoList #id${i} time`).style.display = "none";
      document.querySelector(`.todoList #id${i} .contents`).style.display =
        "none";
      document.querySelector(
        `.todoList #id${i} .contentButtons`
      ).style.display = "none";
      document.querySelector(`.todoList #id${i} .change`).style.display =
        "flex";
      lastId = i;
    });
}
