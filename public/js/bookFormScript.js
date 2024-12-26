let bookFormData = new FormData();
let title;
let author;
let pages;
let genre;
let year;
let newBookCover;
let isbn;

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



async function sendBookFormData() {
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

    bookFormData.append("title", title);
    bookFormData.append("author", selectedAuthorName);
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

    if (response.ok) {
        console.log('Data sent successfully');
    } else {
        console.error('Error sending data:', response.statusText);
    }

    const data = await response.json();

}