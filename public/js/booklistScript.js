

function toggleCategories() {
    var categoryButtons = document.getElementById("categoryButtons");
    var dropButton = document.getElementById("dropButton");
    if (categoryButtons.style.display === "none") {
        dropButton.innerHTML = "▲";
        categoryButtons.style.display = "block";
    }
    else {
        dropButton.innerHTML = "▼";
        categoryButtons.style.display = "none";
    }
}