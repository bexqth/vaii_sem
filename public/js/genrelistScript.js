
let genreId;
let newGenreName;

function selectGenre(name, id) {
    let genreTitle = document.getElementById("genre-title");
    let genreName = document.getElementById("genre-name");
    genreName.value = name;
    genreTitle.innerText = "Edit genre";
    genreId = id;
}

function createNewGenre() {
    let genreTitle = document.getElementById("genre-title");
    let genreName = document.getElementById("genre-name");
    genreName.value = "";
    genreTitle.innerText = "Create new genre";
    genreId = null;
}

async function submit() {
    newGenreName = document.getElementById("genre-name").value;
    let url = "http://127.0.0.1:88/?c=genrelist&a=editGenre";
    let body = {
        "genreId": genreId,
        "genreName": newGenreName,
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
        showUpdatedGenre(data);
    }
}


function showUpdatedGenre(genres) {

    let genreList = document.getElementById("genre-list");
    genreList.innerHTML = "";
    genres.forEach(genre => {
        const div = document.createElement("div");
        div.className = "genre-row";
        const button =  document.createElement("button");
        button.className = "btn";
        button.textContent = genre.name;
        button.onclick = () => selectGenre(genre.name, genre.id);
        div.appendChild(button);
        genreList.appendChild(div);
    });
    let genreName = document.getElementById("genre-name");
    genreName.value = "";
    genreId = null;
}