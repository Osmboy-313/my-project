export function authentication() {


    // Authentication Page Animation Classes Toggle

    let container = document.querySelector(".wrapper.auth");
    let registerBtn = document.querySelector("#register-btn");
    let loginBtn = document.querySelector("#login-btn");

    if (!registerBtn) return;
    if (!loginBtn) return;

    registerBtn.addEventListener('click', function () {
        container.classList.add("active");

        // For Clearing notify messages when switching views

        document.querySelector("#notify-login").classList.remove("success", "failure");
        document.querySelector("#notify-register").classList.remove("success", "failure");
    });

    loginBtn.addEventListener('click', function () {
        container.classList.remove("active");

        // For Clearing notify messages when switching views

        document.querySelector("#notify-login").classList.remove("success", "failure");
        document.querySelector("#notify-register").classList.remove("success", "failure");
    });


    // Code input

    let selectInput = document.querySelector("#registration-form #user-type-select");
    let codeInputBox = document.querySelector('#code-box');
    let codeInput = document.querySelector('#code');

    if (!selectInput) console.log('select imput not found good luck fixing it');

    selectInput.addEventListener('change', function (e) {

        codeInput.value = '';

        if (selectInput.value !== 'user') {
            codeInputBox.hidden = false;
            codeInput.placeholder = `Enter ${selectInput.value} Code`;
        }
        else {
            codeInputBox.hidden = true;
            codeInput.placeholder = '';
        }

    });

    // For Authentication 

    const forms = {
        registerForm : '#registration-form',
        loginForm : '#login-form',
    };

    const inputFields = {
        username: '#username',
        email: '#email',
        userType: '#user-type-select',
        code: '#code',
        password: '#password',
        confirmPassword: '#confirm-password',
    };

    function getForm(formId){
        return document.querySelector(formId);
    }

    function getValue(formId , inputId) {
        return document.querySelector(`${formId} ${inputId}`).value.trim();
    }

    function getInputElement(formId , inputId) {
        return document.querySelector(`${formId} ${inputId}`);
    }

    function showErrors(formId , inputId, message) {
        const box = getInputElement(formId , inputId).closest(".input-box");
        box.classList.add("invalid");
        box.querySelector(".error-box").textContent = message;
    }

    function clearErrors(formId , inputId){
        const box = getInputElement(formId , inputId).closest(".input-box");
        box.classList.remove("invalid");
        box.querySelector(".error-box").textContent = '';
    }

    function clearAllErrors() {
        document.querySelectorAll(".input-box").forEach(box => {
            box.classList.remove('invalid');
            const errorBox = box.querySelector('.error-box');
            if (errorBox) errorBox.textContent = '';
        });
    }

    function notify(formId , addClass, message) {
        const box = getForm(formId).querySelector(".notify");
        if (!box) return
        box.classList.add(addClass);
        box.querySelector('span').textContent = message;
    }

    function clearNotify(formId) {
        const box = getForm(formId).querySelector('.notify');
        if (!box) return;
        box.classList.remove('success');
        box.classList.remove('failure');
    }


    let input = getInputElement(forms.registerForm, inputFields.userType);

    console.log('Select Field : ' , input )


    if (getForm(forms.registerForm)) registerUser();
    if (getForm(forms.loginForm)) loginUser();

    async function registerUser() {

        let response = await fetch('index.php?c=auth&a=codes');
        let registrationCodes = await response.json();
        console.log(registrationCodes);

        let usernameField = getInputElement(forms.registerForm, inputFields.username);
        let emailField = getInputElement(forms.registerForm, inputFields.email);

        let usernameCheckPromise = Promise.resolve();
        let emailCheckPromise = Promise.resolve();

        // Real time Username existence Check !!!

        let userTimer;
        usernameField.addEventListener('input', async function(){
            clearTimeout(userTimer);
            
            userTimer = setTimeout(() => {

                usernameCheckPromise = (async () => {
    
                    clearErrors(forms.registerForm, inputFields.username);
                    let username = this.value.trim();
                    if(!username) return;
        
                    const data = {
                        column : 'username',
                        value : username,
                    };
        
                    const response = await fetch('index.php?c=auth&a=checkUser', {
                        method : 'POST',
                        body : JSON.stringify(data),
                        headers : {
                            'Content-Type' : 'application/json'
                        }
                    });

                    const result = await response.json();
                    console.log(result);

                    if(result.exists){
                        showErrors(forms.registerForm, inputFields.username, "Username is already taken");
                        this.dataset.valid = 'false';
                    }
                    else{
                        this.dataset.valid = 'true';
                    }
    
                })();

            }, 600);

        });

        // Real time Email existence Check !!!

        let emailTimer;

        emailField.addEventListener('input', async function(){
            clearTimeout(emailTimer);

            emailTimer = setTimeout(() =>{

                emailCheckPromise = (async() => {

                    clearErrors(forms.registerForm, inputFields.email);
                    let email = this.value.trim();
                    if(!email) return;
        
                    const data = {
                        column : 'email',
                        value : email,
                    };
        
                    const response = await fetch('index.php?c=auth&a=checkUser', {
                        method : 'POST',
                        body : JSON.stringify(data),
                        headers : {
                            'Content-Type' : 'application/json'
                        }
                    });
                    const result = await response.json();
                    console.log(result);
        
                    if(result.exists){
                        showErrors(forms.registerForm, inputFields.email, "Email already exists")
                        this.dataset.valid = 'false';
                    }
                    else{
                        this.dataset.valid = 'true';
                    }
    

                })();
                            
            }, 600);
            
        });

        // Form Submit
        
        let form = getForm(forms.registerForm);
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            clearAllErrors();
            clearNotify(forms.registerForm);

            let errors = {};

            const username = getValue(forms.registerForm ,inputFields.username);
            const email = getValue(forms.registerForm ,inputFields.email);
            const userType = getValue(forms.registerForm ,inputFields.userType);
            const code = getValue(forms.registerForm ,inputFields.code);
            const password = getValue(forms.registerForm ,inputFields.password);
            const confirmPassword = getValue(forms.registerForm ,inputFields.confirmPassword);
            const codeInputElement = getInputElement(forms.registerForm ,inputFields.code)

            if (!username) errors.username = "Enter YOUR username";
            if (!email) errors.email = "Enter your email";
            if (!userType) errors.userType = "Select your user type";
            if (!password) errors.password = "Enter your password";
            if (password && password.length < 8) errors.password = "Password must be atleast 8 characters long";
            if (!confirmPassword) errors.confirmPassword = "Enter confirmed password";
            if (confirmPassword && (confirmPassword != password)) errors.confirmPassword = "Passwords dont match";
            
            if(password && (confirmPassword === password) && password.length < 8){
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

            await Promise.all([usernameCheckPromise, emailCheckPromise]);

            if (usernameField.dataset.valid === "false") {
                errors.username = "Username is already taken";
            }
            if (emailField.dataset.valid === "false") {
                errors.email = "Email already exists";
            }

            for (let key in errors) {
                showErrors(forms.registerForm ,inputFields[key], errors[key]);
            }

            console.log("Error Count :", Object.keys(errors).length);
            console.log("Errors : ", errors);

            if (Object.keys(errors).length === 0) {
                console.log("✅ Form is valid. Proceed to send data.");

                let formData = {
                    username: username,
                    email: email,
                    userType: userType,
                    enteredCode : code,
                    password: password,
                    confirmPassword : confirmPassword,
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
                console.log('Result from PHP : ' , result);
                console.log('Form Data collected from JS : ' , formData);

                if(result.errors){
                    for(let key in result.errors){
                        showErrors(forms.registerForm ,inputFields[key], result.errors[key]);
                    }
                }
                if(result.success){
                    notify(forms.registerForm ,'success', result.success);
                    form.reset();
                }
                if(result.failure){
                    notify(forms.registerForm ,'failure', result.failure);
                    form.reset();
                }

            }




        })

    }

    function loginUser() {

        let form = getForm(forms.loginForm);

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            clearAllErrors();
            clearNotify(forms.loginForm);

            let errors = {};

            const email = getValue(forms.loginForm ,inputFields.email);
            const password = getValue(forms.loginForm ,inputFields.password);
            const userType = getValue(forms.loginForm ,inputFields.userType);

            if (!email) errors.email = "Enter your email";
            if (!password) errors.password = "Enter your password";
            if (!userType) errors.userType = "Enter your user type";

            for (let key in errors) {
                showErrors(forms.loginForm ,inputFields[key], errors[key]);
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

                if(result.errors){
                    for(let key in result.errors){
                        showErrors(forms.loginForm, inputFields[key], result.errors[key]);
                    }
                }

                if (result.success) {
                    notify(forms.loginForm ,"success", result.success);

                    setTimeout(() => {
                    window.location.href = "index.php?c=dashboard&a=index";
                    }, 1500);

                }
                if (result.failure) notify(forms.loginForm ,"failure", result.failure);

            }

        });

    }


}


// old code, the ultimate spaghetti !!



// form.addEventListener("submit", function(e){
//     e.preventDefault();
    
//     let usernameInputElement = document.querySelector("#username");
//     let emailInputElement = document.querySelector("#email");
//     let userTypeInputElement = document.querySelector("#user-type-select");
//     let codeInputElement = document.querySelector("#code");
//     let passwordInputElement = document.querySelector("#password");
//     let confirmPasswordInputElement = document.querySelector("#confirm-password");
    
    
//     let username = document.querySelector("#username").value;
//     let email = document.querySelector("#email").value;
//     let userType = document.querySelector("#user-type-select").value;
//     let code = document.querySelector("#code").value;
//     let password = document.querySelector("#password").value;
//     let confirmPassword = document.querySelector("#confirm-password").value;
//     let errors = {};

//     if(username == "" || username === undefined){
//         usernameInputElement.closest(".input-box").classList.add("invalid");
//         errors.username = usernameInputElement.closest(".input-box").querySelector(".error-box").textContent = "Enter your username!";
//     }
//     else{
//         usernameInputElement.closest(".input-box").classList.remove("invalid");
//     }

//     if(email == "" || email === undefined){
//         emailInputElement.closest(".input-box").classList.add("invalid");
//        errors.email = emailInputElement.closest(".input-box").querySelector(".error-box").textContent = "Enter your email!";

//     }
//     else{
//         emailInputElement.closest(".input-box").classList.remove("invalid");
//     }

//     if(userType == "" || userType === undefined){
//         userTypeInputElement.closest(".input-box").classList.add("invalid");
//        errors.userType = userTypeInputElement.closest(".input-box").querySelector(".error-box").textContent = "Select your user type";

//     }
//     else{
//         userTypeInputElement.closest(".input-box").classList.remove("invalid");
//     }

//     if(password == "" || password === undefined){
//         passwordInputElement.closest(".input-box").classList.add("invalid");
//       errors.password = passwordInputElement.closest(".input-box").querySelector(".error-box").textContent = "Enter your password!";

//     }
//     else{
//         passwordInputElement.closest(".input-box").classList.remove("invalid");
//     }
    
//     if(confirmPassword == "" || confirmPassword === undefined){
//         confirmPasswordInputElement.closest(".input-box").classList.add("invalid");
//         errors.confirmPassword = confirmPasswordInputElement.closest(".input-box").querySelector(".error-box").textContent = "Enter the confirmed Password!";

//     }
//     else if(confirmPassword != password){
//         confirmPasswordInputElement.closest(".input-box").classList.add("invalid");
//         errors.confirmPassword = confirmPasswordInputElement.closest(".input-box").querySelector(".error-box").textContent = "Passwords dont match!";
//     }
//     else{
//         confirmPasswordInputElement.closest(".input-box").classList.remove("invalid");
//     }

//     if (userType !== "" && userType !== undefined) {
//         if ((userType == 'admin' || userType == 'boss') && (!codeInputBox.hidden && code === "")) {
//             codeInputElement.closest(".input-box").classList.add("invalid");
//             errors.code = codeInputElement.closest(".input-box").querySelector(".error-box").textContent = `Enter ${userType} code`;
//         }
//         else if((userType == 'admin') && (!codeInputBox.hidden && code !== "") ){
//             let match = registrationCodes.find(item => item.admin_code === code);
//             if(!match){ 
//             codeInputElement.closest(".input-box").classList.add("invalid");
//             errors.code = codeInputElement.closest(".input-box").querySelector(".error-box").textContent = `Incorrect ${userType} code`;
//             }
//             else{
//             codeInputElement.closest(".input-box").classList.remove("invalid");
//             }
//         }
//         else if((userType == 'boss') && (!codeInputBox.hidden && code !== "") ){
//             let match = registrationCodes.find(item => item.boss_code === code);
//             if(!match){ 
//             codeInputElement.closest(".input-box").classList.add("invalid");
//             errors.code = codeInputElement.closest(".input-box").querySelector(".error-box").textContent = `Incorrect ${userType} code`;
//             }
//             else{
//                 codeInputElement.closest(".input-box").classList.remove("invalid");
//             }
//         }
//         else{
//             codeInputElement.closest(".input-box").classList.remove("invalid");
//         }
//     }

//     console.log(Object.keys(errors).length);
//     console.log(errors);
// });