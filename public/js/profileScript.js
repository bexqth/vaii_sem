
let followIconFill = false;

function updateFollowButton() {
    let statusButton = document.getElementById("follow-button");
    if(followIconFill === false) {
        statusButton.innerHTML = '<i class="bi bi-heart-fill"></i>';
        followIconFill = true;
        getFollow();
    } else {
        followIconFill = false;
        statusButton.innerHTML = '<i class="bi bi-heart"></i>';
        deleteFollow();
    }
}

function getFollow() {

}

function deleteFollow() {

}