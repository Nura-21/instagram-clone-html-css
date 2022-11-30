
<html>

<body>

<?php

session_start();


if(isset($_SESSION['searchErr']))
{
    echo $_SESSION['searchErr'];
    unset($_SESSION['searchErr']);
}


if (!isset($_SESSION['search_details']))
{
    echo "No results found";
}


$search_results = $_SESSION['search_details'];


?>

<table>

    <thead>
        <tr>
            <th>Username</th>
            <th>Avatar</th>
            <th>Description</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach($search_results as $search_result) { ?>
            <tr>
                <td><?php echo $search_result['user_name']; ?></td>
                <td><?php echo '<img src="data:image/jpeg;base64,' . base64_encode($search_result['avatar']) . '" />'; ?></td>
                <td><?php echo $search_result['description']; ?></td>
            </tr>
        <?php } ?>
    </tbody>


</body>

</html>

<?php

?>