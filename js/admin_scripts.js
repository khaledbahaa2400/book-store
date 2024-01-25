let menuButton = document.querySelector('#menu-btn');
let userButton = document.querySelector('#user-btn');
let navbar = document.querySelector('.header .flex .navbar');
let accountBox = document.querySelector('.header .flex .account-box');

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
    navbar.classList.remove('active');
    accountBox.classList.remove('active');
}

document.querySelector('#stop-update').onclick = () => {
    document.querySelector('.edit-product-form').style.display = 'none';
    window.location.href = 'products.php';
}

document.querySelector('#update-profile').onclick = () => {
    console.log("clicked");
    document.cookie = "redirector = " + window.location.pathname + "; path = /book%20store/";
}