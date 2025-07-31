document.addEventListener("DOMContentLoaded", async function(){

    const params = new URLSearchParams(window.location.search);
    const c = params.get('c');
    console.log(c);

    // if(c == 'users-list'){
    // import('./modules/user.js').then(module => module.showUsers());

    // }

    // if(c == 'my-profile'){
    //     import('./modules/profile.js').then(module => {
    //         module.showProfile()
    //         module.updateRole();
    //     });
    
    // }

    const { openCloseModal } = await import('./modules/open-close-modal.js');
    const modalControls = openCloseModal();

    if(c == 'auth'){
        import('./modules/authentication.js').then(module => module.authentication());

    }

    if(c == 'category'){
        import('./modules/category.js').then(module => module.categor(modalControls) );
    }   

 

    import('./modules/open-close-modal.js').then(module => module.openCloseModal());
    
    import('./modules/sidebar-class-toggle.js').then(module => module.sidebar());
    import('./modules//sidebar-menu-items-active.js').then(module => module.sideBarMenuItems());
    import('./modules/toggle-dropdown-menu.js').then(module => module.dropdown());
    import('./modules/custom-file-input.js').then(module => module.customFileUpload());
    import('./modules/tag-chip-input.js').then(module => module.tagInput());

});


