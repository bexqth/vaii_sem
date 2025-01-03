
function updateFollowButton(profileId, state) {
    if(state === false) {
        giveFollow(profileId);
        followIconFill = true;
    } else {
        removeFollow(profileId);
        followIconFill = false;
    }
}

async function giveFollow(profileId) {
    let statusButton = document.getElementById("follow-button");

    let url = "http://127.0.0.1:88/?c=profile&a=giveFollow";
    let body = {
        "profileId": profileId,
    };

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
    statusButton.innerHTML = '<i class="bi bi-heart-fill"></i>';
}

async function removeFollow(profileId) {
    let statusButton = document.getElementById("follow-button");

    let url = "http://127.0.0.1:88/?c=profile&a=removeFollow";
    let body = {
        "profileId": profileId,
    };

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
    statusButton.innerHTML = '<i class="bi bi-heart"></i>';
}