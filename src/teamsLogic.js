function usernameSearchOpen() {
    document.getElementById("searchPopup").style.display = 'inline-block';
    document.getElementById("teamUsernames").placeholder = 'Search by username';
}

function usernameSearchClose() {
    document.getElementById("searchPopup").style.display = 'none';
}