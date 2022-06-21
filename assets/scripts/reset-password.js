const
    resetPasswordForm = document.getElementById('resetPasswordForm'),
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

function checkResetPasswordFormInputs() {
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

function checkResetPasswordForm() {
    const inputs = resetPasswordForm.querySelectorAll('input[type=text], input[type=password]');

    for (let i = 0; i < inputs.length; i++) {
        if (inputs[i].value === '') {
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

resetPasswordForm.addEventListener('submit', (event) => {
    if (!checkResetPasswordForm() || firstPasswordInput.value !== secondPasswordInput.value) {
        event.preventDefault();

        checkResetPasswordFormInputs();
    }
});
