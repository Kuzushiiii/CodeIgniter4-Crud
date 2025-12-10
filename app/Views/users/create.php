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

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
            $('#createForm').on('submit', function(e) {
                e.preventDefault();

                const formData = $(this).serialize();

                $.ajax({
                    url: '/users/store',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        $('#msg').text(response.message);
                        if (response.status) {
                            $('#msg').css('color', 'green');
                            $('#createForm')[0].reset();
                            setTimeout(() => {
                                window.location.href = '/users';
                            }, 1500);
                        } else {
                            $('#msg').css('color', 'red');
                        }
                    },
                    error: function() {
                        $('#msg').text('Terjadi kesalahan saat menyimpan data.').css('color', 'red');
                    }
                });
            });
    </script>
</body>

</html>