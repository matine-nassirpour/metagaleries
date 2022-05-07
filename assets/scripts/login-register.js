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

function setErrorToInvalidInput(input, error, message) {
    const
        fieldset = input.parentElement,
        smallError = fieldset.querySelector('span small')
    ;

    input.classList.add('error-input');
    error.style.cssText = 'display: flex';
    smallError.innerHTML = message;
}

function removeErrorFromInput(input, error) {
    input.classList.remove('error-input');
    error.style.cssText = 'display: none';
}

function checkRegistrationFormInputs() {
    if (registerEmailInput.value === '') {
        setErrorToInvalidInput(registerEmailInput, registerEmailError, 'Saisissez votre adresse e-mail');
    }

    if (registerEmailInput.value !== '' && !(registerEmailInput.value.match(emailPattern))) {
        setErrorToInvalidInput(registerEmailInput, registerEmailError, 'Adresse e-mail incorrect ou invalide. Veuillez corriger avant de réessayer');
    }

    if (firstPasswordInput.value === '' || firstPasswordInput.value.length < 6) {
        setErrorToInvalidInput(firstPasswordInput, firstPasswordError, '6 caractères minimum requis');
    }

    if (firstPasswordInput.value.length >= 6 && (firstPasswordInput.value !== secondPasswordInput.value)) {
        setErrorToInvalidInput(secondPasswordInput, secondPasswordError, 'Les mots de passe ne correspondent pas');
    }

    if (firstPasswordInput.value.length >= 6 && secondPasswordInput.value === '')  {
        setErrorToInvalidInput(secondPasswordInput, secondPasswordError, 'Saisissez à nouveau votre mot de passe');
    }
}

function checkRegistrationForm() {
    const inputs = registrationForm.querySelectorAll('input[type=text], input[type=password]');

    for (let i = 0; i < inputs.length; i++) {
        if (inputs[i].value === '') {
            registerEmailInput.addEventListener('input', () => {
                if (registerEmailInput.value.match(emailPattern)) {
                    removeErrorFromInput(registerEmailInput, registerEmailError);
                }
            });

            firstPasswordInput.addEventListener('input', () => {
                if (firstPasswordInput.value.length >= 6) {
                    removeErrorFromInput(firstPasswordInput, firstPasswordError);
                }
            });

            secondPasswordInput.addEventListener('input', () => {
                if (firstPasswordInput.value === secondPasswordInput.value) {
                    removeErrorFromInput(secondPasswordInput, secondPasswordError);
                }
            });

            return false;
        }
    }
    return true;
}

registrationForm.addEventListener('submit', (event) => {
    if (!checkRegistrationForm() || !(registerEmailInput.value.match(emailPattern)) || firstPasswordInput.value !== secondPasswordInput.value) {
        event.preventDefault();

        checkRegistrationFormInputs();
    }
});

const
    loginForm = document.getElementById('loginForm'),
    loginEmailInput = document.querySelector('.login-form-email-input'),
    loginEmailError = document.querySelector('.login-email-error'),
    loginPasswordInput = document.querySelector('.login-password-input'),
    loginPasswordError = document.querySelector('.login-password-error')
;

function checkLoginFormInputs() {
    if (loginEmailInput.value === '') {
        setErrorToInvalidInput(loginEmailInput, loginEmailError, 'Saisissez votre adresse e-mail')
    }

    if (loginEmailInput.value !== '' && !(loginEmailInput.value.match(emailPattern))) {
        setErrorToInvalidInput(loginEmailInput, loginEmailError, 'Adresse e-mail incorrect ou invalide. Veuillez corriger avant de réessayer');
    }

    if (loginPasswordInput.value === '') {
        setErrorToInvalidInput(loginPasswordInput, loginPasswordError, 'Saisissez votre mot de passe')
    }
}

function checkLoginForm() {
    const inputs = loginForm.querySelectorAll('input[type=text], input[type=password]');

    for (let i = 0; i < inputs.length; i++) {
        if (inputs[i].value === '') {
            loginEmailInput.addEventListener('input', () => {
                if (loginEmailInput.value.match(emailPattern)) {
                    removeErrorFromInput(loginEmailInput, loginEmailError);
                }
            });

            loginPasswordInput.addEventListener('input', () => {
                if (loginPasswordInput.value !== '') {
                    removeErrorFromInput(loginPasswordInput, loginPasswordError);
                }
            });

            return false;
        }
    }
    return true;
}

loginForm.addEventListener('submit', (event) => {
    if (!checkLoginForm()) {
        event.preventDefault();

        checkLoginFormInputs();
    }
});

/*----------------------------------*\
  >>> Login Register Portal
\*----------------------------------*/

const
    loginFormRadio = document.getElementById('loginFormRadio'),
    registrationFormRadio = document.getElementById('registrationFormRadio'),
    loginFormBody = document.querySelector('.login-form-body'),
    registrationFormBody = document.querySelector('.registration-form-body'),
    loginFormHeader = document.querySelector('.login-form-header'),
    registrationFormHeader = document.querySelector('.registration-form-header')
;

function handleForms(formBody, formHeader, emailInput, otherFormRadio, otherFormBody, otherFormHeader) {
    formBody.style.cssText = 'display: block';
    formHeader.classList.add('active-form-header');
    formHeader.classList.remove('inactive-form-header');
    otherFormRadio.checked = false;
    otherFormBody.style.cssText = 'display: none';
    otherFormHeader.classList.add('inactive-form-header');
    otherFormHeader.classList.remove('active-form-header');
    emailInput.focus();
}

loginFormRadio.addEventListener('click', () => {
    if (loginFormRadio.checked) {
        handleForms(loginFormBody, loginFormHeader, loginEmailInput, registrationFormRadio, registrationFormBody, registrationFormHeader);
    }
});

registrationFormRadio.addEventListener('click', () => {
   if (registrationFormRadio.checked) {
       handleForms(registrationFormBody, registrationFormHeader, registerEmailInput, loginFormRadio, loginFormBody, loginFormHeader);
   }
});
