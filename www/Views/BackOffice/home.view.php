<?php



$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../..');
$dotenv->load();

if ($_SERVER['SERVER_NAME'] === 'localhost') {
    $baseUrl = $_ENV['LOCALHOST_URL'];
} else {
    $baseUrl = $_ENV['PROD_URL'];
}

?>


<script>
        var baseUrl = '<?= $baseUrl ?>';

    var url = baseUrl + "users/get.php";


    function getAllUser(data, callback) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4) {
                if (this.status == 200) {
                    if (typeof callback === 'function') {
                        callback(this.responseText);
                    }
                    var responseData = JSON.parse(this.responseText);


                    var users = responseData.users;

                    updateTable(users);
                } else {
                    console.error("Error: " + this.status);
                }
            }
        };
        xhttp.open("GET", url, true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send(data);
    }

    function updateTable(users) {
        var tableBody = document.querySelector('#userTable tbody');
        tableBody.innerHTML = '';

        if (users.length === 0) {
            var row = document.createElement('tr');
            row.innerHTML = '<td colspan="5">No users found</td>';
            tableBody.appendChild(row);
            return;
        }

        users.forEach(function (user) {
            var row = document.createElement('tr');
            row.innerHTML = '<td>' + user.id + '</td>' +
                '<td>' + user.name + '</td>' +
                '<td>' + user.email + '</td>' +
                '<td>' + user.status + '</td>' +
                '<td>' +
                '<a href="#" class="btn">Edit</a>' +
                '<a href="#" class="btn btn-delete">Delete</a>' +
                '</td>';
            tableBody.appendChild(row);
        });
    }


</script>
<script>

    getAllUser(null, function (response) {
        console.log(response);
    });
</script>


<table id="userTable">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>

    </tbody>
</table>