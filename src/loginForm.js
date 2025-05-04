function loginEvent(event) {
    event.preventDefault();

    const formData = new FormData(document.getElementById("loginForm"));

    fetch("validation.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        document.getElementById("message").innerHTML = data;
        
        if (data === "success") {
            window.location.href = 'boards.php';
        }
    })
    .catch(error => {
        console.error("Error:", error);
        document.getElementById("message").innerHTML = "An error has occured, please try again.";
    });
}

function showPass() {
    var x = document.getElementById("password");
    if (x.type === "password") {
      x.type = "text";
    } else {
      x.type = "password";
    }
  } 