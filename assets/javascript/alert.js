// messages d'alerte pour notifier à l'utilisateur si il a réussi à se connecter
// type 'success' ou 'error'
const showAlert = (type, msg) => {
    console.log('test');
    hideAlert();
    const html = `<div class="alert alert--${type}">${msg}</div>`;
    document.querySelector('.loginForm').insertAdjacentHTML('afterbegin', html);
    window.setTimeout(hideAlert, 2000);
};

// cache l'alerte
const hideAlert = () => {
    const el = document.querySelector('.alert');
    if (el) el.parentElement.removeChild(el);
};
