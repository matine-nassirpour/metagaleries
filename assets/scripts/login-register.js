/*----------------------------------*\
  >>> Registration Form
\*----------------------------------*/

const
    registrationForm = document.getElementById('registrationForm'),
    registerEmailInput = document.querySelector('.registration-form-email-input'),
    emailPattern = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/,
    registerEmailError = document.querySelector('.register-email-error'),
    firstPasswordInput = document.querySelector('.fist-password-input'),
    firstPasswordError = document.querySelector('.first-password-error'),
    secondPasswordInput = document.querySelector('.second-password-input'),
    secondPasswordError = document.querySelector('.second-password-error')
;

function setErrorForInvalidInput(input, error, message) {
    const
        fieldset = input.parentElement,
        smallError = fieldset.querySelector('span small')
    ;

    input.classList.add('error-input');
    error.style.cssText = 'display: flex';
    smallError.innerHTML = message;
}

function myFirstRealFunction(input, error) {
    if (input.value.match(emailPattern)) {
        input.classList.remove('error-input');
        error.style.cssText = 'display: none';
    } else {
        input.classList.add('error-input');
        error.style.cssText = 'display: flex';
    }
}

function checkInputs() {
    if (registerEmailInput.value === '') {
        setErrorForInvalidInput(registerEmailInput, registerEmailError, 'Saisissez votre adresse e-mail');
    }

    if (registerEmailInput.value !== '' && !(registerEmailInput.value.match(emailPattern))) {
        setErrorForInvalidInput(registerEmailInput, registerEmailError, 'Adresse e-mail incorrect ou invalide. Veuillez corriger avant de réessayer');
    }

    if (firstPasswordInput.value === '' || firstPasswordInput.value.length < 6) {
        setErrorForInvalidInput(firstPasswordInput, firstPasswordError, '6 caractères minimum requis');
    }

    if (firstPasswordInput.value.length >= 6 && (firstPasswordInput.value !== secondPasswordInput.value)) {
        setErrorForInvalidInput(secondPasswordInput, secondPasswordError, 'Les mots de passe ne correspondent pas');
    }

    if (firstPasswordInput.value.length >= 6 && secondPasswordInput.value === '')  {
        setErrorForInvalidInput(secondPasswordInput, secondPasswordError, 'Saisissez à nouveau votre mot de passe');
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
    const inputs = registrationForm.getElementsByTagName('input');

    for (let i = 0; i < inputs.length; i++) {
        if (inputs[i].value === '') {
            registerEmailInput.addEventListener('input', () => {
                myFirstRealFunction(registerEmailInput, registerEmailError);
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

registrationForm.addEventListener('submit', (event) => {
    if (!checkForm() || !(registerEmailInput.value.match(emailPattern)) || firstPasswordInput.value !== secondPasswordInput.value) {
        event.preventDefault();
        checkInputs();
    }
});

/*----------------------------------*\
  >>> Login Form
\*----------------------------------*/

const
    loginForm = document.getElementById('loginForm'),
    loginEmailInput = document.querySelector('.login-form-email-input'),
    loginEmailError = document.querySelector('.login-email-error'),
    loginEmailErrorMessage = document.querySelector('.login-email-error small'),
    loginPasswordInput = document.querySelector('.login-password-input'),
    loginPasswordError = document.querySelector('.login-password-error'),
    loginPasswordErrorMessage = document.querySelector('.login-password-error small')
;

function checkLoginEmail() {
    if ((loginEmailInput.value === '') || (!loginEmailInput.value.match(emailPattern))) {
        loginEmailInput.classList.add('error-input');
        loginEmailError.style.cssText = 'display: flex';

        if (loginEmailInput.value === '') {
            loginEmailErrorMessage.innerHTML = 'Saisissez votre adresse e-mail';
        } else if ((!loginEmailInput.value.match(emailPattern))) {
            loginEmailErrorMessage.innerHTML = 'Adresse e-mail incorrect ou invalide. Veuillez corriger avant de réessayer';
        }

        return false;
    }

    return true;
}

function checkLoginPassword() {
    if (loginPasswordInput.value === '') {
        loginPasswordInput.classList.add('error-input');
        loginPasswordError.style.cssText = 'display: flex';
        loginPasswordErrorMessage.innerHTML = 'Saisissez votre mot de passe';

        return false;
    }

    return true
}

function checkLoginInputs() {
    const inputs = loginForm.querySelectorAll('input[type=text], input[type=password]');

    for (let i = 0; i < inputs.length; i++) {
        if (inputs[i].value === '') {
            loginEmailInput.addEventListener('input', () => {
                myFirstRealFunction(loginEmailInput, loginEmailError);
            });
        }
    }
}

loginForm.addEventListener('submit', (event) => {
    if (!checkLoginEmail() || !checkLoginPassword()) {
        event.preventDefault();

        checkLoginInputs();
    }
});

/*----------------------------------*\
  >>> Login Register Portal
\*----------------------------------*/

const
    loginFormRadioInput = document.getElementById('loginFormRadio'),
    registrationFormRadio = document.getElementById('registrationFormRadio'),
    loginFormBody = document.querySelector('.login-form-body'),
    registrationFormBody = document.querySelector('.registration-form-body'),
    loginFormHeader = document.querySelector('.login-form-header'),
    registrationFormHeader = document.querySelector('.registration-form-header')
;

loginFormRadioInput.addEventListener('click', () => {
    if (loginFormRadioInput.checked) {
        loginFormBody.style.cssText = 'display: block';
        registrationFormRadio.checked = false;
        registrationFormBody.style.cssText = 'display: none';
        loginFormHeader.style.cssText = 'background-color: transparent; border: none';
        registrationFormHeader.style.cssText = 'background-color: #F3F3F3; border-top: 1px solid #DDDDDD';
        loginEmailInput.focus();
    }
});

registrationFormRadio.addEventListener('click', () => {
   if (registrationFormRadio.checked) {
       registrationFormBody.style.cssText = 'display: block';
       loginFormRadioInput.checked = false;
       loginFormBody.style.cssText = 'display: none';
       registrationFormHeader.style.cssText = 'background-color: transparent; border: none';
       loginFormHeader.style.cssText = 'background-color: #F3F3F3; border-top: 1px solid #DDDDDD';
       registerEmailInput.focus();
   }
});
