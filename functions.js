async function login(event) {
    event.preventDefault();
    
    const formData = new FormData(document.getElementById('loginForm'));
    const data = {
        name: formData.get('name'),
        password: formData.get('password')
    };

    const response = await fetch('account/login.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    });

    const result = await response.json();
    if (result.success) {
        window.location.reload();
    } else {
        let myModal = new bootstrap.Modal(document.getElementById('fail'));
        myModal.show();
        document.getElementById("error-output").innerHTML = result.message;
        history.pushState({}, "", "index.php");
    }
}

async function register(event) {
    event.preventDefault();
    const formData = new FormData(document.getElementById('registerForm'));
    const data = {
        name: formData.get('name'),
        password: formData.get('password'),
        password2: formData.get('password2'),
        email: formData.get("email")
    };

    const response = await fetch('account/register.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    });

    const result = await response.json();
    if (result.success) {
        window.location.reload();
    } else {
        let myModal = new bootstrap.Modal(document.getElementById('fail'));
        myModal.show();
        document.getElementById("error-output").innerHTML = result.message;
        history.pushState({}, "", "index.php");
    }
}

async function logout(event){
    event.preventDefault();

    const response = await fetch('account/logout.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify("")
    });
    const result = await response.json();
    if (result.success) {
        window.location.reload();
    } else {
        console.log("cant log out")
    }

}

async function likez(event, info, id, user_id) {
    event.preventDefault();

    const data = {
        info: info,
        id: id,
        user_id: user_id,
    };
    const response = await fetch('actions/likes.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    });

    const result = await response.json();
    if (result.success) {
        document.getElementById("likes").innerHTML = "likes : " + result.likes;
        document.getElementById("dislikes").innerHTML = "dislikes : " + result.dislikes;
    } else {
        let myModal = new bootstrap.Modal(document.getElementById('fail'));
        myModal.show();
        document.getElementById("error-output").innerHTML = result.message;
        history.pushState({}, "", "image-page.php?id=" + id);
    }
}


async function commands(event, id, user_id) {
    event.preventDefault();

    const data = {
        text: (document.getElementById('command').value),
        image_id: id,
        user_id: user_id
    };

    const response = await fetch('actions/command.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    });
    const result = await response.json();
    if (result.success) {
        document.getElementById('command').value = ""; 

        console.log("lol")
    } else {
        console.log("kek")
    }
}

