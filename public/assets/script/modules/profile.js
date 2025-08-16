export async function profile() {

    // ========== Constants ==========

    const forms = {
        details: 'update-details',
        role: 'update-role',
        password: 'update-password',
    };

    const fields = {
        username: '#username',
        email: '#email',
        userType: '#user-type-select',
        code: '#code',
        currentPassword : '#current-password',
        password : '#password',
        confirmPassword : '#confirm-password',
    };

    // ========== DOM Utils ==========

    const $ = (selector) => document.querySelector(selector);
    const $$ = (selector) => document.querySelectorAll(selector);

    const getFormById = (id) => document.getElementById(id);
    const getInput = (form, field) => form?.querySelector(field) || null;
    const getValue = (form, field) => getInput(form, field)?.value.trim() || '';
    const getElement = (selector) => $(selector);

    const capitalizeFirst = (str) =>
        str.charAt(0).toUpperCase() + str.slice(1);

    function showErrors(form, fieldSelector, message) {
        const field = getInput(form, fieldSelector);
        if (!field) return;

        const box = field.closest('.input-box');
        if (!box) return;

        box.classList.add('error');
        const errorSpan = box.querySelector('span');
        if (errorSpan) errorSpan.textContent = message;
    }

    function clearErrors() {
        $$(".input-box").forEach((box) => {
            box.classList.remove('error');
            const errorBox = box.querySelector('span');
            if (errorBox) errorBox.textContent = '';
        });
    }

    function showAlert(classType, msg){
        const box = $('.alert');
        box.classList.add(classType);
        box.querySelector('span').textContent = msg;
    }

    // ========== API Calls ==========

    async function fetchUser() {
        const response = await fetch('index.php?c=profile&a=get', { method: 'POST' });
        return await response.json();
    }

    async function fetchCodes() {
        const response = await fetch('index.php?c=code&a=get', { method: 'POST' });
        return await response.json();
    }

    async function doesUserExists(column, value, id){
        const formData = id ? {id, value , column} : {value , column};
        const response = await fetch('index.php?c=profile&a=doesUserExists', {
            method : 'POST',
            body : JSON.stringify(formData),
            headers : {'Content-Type' : 'application/json'},
        });
        const result = await response.json();
        return result.valid;
    }

    // ========== Event Delegation ==========

    function setupFormHandlers() {

        document.body.addEventListener('submit', async (e) => {
            e.preventDefault();
            const form = e.target;
            const formId = form.id;


            if (formId === forms.details) {
                handleProfileDetailsUpdate(form);
            }

            if (formId === forms.role) {
                await handleProfileRoleUpdate(form);
            }

            if(formId === forms.password){
                handleProfilePasswordUpdate(form);
            }

        });

        document.body.addEventListener('input', async (e) => {
            const input = e.target;
            const form = input.closest('form');
            const formId = form.id;
            
            const column = input.id;

            if(formId === forms.details){

                handleProfileDetailsUpdateValidation(form, formId, input, column)
            }


            
        });

    }

    // ========== Real Time Validator Functions ==========
    
    let debounce;
    async function handleProfileDetailsUpdateValidation(form , formId, input, column ){
        clearTimeout(debounce);
        debounce = setTimeout(async() => {

            clearErrors();

            const value = input.value.trim();
            if(!value) return;
            const user = await fetchUser();
            const valid = await doesUserExists(column, value, user.id );

            input.dataset.valid = valid;
            // input.dataset.column = user[column];
            if (!valid) showErrors(form, fields[input.id], `This ${capitalizeFirst(column)} Already Exists !`);

            console.log('RESPONSE FROM PHP ON INPUT :' , valid, input, column);

        }, 1000);
    }

    


    // ========== AJAX CRUD OPERATIONS ==========

    async function showProfile() {
        const usernameInput = getElement(fields.username);
        const emailInput = getElement(fields.email);
        const userTypeSelect = getElement(fields.userType);

        const user = await fetchUser();

        if (usernameInput){
            usernameInput.value = user.username;
            usernameInput.dataset.value = user.username
        }
        if (emailInput){
            emailInput.value = user.email;
            emailInput.dataset.value = user.email;
        }
        if (userTypeSelect) userTypeSelect.value = user.user_type;

        const codeInput = getElement(fields.code);
        const codeBox = codeInput?.parentElement;
        const codeLabel = codeBox?.querySelector('label');

        userTypeSelect?.addEventListener('change', () => {
            clearErrors();

            const roleForm = getFormById(forms.role);
            const selectedRole = getValue(roleForm, fields.userType);
            const currentRole = user.user_type;

            const isSame = selectedRole === currentRole;
            const isUser = selectedRole === 'user';

            if (!isSame && !isUser) {
                codeBox?.classList.remove('hidden');
                if (codeLabel) codeLabel.textContent = `${capitalizeFirst(selectedRole)} Code`;
                if (codeInput) codeInput.placeholder = `Enter ${capitalizeFirst(selectedRole)} Code`;
            } else {
                codeBox?.classList.add('hidden');
            }
        });
    }

    async function handleProfileRoleUpdate(form) {
        clearErrors();

        const codes = await fetchCodes();
        const user = await fetchUser();

        const errors = {};

        const selectedRole = getValue(form, fields.userType);
        const currentRole = user.user_type;
        const isSameRole = selectedRole === currentRole;
        const isUserRole = selectedRole === 'user';
        const enteredCode = getValue(form, fields.code);

        if (isSameRole) {
            // errors.userType = `You're already a ${capitalizeFirst(currentRole)}!`;
            errors.nothing = 'Nothing Changed';
            showAlert('warning', 'Nothing Changed');
        }

        if (!isSameRole && !isUserRole) {
            if (!enteredCode) {
                errors.code = 'Enter Code!';
            } else {
                const match = codes.find((code) =>
                    selectedRole === 'admin'
                        ? code.admin_code === enteredCode
                        : code.boss_code === enteredCode
                );

                if (!match) {
                    errors.code = `Incorrect ${capitalizeFirst(selectedRole)} code`;
                }
            }
        }

        for (let key in errors) {
            showErrors(form, fields[key], errors[key]);
        }

        if (Object.keys(errors).length === 0) {
            const response = await fetch('index.php?c=profile&a=update', {
                method: 'POST',
                body: JSON.stringify({
                    id: user.id,
                    userType: selectedRole,
                }),
                headers: { 'Content-Type': 'application/json' },
            });

            const result = await response.json();

            if (result.success) {
                location.reload();
            }
        }
    }

    async function handleProfileDetailsUpdate(form) {
        const errors = {};
        const user = await fetchUser();

        const username = getValue(form, fields.username);
        const email = getValue(form, fields.email);

        const usernameField = getElement(fields.username);
        const emailField = getElement(fields.email)

        if (!username) errors.username = 'Enter your username';
        if (!email) errors.email = 'Enter your email';

        if(username && usernameField.dataset.valid === 'false'){
            errors.username = 'This Username Already Exists';
        }

        if(email && emailField.dataset.valid === 'false'){
            errors.email = 'This Email Already Exists';
        }

        if(username === usernameField.dataset.value && email === emailField.dataset.value){
            // errors.username = 'Nothing Changed';
            // errors.email = 'Nothing Changed';
            errors.nothing = 'Nothing Changed';
            showAlert('warning', 'Nothing Changed');
        }


        for (let key in errors) {
            showErrors(form, fields[key], errors[key]);
        }

        if(Object.keys(errors).length === 0){

            const formData = {
                id : user.id ,
                username : username,
                email : email,
            };

            const response = await fetch('index.php?c=profile&a=update', {
                method : 'POST',
                body : JSON.stringify(formData),
                headers : {'Content-Type' : 'application/json'},
            });
            const result = await response.json();

            if(result.success){
                location.reload();
            }


        }

    }


    async function handleProfilePasswordUpdate(form) {
        const errors = {};
        const user = await fetchUser();

        const currentPassword = getValue(form, fields.currentPassword);
        const password = getValue(form, fields.password);
        const confirmPassword = getValue(form, fields.confirmPassword);

        if(!currentPassword) errors.currentPassword = "Enter Current Password";
        if(!password) errors.password = "Enter New Password";
        if(!confirmPassword) errors.confirmPassword = "Confirm New Password";

        if(password && password.length < 8) errors.password = 'Password must be atleast 8 characters long';

        if(password && confirmPassword && password !== confirmPassword){
            // errors.password = 'Passwords Dont Match';
            errors.confirmPassword = 'Passwords Dont Match';
        }

        console.log('Errors count : ', Object.keys(errors).length);

        for(let key in errors){
            showErrors(form, fields[key], errors[key]);
        }

        if(Object.keys(errors).length === 0){
            clearErrors();
            console.log('No error ready to submit !');

            const formData = {
                id : user.id,
                confirmPassword : confirmPassword,
                password : password,
                currentPassword : currentPassword,
            };

            const response = await fetch('index.php?c=profile&a=update', {
                method : 'POST',
                body : JSON.stringify(formData),
                headers : {'Content-Type' : 'application/json'},
            });
            const result = await response.json();

            console.log('RESPONSE FROM PHP : ', result);

            if(result.success){
                form.reset();
                showAlert('success', 'Successfully Updated the Password');
            }

        }

    }

    // ========== Init ==========

    setupFormHandlers();
    showProfile();
}
