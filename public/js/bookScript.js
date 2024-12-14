
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
function updateProgress () {

    if(!edited) {
        //edit
        editProgress();
        edited = true;

    } else {
        saveProgress();
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

function saveProgress() {
    let editButton = document.getElementById("editPagesButton");
    let readPagesInput = document.getElementById("pagesReadInput");
    readPagesInput.setAttribute('readonly', 'readonly');
    readPagesInput.style.border = "none"
    editButton.innerHTML = '<i class="bi bi-plus-lg"></i>';
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


