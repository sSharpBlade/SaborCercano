const logregBox = document.querySelector('.login');
const loginLink = document.querySelector('.iniciar-enlace');
const registerLink = document.querySelector('.registrar-enlace');

registerLink.addEventListener('click', () => {
    logregBox.classList.add('active');
});

loginLink.addEventListener('click', () => {
    logregBox.classList.remove('active');
});