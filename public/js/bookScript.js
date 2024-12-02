
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


async function addToReading(option, bookId, list) {

    let url = "http://127.0.0.1:88/?c=book&a=setBookStatus";
    let body = {
        "bookId" : bookId,
        "list" : list,
    };

    updateButtonStatus(option);
    let response = await fetch(
        url, // URL to the action
        {
            method: "POST",
            body: JSON.stringify(body),
            headers: { // Set headers for JSON communication
                "Content-type": "application/json", // Send JSON
                "Accept": "application/json", // Accept only JSON as response
            }

        }
    )
}

