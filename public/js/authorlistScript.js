
let authorId;
let newAuthorName;

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
    newAuthorName = document.getElementById("author-name").value;
    let url = "http://127.0.0.1:88/?c=authorlist&a=editAuthor";
    let body = {
        "authorId": authorId,
        "authorName": newAuthorName,
    };

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
        showUpdatedAuthors(data);
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
    authorName.innerText = "";
}