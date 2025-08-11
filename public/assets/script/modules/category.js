// ./public/assets/script/modules/category.js
export function categor(modalControls) {
    // ======================= Config =======================
    const fields = {
        name: '#name',
    };

    // ======================= Module State =======================
    let categories = [];
    let recordsPerPage = 12;
    let currentPage = 1;
    let totalPages = 1;

    // ======================= DOM Utility =======================
    const $ = (selector) => document.querySelector(selector);
    const $$ = (selector) => document.querySelectorAll(selector);

    const getInputElement = (form, field) => form ? form.querySelector(field) : null;
    const getValue = (form, field) => {
        const element = getInputElement(form, field);
        return element ? element.value.trim() : '';
    };

    // ======================= Validators & Alerts =======================
    function showErrors(form, field, msg) {
        if (!form) return;
        const box = getInputElement(form, field)?.closest('.modal__input-box');
        if (box) {
        box.classList.add('error');
            const errorBox = box.querySelector('span.error-box');
            if (errorBox) errorBox.textContent = msg;
        }
    }

    function clearAllErrors(form) {
        if (!form) return;
        form.querySelectorAll('.modal__input-box').forEach(box => {
            box.classList.remove('error');
            const errorBox = box.querySelector('.error-box');
            if (errorBox) errorBox.textContent = '';
        });
    }

    function showAlert(form, classType, title, msg) {
        if (!form) return;
        const box = form.closest('.modal__body')?.querySelector('.modal__alert');
        if (box) {
        box.className = `modal__alert ${classType}`;
            const titleEl = box.querySelector('.modal__alert-title');
            const msgEl = box.querySelector('.modal__alert-text');
            if (titleEl) titleEl.textContent = title;
            if (msgEl) msgEl.textContent = msg;
        }
    }

    function clearAlert(form) {
        if (!form) return;
        const box = form.closest('.modal__body')?.querySelector('.modal__alert');
        if (box) {
        box.className = `modal__alert hidden`;
            const msgEl = box.querySelector('.modal__alert-text');
            if (msgEl) msgEl.textContent = '';
        }
    }

    // ======================= Reusable API CALLS =======================
    async function checkCategoryExistence(name, id = null) {
        const formData = id ? { id, name } : { name };
        const response = await fetch('index.php?c=category&a=existenceCheck', {
            method: 'POST',
            body: JSON.stringify(formData),
            headers: { 'Content-Type': 'application/json' }
        });
        const result = await response.json();
        return result.exists;
    }

    async function fetchCategories() {
        const url = 'index.php?c=category&a=fetchAll&t=' + Date.now();
        const response = await fetch(url, { method: 'POST' });
        const result = await response.json();
        categories = result.categories || [];
        totalPages = Math.ceil(categories.length / recordsPerPage);       
    }

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
        setupFormHandlers();
        showCategories();
    }

    // ======================= Event Delegation Form Handlers =======================
    function setupFormHandlers() {
        // Handle all form submissions using event delegation
        document.addEventListener('submit', async function(e) {
            const form = e.target;
            const formId = form.id;

            // Handle Add Category Form
            if (formId === 'add-category-form') {
                e.preventDefault();
                await handleAddCategory(form);
            }
            
            // Handle Edit Category Form
            else if (formId === 'edit-category-form') {
                e.preventDefault();
                await handleEditCategory(form);
            }
            
            // Handle Delete Category Form
            else if (formId === 'del-category-form') {
                e.preventDefault();
                await handleDeleteCategory(form);
            }
        });

        // Handle real-time validation for add form
        document.addEventListener('input', function(e) {
            const input = e.target;
            const form = input.closest('form');
            
            if (form && form.id === 'add-category-form' && input.matches('#name')) {
                handleAddFormValidation(input);
            }
            
            if (form && form.id === 'edit-category-form' && input.matches('#name')) {
                handleEditFormValidation(input);
            }
        });
    }

    // ======================= Form Handlers =======================
    
    let addValidationTimer;
    async function handleAddFormValidation(input) {
        clearTimeout(addValidationTimer);
        addValidationTimer = setTimeout(async () => {
            const form = input.closest('form');
            clearAllErrors(form);
            
            const name = input.value.trim();
                if (!name) return;

                const exists = await checkCategoryExistence(name);
            input.dataset.valid = !exists;
            if (exists) showErrors(form, fields.name, 'Category Already Exists');
            }, 1000);
    }

    let editValidationTimer;
    async function handleEditFormValidation(input) {
        clearTimeout(editValidationTimer);
        editValidationTimer = setTimeout(async () => {
            const form = input.closest('form');
            clearAllErrors(form);
            
            const name = input.value.trim();
            if (!name) return;

            const categoryId = form.dataset.editId;
            const exists = await checkCategoryExistence(name, categoryId);
            input.dataset.valid = !exists;
            if (exists) showErrors(form, fields.name, "Category Already Exists");
        }, 1000);
    }

    async function handleAddCategory(form) {
        clearAlert(form);
        clearAllErrors(form);

        const errors = {};
        const name = getValue(form, fields.name);
        const nameElement = getInputElement(form, fields.name);

        if (!name) errors.name = "Enter Category Name";
        
        if (nameElement && nameElement.dataset.valid === 'false') {
            errors.name = "Category Already Exists";
        }
        
        

        for (let key in errors) {
        showErrors(form, fields[key], errors[key]);
        }

        if (Object.keys(errors).length === 0) {
        const formData = { name };
            const response = await fetch('index.php?c=category&a=add', {
                method: 'POST',
                body: JSON.stringify(formData),
            headers: { 'Content-Type': 'application/json' }
            });
            const result = await response.json();

            if (result.errors) {
                for (let key in result.errors) {
                showErrors(form, fields[key], result.errors[key]);
                }
            }
            if (result.success) {
                showAlert(form, 'success', 'Success!', result.success);
                form.reset();
                await fetchCategories();
                showCategories(currentPage);
                modalControls.closeModal(form.closest('.modal'));
            }
            if (result.failure) {
            showAlert(form, 'failure', 'Error', result.failure);
            }
        
        }
    }

    async function handleEditCategory(form) {
        clearAlert(form);
        clearAllErrors(form);

        const errors = {};
        const name = getValue(form, fields.name);
        if (!name) errors.name = "Enter Category";
        
        const nameElement = getInputElement(form, fields.name);
        if (nameElement && nameElement.dataset.valid === 'false') {
            errors.name = "Category Already Exists";
        }

        for (let key in errors) {
            showErrors(form, fields[key], errors[key]);
        }

        if (Object.keys(errors).length === 0) {
            const categoryId = form.dataset.editId;
            const formData = { id: categoryId, name };
            const response = await fetch('index.php?c=category&a=edit', {
                method: 'POST',
                body: JSON.stringify(formData),
                headers: { 'Content-Type': 'application/json' }
            });
            const result = await response.json();

            if (result.errors) {
                for (let key in result.errors) {
                    showErrors(form, fields[key], result.errors[key]);
                }
            }
            if (result.success) {
                showAlert(form, 'success', 'Success!', result.success);
                await fetchCategories();
                showCategories(currentPage);
                modalControls.closeModal(form.closest('.modal'));
            }
            if (result.failure) {
                showAlert(form, 'failure', 'Error', result.failure);
            }
        }
    }

    async function handleDeleteCategory(form) {
        const categoryId = form.dataset.deleteId;
        const response = await fetch('index.php?c=category&a=delete', {
            method: 'POST',
            body: JSON.stringify({ id: categoryId }),
            headers: { 'Content-Type': 'application/json' }
        });
        const result = await response.json();

        if (result.success) {
            await fetchCategories();
            showCategories(currentPage);
            modalControls.closeModal(form.closest('.modal'));
        }
        if (result.failure) {
            console.log(result.failure);
        }
    }

    // ======================= AJAX/FETCH CRUD OPERATIONS =======================
    async function showCategories(page = currentPage) {
        currentPage = page;
        const table = $('.main-content.categories table');
        const tableBody = $('tbody');
        const alert = table.closest('.main-content').querySelector('.alert');
        const pagination = $('.pagination__controls');

       await fetchCategories();

        function render() {
            renderTable();
            renderPagination();
        }

        function renderTable() {
            tableBody.innerHTML = '';
            const start = (currentPage - 1) * recordsPerPage;
            const end = start + recordsPerPage;
            const pageData = categories.slice(start, end);
            let serialNumber = start + 1;

            pageData.forEach(category => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${serialNumber++}</td>
                    <td>${category.category_name}</td>
                    <td class="action">
                        <div class="buttons">
                            <button type="button" class="edit-btn" data-id="${category.id}" data-modal-target="#edit-modal" data-title="Edit Category" data-label="Category" data-placeholder="Enter Category" data-form="edit-category-form">
                         <span>Edit</span>
                        </button>
                            <button type="button" class="del-btn" data-id="${category.id}" data-modal-target="#del-modal" data-title="Delete This Category?" data-message="This Category will be permanently deleted!" data-form="del-category-form">
                            <span>Delete</span>
                        </button>
                        </div>
                    </td>`;
                tableBody.appendChild(tr);
            });

            const rangeStart = categories.length === 0 ? start : start + 1;
            const rangeEnd = Math.min(end, categories.length);
            const summaryEl = $('.pagination__summary');
            if (summaryEl) {
                const pEl = summaryEl.querySelector('p');
                if (pEl) pEl.textContent = `Showing ${rangeStart} - ${rangeEnd} of ${categories.length}`;
            }

            if (table) table.classList.toggle('de-active', categories.length === 0);
            const paginationEl = $('.pagination');
            if (paginationEl) paginationEl.classList.toggle('de-active', categories.length === 0);
            if (alert) alert.classList.toggle('active', categories.length === 0);

            attachListener();
        }

        function renderPagination() {
            if (!pagination) return;
            pagination.innerHTML = '';
            const ul = document.createElement('ul');

            const createArrows = (isPrev) => {
                const li = document.createElement('li');
                const a = document.createElement('a');
                a.innerHTML = `<i class='bx bx-chevron-${isPrev ? 'left' : 'right'}'></i>`;
                if ((isPrev && currentPage === 1) || (!isPrev && currentPage === totalPages)) {
                    a.style.pointerEvents = 'none';
                    a.style.opacity = 0.5;
                } else {
                    a.addEventListener('click', () => {
                        currentPage += isPrev ? -1 : 1;
                        render();
                    });
                }
                li.appendChild(a);
                return li;
            };

            ul.appendChild(createArrows(true));

            const pages = paginationDesign(currentPage, totalPages);
            pages.forEach(page => {
                const li = document.createElement('li');
                if (page === '...') {
                    const p = document.createElement('p');
                    p.textContent = page;
                    li.appendChild(p);
                } else {
                    const a = document.createElement('a');
                    a.textContent = page;
                    if (page === currentPage) li.classList.add('active');
                    a.addEventListener('click', () => {
                        currentPage = page;
                        render();
                    });
                    li.appendChild(a);

                }
                ul.appendChild(li);
            });

            ul.appendChild(createArrows(false));
            pagination.appendChild(ul);
        }

        function paginationDesign(currentPage, totalPages) {
            let pages = [];
            if (totalPages <= 7) {
                for (let i = 1; i <= totalPages; i++) pages.push(i);
            } else {
                if (currentPage <= 3) {
                    pages.push(1, 2, 3, 4, 5, '...', totalPages);
                } else if (currentPage >= totalPages - 3) {
                    pages.push(1, '...', totalPages - 4, totalPages - 3, totalPages - 2, totalPages - 1, totalPages);
                } else {
                    pages.push(1, '...', currentPage - 1, currentPage, currentPage + 1, '...', totalPages);
                }
            }
            return pages;
        }

        render();
    }

    async function loadCategoriesToEdit(id) {
        const response = await fetch('index.php?c=category&a=populate', {
            method: 'POST',
            body: JSON.stringify(id),
            headers: { 'Content-Type': 'application/json' }
        });
        const result = await response.json();

        // Wait for modal to be created and form to be available
        const checkForm = () => {
            const form = document.getElementById('edit-category-form');
            if (!form) {
                setTimeout(checkForm, 100);
                return;
            }

            const nameElement = getInputElement(form, fields.name);
            if (!nameElement) return;
            
            nameElement.value = result.category_name.trim();
            form.dataset.editId = id;
        };
        checkForm();
    }

    function deleteCategory(id) {
        const checkForm = () => {
            const form = document.getElementById('del-category-form');
            if (!form) {
                setTimeout(checkForm, 100);
                return;
            }
            form.dataset.deleteId = id;
        };
        checkForm();
    }

    startCategoryModule();
} 