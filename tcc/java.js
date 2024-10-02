// java.js
document.getElementById("menu-icon").addEventListener("click", function() {
    var navMenu = document.getElementById("nav-menu");
    if (navMenu.style.display === "none" || navMenu.style.display === "") {
        navMenu.style.display = "flex";
    } else {
        navMenu.style.display = "none";
    }
});
