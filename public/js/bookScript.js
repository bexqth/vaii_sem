
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
        alert(data.message);

    } catch (error) {
        console.error('Fetch error:', error);
        //alert(response.text());

    }
}


