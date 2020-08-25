<!DOCTYPE html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Simple Dashboard - Listing Users</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">

        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" 
            integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" 
            crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css?family=Lato|Roboto" rel="stylesheet">  
        <link rel="stylesheet" href="css/simpledashboard.css">
    </head>
    <body>
        <header>
            <h1><a href="index.php">Simple Dashboard</a></h1>
        </header>

        <div class="users">
            <div style="width:100%; margin-bottom: 50px; text-align:right;">
                <a href="new.php" class="btn-green">
                    <span class="fa fa-plus"></span>&nbsp;&nbsp;New User
                </a>
            </div>
            <!-- Fetching users from database -->
            <?php
                // Include functions file
                require_once 'includes/SimpleDashboard.php';

                // Displaying users
                $users = getUsers();
                if (count($users) > 0) {
                    foreach ($users as $user) { ?>
                        <div class="user">
                            <img class="image" src="uploads/images/<?= $user['avatar']; ?>" width="130px" height="110px">
                            <div class="details">
                                <span><strong><?= $user['firstname']; ?> <?= $user['lastname']; ?></strong> - (<?= $user['age']; ?> years)</span><br /><br />
                                <span><i class="fa fa-envelope"></i><?= $user['email']; ?></span><br />
                                <span><i class="fa fa-map-marker-alt"></i><?= $user['city']; ?> <?= $user['region']; ?>, <?= $user['country']; ?></span><br />
                                <span><i class="fa fa-calendar-alt"></i>Registered on: <?= (new DateTime($user['created_at']))->format('M d, Y'); ?></span><br />
                            </div>
                            <div class="options">
                                <a href="user.php?id=<?= $user['id']; ?>" class="btn-orange" style="margin-top: 4rem;">View</a>
                            </div>
                        </div><!-- ./user -->
                    <?php }
                } else {
                    // No user to list.
                    ?>
                        <div class="alert alert-danger">
                            <span class="fa fa-ban"></span>
                            <span>There is no user to show.</span>
                        </div>
                    <?php
                }
            ?>
        </div>

        <footer>
            <span>&copy; 2020 - SimpleDashboard</span>
        </footer>
    </body>
</html>