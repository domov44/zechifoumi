document.addEventListener("DOMContentLoaded", function() {
    let isOpen = false; // Définir isOpen sur false par défaut
    const toggle = document.getElementById("toggle");
    const aside = document.querySelector(".aside");
    const content = document.querySelector(".content.w-aside");

    if (toggle) {
        toggle.addEventListener("click", function() {
            if (!isOpen) {
                openSidebar();
            } else {
                closeSidebar();
            }
        });
    }

    document.addEventListener("click", function(event) {
        if (
            aside && !aside.contains(event.target) &&
            !event.target.classList.contains("toggle") &&
            window.innerWidth <= 1200 &&
            isOpen
        ) {
            closeSidebar();
        }
    });

    function openSidebar() {
        aside.style.transform = "translateX(0)";
        if (window.innerWidth >= 1200) {
            content.style.marginLeft = "280px";
        }
        isOpen = true;
    }

    function closeSidebar() {
        aside.style.transform = "translateX(-100%)";
        if (window.innerWidth >= 1200) {
            content.style.marginLeft = "initial";
        }
        isOpen = false;
    }

    // Automatically open sidebar if it's closed on page load
    if (!isOpen) {
        toggle.click();
    }
});
