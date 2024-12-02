
function addToList(i) {
    let statusButton = document.getElementById("statusButton");

    switch (i) {
        case 0:
            statusButton.innerHTML = "Reading";
            break;
        case 1:
            statusButton.innerHTML = "Finished";
            break;
        case 2:
            statusButton.innerHTML = "Planning";
            break;
    }
}


async function addToReading(bookId, list) {
    let url = "http://127.0.0.1:88/?c=book&a=setBookStatus";
    let body = {
        "bookId" : bookId,
        "list" : list,
    };
    let statusButton = document.getElementById("statusButton");
    statusButton.innerHTML = "Reading";

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

function addToFinished() {
    let statusButton = document.getElementById("statusButton");
    statusButton.innerHTML = "Finished";

}

function addToPlanning() {
    let statusButton = document.getElementById("statusButton");
    statusButton.innerHTML = "Planning";

}
