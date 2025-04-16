let usernames = [];

function addUsername() {
    const inputField = document.getElementById("teamInvites");
    const teamName = document.getElementById("teamName");
    const username = inputField.value.trim();

    if (teamName) {
        
    }

    if (username) {
        usernames.push(username);
        inputField.value = '';
    } else {
        alert("Please enter a username.")
    }
}

// document.getElementById('submitButton').addEventListener("click", addUsername);

document.getElementById("teamInvites").addEventListener("keypress", function(event) {
    if (event.key === "Enter") {
        addUsername();
    }
});