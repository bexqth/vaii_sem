let formData = new FormData();
let bio;
let newProfilePicture;
let newBannerPicture;

document.addEventListener('DOMContentLoaded', function () {
    const dropZone = document.getElementById('drop-zone-profile-picture');
    const profilePicture = document.getElementById('profile-picture');

    const dropZoneBanner = document.getElementById('drop-zone-banner');
    const bannerImage = document.getElementById('banner-image');

    dropZone.addEventListener('dragover', (event) => {
        event.preventDefault();
        event.dataTransfer.dropEffect = 'copy';
    });

    dropZone.addEventListener('drop', (event) => {
        event.preventDefault();
        const file = event.dataTransfer.files[0];
        if (file && isImage(file.name)) {
            const url = URL.createObjectURL(file);
            profilePicture.src = url;
            newProfilePicture = event.dataTransfer.files[0];
        } else {
            showMessage("error", "Please drop an image file")
        }
    });

    dropZoneBanner.addEventListener('dragover', (event) => {
        event.preventDefault();
        event.dataTransfer.dropEffect = 'copy';
    });

    dropZoneBanner.addEventListener('drop', (event) => {
        event.preventDefault();
        const file = event.dataTransfer.files[0];
        if (file && isImage(file.name)) {
            const url = URL.createObjectURL(file);
            bannerImage.src = url;
            newBannerPicture = event.dataTransfer.files[0];
        } else {
            showMessage("error", "Please drop an image file")
        }
    });
});

function isImage(name){
    name = name.toLowerCase();
    let extension = name.split('.').pop();
    if(extension === "jpeg" || extension === "jpg") {
        return true;
    }
    return false;
}

async function sendFormData() {
    bio = document.getElementById("about_text").value;
    if(validateData(bio)) {
        formData.append("bio", bio);
        formData.append("profile_picture", newProfilePicture);
        formData.append("banner_picture", newBannerPicture);

        let url = "http://127.0.0.1:88/?c=profile&a=editProfile";

        try{
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
        catch (error) {
            console.error("An error occurred:", error);
            showMessage("error", "Something went wrong. Please try again later.");
        }

    } else {
        showMessage("error", "Bio text is longer than 400 characters")
    }
}

function validateData(bio) {
    let maxCharacters = 400;
    if(bio.length <= maxCharacters) {
        return true;
    }
    return false;
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

