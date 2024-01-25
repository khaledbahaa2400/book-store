let menuButton = document.querySelector('#menu-btn');
let userButton = document.querySelector('#user-btn');
let navbar = document.querySelector('.header .header-2 .navbar');
let accountBox = document.querySelector('.header .header-2 .flex .user-box');

menuButton.onclick = () => {
    navbar.classList.toggle('active');
    accountBox.classList.remove('active');
}

userButton.onclick = () => {
    accountBox.classList.toggle('active');
    navbar.classList.remove('active');
}

document.addEventListener('click', function(event) {
    if (userButton.contains(event.target) || menuButton.contains(event.target) || navbar.contains(event.target) || accountBox.contains(event.target))
        return;
    navbar.classList.remove('active');
    accountBox.classList.remove('active');
})

window.onscroll = () => {
    accountBox.classList.remove('active');
    navbar.classList.remove('active');

    if (window.scrollY > 60) {
        document.querySelector('.header .header-2').classList.add('active');
    } else {
        document.querySelector('.header .header-2').classList.remove('active');
    }
}

let updateBtn = document.querySelector('.header .header-2 .flex .user-box .update-btn');
updateBtn.onclick = () => {
    document.cookie = "redirector = " + window.location.pathname + "; path = /book%20store/";
}