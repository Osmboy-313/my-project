// export function openCloseModal() {

//     let openModalBtn = document.querySelectorAll("[data-modal-target]");
//     let closeModalBtn = document.querySelectorAll("[data-modal-close]");
//     let overlay = document.querySelector("#overlay");

//     if (!openModalBtn) return;
//     if (!closeModalBtn) return;
//     if (!overlay) return;

//     document.addEventListener('click', (e) => {

//         const openBtn = e.target.closest('[data-modal-target]');
//         const closeBtn = e.target.closest('[data-modal-close]');
        
//         if(openBtn){
//             e.preventDefault();
//             const modal = document.querySelector(openBtn.dataset.modalTarget);
//             openModal(modal);
//         }

//         if(closeBtn){
//             e.preventDefault();
//             const modal = closeBtn.closest('.modal');
//             closeModal(modal);
//         }


//     })

//     // openModalBtn.forEach(button => {
//     //     button.addEventListener("click", (e) => {
//     //         e.preventDefault();
//     //         const modal = document.querySelector(button.dataset.modalTarget);
//     //         openModal(modal);
//     //     });
//     // });


//     // closeModalBtn.forEach(button => {
//     //     button.addEventListener("click", () => {
//     //         const modal = button.closest('.modal');
//     //         closeModal(modal);
//     //     });
//     // });

//     overlay.addEventListener('click', () => {

//         const modals = document.querySelectorAll('.modal.active');
//         modals.forEach(modal => {
//             closeModal(modal);
//         });
//     })

//     function openModal(modal) {

//         if (modal == null) return;

//         modal.classList.add('active');
//         overlay.classList.add('active');
//     }

//     function closeModal(modal) {
        
//         if (modal == null) return

//         modal.classList.remove('active');
//         overlay.classList.remove('active');
//     }

//     return { closeModal };

// }

export function openCloseModal() {
    const overlay = document.querySelector("#overlay");

    if (!overlay) return;

    document.addEventListener('click', (e) => {
        const openBtn = e.target.closest('[data-modal-target]');
        const closeBtn = e.target.closest('[data-modal-close]');

        // Open modal
        if (openBtn) {
            e.preventDefault();
            const modal = document.querySelector(openBtn.dataset.modalTarget);
            if (!modal) return;

            // Inject dynamic content
            if (openBtn.dataset.title) {
                const titleEl = modal.querySelector('.modal__message-title');
                if (titleEl) titleEl.innerText = openBtn.dataset.title;
            }

            if (openBtn.dataset.label) {
                const label = modal.querySelector('label');
                if (label) label.innerText = openBtn.dataset.label;
            }

            if (openBtn.dataset.placeholder) {
                const input = modal.querySelector('input[type="text"]');
                if (input) input.placeholder = openBtn.dataset.placeholder;
            }

            if (openBtn.dataset.message) {
                const msg = modal.querySelector('.modal__message-text');
                if (msg) msg.innerText = openBtn.dataset.message;
            }

            if (openBtn.dataset.form) {
                const form = modal.querySelector('form');
                if (form) form.id = openBtn.dataset.form;
            }

            // Clear input and errors
            const inputs = modal.querySelectorAll('input[type="text"]');
            inputs.forEach(input => {
                input.value = '';
            });

            // Clear any existing errors
            const errorBoxes = modal.querySelectorAll('.modal__input-box');
            errorBoxes.forEach(box => {
                box.classList.remove('error');
                const errorBox = box.querySelector('.error-box');
                if (errorBox) errorBox.textContent = '';
            });

            // Clear alerts
            const alerts = modal.querySelectorAll('.modal__alert');
            alerts.forEach(alert => {
                alert.className = 'modal__alert hidden';
            });

            modal.classList.add('active');
            overlay.classList.add('active');
        }

        // Close modal
        if (closeBtn) {
            e.preventDefault();
            const modal = closeBtn.closest('.modal');
            if (!modal) return;
            modal.classList.remove('active');
            overlay.classList.remove('active');
        }
    });

    // Close on overlay click
    overlay.addEventListener('click', () => {
        document.querySelectorAll('.modal.active').forEach(modal => {
            modal.classList.remove('active');
        });
        overlay.classList.remove('active');
    });

    function closeModal(modal) {
        if (!modal) return;
        modal.classList.remove('active');
        overlay.classList.remove('active');
    }

    return { closeModal };
}