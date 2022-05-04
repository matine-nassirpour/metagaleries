const
    form = document.getElementById('registrationForm'),
    emailInput = document.querySelector('.email-input'),
    emailPattern = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/,
    emailError = document.querySelector('.email-error'),
    emailErrorMessage = document.querySelector('.email-error small'),
    firstPasswordInput = document.querySelector('.fist-password-input'),
    firstPasswordError = document.querySelector('.first-password-error'),
    firstPasswordErrorMessage = document.querySelector('.first-password-error small'),
    secondPasswordInput = document.querySelector('.second-password-input'),
    secondPasswordError = document.querySelector('.second-password-error'),
    secondPasswordErrorMessage = document.querySelector('.second-password-error small')
;

function checkInputs() {
    if (emailInput.value === '') {
        emailInput.classList.add('error-input');
        emailError.style.cssText = 'display: flex';
        emailErrorMessage.innerHTML = 'Saisissez votre adresse e-mail';
    }

    if (emailInput.value !== '' && !(emailInput.value.match(emailPattern))) {
        emailInput.classList.add('error-input');
        emailError.style.cssText = 'display: flex';
        emailErrorMessage.innerHTML = 'Adresse e-mail incorrect ou invalide. Veuillez corriger avant de réessayer';
    }

    if (firstPasswordInput.value === '' || firstPasswordInput.value.length < 6) {
        firstPasswordInput.classList.add('error-input');
        firstPasswordError.style.cssText = 'display: flex';
        firstPasswordErrorMessage.innerHTML = '6 caractères minimum requis';
    }

    if (firstPasswordInput.value.length >= 6 && (firstPasswordInput.value !== secondPasswordInput.value)) {
        secondPasswordInput.classList.add('error-input');
        secondPasswordError.style.cssText = 'display: flex';
        secondPasswordErrorMessage.innerHTML = 'Les mots de passe ne correspondent pas';
    }

    if (firstPasswordInput.value.length >= 6 && secondPasswordInput.value === '')  {
        secondPasswordInput.classList.add('error-input');
        secondPasswordError.style.cssText = 'display: flex';
        secondPasswordErrorMessage.innerHTML = 'Saisissez à nouveau votre mot de passe';
    }
}

function checkEmail() {
    if (emailInput.value.match(emailPattern)) {
        emailInput.classList.remove('error-input');
        emailError.style.cssText = 'display: none';
    } else {
        emailInput.classList.add('error-input');
        emailError.style.cssText = 'display: flex';
    }
}

function checkPasswordLength() {
    if (firstPasswordInput.value.length >= 6) {
        firstPasswordInput.classList.remove('error-input');
        firstPasswordError.style.cssText = 'display: none';
    } else {
        firstPasswordInput.classList.add('error-input');
        firstPasswordError.style.cssText = 'display: flex';
    }
}

function checkPasswordValidation() {
    if (firstPasswordInput.value === secondPasswordInput.value) {
        secondPasswordInput.classList.remove('error-input');
        secondPasswordError.style.cssText = 'display: none';
    }
}

function checkForm() {
    const inputs = form.getElementsByTagName('input');

    for (let i = 0; i < inputs.length; i++) {
        if (inputs[i].value === '') {
            emailInput.addEventListener('input', () => {
                checkEmail();
            });

            firstPasswordInput.addEventListener('input', () => {
                checkPasswordLength();
            });

            secondPasswordInput.addEventListener('input', () => {
                checkPasswordValidation();
            });

            return false;
        }
    }
    return true;
}

form.addEventListener('submit', (event) => {
    if (!checkForm() || !(emailInput.value.match(emailPattern)) || firstPasswordInput.value !== secondPasswordInput.value) {
        event.preventDefault();
        checkInputs();
    }
});

const
    loginFormRadioInput = document.getElementById('loginFormRadio'),
    registrationFormRadioInput = document.getElementById('registrationFormRadio'),
    loginFormBody = document.querySelector('.login-form-body'),
    registrationFormBody = document.querySelector('.registration-form-body'),
    loginFormHeader = document.querySelector('.login-form-header'),
    registrationFormHeader = document.querySelector('.registration-form-header')
;

loginFormRadioInput.addEventListener('click', () => {
    if (loginFormRadioInput.checked) {
        loginFormBody.style.cssText = 'display: block';
        registrationFormRadioInput.checked = false;
        registrationFormBody.style.cssText = 'display: none';
        loginFormHeader.classList.remove('js-form-box-header');
        registrationFormHeader.classList.add('js-form-box-header');
    }
});

registrationFormRadioInput.addEventListener('click', () => {
   if (registrationFormRadioInput.checked) {
       registrationFormBody.style.cssText = 'display: block';
       loginFormRadioInput.checked = false;
       loginFormBody.style.cssText = 'display: none';
       registrationFormHeader.classList.remove('js-form-box-header');
       loginFormHeader.classList.add('js-form-box-header');
   }
});
