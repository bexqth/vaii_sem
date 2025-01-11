let formData = new FormData();
let bio;
let newProfilePicture;
let newBannerPicture;

document.addEventListener('DOMContentLoaded', function () {
    const dropZone = document.getElementById('drop-zone-profile-picture');
    const profilePicture = document.getElementById('profile-picture');

    const dropZoneBanner = document.getElementById('drop-zone-banner');
    const bannerImage = document.getElementById('banner-image');

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
            profilePicture.src = url;
            newProfilePicture = event.dataTransfer.files[0];
        } else {
            alert('Please drop an image file.');
        }
    });

    // Banner Picture Drop Zone
    dropZoneBanner.addEventListener('dragover', (event) => {
        event.preventDefault(); // Prevents the default browser behavior
        event.dataTransfer.dropEffect = 'copy'; // Indicates the drop effect
    });

    dropZoneBanner.addEventListener('drop', (event) => {
        event.preventDefault(); // Prevents the default drop action
        const file = event.dataTransfer.files[0];
        if (isImage(file.name)) {
            const url = URL.createObjectURL(file); // Creates a temporary URL for the file
            bannerImage.src = url; // Sets the banner image to the dropped image
            newBannerPicture = event.dataTransfer.files[0]; // Stores the file for later use
        } else {
            alert('Please drop an image file.');
        }
    });
});

function isImage(name){
    name = name.toLowerCase();
    let extension = name.split('.').pop();
    if(extension === "png" || extension === "jpeg" || extension === "jpg") {
        return true;
    }
    return false;
}

async function sendFormData() {
    bio = document.getElementById("about_text").value;
    formData.append("bio", bio);
    formData.append("profile_picture", newProfilePicture);
    formData.append("banner_picture", newBannerPicture);

    let url = "http://127.0.0.1:88/?c=profile&a=editProfile";

    let response = await fetch(url, {
        method: "POST",
        body: formData,
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

    }
}


