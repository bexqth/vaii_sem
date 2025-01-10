
function toggleCategories() {
    let categoryButtons = document.getElementById("categoryButtons");
    let dropButton = document.getElementById("dropButton");
    if (categoryButtons.style.display === "none") {
        dropButton.innerHTML = "▲";
        categoryButtons.style.display = "block";
    }
    else {
        dropButton.innerHTML = "▼";
        categoryButtons.style.display = "none";
    }
}

async function filterBooks(genreId, genreName) {
    const booklistTitle = document.getElementById("booklist-title");
    booklistTitle.innerText = `Booklist - ${genreName}`;
    const genreButton = document.getElementById(genreId);
    let url = "http://127.0.0.1:88/?c=booklist&a=filterByGenre";
    let body = {
        "genreId": genreId,
    };

    let response = await fetch(url, {
        method: "POST",
        body: JSON.stringify(body),
        headers: {
            "Content-type": "application/json",
            "Accept": "application/json",
        }

    });

    if(response.ok) {
        const data = await response.json();
        showFilteredBooks(data);
    }
}

function showFilteredBooks(books) {
    const booksSpace = document.getElementById("booksSpace");
    booksSpace.innerHTML = ""; // Clear previous books

    if (!Array.isArray(books) || books.length === 0) {
        booksSpace.innerHTML = '<p>No books found for the selected genre.</p>';
        return;
    }

    books.forEach(book => {
        const colDiv = document.createElement("div");
        colDiv.classList.add("col");

        const cardDiv = document.createElement("div");
        cardDiv.classList.add("book-card", "card");

        const link = document.createElement("a");
        link.href = `http://127.0.0.1:88/?c=book&a=index&id=${book.id}`;

        const img = document.createElement("img");
        img.src = book.cover_url;
        img.classList.add("card-img-top");
        img.alt = "Book Cover";

        link.appendChild(img);

        const cardBody = document.createElement("div");
        cardBody.classList.add("card-body");

        const title = document.createElement("h6");
        title.classList.add("card-title");
        title.textContent = book.title;

        const author = document.createElement("p");
        author.classList.add("card-title");
        author.textContent = book.author;

        cardBody.appendChild(title);
        cardBody.appendChild(author);

        cardDiv.appendChild(link);
        cardDiv.appendChild(cardBody);

        colDiv.appendChild(cardDiv);

        booksSpace.appendChild(colDiv);
    });
}

        //ked mi pride chyba zo servera nech to nejako zablika
        //ajax send form - dobre na obhajobe