var tasks = document.querySelectorAll(".draggableTask");
var lists = document.querySelectorAll(".taskList");
var listID = 0;
var taskID = 0;

// Makes it so that the backend can handle the dragging class as a kind of state, so this method toggles it on/off based on event listeners for when the drag process begins, and then ends.
tasks.forEach(task => {
    task.addEventListener("dragstart", () => {
        task.classList.add("dragging");  
    });

    task.addEventListener("dragend", () => {
        task.classList.remove("dragging");  
    });
});

// This method makes it so that, every list in the board acts as a container for the draggable tasks, so therefor when a draggable task is being dragged over and then dropped over a list, we append that task to the bottom, not including the create new task element.
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

//gets the task id that the user wants to edit in the menu
document.addEventListener("click", function(e) {
    const taskMenu = e.target.closest(".moreTask");

    if (taskMenu) {
        taskID = taskMenu.dataset.taskId;
        openTaskMenu(taskID);
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

function renameList(element) {
    const xhttp = new XMLHttpRequest();
    const listID = element.dataset.listId;
    const newName = element.value;
    xhttp.open("GET", "renameList.php?listID="+encodeURIComponent(listID)+"&name="+encodeURIComponent(newName));

    xhttp.onload = function() {
        element.placeholder = newName;
        location.reload();
    };

    xhttp.send();
}

function createTask(element) {
    const xhttp = new XMLHttpRequest();
    const listID = element.dataset.listId;
    const newTask = element.value;
    xhttp.open("GET", "createTask.php?listID="+encodeURIComponent(listID)+"&name="+encodeURIComponent(newTask));

    xhttp.onload = function() {
        location.reload();
        element.value = '';
    };

    xhttp.send();
}

function renameBoard(element) {
    const xhttp = new XMLHttpRequest();
    const newName = element.value;
    const boardID = element.dataset.boardId;
    xhttp.open("GET", "renameBoard.php?name="+encodeURIComponent(newName)+"&boardID="+encodeURIComponent(boardID));

    xhttp.onload = function() {
        location.reload();
        element.value = newName;
    };

    xhttp.send();
}

function closeBoard(element) {
    const xhttp = new XMLHttpRequest();
    const boardID = element.dataset.boardId;
    xhttp.open("GET", "updateClose.php?boardID="+encodeURIComponent(boardID));

    xhttp.onload = function() {
        location.href = "boards.php";
    };
    
    xhttp.send();
}

function openTaskMenu(element) {
    document.getElementById("taskMenu").style.display = 'block';
    document.getElementById("taskMenuHeading").innerText = element.dataset.taskName;
    document.getElementById("taskDate").innerText = 'Created: ' + element.dataset.taskDate;
    document.getElementById("taskDesc").innerText = 'Description: ' + element.dataset.taskDesc;
    taskID = element.dataset.taskId
}

function closeTaskMenu() {
    document.getElementById("taskMenu").style.display = 'none';
}

//lets user click anywhere outside of task menu to close
document.getElementById("taskMenu").addEventListener("click", function(e) {
    if(e.target === this) closeTaskMenu();
});

function deleteTask(taskID) {
        const xhttp = new XMLHttpRequest();
        xhttp.open("GET", "deleteTask.php?taskID="+encodeURIComponent(taskID));

        xhttp.onload = function() {
            location.reload();
        };
        
        xhttp.send();
}

document.getElementById("taskForm").addEventListener("submit", async (e, taskID) =>  {
    e.preventDefault();

    const formData = new FormData(document.getElementById("taskForm"));

    try {
        const response = await fetch("updateTask.php", {
            method: 'POST',
            body: JSON.stringify({
                taskID: taskID,
                taskName: formData.get("taskName"),
                taskDesc: formData.get("taskDesc")
            }),
            headers: {
                'Content-Type': 'application/json'
            }
        });

        const result = await response.json();

        if (result.success) {
            location.reload();
        }
    } catch (error) {
        console.error("Error:", error);
        alert("An error has occured, please try again.");
    }
});