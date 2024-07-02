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