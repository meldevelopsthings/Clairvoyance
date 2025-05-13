var tasks = document.querySelectorAll(".draggableTask");
var lists = document.querySelectorAll(".taskList");
var listID = 0;


tasks.forEach(task => {
    task.addEventListener("dragstart", () => {
        task.classList.add("dragging");  
    });

    task.addEventListener("dragend", () => {
        task.classList.remove("dragging");  
    });
});

lists.forEach(list => {
    list.addEventListener("dragover", e => {
        e.preventDefault();
        const task = document.querySelector(".dragging");
        const last = list.lastElementChild;
        list.insertBefore(task, last);
        
        const xhttp = new XMLHttpRequest();
        xhttp.open("GET", "changeList.php?newListID="+list.id+"&taskID="+task.id);
        xhttp.send();
    });
});

function deleteWarningOpen() {
    document.getElementById("deleteBoardWarning").style.display = 'block';
}

function deleteWarningClose() {
    document.getElementById("deleteBoardWarning").style.display = 'none';
}

function deleteBoard() {
    const xhttp = new XMLHttpRequest();
    const urlInfo = new URLSearchParams(window.location.search);
    const boardID = urlInfo.get("boardID");
    xhttp.open("GET", "deleteBoard.php?boardID="+boardID);

    xhttp.onload = function() {
        window.location.href = 'boards.php';
    };

    xhttp.send();
}

function newList() {
    const xhttp = new XMLHttpRequest();
    const urlInfo = new URLSearchParams(window.location.search);
    const boardID = urlInfo.get("boardID");
    xhttp.open("GET", "createList.php?boardID="+boardID);

    xhttp.onload = function() {
        location.reload();
    };

    xhttp.send();
}

//gets the list id that the user tries to delete
document.addEventListener("click", function(e) {
    const deleteButton = e.target.closest(".delButton");

    if (deleteButton) {
        listID = deleteButton.dataset.listId;
        deleteList(listID);
    } 
});

//gets the list id that the user tries to update
document.addEventListener("click", function(e) {
    const listEdited = e.target.closest(".taskListText");

    if (listEdited) {
        listID = listEdited.dataset.listId;
    }
});

function deleteList(listID) {
    const xhttp = new XMLHttpRequest();
    xhttp.open("GET", "deleteList.php?listID="+listID);

    xhttp.onload = function() {
        location.reload();
    };

    xhttp.send();
}

function renameList() {
    const xhttp = new XMLHttpRequest();
    const newName = document.querySelector("input[name='listName']").value;
    xhttp.open("GET", "renameList.php?listID="+encodeURIComponent(listID)+"&name="+encodeURIComponent(newName));

    xhttp.onload = function() {
        location.reload();
    };

    xhttp.send();
}
