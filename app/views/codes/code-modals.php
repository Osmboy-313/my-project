
<?php

$Title = $activeTab === '#boss' ? 'Boss Code' : 'Admin Code' ;
$placeHolder = $activeTab === '#boss' ? 'boss Code' : 'admin Code' ;

?>

<!-- *** Add Category Modal *** -->

<div class="modal modal--add" id="add-modal">

    <div class="modal__wrapper">

        <div class="modal__head">
            <span class="modal__title"></span>
            <button data-modal-close class="modal__close-btn">&times;</button>
        </div>

        <div class="modal__body">

            <div class="modal__icon">
                <div class="modal__icon-wrapper">
                    <div class="modal__icon-shape">
                        <i class='bx bx-plus'></i>
                    </div>
                </div>
            </div>

            <div class="modal__heading">
                <p class="modal__message-title">Add <?= $Title ?></p>
                <p class="modal__message-text"></p>
            </div>

            <!-- <div class="alert">
                <div class="alert__symbol"></div>
                <div class="alert__message">
                    <div class="alert__title"></div>
                    <div class="alert__text"></div>
                </div>
            </div> -->

            <!-- <div class="modal__alert success">

                <div class="modal__alert-symbol">

                    <i class='bx bx-check' ></i>

                </div>

                <div class="modal__alert-message">
                    <div class="modal__alert-title">Success !</div>
                    <div class="modal__alert-text">Category Has Been Added!</div>
                </div>

                <div class="modal__close-btn">
                    <i class='bx bx-x' ></i>
                </div>

            </div> -->


            <form action="" class="modal__form add-category-form" id="add-category-form">

                <div class="modal__input-box">
                    <label for="name"><?= $Title ?></label>
                    <input type="text" class="name" id="name" placeholder="Add your Category name">
                    <span class="error-box">Enter your <?= $placeHolder ?></span>
                </div>

                <div class="modal__actions">
                    <input type="submit" class="modal__add-btn" value="Add">
                </div>

            </form>

        </div>

    </div>

</div>

<!-- *** Edit Category Modal *** -->

<div class="modal modal--edit" id="edit-modal">

    <div class="modal__wrapper">

        <div class="modal__head">
            <span class="modal__title"></span>
            <button data-modal-close class="modal__close-btn">&times;</button>
        </div>

        <div class="modal__body">

            <div class="modal__icon">
                <div class="modal__icon-wrapper">
                    <div class="modal__icon-shape">
                        <i class='bx bxs-pencil'></i>
                    </div>
                </div>
            </div>

            <div class="modal__heading">
                <p class="modal__message-title">Edit <?= $Title ?></p>
                <p class="modal__message-text"></p>
            </div>


            <!-- <div class="modal__alert success">

                <div class="modal__alert-symbol">

                    <i class='bx bx-check' ></i>

                </div>

                <div class="modal__alert-message">
                    <div class="modal__alert-title">Success !</div>
                    <div class="modal__alert-text">Category Has Been Added!</div>
                </div>

                <div class="modal__close-btn">
                    <i class='bx bx-x' ></i>
                </div>

            </div> -->


            <form action="" class="modal__form edit-category-form" id="edit-category-form">

                <div class="modal__input-box">
                    <label for="name"><?= $Title ?></label>
                    <input type="text" class="name" id="name" placeholder="Add your Category name">
                    <span class="error-box">Enter your <?= $placeHolder ?></span>
                </div>

                <div class="modal__actions">
                    <input type="submit" class="modal__add-btn" value="Edit">
                </div>

            </form>

        </div>

    </div>

</div>

<!-- *** Delete Category Modal *** -->

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
                <p class="modal__message-title">Delete This <?= $Title ?>?</p>
                <p class="modal__message-text">This code will be permanently deleted</p>
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