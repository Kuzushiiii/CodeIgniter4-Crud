<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AJAX CRUD Users</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 50px;
            background-color: #F0F8FF;
        }
        
        h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 50px;
            font-weight: bold;
        }

        h4 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 20px;
            font-weight: normal;
        }

        table {
            width: 67%;
            border-collapse: collapse;
            margin-top: 20px;
            margin: auto;

        }

        th,
        td {
            border-left: none;
            border-right: none;
            padding: 8px;
            text-align: center;
            border-bottom: 2px solid grey;
        }

        th {
            background-color: #97cdfcff;
            border-top: none;
            border-left: none;
            border-right: none;
            font-weight: bold;
        }

        tr:hover {
            background: #c2c5c7ff;
        }

        a {
            padding: 10px 10px;
            text-decoration: none;
        }

        button {
            margin-right: 5px;
            padding: 8px 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            font-weight: bold;
            margin: 0 2px;
            color: inherit;
            border-radius: 4px;
        }

        .tbhbtn {
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 10px;
            margin-left: 300px;
            margin-bottom: 20px;
        }

        .tbhbtn:hover {
            background-color: #45a049;
            transform: translateY(-1px);
        }

        .edtbtn {
            background-color: #ffc107;
            color: black;
            border: none;
            border-radius: 10px;
        }

        .edtbtn:hover {
            background-color: #e0a800;
            transform: translateY(-1px);
        }

        .dltbtn {
            background-color: #dc3545;
            border: none;
            color: white;
            border-radius: 10px;
        }

        .dltbtn:hover {
            background-color: #c82333;
            transform: translateY(-1px);
        }

        #cari {
            padding: 8px;
            width: 300px;
            margin-left: 300px;
        }
    </style>
</head>

<body>
    <h2>Data User</h2>
    <h4>M Tiansyah Wahyudi Putra</h4>

    <h3 style="margin-left:300px;">Cari Data User</h3>
    <input
        type="text"
        id="cari"
        placeholder="Cari username atau email..."
        style="padding:8px; width:300px;">

    <br><br>

    <button class="tbhbtn" type="button"> <a href="/users/create">Tambah User</a></button>
    <table border="1" cellpadding="8">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody id="userTable">
            <!-- Data user akan dimuat di sini melalui AJAX -->
        </tbody>
    </table>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const searchInput = document.getElementById('cari');
            const userTable = document.getElementById('userTable');

            let usersData = []; // cache data

            function fetchUsers() {
                fetch('/users/fetch')
                    .then(res => res.json())
                    .then(data => {
                        usersData = data;
                        renderTable(usersData);
                    });
            }


            function renderTable(data) {
                userTable.innerHTML = '';

                data.forEach(user => {
                    const row = document.createElement('tr');

                    row.innerHTML = `
                        <td>${user.id}</td>
                        <td>${user.username}</td>
                        <td>${user.email}</td>
                        <td>
                            <button class="edtbtn" onclick="window.location.href='/users/edit/${user.id}'">Edit</button>
                            <button class="dltbtn" onclick="deleteUser(${user.id}, '${user.username}')">Delete</button>
                        </td>
                    `;

                    userTable.appendChild(row);
                });
            }

            document.getElementById('cari').addEventListener('keyup', function() {
                const keyword = this.value.toLowerCase();

                const filtered = usersData.filter(user =>
                    user.username.toLowerCase().includes(keyword) ||
                    user.email.toLowerCase().includes(keyword)
                );

                renderTable(filtered);
            });

            window.deleteUser = function(id, username) {
                if (confirm('Hapus user ' + username + ' dengan id : ' + id + ' ?')) {
                    fetch('/users/delete/' + id, {
                            method: 'DELETE'
                        })
                        .then(r => r.json())
                        .then(res => {
                            alert(res.message);
                            fetchUsers();
                        });
                }
            };

            fetchUsers();
        });
    </script>

</body>

</html>