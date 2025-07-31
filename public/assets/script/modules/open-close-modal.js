export function openCloseModal() {

    let openModalBtn = document.querySelectorAll("[data-modal-target]");
    let closeModalBtn = document.querySelectorAll("[data-modal-close]");
    let overlay = document.querySelector("#overlay");

    if (!openModalBtn) return;
    if (!closeModalBtn) return;
    if (!overlay) return;

    document.addEventListener('click', (e) => {

        const openBtn = e.target.closest('[data-modal-target]');
        const closeBtn = e.target.closest('[data-modal-close]');
        
        if(openBtn){
            e.preventDefault();
            const modal = document.querySelector(openBtn.dataset.modalTarget);
            openModal(modal);
        }

        if(closeBtn){
            e.preventDefault();
            const modal = closeBtn.closest('.modal');
            closeModal(modal);
        }


    })

    // openModalBtn.forEach(button => {
    //     button.addEventListener("click", (e) => {
    //         e.preventDefault();
    //         const modal = document.querySelector(button.dataset.modalTarget);
    //         openModal(modal);
    //     });
    // });


    // closeModalBtn.forEach(button => {
    //     button.addEventListener("click", () => {
    //         const modal = button.closest('.modal');
    //         closeModal(modal);
    //     });
    // });

    overlay.addEventListener('click', () => {

        const modals = document.querySelectorAll('.modal.active');
        modals.forEach(modal => {
            closeModal(modal);
        });
    })

    function openModal(modal) {

        if (modal == null) return;

        modal.classList.add('active');
        overlay.classList.add('active');
    }

    function closeModal(modal) {
        
        if (modal == null) return

        modal.classList.remove('active');
        overlay.classList.remove('active');
    }

    return { closeModal };

}