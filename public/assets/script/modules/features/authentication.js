
import { showAlert, closeAlert } from '../utils/alerts.js';

export function authentication() {

    // ======================= Config =======================

    const forms = {
        registerForm: 'registration-form',
        loginForm: 'login-form',
    };

    const buttons = {
        registerButton: '#register-btn',
        loginButton: '#login-btn',
    };

    const inputFields = {
        username: '#username',
        email: '#email',
        userType: '#user-type-select',
        code: '#code',
        password: '#password',
        confirmPassword: '#confirm-password',
    };

    // ======================= DOM Utility =======================

    const $ = (selector) => document.querySelector(selector);
    const $$ = (selector) => document.querySelectorAll(selector);

    const getForm = (formId) => document.getElementById(formId);
    // const getInputElement = (formId, inputId) => $(`${formId} ${inputId}`);
    // const getValue = (formId, inputId) => getInputElement(formId, inputId)?.value.trim() || '';
    
    const getInputElement = (form, inputId) => {
        return form.querySelector(inputId);
    }
    const getValue = (form, inputId) => getInputElement(form, inputId)?.value.trim() || '';

    function capitalize(str) {
        return str.charAt(0).toUpperCase() + str.slice(1);
    }

    // ======================= Helper Functions =======================

    function showError(form, inputId, message) {
        // const inputBox = inputElement.closest('.input-box');
        const inputBox = getInputElement(form, inputId).closest('.input-box');
        if (!inputBox) return;

        inputBox.classList.add('error');
        const errorBox = inputBox.querySelector('.error-box');
        if (errorBox) {
            errorBox.textContent = message;
        }
    }

    function clearError(inputElement) {
        const inputBox = inputElement.closest('.input-box');
        if (!inputBox) return;

        inputBox.classList.remove('error');
        const errorBox = inputBox.querySelector('.error-box');
        if (errorBox) {
            errorBox.textContent = '';
        }
    }

    function clearAllErrors(form) {
        if (!form) return;

        form.querySelectorAll('.input-box').forEach(box => {
            box.classList.remove('error');
            const errorBox = box.querySelector('.error-box');
            if (errorBox) {
                errorBox.textContent = '';
            }
        });
    }

    // ======================= API Calls =======================

    async function fetchRegistrationCodes() {
        try {
            const response = await fetch('index.php?c=auth&a=codes');
            registrationCodes = await response.json();
            console.log('Registration codes fetched:', registrationCodes);
        } catch (error) {
            console.error('Error fetching registration codes:', error);
        }
    }

    // ======================= Module State =======================
    let isAnimating = false;
    let registrationCodes = [];
    let usernameTimer;
    let emailTimer;

    // ======================= Initialization =======================

    function startAuthenticationModule() {
        if (!validateRequiredElements()) return;

        setupEventListeners();
        setupCodeInputToggle();
        setupFormHandlers();
        fetchRegistrationCodes();
    }

    function validateRequiredElements() {
        const requiredElements = [
            '.wrapper.auth',
            '#register-btn',
            '#login-btn',
            '#registration-form #user-type-select',
            '#code-box',
            '#code'
        ];

        const missingElements = requiredElements.filter(selector => !$(selector));

        if (missingElements.length > 0) {
            console.warn('Missing required elements for authentication:', missingElements);
            return false;
        }

        return true;
    }

    // ======================= Setup Animation =======================

    function setupEventListeners() {
        const registerBtn = $(buttons.registerButton);
        const loginBtn = $(buttons.loginButton);

        if (registerBtn) {
            registerBtn.addEventListener('click', handleRegisterClick);
        }

        if (loginBtn) {
            loginBtn.addEventListener('click', handleLoginClick);
        }
    }

    function handleRegisterClick() {
        if (isAnimating) return;

        const container = $('.wrapper.auth');
        container.classList.add('active');
        closeAlert(getForm(forms.registerForm));
    }

    function handleLoginClick() {
        if (isAnimating) return;

        const container = $('.wrapper.auth');
        container.classList.remove('active');
        closeAlert(getForm(forms.loginForm));
    }

    // ======================= Setup Code Input Toggle =======================

    function setupCodeInputToggle() {
        const selectInput = $('#registration-form #user-type-select');
        const codeInputBox = $('#code-box');
        const codeInput = $('#code');

        if (!selectInput || !codeInputBox || !codeInput) return;

        selectInput.addEventListener('change', handleUserTypeChange);

        function handleUserTypeChange() {
            const selectedValue = selectInput.value;

            // Clear code input
            codeInput.value = '';

            if (selectedValue !== 'user') {
                codeInputBox.hidden = false;
                codeInput.placeholder = `Enter ${selectedValue} Code`;
            } else {
                codeInputBox.hidden = true;
                codeInput.placeholder = '';
            }
        }
    }

    // ======================= Event Delegation : Setup Form Handlers =======================


    function setupFormHandlers() {

        document.body.addEventListener('submit', async function (e) {
            const form = e.target;
            const formId = form.id;

            // Handle Register Form
            if (formId === forms.registerForm) {
                e.preventDefault();
                await handleRegisterForm(form);
            }

            // Handle Login Form
            else if (formId === forms.loginForm) {
                e.preventDefault();
                await handleLoginForm(form);
            }

        });

        document.addEventListener('input', function (e) {
            const input = e.target;
            const form = input.closest('form');


            if (form && form.id === forms.registerForm) {

                if (input.matches(inputFields.username)) {
                    handleFieldValidation(form, input, 'username', 'usernameTimer');
                }

                if (input.matches(inputFields.email)) {
                    handleFieldValidation(form, input, 'email', 'emailTimer');
                }

            }

        });

    }

    // ======================= Real Time Validation =======================

    function handleFieldValidation(form, input, columnName, timerRefName) {
        clearTimeout(window[timerRefName]);

        window[timerRefName] = setTimeout(async () => {
            clearError(input);

            const value = input.value.trim();
            if (!value) return;

            const data = {
                column: columnName,
                value: value,
            };

            try {
                const response = await fetch('index.php?c=auth&a=checkUser', {
                    method: 'POST',
                    body: JSON.stringify(data),
                    headers: {
                        'Content-Type': 'application/json',
                    },
                });

                const result = await response.json();

                if (result.exists) {
                    showError(form, inputFields[columnName], `${capitalize(columnName)} is already taken`);
                    input.dataset.valid = 'false';
                } else {
                    input.dataset.valid = 'true';
                }
            } catch (error) {
                console.error(`${capitalize(columnName)} check error:`, error);
            }
        }, 600);
    }



    // ======================= Form Handlers =======================


    async function handleRegisterForm(form) {
        clearAllErrors(form);

        let errors = {};


        const username = getValue(form, inputFields.username);
        const email = getValue(form, inputFields.email);
        const userType = getValue(form, inputFields.userType);
        const code = getValue(form, inputFields.code);
        const password = getValue(form, inputFields.password);
        const confirmPassword = getValue(form, inputFields.confirmPassword);
        const codeInputElement = getInputElement(form, inputFields.code)

        const usernameField = getInputElement(form, inputFields.username);
        const emailField = getInputElement(form, inputFields.email);

        if (!username) errors.username = "Enter your username";
        if (!email) errors.email = "Enter your email";
        if (!userType) errors.userType = "Select your user type";
        if (!password) errors.password = "Enter your password";
        if (password && password.length < 8) errors.password = "Password must be atleast 8 characters long";
        if (!confirmPassword) errors.confirmPassword = "Enter confirmed password";
        if (confirmPassword && (confirmPassword != password)) errors.confirmPassword = "Passwords dont match";

        if (password && (confirmPassword === password) && password.length < 8) {
            errors.password = "Password must be atleast 8 characters long";
            errors.confirmPassword = "Password must be atleast 8 characters long";
        }

        if ((userType == 'admin' || userType == 'boss') && !codeInputElement.hidden) {
            if (!code) {
                errors.code = `Enter the ${userType} code`;
            }
            else {
                const match = registrationCodes.find(items =>
                    userType === 'admin' ? items.admin_code === code : items.boss_code === code
                );
                if (!match) errors.code = `Incorrect ${userType} code`;
            }
        }

        if (usernameField.dataset.valid === "false") {
            errors.username = "Username is already taken";
        }
        if (emailField.dataset.valid === "false") {
            errors.email = "Email is already taken";
        }

        for (let key in errors) {
            showError(form, inputFields[key], errors[key]);
        }

        if (Object.keys(errors).length === 0) {

            let formData = {
                username: username,
                email: email,
                userType: userType,
                enteredCode: code,
                password: password,
                confirmPassword: confirmPassword,
                submit: 1,
            }

            let response = await fetch('index.php?c=auth&a=register', {
                method: 'POST',
                body: JSON.stringify(formData),
                headers: {
                    'Content-Type': 'application/json',
                }

            });

            let result = await response.json();

            if (result.errors) {
                for (let key in result.errors) {
                    showError(form, inputFields[key], result.errors[key]);
                }
            }

            if (result.success) {
                showAlert(form, 'alert--success', result.success);
                form.reset();
            }

            if (result.failure) {
                showAlert(form, 'alert--failure', result.failure);
            }

        }
    }

    async function handleLoginForm(form) {


        showAlert(form, 'alert--success', 'something');
        clearAllErrors(form);


        let errors = {};

        const email = getValue(form, inputFields.email);
        const password = getValue(form, inputFields.password);
        const userType = getValue(form, inputFields.userType);

        if (!email) errors.email = "Enter your email";
        if (!password) errors.password = "Enter your password";
        if (!userType) errors.userType = "Enter your user type";

        for (let key in errors) {
            showError(form, inputFields[key], errors[key]);
        }

        if (Object.keys(errors).length === 0) {

            let formData = {
                email: email,
                userType: userType,
                password: password,
                submit: 1,
            };
            console.log("form is okay")

            let response = await fetch("index.php?c=auth&a=login", {
                method: 'POST',
                body: JSON.stringify(formData),
                headers: {
                    'Content-Type': 'application/json'
                }
            });
            let result = await response.json();

            console.log(result);

            if (result.errors) {
                for (let key in result.errors) {
                    showError(form, inputFields[key], result.errors[key]);
                }
            }

            if (result.success) {

                showAlert(form, 'alert--success', result.success);

                setTimeout(() => {
                    window.location.href = "index.php?c=dashboard&a=index";
                }, 1500);

            }
            if (result.failure){
                showAlert(form, 'alert--failure', result.failure);
            }

        }
    }

    // ======================= Start Module =======================
    startAuthenticationModule();
}
