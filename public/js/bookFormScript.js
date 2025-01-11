let bookFormData = new FormData();
let title;
let author;
let pages;
let genre;
let year;
let newBookCover;
let isbn;
let description;

document.addEventListener('DOMContentLoaded', function () {
    const dropZone = document.getElementById('drop-zone-cover');
    const bookCover = document.getElementById('book-cover');

    // Profile Picture Drop Zone
    dropZone.addEventListener('dragover', (event) => {
        event.preventDefault(); // Prevents the default browser behavior
        event.dataTransfer.dropEffect = 'copy'; // Indicates the drop effect
    });

    dropZone.addEventListener('drop', (event) => {
        event.preventDefault(); // Prevents the default drop action
        const file = event.dataTransfer.files[0];
        if (file && file.type.startsWith('image/')) {
            const url = URL.createObjectURL(file);
            bookCover.src = url;
            newBookCover = event.dataTransfer.files[0];
        } else {
            alert('Please drop an image file.');
        }
    });

});



async function sendBookFormData(bookId) {
    title = document.getElementById("title").value;

    const authorSelect = document.getElementById('authors');
    const selectedAuthorIndex = authorSelect.selectedIndex;
    const selectedAuthorName = authorSelect.options[selectedAuthorIndex].text;

    const genreSelect = document.getElementById('genres');
    const selectedGenreIndex = genreSelect.selectedIndex;
    const selectedGenreName = genreSelect.options[selectedGenreIndex].text;

    isbn = document.getElementById("isbn").value;
    pages = document.getElementById("pages").value;
    year = document.getElementById("year").value;
    description = document.getElementById("description").value;

    bookFormData.append("id", bookId);
    bookFormData.append("title", title);
    bookFormData.append("author", selectedAuthorName);
    bookFormData.append("description", description);
    bookFormData.append("genre", selectedGenreName);
    bookFormData.append("isbn", isbn);
    bookFormData.append("pages", pages);
    bookFormData.append("year", year);
    bookFormData.append("bookCover", newBookCover);

    let url = "http://127.0.0.1:88/?c=book&a=submitBook";

    let response = await fetch(url, {
        method: "POST",
        body: bookFormData,
    });

    const data = await response.json();
    if (response.ok) {
        if(data["type"] === "error") {
            const errorMessage = document.getElementById('errorMessage');
            errorMessage.innerText = data.message;
            errorMessage.style.display = 'block';

            setTimeout(() => {
                errorMessage.style.display = 'none';
            }, 3500);

            const successMessageDiv = document.getElementById('successMessage');
            successMessageDiv.style.display = 'none';
        } else if (data["type"] === "success") {
            const successMessageDiv = document.getElementById('successMessage');
            successMessageDiv.innerText = data.message;
            successMessageDiv.style.display = 'block';

            setTimeout(() => {
                successMessageDiv.style.display = 'none';
            }, 3500);

            const errorMessageDiv = document.getElementById('errorMessage');
            errorMessageDiv.style.display = 'none';
        }

    } else {
        console.error('Error sending data:', response.statusText);
    }


}