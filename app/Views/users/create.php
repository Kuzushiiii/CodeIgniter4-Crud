<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data User</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 50px;
            background-color: #F0F8FF;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 40px;
        }

        form {
            max-width: 400px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 2px 2px 12px #aaa;
            background-color: #f9f9f9;
        }

        label {
            display: block;
            width: 100%;
            font-weight: bold;
        }

        input {
            display: block;
            width: 100%;
            margin-bottom: 0px;
            padding: 8px;
            box-sizing: border-box;
        }

        button {
            padding: 10px 15px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            border-radius: 10px;
        }

        .upt {
            background-color: #4CAF50;
            color: white;
            border: none;
            margin-right: 10px;
        }

        .upt:hover {
            background-color: #45a049;
            transform: translateY(-1px);
        }

        .cnl {
            background-color: #f44336;
            color: white;
            border: none;
        }

        .cnl:hover {
            background-color: #da190b;
            transform: translateY(-1px);
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        #msg {
            text-align: center;
            margin-top: 20px;
            font-weight: bold;
            color: green;
        }
    </style>
</head>

<body>
    <h2>Tambah User</h2>

    <form id="createForm">
        <label>Username</label><br>
        <input type="text" name="username" required>
        <br><br>

        <label>Email</label><br>
        <input type="email" name="email" required>
        <br><br>

        <label>Password</label><br>
        <input type="password" name="password" required>
        <br><br>

        <button class="upt" type="submit">Simpan</button>
        <button class="cnl" type="button"><a href="/users">Batal</a></button>
    </form>

    <p id="msg"></p>

    <script>
        //menangani submit form create
        document.getElementById('createForm').addEventListener('submit', function(e) {
            e.preventDefault();

            //mengirim data form ke server menggunakan fetch API
            fetch('/users/store', {
                    method: 'POST',
                    body: new FormData(this),
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest' //menandai ini sebagai permintaan AJAX
                    }
                })
                .then(res => res.json())
                .then(result => {
                    document.getElementById('msg').innerText = result.message;
                    if (result.status) {
                        setTimeout(() => {
                            window.location.href = '/users';
                        }, 1000);
                    }
                });
        });
    </script>
</body>

</html>