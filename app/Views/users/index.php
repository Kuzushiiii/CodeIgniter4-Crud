<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD AJAX CI4 - Tian</title>
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
            box-shadow: 0 10px 8px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            background-color: #ffffff;
            text-align: center;

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
        //ambil elemen cari dan tabel berdasarkan id
        const cariInput = document.getElementById('cari');
        const userTable = document.getElementById('userTable');

        //event keyup untuk input pencarian
        //saat user mengetik, AJAX akan mengirim permintaan ke controller
        cariInput.addEventListener('keyup', () => {
            fetchUsers(cariInput.value);
        });

        //fungsi untuk mengambil data user dari controller
        function fetchUsers(keyword = '') {
            fetch('/users/fetch?keyword=' + encodeURIComponent(keyword))
                .then(response => response.json())
                .then(data => {
                    //data dari controller berupa array
                    if (Array.isArray(data)) {
                        renderTable(data);
                    } else {
                        renderTable([]);
                    }
                })
                .catch(error => {
                    console.error('Error fetching users:', error);
                    renderTable([]);
                });
        }

        //fungsi untuk menampilkan data user di tabel
        function renderTable(users) {
            userTable.innerHTML = '';

            if (!Array.isArray(users)) {
                return;
            }

            users.forEach(user => {
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

        //fungsi untuk menghapus user menggunakan AJAX metode DELETE
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
        // Muat data user saat halaman dimuat
        fetchUsers();
    </script>
<footer>
    <h4 style="text-align:center; margin-top:20px;">M Tiansyah Wahyudi Putra</h4>
</footer>
</body>

</html>