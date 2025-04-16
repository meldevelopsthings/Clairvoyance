let usernames = [];

function addUsername() {
    const inputField = document.getElementById("teamInvites");
    const username = inputField.value.trim();

    if (username) {
        usernames.push(username);
        inputField.value = '';
    } else {
        alert("Please enter a username.")
    }
}

function submitUsername() {
    if (usernames.length == 0) {
        alert ("No usernames to submit.");
        return;
    }

    fetch("teamsLogicPhp.php", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ usernames: usernames })
    })
}

// document.getElementById('submitButton').addEventListener("click", addUsername);

document.getElementById("teamInvites").addEventListener("keypress", function(event) {
    if (event.key === "Enter") {
        addUsername();
    }
});