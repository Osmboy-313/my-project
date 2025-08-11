
export async function profile(){

    const inputFields = {
        username: '#username',
        email: '#email',
        userType: '#user-type-select',
        code: '#code',
    };
    
    function getElement(id) {
        return document.querySelector(id);
    }
    
    function getValue(id) {
        return document.querySelector(id).value.trim();
    }
    
    function showErrors(id, message) {
        const box = getElement(id).closest('.input-box');
        box.classList.add('error');
        box.querySelector("span").textContent = message;
    }
    
    function clearErrors() {
        document.querySelectorAll(".input-box").forEach(box => {
            box.classList.remove('error');
            const errorBox = box.querySelector('span');
            if (errorBox) errorBox.textContent = '';
        });
    }
    
    let response = await fetch('index.php?c=profile&a=get', {
        method : 'POST',
    });
    let result = await response.json();

    console.log(result);
    
    function showProfile() {
    
        let username = getElement(inputFields.username);
        let email = getElement(inputFields.email);
        let userType = getElement(inputFields.userType);
    
        username.value = result.username;
        email.value = result.email;
        userType.value = result.user_type;
    
    
        let codeInput = getElement(inputFields.code);
        let codeInputBox = getElement(inputFields.code).parentElement;
        let codeInputLabel = codeInputBox.querySelector('label');
    
    
    
        userType.addEventListener('change', function (e) {
            clearErrors();
    
            let selectedRole = getValue(inputFields.userType);
            let currentRole = result.user_type;
            let isSameRole = selectedRole == currentRole;
            let isUserRole = selectedRole == 'user';
    
            if (!isSameRole && !isUserRole) {
                codeInputBox.classList.remove('hidden');
                codeInput.placeholder = `Enter ${selectedRole} Code`;
                codeInputLabel.textContent = `${selectedRole} Code`;
            }
            else {
                codeInputBox.classList.add('hidden');
            }
    
        });
    
    }
    
    async function updateRole() {
    
        let roleUpdateForm = document.querySelector('#role-update-form');
        let response = await fetch('index.php?c=code&a=get', {
            method : 'POST',
        });
        let codes = await response.json();
    
        roleUpdateForm.addEventListener('submit', async function (e) {
            e.preventDefault();
            clearErrors();
    
            let errors = {}
    
            let selectedRole = getValue(inputFields.userType);
            let currentRole = result.user_type;
            let isSameRole = selectedRole == currentRole;
    
            let enteredCode = getValue(inputFields.code);
            console.log('Entered Code',enteredCode)
    
            if (isSameRole) errors.userType = `You're Already ${currentRole} baby !`;
    
            if (!isSameRole) {

                if(!enteredCode) errors.code = 'Enter Code !';
    
                let match = codes.find(eachCode =>
                    selectedRole === 'admin' ? eachCode.admin_code == enteredCode : eachCode.boss_code === enteredCode
                );
    
                if (enteredCode && !match) errors.code = `Incorrect ${selectedRole} code`;
    
            }
    
    
            for (let key in errors) {
                showErrors(inputFields[key], errors[key]);
            }
    
            console.log('Number of errors : ', Object.keys(errors).length);
    
            if (Object.keys(errors).length === 0) {
    
                // here I will sent data to handlers and update the ROLE ;) hehe finally
    
            }
    
    
        });
    
    }

    showProfile();
    updateRole();

}




