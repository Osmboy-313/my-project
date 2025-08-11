document.addEventListener("DOMContentLoaded", async function () {

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




    if (c == 'profile') {
        import('./modules/profile.js').then(module => module.profile());

    }

    if (c == 'auth') {
        import('./modules/authentication.js').then(module => module.authentication());

    }

    if (c == 'category') {
        import('./modules/category.js').then(module => module.categor(modalControls));
    }

    function setupTabs() {
        const tabButtons = document.querySelectorAll('.tabs .tab');
        const activeIndicator = document.querySelector('.tabs .active');

        if (!tabButtons.length || !activeIndicator) {
            console.warn("Tab buttons or indicator not found.");
            return;
        }

        tabButtons.forEach((button, index) => {
            button.addEventListener('click', () => {
                activeIndicator.style.transform = `translateX(${index * 200}px)`;

                tabButtons.forEach(btn => btn.classList.remove('selected'));
                button.classList.add('selected');
            });
        });
    }

    function opentabs() {
        const tabs = document.querySelectorAll('[data-tab-target]');
        const tabContents = document.querySelectorAll('[data-tab-content]');

        console.log('tabs :', tabs);

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                const target = document.querySelector(tab.dataset.tabTarget);
                tabContents.forEach(tabContent => {
                    tabContent.classList.remove('active');
                });
                target.classList.add('active');
            });
        });

    }

    // function initTabs() {
    //     const tabButtons = document.querySelectorAll('.tabs .tab');
    //     const tabContents = document.querySelectorAll('[data-tab-content]');
    //     const activeIndicator = document.querySelector('.tabs .active');
    
    //     const urlParams = new URLSearchParams(window.location.search);
    //     let savedTab = urlParams.get('tab') || localStorage.getItem('activeTab') || '#user';
    
    //     let activeIndex = 0;
    //     tabButtons.forEach((button, index) => {
    //         if (button.dataset.tabTarget === savedTab) {
    //             activeIndex = index;
    //         }
    //     });
    
    //     function activateTab(index, skipTransition = false) {
    //         if (skipTransition) {
    //             activeIndicator.classList.add('no-transition');
    //         }
    
    //         activeIndicator.style.transform = `translateX(${index * 200}px)`;
    
    //         tabButtons.forEach(btn => btn.classList.remove('selected'));
    //         tabContents.forEach(tabContent => tabContent.classList.remove('active'));
    
    //         tabButtons[index].classList.add('selected');
    //         document.querySelector(tabButtons[index].dataset.tabTarget).classList.add('active');
    //         localStorage.setItem('activeTab', tabButtons[index].dataset.tabTarget);
    
    //         const currentUrl = new URL(window.location.href);
    //         currentUrl.searchParams.set('tab', tabButtons[index].dataset.tabTarget);
    //         history.replaceState({}, '', currentUrl);
    
    //         // Force reflow to ensure transition resets
    //         if (skipTransition) {
    //             setTimeout(() => {
    //                 activeIndicator.classList.remove('no-transition');
    //             }, 50); // small delay to re-enable transition
    //         }
    //     }
    
    //     activateTab(activeIndex, true); // Skip transition on first load
    
    //     tabButtons.forEach((button, index) => {
    //         button.addEventListener('click', () => {
    //             activateTab(index); // Use normal transition on click
    //         });
    //     });
    // }

    function userListTabs() {

        const tabButtons = document.querySelectorAll('.tabs .tab');
        const activeIndicator = document.querySelector('.tabs .active');
        const tabContents = document.querySelectorAll('[data-tab-content]');
        const contentWrapper = document.querySelector('.main-content.tab-content');
    
        const urlParams = new URLSearchParams(window.location.search);
        let savedTab = urlParams.get('tab') || localStorage.getItem('activeTab') || '#user';
    
        let activeIndex = 0;
        tabButtons.forEach((button, index) => {
            if (button.dataset.tabTarget === savedTab) {
                activeIndex = index;
            }
        });
    
        function activateTab(index, skipTransition = false) {
            const selectedTab = tabButtons[index].dataset.tabTarget;
    
            if (skipTransition) activeIndicator.classList.add('no-transition');
            activeIndicator.style.transform = `translateX(${index * 200}px)`;
    
            // Update selected class
            tabButtons.forEach(btn => btn.classList.remove('selected'));
            tabButtons[index].classList.add('selected');
    
            // Update localStorage and URL
            localStorage.setItem('activeTab', selectedTab);
            const currentUrl = new URL(window.location.href);
            currentUrl.searchParams.set('tab', selectedTab);
            currentUrl.searchParams.set('page', 1); // reset page on tab switch
            history.replaceState({}, '', currentUrl);
    
            loadTabContent(selectedTab, 1); // AJAX load
    
            if (skipTransition) {
                setTimeout(() => {
                    activeIndicator.classList.remove('no-transition');
                }, 50);
            }
        }
    
        function loadTabContent(tab, page = 1) {
            const url = `?c=user&a=index&tab=${encodeURIComponent(tab)}&page=${page}&ajax=1`;
            fetch(url)
                .then(res => res.text())
                .then(html => {
                    contentWrapper.innerHTML = html;
                    initPaginationHandlers(); // re-attach events inside loaded HTML
                });
        }
    
        function initPaginationHandlers() {
            document.querySelectorAll('.pagination__controls a').forEach(link => {
                link.addEventListener('click', e => {
                    e.preventDefault();
                    const url = new URL(link.href);
                    const tab = url.searchParams.get('tab') || '#user';
                    const page = url.searchParams.get('page') || 1;
                    loadTabContent(tab, page);
    
                    // update URL without reload
                    history.replaceState({}, '', url);
                });
            });
        }
    
        activateTab(activeIndex, true); // Initial load
    
        tabButtons.forEach((button, index) => {
            button.addEventListener('click', () => {
                activateTab(index);
            });
        });
    }



    function codeTabs() {

        const tabButtons = document.querySelectorAll('.tabs .tab');
        const activeIndicator = document.querySelector('.tabs .active');
        const tabContents = document.querySelectorAll('[data-tab-content]');
        const contentWrapper = document.querySelector('.main-content.tab-content');
    
        const urlParams = new URLSearchParams(window.location.search);
        let savedTab = urlParams.get('tab') || localStorage.getItem('activeTab') || '#admin';
    
        let activeIndex = 0;
        tabButtons.forEach((button, index) => {
            if (button.dataset.tabTarget === savedTab) {
                activeIndex = index;
            }
        });
    
        function activateTab(index, skipTransition = false) {
            const selectedTab = tabButtons[index].dataset.tabTarget;
    
            if (skipTransition) activeIndicator.classList.add('no-transition');
            activeIndicator.style.transform = `translateX(${index * 200}px)`;
    
            // Update selected class
            tabButtons.forEach(btn => btn.classList.remove('selected'));
            tabButtons[index].classList.add('selected');
    
            // Update localStorage and URL
            localStorage.setItem('activeTab', selectedTab);
            const currentUrl = new URL(window.location.href);
            currentUrl.searchParams.set('tab', selectedTab);
            currentUrl.searchParams.set('page', 1); // reset page on tab switch
            history.replaceState({}, '', currentUrl);
    
            loadTabContent(selectedTab, 1); // AJAX load
    
            if (skipTransition) {
                setTimeout(() => {
                    activeIndicator.classList.remove('no-transition');
                }, 50);
            }
        }
    
        function loadTabContent(tab, page = 1) {
            const url = `?c=code&a=index&tab=${encodeURIComponent(tab)}&page=${page}&ajax=1`;
            fetch(url)
                .then(res => res.text())
                .then(html => {
                    contentWrapper.innerHTML = html;
                    initPaginationHandlers(); // re-attach events inside loaded HTML
                });
        }
    
        function initPaginationHandlers() {
            document.querySelectorAll('.pagination__controls a').forEach(link => {
                link.addEventListener('click', e => {
                    e.preventDefault();
                    const url = new URL(link.href);
                    const tab = url.searchParams.get('tab') || '#admin';
                    const page = url.searchParams.get('page') || 1;
                    loadTabContent(tab, page);
    
                    // update URL without reload
                    history.replaceState({}, '', url);
                });
            });
        }
    
        activateTab(activeIndex, true); // Initial load
    
        tabButtons.forEach((button, index) => {
            button.addEventListener('click', () => {
                activateTab(index);
            });
        });

        // RETURN loadTabContent, so we can use it to refresh the records !!
        return loadTabContent;

    }

    function handleDynamicModalButton() {
        const addBtn = document.querySelector('.add-code-btn');
    
        addBtn.addEventListener('click', () => {
            const activeTab = document.querySelector('.tab.selected')?.dataset.tabTarget;
    
            // Set dynamic attributes based on active tab
            if (activeTab === '#admin') {
                addBtn.dataset.title = "Add Admin Code";
                addBtn.dataset.label = "Admin Code";
                addBtn.dataset.placeholder = "Enter admin code";
                addBtn.dataset.form = "add-admin-form";
            } else if (activeTab === '#boss') {
                addBtn.dataset.title = "Add Boss Code";
                addBtn.dataset.label = "Boss Code";
                addBtn.dataset.placeholder = "Enter boss code";
                addBtn.dataset.form = "add-boss-form";
            }
    
            // Let the openCloseModal function do its magic
        });
    }
    
    
    if (c == 'user' ) {
        userListTabs();
    }

    if (c == 'code' ) {
        handleDynamicModalButton();
        const loadTabContent = codeTabs();
        import('./modules/code.js').then(module => module.code(modalControls, loadTabContent));
    }


    // setupTabs();
    // opentabs();

    import('./modules/open-close-modal.js').then(module => module.openCloseModal());

    import('./modules/sidebar-class-toggle.js').then(module => module.sidebar());
    import('./modules//sidebar-menu-items-active.js').then(module => module.sideBarMenuItems());
    import('./modules/toggle-dropdown-menu.js').then(module => module.dropdown());
    import('./modules/custom-file-input.js').then(module => module.customFileUpload());
    import('./modules/tag-chip-input.js').then(module => module.tagInput());

});


