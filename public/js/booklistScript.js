

function toggleCategories() {
    var categoryButtons = document.getElementById("categoryButtons");
    if (categoryButtons.style.display === "none") {
        categoryButtons.style.display = "block";
    }
    else { categoryButtons.style.display = "none";
    }
}