<div class="title">
    <span>Edit Post</span>
    <button><a href=" <?= url('post', 'index') ?> " class="add-category" ><span>Back</span></a> </button>
</div>

<div class="main-content add-edit-post">

    <div class="alert"><span>Successfully Failed !</span></div>

    <form action="">

        <div class="title"><span>Edit Post</span></div>

        <div class="input-box" >
            <label for="Post Name">Post Name</label>
            <input type="text" placeholder="Enter the Title of the Post">
        </div>

        <div class="input-box" >
            <label for="">Post tags</label>
            <input type="text" id="tag-input" placeholder="Enter the tags of the Post">
            <input type="text" id="hidden-tag-input" class="hidden-tag-input" hidden>
            
            <div class="tags" id="tags">
                
            </div>

        </div>

        <div class="input-box" >
            <label for="">Post Description</label>
            <textarea name="" class="news-decription-field"></textarea>
        </div>

        <div class="input-box" >

            <label for="">Post Category</label>

            <div class="select-wrapper">
                <select name="" id="">
                    <option value="" selected disabled>Select an option</option>
                    <option value="">You suck</option>
                </select>
                <i class='bx bx-chevron-down select-tag-arrow'></i>
            </div>

        </div>

        <div class="input-box" >
            <label for="Post Picture">Post Picture</label>
            <div class="custom-file-upload" id="custom-file-upload">
                <input type="file" hidden class="file-upload-input" id="file-upload-input" >
                <button type="button" class="file-upload-btn" id="file-upload-btn">Browse ...</button>
                <span class="file-upload-msg" id="file-upload-msg">No File Selected</span>
            </div>
        </div>

        <input type="submit" name="add-post" class="add-edit-post-btn" value="Edit Post">


    

    </form>

</div>
