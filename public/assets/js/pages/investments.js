document.addEventListener('DOMContentLoaded', () => {
    const element = document.querySelector('.form-control.bg-body');
    if (element) {
        const choices = new Choices(element, {
            searchEnabled: false,
        });
    }
});

document.addEventListener('DOMContentLoaded', function () {
    const element = document.querySelector('.unstake-input');
    if (element) {
        const choices = new Choices(element, {
            searchEnabled: false,
        });
    }
});

document.addEventListener('DOMContentLoaded', () => {
    // Get all tab links and tab content divs
    const tabLinks = document.querySelectorAll('.stake-box a');
    const tabPanes = document.querySelectorAll('.tab-pane');

    // Function to remove the 'show active' classes and add them to the selected tab
    const activateTab = (tabLink, tabPane) => {
        tabLinks.forEach(link => link.querySelector('.select-item').classList.remove('active'));
        tabPanes.forEach(pane => pane.classList.remove('show', 'active'));

        tabLink.querySelector('.select-item').classList.add('active');
        tabPane.classList.add('show', 'active');
    };

    // Add event listeners to all tab links
    tabLinks.forEach((tabLink, index) => {
        const tabId = tabLink.getAttribute('href').substring(1); // Get the tab ID
        const tabPane = document.getElementById(tabId); // Get the corresponding tab content

        tabLink.addEventListener('click', (e) => {
            e.preventDefault(); // Prevent the default anchor behavior
            activateTab(tabLink, tabPane); // Activate the tab
        });
    });
});
