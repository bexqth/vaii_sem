
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
    let followers = document.getElementById("followers");
    let followings = document.getElementById("followings");
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

    const data = await response.json();
    followers.innerHTML = data.followers + " followers";
    followings.innerHTML = data.followings + " followings";
    statusButton.innerHTML = '<i class="bi bi-heart-fill"></i>';
    statusButton.setAttribute("onclick", `updateFollowButton(${profileId}, true)`);
}

async function removeFollow(profileId) {
    let statusButton = document.getElementById("follow-button");
    let followers = document.getElementById("followers");
    let followings = document.getElementById("followings");

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
    const data = await response.json();
    followers.innerHTML = data.followers + " followers";
    followings.innerHTML = data.followings + " followings";
    statusButton.innerHTML = '<i class="bi bi-heart"></i>';
    statusButton.setAttribute("onclick", `updateFollowButton(${profileId}, false)`);
}