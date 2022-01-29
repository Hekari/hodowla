const hamburger=document.querySelector(".burger")
const ul=document.querySelector("ul")
const nav=document.querySelector("nav")
const hamburger_Visible=document.querySelector(".fa-bars")
const hamburger_Close=document.querySelector(".fa-times")
const burger = () => {
    hamburger_Close.classList.toggle("hide")
    hamburger_Visible.classList.toggle("hide")
    hamburger.classList.toggle("center")
    ul.classList.toggle("active")

}
hamburger.addEventListener("click",burger)
