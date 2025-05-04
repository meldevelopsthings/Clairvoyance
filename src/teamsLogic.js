let selectedUsers = [];

function usernameSearchOpen() {
    document.getElementById("searchPopup").style.display = 'inline-block';
    document.getElementById("usernameSearchBox").focus;
}

function renderResults(users) {
    const resultsDiv = document.getElementById("searchResults");
    resultsDiv.innerHTML = users.map(user => {
        const isChecked = selectedUsers.some(u => u === user);
        return `
            <label class="flex items-center p-2 hover:bg-lighter-500 rounded">
                <input type="checkbox"
                    class="mr-2"
                    value="${user.replace(/"/g, '&quot;')}"
                    ${isChecked ? "checked" : ""}
                    onchange="handleUserSelection('${user.replace(/'/g, "\\'")}')">
                ${user}
            </label>
        `;
    }).join('');
}

function handleUserSelection(username) {
    const index = selectedUsers.indexOf(username);
    if (index === -1) {
        selectedUsers.push(username);
    } else {
        selectedUsers.splice(index, 1);
    }
    console.log("Current selected users:", selectedUsers);
}

function confirmMembers() {
    selectedUsers = [...new Set(selectedUsers)].filter(Boolean);
    
    document.getElementById("teamUsernames").value = selectedUsers.join(', ');
    document.getElementById("searchPopup").classList.add("hidden");
    
    document.getElementById("usernameSearch").value = '';
    document.getElementById("searchResults").innerHTML = '';
    
    console.log("Final selected users:", selectedUsers);
}

document.getElementById("usernameSearchBox").addEventListener("input" ,async function(e) {
   const searchTerm = e.target.value;
   
   try {
    const response = await fetch(`searchUsers.php?term=${encodeURIComponent(searchTerm)}`);
    const users = await response.json();

    renderResults(users);

   } catch (error) {
    console.error("Erorr:", error);
   }
});

function confirmMembers() {
    document.getElementById("searchPopup").classList.add("hidden");
    document.getElementById("teamUsernames").value = selectedUsers.join(", ");
    document.getElementById("usernameSearchBox").value = '';
    document.getElementById("searchResults").innerHTML = '';
}

function usernameSearchClose() {
    document.getElementById("searchPopup").style.display = 'none';
}
