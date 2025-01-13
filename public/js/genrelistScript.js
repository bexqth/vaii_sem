
let genreId;
let newGenreName;
genreId = null;

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

    let numbers = ["1", "2", "3", "4", "5", "6", "7", "8", "9", "0"];
    for (let i = 0; i < newGenreName.length; i++) {
        for (let j = 0; j < numbers.length; j++) {
            if(newGenreName[i] === numbers[j]) {
                showMessage("success", "Genre cant contain numbers");
                return;
            }
        }
    }

    let url = "http://127.0.0.1:88/?c=genrelist&a=editGenre";
    let body = {
        "genreId": genreId,
        "genreName": newGenreName,
    };

    try{
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
            let genreTitle = document.getElementById("genre-title");
            let genreName = document.getElementById("genre-name");
            genreName.value = "";
            genreTitle.innerText = "Create new genre";
            genreId = null;
        } else {
            showMessage("error", "Something went wrong. Please try again later.");
        }
    }
    catch (error){
        console.error("An error occurred:", error);
        showMessage("error", "Something went wrong. Please try again later.");
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