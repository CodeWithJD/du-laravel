document.addEventListener("DOMContentLoaded", function () {
    // Selecting all buttons with the 'btn-close' class
    const closeButtons = document.querySelectorAll(".btn-close");

    // Adding an event listener to each button
    closeButtons.forEach(button => {
        button.addEventListener("click", function () {
            // Redirecting to the desired route
            window.location.href = "/wallet/transfer";
        });
    });
});
