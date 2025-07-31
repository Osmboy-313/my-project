// export function category() {

//     showCategory();

//     // All id's and errors functions just for ease !

//     let forms = {
//         addForm: '#add-category-form',
//         editForm: '#edit-category-form',
//         deleteForm: '#del-category-form',
//     };

//     let inputFields = {
//         name: '#name',
//     };

//     function getForm(formId) {
//         return document.querySelector(formId);
//     }

//     function getElement(formId, inputId) {
//         return document.querySelector(`${formId} ${inputId}`);
//     }

//     function getValue(formId, inputId) {
//         return document.querySelector(`${formId} ${inputId}`).value.trim();
//     }

//     function showErrors(formId, inputId, message) {
//         const box = getElement(formId, inputId).closest(".input-box");
//         box.classList.add('error');
//         box.querySelector('span.error-box').textContent = message;
//     }

//     function clearAllErrors() {
//         document.querySelectorAll('.input-box').forEach(box => {
//             box.classList.remove('error');
//             const errorBox = box.querySelector('.error-box');
//             if (errorBox) errorBox.textContent = '';
//         });
//     }

//     function alert(formId, addclass, message) {
//         const box = getForm(formId).closest('.modal-body').querySelector('.alert');
//         box.classList.add(addclass);
//         box.querySelector('span').textContent = message;
//     }

//     function clearAlert(formId) {
//         const box = getForm(formId).closest('.modal-body').querySelector('.alert');
//         box.classList.remove('success', 'failure');
//         box.querySelector('span').textContent = '';
//     }

//     // Attaching event listener to each button created dynamically through js inside he table


//     function attach() {

//         document.querySelectorAll('.edit-btn').forEach(button => {
//             button.addEventListener('click', function () {
//                 const id = this.dataset.id;
//                 editCategory(id)
//             });
//         });

//     }


//     // Crud Functions for category

//     function addCategory() {

//         clearAllErrors();
//         clearAlert(forms.addForm);

//         // Real Time category existence check for current user only
//         let nameCheckPromise = Promise.resolve();
//         const nameElement = getElement(forms.addForm, inputFields.name);
//         let nameTimer = '';

//         nameElement.addEventListener('input', function (e) {

//             clearTimeout(nameTimer);

//             nameTimer = setTimeout(() => {

//                 nameCheckPromise = (async () => {

//                     clearAllErrors();
//                     const name = this.value.trim();
//                     if (!name) return;
//                     console.log(name)

//                     const formData = {
//                         name: name
//                     }

//                     const resposne = await fetch('index.php?c=category&a=existenceCheck', {
//                         method: 'POST',
//                         body: JSON.stringify(formData),
//                         headers: {
//                             'Content-Type': 'application/json'
//                         }
//                     });

//                     const result = await resposne.json();

//                     console.log('PHP real time response : ', result);

//                     if (result.exists) {
//                         showErrors(forms.addForm, inputFields.name, "Category Already Exists")
//                         this.dataset.valid = 'false';
//                     }
//                     else {
//                         this.dataset.valid = 'true';
//                     }

//                 })();

//             }, 1000);

//         });

//         // on submit validation and sanitization

//         let form = getForm(forms.addForm);

//         form.addEventListener('submit', async function (e) {
//             e.preventDefault();
//             clearAllErrors();
//             clearAlert(forms.addForm);

//             let errors = {};

//             const name = getValue(forms.addForm, inputFields.name);

//             if (!name) errors.name = "Enter your category name!";

//             await Promise.all([nameCheckPromise]);

//             if (nameElement.dataset.valid === 'false') errors.name = "Category Already Exists!";

//             for (let key in errors) {
//                 showErrors(forms.addForm, inputFields[key], errors[key]);
//             }

//             console.log('Error Count : ', Object.keys(errors).length)
//             console.log('Errors themselves : ', errors);

//             if (Object.keys(errors).length === 0) {

//                 let formData = {
//                     name: name,
//                 };

//                 console.log('collected data from Js : ', formData);

//                 const response = await fetch('index.php?c=category&a=add', {
//                     method: 'POST',
//                     body: JSON.stringify(formData),
//                     headers: {
//                         'Content-Type': 'application/json'
//                     }
//                 });
//                 const result = await response.json();
//                 console.log(result);

//                 if (result.errors) {
//                     for (let key in result.errors) {
//                         showErrors(forms.addForm, inputFields[key], result.errors[key])
//                     }
//                 }
//                 if (result.success) {
//                     alert(forms.addForm, 'success', result.success);
//                     form.reset();
//                     showCategory();
//                 }
//                 if (result.failure) alert(forms.addForm, 'failure', result.failure);

//             }

//         })

//     }
//     addCategory();


//     async function showCategory() {

//         const response = await fetch('index.php?c=category&a=fetchAll', {
//             method: 'POST'
//         });
//         const result = await response.json();
//         console.log(result.categories);

//         let categories = result.categories;
//         let table = document.querySelector('table')
//         let tableBody = document.querySelector('tbody');
//         let alert = table.closest('.main-content').querySelector('.alert');

//         let pagination = document.querySelector('.pagination__controls');
//         let recordsPerPage = 12;
//         let currentPage = 1;
//         let totalPages = Math.ceil(categories.length / recordsPerPage);

//         if (categories && categories.length > 0) {

//             alert.classList.remove('active');

//             function renderTable(page) {

//                 tableBody.innerHTML = '';
//                 let start = (page - 1) * recordsPerPage;
//                 let end = start + recordsPerPage;
//                 let serialNumber = start + 1;
//                 let pageData = categories.slice(start, end);

//                 pageData.forEach(category => {

//                     let tr = document.createElement('tr');
//                     tr.innerHTML = `
                    
//                         <td>${serialNumber++}</td>
//                         <td>${category.category_name}</td>
//                         <td class="action">
//                             <div class="buttons">

//                             <button type="button" data-modal-target="#edit-modal" class="edit-btn" data-id='${category.id}'>
//                              <span>Edit</span>
//                             </button>

//                             <button type="button" data-modal-target="#del-modal" class="del-btn" data-id='${category.id}'>
//                                 <span>Delete</span>
//                             </button>

//                             </div>
//                         </td>

//                     `;

//                     tableBody.appendChild(tr);
//                 });

//                 let rangeStart = start + 1;
//                 let rangeEnd = Math.min(end, categories.length);

//                 document.querySelector("#range-start").textContent = rangeStart;
//                 document.querySelector("#range-end").textContent = rangeEnd;
//                 document.querySelector("#total-records").textContent = categories.length;

//                 // Now each newly created button will call the edit function using this helper function with it's id as argument

//                 attach();

//             }

//             function renderPagination() {

//                 pagination.innerHTML = '';

//                 let ul = document.createElement('ul');


//                 let prevLi = document.createElement('li');
//                 let prevA = document.createElement('a');

//                 prevA.innerHTML = `<i class='bx bx-chevron-left' ></i>`;

//                 if (currentPage === 1) {
//                     // prevLi.style.pointerEvents = 'none';
//                     prevA.style.pointerEvents = 'none';
//                     prevA.style.opacity = 0.5;
//                 }
//                 else {
//                     prevA.addEventListener('click', function () {
//                         currentPage--;
//                         renderTable(currentPage);
//                         renderPagination();
//                     });
//                 }
//                 prevLi.appendChild(prevA);
//                 ul.append(prevLi);


//                 // let lastPage = totalPages;

//                 // for(let i = 1 ; i <= totalPages ; i++){

//                 //     if(i === 1 || (i >= 1 & i<= 5 && currentPage < 4) ||(i >= currentPage - 1 && i <= currentPage + 1) || i == lastPage){

//                 //         let li = document.createElement('li');
//                 //         let a = document.createElement('a');

//                 //         a.textContent = i;

//                 //         if(i === currentPage){
//                 //             li.classList.add('active');
//                 //         }
//                 //         a.addEventListener('click', function(){
//                 //             currentPage = i;
//                 //             renderTable(currentPage);
//                 //             renderPagination();
//                 //         })

//                 //         li.appendChild(a);
//                 //         ul.appendChild(li);

//                 //     }
//                 //     else if(i === currentPage - 2 && currentPage > 3 || i === currentPage + 2 && currentPage < totalPages - 2){
//                 //         const p = document.createElement('p');
//                 //         p.textContent = '.....';
//                 //         ul.appendChild(p);
//                 //     }

//                 // }

//                 let showPages = [];

//                 if (totalPages <= 7) {
//                     for (let i = 1; i <= totalPages; i++) showPages.push(i);
//                 }
//                 else {
//                     if (currentPage <= 3) {
//                         showPages.push(1, 2, 3, 4, 5, '...', totalPages);
//                     }
//                     else if (currentPage >= totalPages - 3) {
//                         showPages.push(1, '...', totalPages - 4, totalPages - 3, totalPages - 2, totalPages - 1, totalPages);
//                     }
//                     else {
//                         showPages.push(1, '...', currentPage - 1, currentPage, currentPage + 1, '...', totalPages);
//                     }
//                 }

//                 showPages.forEach(page => {
//                     let li = document.createElement('li');

//                     if (page === '...') {
//                         let p = document.createElement('p');
//                         p.textContent = page;
//                         li.appendChild(p);
//                     }
//                     else {
//                         let a = document.createElement('a');
//                         a.textContent = page;

//                         if (page === currentPage) {
//                             li.classList.add('active');
//                         }

//                         a.addEventListener('click', () => {
//                             currentPage = page;
//                             renderTable(currentPage);
//                             renderPagination();
//                         })

//                         li.appendChild(a);

//                     }

//                     ul.appendChild(li);

//                 })

//                 let nextLi = document.createElement('li');
//                 let nextA = document.createElement('a');

//                 nextA.innerHTML = `<i class='bx bx-chevron-right'></i>`;

//                 if (currentPage === totalPages) {
//                     nextA.style.pointerEvents = 'none';
//                     nextA.style.opacity = 0.5;
//                 }
//                 else {
//                     nextA.addEventListener('click', function () {
//                         currentPage++;
//                         renderTable(currentPage);
//                         renderPagination();
//                     });
//                 }

//                 nextLi.appendChild(nextA);
//                 ul.appendChild(nextLi);

//                 pagination.append(ul);

//             }
//             renderTable(currentPage);
//             renderPagination();


//         } else {
//             table.style.display = 'none';
//             alert.classList.add('.active');
//             // alert.querySelector('span').textContent = 'No Record Found';
//         }


//     }

//     async function editCategory(id) {
//         console.log(id);
//         clearAllErrors();
//         clearAlert(forms.editForm);

//         const response = await fetch('index.php?c=category&a=populate', {
//             method: 'POST',
//             body: JSON.stringify(id),
//             headers: {
//                 'Content-Type': 'application/json'
//             }
//         });
//         const result = await response.json();

//         console.log('response : ', result);

//         const nameElement = getElement(forms.editForm, inputFields.name);
//         nameElement.value = '';
//         nameElement.value = result.category_name;

//         // Real time category name check but leaving the current/existing one
//         let nameEditCheckPromise = Promise.resolve();
//         let nameElementTimer = '';

//         nameElement.addEventListener('input', function () {

//             clearTimeout(nameElementTimer);
//             clearAllErrors();

//             nameElementTimer = setTimeout(() => {

//                 nameEditCheckPromise = (async () => {

//                     const name = this.value.trim();
//                     if (!name) return;

//                     const formData = {
//                         id: id,
//                         name: name
//                     };

//                     const response = await fetch('index.php?c=category&a=existenceCheck', {
//                         method: 'POST',
//                         body: JSON.stringify(formData),
//                         headers: {
//                             'Content-Type': 'application/json'
//                         }
//                     })
//                     const result = await response.json();
//                     console.log('RESPONSE FROM PHP IN EDIT FORM : ', result);

//                     if (result.exists) {
//                         showErrors(forms.editForm, inputFields.name, "Category Already Exists!")
//                         this.dataset.valid = 'false';
//                     }
//                     else {
//                         this.dataset.valid = 'true';
//                     }

//                 })();

//             }, 1000)
//         })

//         // On submit validation

//         let form = getForm(forms.editForm);
//         form.addEventListener('submit', async function (e) {
//             e.preventDefault();
//             clearAlert(forms.editForm);
//             clearAllErrors();

//             let errors = {};
//             const name = getValue(forms.editForm, inputFields.name);

//             if (!name) errors.name = "Enter category name";

//             await Promise.all([nameEditCheckPromise]);

//             if (nameElement.dataset.valid === 'false') errors.name = "Category Already Exists!";


//             for (let key in errors) {
//                 showErrors(forms.editForm, inputFields[key], errors[key]);
//             }

//             if (Object.keys(errors).length === 0) {
//                 console.log('form is okay for submitting');

//                 let formData = {
//                     id: id,
//                     name: name
//                 };

//                 const response = await fetch('index.php?c=category&a=edit', {
//                     method: 'POST',
//                     body: JSON.stringify(formData),
//                     headers: {
//                         'Content-Type': 'application/json'
//                     }
//                 })
//                 const result = await response.json();
//                 console.log("data recieved in php : ", result);

//                 if (result.errors) {
//                     for (let key in result.errors) {
//                         showErrors(forms.editForm, inputFields[key], result.errors[key]);
//                     }
//                 }
//                 if (result.success) {
//                     alert(forms.editForm, 'success', result.success);
//                     showCategory();
//                 }
//                 if (result.failure) alert(forms.editForm, 'failure', result.failure);


//             }

//         })

//     }

// }


export function categor(modalControls) {

    // ======================= Config =======================

    const forms = {
        add: '#add-category-form',
        edit: '#edit-category-form',
        delete: '#del-category-form',
    };

    const fields = {
        name: '#name',
    };


    // ======================= Module State =======================

    let categories = [];
    let recordsPerPage = 12;
    let currentPage = 1; // Now module-level variable
    let totalPages = 1;

    // ======================= DOM Utility =======================

    let $ = (selector) => document.querySelector(selector);
    let $$ = (selector) => document.querySelectorAll(selector);

    const getForm = (formKey) => $(forms[formKey]);
    const getInputElement = (formKey, field) => $(`${forms[formKey]} ${field}`);
    const getValue = (formKey, field) => getInputElement(formKey, field).value.trim();

    // ======================= Validators & Alerts =======================

    function showErrors(formKey, field, msg) {
        const box = getInputElement(formKey, field).closest('.modal__input-box');
        box.classList.add('error');
        box.querySelector('span.error-box').textContent = msg;
    }

    function clearAllErrors() {
        $$('.modal__input-box').forEach(box => {
            box.classList.remove('error');
            const errorBox = box.querySelector('.error-box');
            if (errorBox) errorBox.textContent = '';
        });
    }

    function showAlert(formKey, classType, title , msg) {
        const box = getForm(formKey).closest('.modal__body').querySelector('.modal__alert');
        box.className = `modal__alert ${classType}`;
        box.querySelector('.modal__alert-title').textContent = title;
        box.querySelector('.modal__alert-text').textContent = msg;
    }

    function clearAlert(formKey) {
        const box = getForm(formKey).closest('.modal__body').querySelector('.modal__alert');
        box.className = `modal__alert hidden`;
        box.querySelector('.modal__alert-text').textContent = '';
    }


    // ======================= Reusable API CALLS =======================

    // * ------------- Real time Existence Check Helper Function ------------- *

    async function checkCategoryExistence(name, id = null) {

        const formData = id ? { id, name } : { name };

        const response = await fetch('index.php?c=category&a=existenceCheck', {
            method: 'POST',
            body: JSON.stringify(formData),
            headers: {
                'Content-Type': 'application/json'
            }
        });

        const result = await response.json();
        return result.exists;
    }

    // * ------------- Real Time Records Fetching Helper Function ------------- *

    async function fetchCategories() {

        const url = 'index.php?c=category&a=fetchAll&t=' + Date.now();

        const response = await fetch(url, {
            method: 'POST'
        });
        const result = await response.json();
        console.log('Categories from DB : ', result.categories);

        categories = result.categories || [];
        totalPages = Math.ceil(categories.length / recordsPerPage);       

    }

    // * ------------- Attach Listener to each button in the record ------------- *

    //!  why on onlick instead of addevenlistener is bcz the function will call each time I click edit or del btn creating multiple listeners without removing any so if I edit two records in a fresh page, then if I edit another then the previous two will also be edited and will become the same as the one I just edited, whereas onclick always replaces or overwrites the previous listeners, hence fixing the main problemo !

    function attachListener() {

        $$('.edit-btn').forEach(button => {
            button.onclick = () => loadCategoriesToEdit(button.dataset.id);
        });
        $$('.del-btn').forEach(button => {
            button.onclick = () => deleteCategory(button.dataset.id);
        });
    }

    // ======================= Start Up =======================

    function startCategoryModule() {
        addCategory();
        showCategories();
    }

    // ======================= AJAX/FETCH CRUD OPERATIONS =======================

    // * ------------- Add Category ------------- *

    function addCategory() {


        let formKey = 'add';
        let nameTimer, valid = false;
        let nameElement = getInputElement(formKey, fields.name);

        clearAlert(formKey);
        clearAllErrors();

        nameElement.addEventListener('input', () => {
            clearTimeout(nameTimer);

            nameTimer = setTimeout(async () => {

                clearAllErrors();
                const name = nameElement.value.trim();
                if (!name) return;

                const exists = await checkCategoryExistence(name);
                const valid = !exists;
                console.log('checkCategoryExistence returned value', exists, '  not exists -- valid  :  ', valid)
                nameElement.dataset.valid = valid;
                if (!valid) showErrors(formKey, fields.name, 'Category Already Exists');
            }, 1000);

        });

        let form = getForm(formKey);
        form.addEventListener('submit', async function (e) {
            e.preventDefault();
            clearAlert(formKey);
            clearAllErrors();

            const errors = {};

            const name = getValue(formKey, fields.name);
            if (!name) errors.name = "Enter Category Name";
            if (nameElement.dataset.valid === 'false') errors.name = "Category Already Exists"

            for (let key in errors) {
                showErrors(formKey, fields[key], errors[key]);

            }

            console.log('error count : ', Object.keys(errors).length);
            console.log("real errors : ", errors)

            if (Object.keys(errors).length === 0) {
                console.log("form is ready to be submitted")

                const formData = {
                    name: name
                };

                const response = await fetch('index.php?c=category&a=add', {
                    method: 'POST',
                    body: JSON.stringify(formData),
                    headers:
                        { 'Content-Type': 'application/json' },
                });
                const result = await response.json();
                console.log(result);

                if (result.errors) {
                    for (let key in result.errors) {
                        showErrors(formKey, fields[key], result.errors[key]);
                    }
                }
                if (result.success) {
                    showAlert(formKey, 'success', 'Success!' , result.success);
                    form.reset();
                    fetchCategories();
                    showCategories(currentPage);
                }
                if (result.failure) {
                    showAlert(formKey, 'failure', result.failure);
                }

            }
        });

    }

    // * ------------- Show Categories ------------- *



    async function showCategories(page = currentPage) {

        currentPage = page;

        let table = $('.main-content.categories table');
        let tableBody = $('tbody');
        let alert = table.closest('.main-content').querySelector('.alert');
        let pagination = $('.pagination__controls');

       await fetchCategories();

        function render() {
            renderTable();
            renderPagination();
        }

        // Render Table function :

        function renderTable() {

            tableBody.innerHTML = '';
            let start = (currentPage - 1) * recordsPerPage;
            let end = start + recordsPerPage;
            let pageData = categories.slice(start, end);

            let serialNumber = start + 1;

            pageData.forEach(category => {

                let tr = document.createElement('tr');
                tr.innerHTML = `
                
                    <td>${serialNumber++}</td>
                    <td>${category.category_name}</td>
                    <td class="action">
                        <div class="buttons">
    
                        <button type="button" data-modal-target="#edit-modal" class="edit-btn" data-id='${category.id}'>
                         <span>Edit</span>
                        </button>
    
                        <button type="button" data-modal-target="#del-modal" class="del-btn" data-id='${category.id}'>
                            <span>Delete</span>
                        </button>
    
                        </div>
                    </td>
    
                `;

                tableBody.appendChild(tr);
            });

            let rangeStart = categories.length === 0 ? start : start + 1 ;
            let rangeEnd = Math.min(end, categories.length);

            $('.pagination__summary').querySelector('p').textContent = `Showing ${rangeStart} - ${rangeEnd} of ${categories.length} ` ;

            
            table.classList.toggle('de-active', categories.length === 0);
            $('.pagination').classList.toggle('de-active', categories.length === 0);
            alert.classList.toggle('active', categories.length === 0);

            attachListener();

        }

        // Render Pagination Function

        function renderPagination() {

            pagination.innerHTML = '';

            let ul = document.createElement('ul');

            const createArrows = (isPrev) => {

                let li = document.createElement('li');
                let a = document.createElement('a');
                a.innerHTML = `<i class='bx bx-chevron-${isPrev ? 'left' : 'right'}'></i>`;

                if ((isPrev && currentPage === 1) || (!isPrev && currentPage === totalPages)) {
                    a.style.pointerEvents = 'none';
                    a.style.opacity = 0.5;
                }
                else {
                    a.addEventListener('click', () => {
                        currentPage += isPrev ? -1 : 1;
                        render();
                    });
                }

                li.appendChild(a);
                return li;
            }
            // For previous Arrow
            ul.appendChild(createArrows(true));

            // Page Numbers between the previous and next Arrows 

            function paginationDesign(currentPage, totalPages) {

                let pages = [];

                if (totalPages <= 7) {
                    for (let i = 1; i <= totalPages; i++) pages.push(i);
                }
                else {
                    if (currentPage <= 3) {
                        pages.push(1, 2, 3, 4, 5, '...', totalPages);
                    }
                    else if (currentPage >= totalPages - 3) {
                        pages.push(1, '...', totalPages - 4, totalPages - 3, totalPages - 2, totalPages - 1, totalPages);
                    }
                    else {
                        pages.push(1, '...', currentPage - 1, currentPage, currentPage + 1, '...', totalPages);
                    }
                }

                return pages;

            }

            const pages = paginationDesign(currentPage, totalPages);

            pages.forEach(page => {
                let li = document.createElement('li');

                if (page === '...') {
                    let p = document.createElement('p');
                    p.textContent = page;
                    li.appendChild(p);
                }
                else {
                    let a = document.createElement('a');
                    a.textContent = page;

                    if (page === currentPage) {
                        li.classList.add('active');
                    }

                    a.addEventListener('click', () => {
                        currentPage = page;
                        render();
                    })

                    li.appendChild(a);

                }

                ul.appendChild(li);

            });

            // For next Arrow
            ul.appendChild(createArrows(false));

            pagination.appendChild(ul);

        }

        render();

    }


    // * ------------- Edit Categories ------------- *

    async function loadCategoriesToEdit(id) {

        const formKey = 'edit';
        clearAlert(formKey);
        clearAllErrors();

        const response = await fetch('index.php?c=category&a=populate', {
            method: 'POST',
            body: JSON.stringify(id),
            headers: {
                'Content-Type': 'application/json'
            }
        });
        const result = await response.json();
        console.log('starting point !');
        console.log('response : ', result);
        console.log('Id of the clicked recored : ', id);


        let nameElement = getInputElement(formKey, fields.name);
        nameElement.value = result.category_name.trim();

        let timer;

        nameElement.oninput = () => {
            clearTimeout(timer);
            clearAlert(formKey);
            const Id = id;

            timer = setTimeout(async () => {
                clearAllErrors();
                const name = nameElement.value.trim();
                if (!name) return;

                const exists = await checkCategoryExistence(name, id)
                const valid = !exists;
                nameElement.dataset.valid = valid;
                console.log('const id : ', id, ' && exists : ', exists, ' Is it valid to go : ', valid);
                if (!valid) showErrors(formKey, fields.name, "Category Already Exists");
            }, 1000)
        }

        const form = getForm(formKey);
        form.onsubmit = async (e) => {
            e.preventDefault();
            clearAlert(formKey);
            clearAllErrors();

            const errors = {};

            const name = getValue(formKey, fields.name);

            if (!name) errors.name = "Enter Category";
            if (nameElement.dataset.valid === 'false') errors.name = "Category Already Exists";

            for (let key in errors) {
                showErrors(formKey, fields[key], errors[key]);
            }

            console.log("error Count : ", Object.keys(errors).length);
            console.log('actual errors : ', errors)

            if (Object.keys(errors).length === 0) {
                console.log('Form is okay to be submitted');

                let formData = {
                    id: id,
                    name: name
                };

                const response = await fetch('index.php?c=category&a=edit', {
                    method: 'POST',
                    body: JSON.stringify(formData),
                    headers: {
                        'Content-Type': 'application/json'
                    }
                })
                const result = await response.json();
                console.log("data recieved in php : ", result);

                if (result.errors) {
                    for (let key in result.errors) {
                        showErrors(formKey, fields[key], result.errors[key]);
                    }
                }
                if (result.success) {
                    showAlert(formKey, 'success', result.success);
                    fetchCategories();
                    showCategories(currentPage);
                }
                if (result.failure) {
                    showAlert(formKey, 'failure', result.success);
                }

            }

        };

    }

    // * ------------- Delete Categories ------------- *

    function deleteCategory(id) {

        const formKey = 'delete';
        const form = getForm(formKey);

        form.dataset.deleteId = id;

        console.log('DELETE ID BEFORE THE FORM IS SUBMITTED : ', form.dataset.deleteId)

        form.onsubmit = async (e) => {
            e.preventDefault();

            const id = form.dataset.deleteId;
            console.log('id for category to delete : ', id);

            const response = await fetch('index.php?c=category&a=delete', {
                method: 'POST',
                body: JSON.stringify({ id: id }),
                headers: {
                    'Content-Type': 'application/json'
                }
            });

            const result = await response.json();

            console.log('ID FOR DELETING A CATEGORY RECIEVED BY PHP : ', result);

            if (result.success) {
                await fetchCategories();
                showCategories(currentPage);
                const modal = getForm(formKey).closest('.modal');
                modalControls.closeModal(modal);
            }
            if (result.failure) {
                console.log(result.failure);
            }

        }

    }

    startCategoryModule();

} 