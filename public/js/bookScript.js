
function updateButtonStatus(i) {
    let statusButton = document.getElementById("statusButton");
    switch (i) {
        case 1:
            statusButton.innerHTML = "Reading";
            break;
        case 2:
            statusButton.innerHTML = "Finished";
            break;
        case 3:
            statusButton.innerHTML = "Planning";
            break;
    }
}


let edited = false;
function updateProgress (bookId, maxPages) {
    if(!edited) {
        editProgress();
        edited = true;

    } else {
        saveProgress(bookId, maxPages);
        edited = false;
    }
}

function editProgress() {
    let readPagesInput = document.getElementById("pagesReadInput");
    readPagesInput.removeAttribute("readonly");
    readPagesInput.style.border = "#cb967e 2px solid"
    let editButton = document.getElementById("editPagesButton");
    editButton.innerHTML = '<i class="bi bi-check2-circle"></i>';
}

async function saveProgress(bookId, maxPages) {
    let readPagesInput = document.getElementById("pagesReadInput");
    let totalPages = maxPages;
    let pages = readPagesInput.value;
    if(pages > totalPages) {
        showMessage("error", "Selected number of pages is higher than maximum");
        return;
    }

    let editButton = document.getElementById("editPagesButton");
    let progressBar = document.getElementById("progressBar");
    readPagesInput.setAttribute('readonly', 'readonly');
    readPagesInput.style.border = "none"
    editButton.innerHTML = '<i class="bi bi-plus-lg"></i>';

    let progressPercentage = (pages / totalPages) * 100;
    progressBar.style.width = progressPercentage + '%';


    let url = "http://127.0.0.1:88/?c=book&a=editReadingProgress";
    let body = {
        "bookId": bookId,
        "pages": pages,
    };

    let response = await fetch(url, {
        method: "POST",
        body: JSON.stringify(body),
        headers: {
            "Content-type": "application/json",
            "Accept": "application/json",
        }
    });

    if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
    }

}


async function addToReading(option, bookId, list) {
    let url = "http://127.0.0.1:88/?c=book&a=setBookStatus";
    let body = {
        "bookId": bookId,
        "list": list,
    };

    try {
        let response = await fetch(url, {
            method: "POST",
            body: JSON.stringify(body),
            headers: {
                "Content-type": "application/json",
                "Accept": "application/json",
            }
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        updateButtonStatus(option);
        const data = await response.json();

        const successMessageDiv = document.getElementById('successMessage');
        successMessageDiv.innerText = data.message;
        successMessageDiv.style.display = 'block';

        setTimeout(() => {
            successMessageDiv.style.display = 'none';
        }, 3500);

        const errorMessageDiv = document.getElementById('errorMessage');
        errorMessageDiv.style.display = 'none';

    } catch (error) {
        const errorMessageDiv = document.getElementById('errorMessage');
        errorMessageDiv.innerText = 'An error occurred while updating the book status. Please try again later.';
        errorMessageDiv.style.display = 'block';

        setTimeout(() => {
            errorMessageDiv.style.display = 'none';
        }, 3500);

        const successMessageDiv = document.getElementById('successMessage');
        successMessageDiv.style.display = 'none';

    }
}


function updateFavoriteButton(bookId, state) {
    if(state === false) {
        addFavoriteBook(bookId);
        favoriteIconFill = true;
    } else {
        removeFavoriteBook(bookId);
        favoriteIconFill = false;
    }
}


async function addFavoriteBook(bookId) {
    let favoriteButton = document.getElementById("favorite-button");
    let url = "http://127.0.0.1:88/?c=book&a=addAsFavoriteBook";
    let body = {
        "bookId": bookId,
    };

    let response = await fetch(url, {
        method: "POST",
        body: JSON.stringify(body),
        headers: {
            "Content-type": "application/json",
            "Accept": "application/json",
        }
    });

    if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
    }

    favoriteButton.innerHTML = '<i class="bi bi-heart-fill"></i>';
    favoriteButton.setAttribute("onclick", `updateFavoriteButton(${bookId}, true)`);
}

async function removeFavoriteBook(bookId) {
    let favoriteButton = document.getElementById("favorite-button");
    let url = "http://127.0.0.1:88/?c=book&a=removeAsFavoriteBook";
    let body = {
        "bookId": bookId,
    };

    let response = await fetch(url, {
        method: "POST",
        body: JSON.stringify(body),
        headers: {
            "Content-type": "application/json",
            "Accept": "application/json",
        }
    });

    if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
    }

    favoriteButton.innerHTML = '<i class="bi bi-heart"></i>';
    favoriteButton.setAttribute("onclick", `updateFavoriteButton(${bookId}, false)`);
}


function showMessage(type, message) {
    if(type === "error") {
        const errorMessage = document.getElementById('errorMessage');
        errorMessage.innerText = message;
        errorMessage.style.display = 'block';

        setTimeout(() => {
            errorMessage.style.display = 'none';
        }, 3500);

        const successMessageDiv = document.getElementById('successMessage');
        successMessageDiv.style.display = 'none';
    } else if (type === "success") {
        const successMessageDiv = document.getElementById('successMessage');
        successMessageDiv.innerText = message;
        successMessageDiv.style.display = 'block';

        setTimeout(() => {
            successMessageDiv.style.display = 'none';
        }, 3500);

        const errorMessageDiv = document.getElementById('errorMessage');
        errorMessageDiv.style.display = 'none';
    }
}
