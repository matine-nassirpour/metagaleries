const
    form = document.getElementById('registrationForm'),
    formGroup = document.querySelector('.form-group'),
    emailInput = document.querySelector('.email-input'),
    firstPasswordInput = document.querySelector('.fist-password-input'),
    secondPasswordInput = document.querySelector('.second-password-input')
;

function checkInputs() {
    const
        emailValue = emailInput.value.trim(),
        firstPasswordInputValue = firstPasswordInput.value.trim(),
        secondPasswordInputValue = secondPasswordInput.value.trim()
    ;

    if (emailValue === '') {
        setErrorFor(emailInput, 'Saisissez votre adresse e-mail');
    } else if (!isEmailValid(emailValue)) {
        setErrorFor(emailInput, 'Adresse e-mail incorrect ou invalide. Veuillez corriger avant de réessayer.');
    }

    if (firstPasswordInputValue === '') {
        setErrorFor(firstPasswordInput, '6 caractères minimum requis');
    }

    if (firstPasswordInputValue !== secondPasswordInputValue) {
        setErrorFor(secondPasswordInput, 'Les mots de passe ne correspondent pas')
    }
}

function setErrorFor(input, message) {
    const
        formGroup = input.parentElement,
        formError = formGroup.querySelector('.form-error small')
    ;

    formError.innerText = message;
    formGroup.className = 'form-group invalid-data';
}

function isEmailValid(email) {
    return /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(email);
}

form.addEventListener('submit', (event) => {
    event.preventDefault();

    checkInputs();
});

emailInput.addEventListener('keypress', () => {
    if (formGroup.classList.contains('invalid-data')) {
        formGroup.classList.remove('invalid-data');
    }
});
