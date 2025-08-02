<div class="modal modal--delete" id="del-modal">

    <div class="modal__wrapper">

        <div class="modal__head">
            <span class="modal__title"></span>
            <button data-modal-close class="modal__close-btn">&times;</button>
        </div>

        <div class="modal__body">

            <div class="modal__icon">
                <div class="modal__icon-wrapper">
                    <div class="modal__icon-shape">
                        <i class="fa-solid fa-exclamation"></i>
                    </div>
                </div>
            </div>

            <div class="modal__heading">
                <p class="modal__message-title">Delete This Post?</p>
                <p class="modal__message-text">This Post will be permanently deleted</p>
            </div>

            <form action="" class="modal__form del-category-form" id="del-category-form">

                <div class="modal__actions">
                    <input type="submit" class="modal__delete-btn" value="Delete">
                    <button data-modal-close type="button" class="modal__cancel-btn">Cancel</button>
                </div>

            </form>

        </div>

    </div>

</div>

<div class="overlay" id="overlay"></div>