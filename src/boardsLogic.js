const tasks = document.querySelectorAll(".draggableTask");
const lists = document.querySelectorAll(".draggableList");


tasks.forEach(task => {
    task.addEventListener("dragstart", () => {
        task.classList.add("dragging");  
    })

    task.addEventListener("dragend", () => {
        task.classList.remove("dragging");  
    })
})

lists.forEach(list => {
    list.addEventListener("dragover", e => {
        e.preventDefault();
        const task = document.querySelector(".dragging");
        const last = list.lastElementChild;
        list.insertBefore(task, last);
        
        const xhttp = new XMLHttpRequest();
        xhttp.open("GET", "changeList.php?newListID="+list.id+"&taskID="+task.id);
        xhttp.send();
    })
})


