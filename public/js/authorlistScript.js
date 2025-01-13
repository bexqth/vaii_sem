
let authorId;
let newAuthorName;
authorId = null;

function selectAuthor(name, id) {
    let authorTitle = document.getElementById("author-title");
    let authorName = document.getElementById("author-name");
    authorName.value = name;
    authorTitle.innerText = "Edit author";
    authorId = id;
}

function createNewAuthor() {
    let authorName = document.getElementById("author-name");
    let authorTitle = document.getElementById("author-title");
    authorName.value = "";
    authorTitle.innerText = "Create new author";
    authorId = null;
}

async function submit() {
    let authorName = document.getElementById("author-name");
    let authorTitle = document.getElementById("author-title");
    newAuthorName = document.getElementById("author-name").value;

    let numbers = ["1", "2", "3", "4", "5", "6", "7", "8", "9", "0"];
    for (let i = 0; i < newAuthorName.length; i++) {
        for (let j = 0; j < numbers.length; j++) {
            if(newAuthorName[i] === numbers[j]) {
                showMessage("success", "Authors name cant contain numbers");
                return;
            }
        }
    }

    let url = "http://127.0.0.1:88/?c=authorlist&a=editAuthor";
    let body = {
        "authorId": authorId,
        "authorName": newAuthorName,
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

        if (response.ok) {
            const data = await response.json();
            showMessage(data["type"], data["message"])
            showUpdatedAuthors(data["updatedAuthors"]);
            authorName.value = "";
            authorTitle.innerText = "Create new author";
            authorId = null;
        } else {
            showMessage("error", "Something went wrong. Please try again later.");
        }

    } catch (error){
        console.error("An error occurred:", error);
        showMessage("error", "Something went wrong. Please try again later.");
    }

}


function showUpdatedAuthors(authors) {

    let authorList = document.getElementById("authors-list");
    authorList.innerHTML = "";
    authors.forEach(author => {
        const div = document.createElement("div");
        div.className = "author-row";
        const button =  document.createElement("button");
        button.className = "btn";
        button.textContent = author.name;
        button.onclick = () => selectAuthor(author.name, author.id);
        div.appendChild(button);
        authorList.appendChild(div);
    });
    let authorName = document.getElementById("author-name");
    authorName.value = "";
    authorId = null;
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