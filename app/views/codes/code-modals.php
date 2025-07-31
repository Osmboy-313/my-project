
<!-- *** Add Category Modal *** -->

<div class="modal" id="modal">

    <div class="modal-head">
        <span class="title" >Add Codes</span>
        <button data-modal-close class="close-btn"><span>&times;</span></button>
    </div>

    <div class="modal-body">
        
        <form action="" class="add-category-form">

            <div class="input-box" >
                <label for="name">Admin Code</label>
                <input type="text" class="add-name-input" placeholder="Add your admin code">
            </div>

            <div class="input-box" >
                <label for="name">Boss Code</label>
                <input type="text" class="add-name-input" placeholder="Add your boss code">
            </div>

            <input type="submit" value="Add" class="submit-btn">

        </form>

    </div>

</div>

<!-- *** Edit Category Modal *** -->

<div class="modal" id="edit-modal">
        
    <div class="modal-head">
        <span class="title" >Edit Codes</span>
        <button data-modal-close class="close-btn">&times;</button>
    </div>

    <div class="modal-body">
        
        <form action="" class="edit-category-form">

            <div class="input-box">
                <label for="name">Admin Code</label>
                <input type="text" class="edit-name-input" placeholder="Edit your admin code">
            </div>

            <div class="input-box">
                <label for="name">Boss Code</label>
                <input type="text" class="edit-name-input" placeholder="Edit your boss code">
            </div>

            <input type="submit" value="Edit" class="submit-btn">

        </form>

    </div>

</div>

<!-- *** Delete Category Modal *** -->

<div class="modal" id="del-modal">
    
    <div class="modal-head">
        <span class="title" >Delete Codes</span>
        <button data-modal-close class="close-btn">&times;</button>
    </div>

    <div class="modal-body">
        
        <form action="" class="del-category-form">
            
            <p>Are you sure you want to delete this?</p>

            <div class="input-box">
                <button data-modal-close type="button" class="cancel-btn">Cancel</button>
                <button type="submit" class="del-btn">Delete</button>
            </div>

        </form>

    </div>
</div>

<div class="overlay" id="overlay"></div>