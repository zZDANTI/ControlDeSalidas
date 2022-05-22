const navBoton = document.querySelector(".boton") 
const navMenu = document.querySelector(".nav-menu") 

navBoton.addEventListener("click", ()=> {
    navMenu.classList.toggle("nav-menu-visible")
})