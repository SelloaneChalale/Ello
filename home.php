<?php
include 'config.php';
// Retrieve posts with user information
$sql = "SELECT p.content, p.image, p.created_at, u.username FROM posts p JOIN users u ON p.user_id = u.id WHERE published ='1' ORDER BY p.created_at DESC  ";
$result = mysqli_query($conn, $sql);
$posts = mysqli_fetch_all($result, MYSQLI_ASSOC);

function publishScheduledPosts($conn) {
    // Current time in the format 'YYYY-MM-DDTHH:MM'
    $current_time = date('Y-m-d\TH:i');

    // Update query to set published to '1' for all posts where schedule_time has passed and published is '0'
    $update_sql = "UPDATE posts SET published = '1' WHERE schedule_time <= ? AND published = '0'";
    $stmt = $conn->prepare($update_sql);
    if (!$stmt) {
        die("Error preparing statement: " . $conn->error);
    }

    // Bind the current time parameter
    $stmt->bind_param("s", $current_time);

    // Execute the update query
    if ($stmt->execute()) {
        // echo "Posts updated successfully!";
    } else {
        echo "Error updating posts: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Ensure the $conn variable is defined and passed securely from your config
publishScheduledPosts($conn);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/png" href="assets/images/logo.png" />
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Ello - Social Network</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Major+Mono+Display" rel="stylesheet">
    <link href='https://cdn.jsdelivr.net/npm/boxicons@1.9.2/css/boxicons.min.css' rel='stylesheet'>

    <!-- Styles -->
    <link href="assets/css/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/components.css" rel="stylesheet">
    <link href="assets/css/media.css" rel="stylesheet">
    <link href="https://vjs.zencdn.net/7.4.1/video-js.css" rel="stylesheet">
    <script src="https://vjs.zencdn.net/ie8/1.1.2/videojs-ie8.min.js"></script>
</head>

<body class="newsfeed">
    <div class="container-fluid" id="wrapper">
        <div class="row newsfeed-size">
            <div class="col-md-12 newsfeed-right-side">
                <nav id="navbar-main" class="navbar navbar-expand-lg shadow-sm sticky-top">
                    <ul class="navbar-nav mr-5" id="main_menu">
                        <a class="navbar-brand nav-item mr-lg-5" href="index.html"><img src="assets/images/logo.png" width="40" height="40" class="mr-3" alt="Logo"></a>
                        <!-- Collect the nav links, forms, and other content for toggling -->
                        <form class="w-30 mx-2 my-auto d-inline form-inline mr-5">
                            <div class="input-group">
                                <input type="text" class="form-control search-input w-75" placeholder="Search for people, companies, events and more..." aria-label="Search" aria-describedby="search-addon">
                                <div class="input-group-append">
                                    <button class="btn search-button" type="button"><i class='bx bx-search'></i></button>
                                </div>
                            </div>
                        </form>
                        <li class="nav-item btn-group d-mobile">
                            <a href="#" class="nav-link nav-icon nav-links" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="bx bx-plus"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right nav-dropdown-menu">
                                <a href="#" class="dropdown-item" aria-describedby="createGroup">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <i class='bx bx-group post-option-icon'></i>
                                        </div>
                                        <div class="col-md-10">
                                            <span class="fs-9">Group</span>
                                            <small id="createGroup" class="form-text text-muted">Find people with shared interests</small>
                                        </div>
                                    </div>
                                </a>
                                <a href="#" class="dropdown-item" aria-describedby="createEvent">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <i class='bx bx-calendar post-option-icon'></i>
                                        </div>
                                        <div class="col-md-10">
                                            <span class="fs-9">Event</span>
                                            <small id="createEvent" class="form-text text-muted">bring people together with a public or private event</small>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </li>
                        <li class="nav-item dropdown message-drop-li">
                            <a href="#" class="nav-link nav-links message-drop" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class='bx bxs-message-rounded message-dropdown'></i> <span class="badge badge-pill badge-primary">1</span>
                            </a>
                            <ul class="dropdown-menu notify-drop dropdown-menu-right nav-drop">
                                <div class="notify-drop-title">
                                    <div class="fs-8">Messages | <a href="#">Requests</a></div>
                                    <div>
                                        <a href="#" class="notify-right-icon">
                                            Mark All as Read
                                        </a>
                                    </div>
                                </div>
                                <!-- end notify title -->
                                <!-- notify content -->
                                <div class="drop-content">
                                    <li>
                                        <div class="col-md-3 col-sm-3 col-xs-3">
                                            <div class="notify-img">
                                                <img src="assets/images/users/user-6.png" alt="notification user image">
                                            </div>
                                        </div>
                                        <div class="col-md-9 col-sm-9 col-xs-9 pd-l0">
                                            <a href="#" class="notification-user">Susan P. Jarvis</a>
                                            <a href="#" class="notify-right-icon">
                                                <i class='bx bx-radio-circle-marked'></i>
                                            </a>
                                            <p class="time">
                                                <i class='bx bx-check'></i> This party is going to have a DJ, food, and drinks.
                                            </p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="col-md-3 col-sm-3 col-xs-3">
                                            <div class="notify-img">
                                                <img src="assets/images/users/user-5.png" alt="notification user image">
                                            </div>
                                        </div>
                                        <div class="col-md-9 col-sm-9 col-xs-9 pd-l0">
                                            <a href="#" class="notification-user">Ruth D. Greene <span class="badge badge-pill badge-primary ml-1">1</span></a>
                                            <a href="#" class="notify-right-icon">
                                                <i class='bx bx-radio-circle-marked'></i>
                                            </a>
                                            <p class="time">
                                                Great, I’ll see you tomorrow!.
                                            </p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="col-md-3 col-sm-3 col-xs-3">
                                            <div class="notify-img">
                                                <img src="assets/images/users/user-7.png" alt="notification user image">
                                            </div>
                                        </div>
                                        <div class="col-md-9 col-sm-9 col-xs-9 pd-l0">
                                            <a href="#" class="notification-user">Kimberly R. Hatfield</a>
                                            <a href="#" class="notify-right-icon">
                                                <i class='bx bx-radio-circle-marked'></i>
                                            </a>
                                            <p class="time">
                                                yeah, I will be there.
                                            </p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="col-md-3 col-sm-3 col-xs-3">
                                            <div class="notify-img">
                                                <img src="assets/images/users/user-8.png" alt="notification user image">
                                            </div>
                                        </div>
                                        <div class="col-md-9 col-sm-9 col-xs-9 pd-l0">
                                            <a href="#" class="notification-user">Joe S. Feeney</a>
                                            <a href="#" class="notify-right-icon">
                                                <i class='bx bx-radio-circle-marked'></i>
                                            </a>
                                            <p class="time">
                                                I would really like to bring my friend Jake, if...
                                            </p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="col-md-3 col-sm-3 col-xs-3">
                                            <div class="notify-img">
                                                <img src="assets/images/users/user-9.png" alt="notification user image">
                                            </div>
                                        </div>
                                        <div class="col-md-9 col-sm-9 col-xs-9 pd-l0">
                                            <a href="#" class="notification-user">William S. Willmon</a>
                                            <a href="#" class="notify-right-icon">
                                                <i class='bx bx-radio-circle-marked'></i>
                                            </a>
                                            <p class="time">
                                                Sure, what can I help you with?
                                            </p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="col-md-3 col-sm-3 col-xs-3">
                                            <div class="notify-img">
                                                <img src="assets/images/users/user-10.png" alt="notification user image">
                                            </div>
                                        </div>
                                        <div class="col-md-9 col-sm-9 col-xs-9 pd-l0">
                                            <a href="#" class="notification-user">Sean S. Smith</a>
                                            <a href="#" class="notify-right-icon">
                                                <i class='bx bx-radio-circle-marked'></i>
                                            </a>
                                            <p class="time">
                                                Which of those two is best?
                                            </p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="col-md-3 col-sm-3 col-xs-3">
                                            <div class="notify-img">
                                                <img src="assets/images/users/user-10.png" alt="notification user image">
                                            </div>
                                        </div>
                                        <div class="col-md-9 col-sm-9 col-xs-9 pd-l0">
                                            <a href="#" class="notification-user">Sean S. Smith</a>
                                            <a href="#" class="notify-right-icon">
                                                <i class='bx bx-radio-circle-marked'></i>
                                            </a>
                                            <p class="time">
                                                Which of those two is best?
                                            </p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="col-md-3 col-sm-3 col-xs-3">
                                            <div class="notify-img">
                                                <img src="assets/images/users/user-10.png" alt="notification user image">
                                            </div>
                                        </div>
                                        <div class="col-md-9 col-sm-9 col-xs-9 pd-l0">
                                            <a href="#" class="notification-user">Test S. Smith</a>
                                            <a href="#" class="notify-right-icon">
                                                <i class='bx bx-radio-circle-marked'></i>
                                            </a>
                                            <p class="time">
                                                Which of those two is best?
                                            </p>
                                        </div>
                                    </li>
                                </div>
                                <div class="notify-drop-footer text-center">
                                    <a href="#">See More</a>
                                </div>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link nav-links" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class='bx bxs-bell notification-bell'></i> <span class="badge badge-pill badge-primary">3</span>
                            </a>
                            <ul class="dropdown-menu notify-drop notify-mobile dropdown-menu-right nav-drop">
                                <div class="notify-drop-title">
                                    <div class="fs-8">Notifications <span class="badge badge-pill badge-primary ml-2">3</span></div>
                                    <div>
                                        <a href="#" class="notify-right-icon">
                                            Mark All as Read
                                        </a>
                                    </div>
                                </div>
                                <!-- end notify title -->
                                <!-- notify content -->
                                <div class="drop-content">
                                    <li>
                                        <div class="col-md-3 col-sm-3 col-xs-3">
                                            <div class="notify-img">
                                                <img src="assets/images/users/user-10.png" alt="notification user image">
                                            </div>
                                        </div>
                                        <div class="col-md-9 col-sm-9 col-xs-9 pd-l0">
                                            <a href="#" class="notification-user">Sean</a> <span class="notification-type">replied to your comment on a post in </span><a href="#" class="notification-for">PHP</a>
                                            <a href="#" class="notify-right-icon">
                                                <i class='bx bx-radio-circle-marked'></i>
                                            </a>
                                            <p class="time">
                                                <span class="badge badge-pill badge-primary"><i class='bx bxs-group'></i></span> 3h
                                            </p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="col-md-3 col-sm-3 col-xs-3">
                                            <div class="notify-img">
                                                <img src="assets/images/users/user-7.png" alt="notification user image">
                                            </div>
                                        </div>
                                        <div class="col-md-9 col-sm-9 col-xs-9 pd-l0">
                                            <a href="#" class="notification-user">Kimberly</a> <span class="notification-type">likes your comment "I would really... </span>
                                            <a href="#" class="notify-right-icon">
                                                <i class='bx bx-radio-circle-marked'></i>
                                            </a>
                                            <p class="time">
                                                <span class="badge badge-pill badge-primary"><i class='bx bxs-like'></i></span> 7h
                                            </p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="col-md-3 col-sm-3 col-xs-3">
                                            <div class="notify-img">
                                                <img src="assets/images/users/user-8.png" alt="notification user image">
                                            </div>
                                        </div>
                                        <div class="col-md-9 col-sm-9 col-xs-9 pd-l0">
                                            <span class="notification-type">10 people saw your story before it disappeared. See who saw it.</span>
                                            <a href="#" class="notify-right-icon">
                                                <i class='bx bx-radio-circle-marked'></i>
                                            </a>
                                            <p class="time">
                                                <span class="badge badge-pill badge-primary"><i class='bx bx-images'></i></span> 23h
                                            </p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="col-md-3 col-sm-3 col-xs-3">
                                            <div class="notify-img">
                                                <img src="assets/images/users/user-11.png" alt="notification user image">
                                            </div>
                                        </div>
                                        <div class="col-md-9 col-sm-9 col-xs-9 pd-l0">
                                            <a href="#" class="notification-user">Michelle</a> <span class="notification-type">posted in </span><a href="#" class="notification-for">Ello Social Design System</a>
                                            <a href="#" class="notify-right-icon">
                                                <i class='bx bx-radio-circle-marked'></i>
                                            </a>
                                            <p class="time">
                                                <span class="badge badge-pill badge-primary"><i class='bx bxs-quote-right'></i></span> 1d
                                            </p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="col-md-3 col-sm-3 col-xs-3">
                                            <div class="notify-img">
                                                <img src="assets/images/users/user-5.png" alt="notification user image">
                                            </div>
                                        </div>
                                        <div class="col-md-9 col-sm-9 col-xs-9 pd-l0">
                                            <a href="#" class="notification-user">Karen</a> <span class="notification-type">likes your comment "Sure, here... </span>
                                            <a href="#" class="notify-right-icon">
                                                <i class='bx bx-radio-circle-marked'></i>
                                            </a>
                                            <p class="time">
                                                <span class="badge badge-pill badge-primary"><i class='bx bxs-like'></i></span> 2d
                                            </p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="col-md-3 col-sm-3 col-xs-3">
                                            <div class="notify-img">
                                                <img src="assets/images/users/user-12.png" alt="notification user image">
                                            </div>
                                        </div>
                                        <div class="col-md-9 col-sm-9 col-xs-9 pd-l0">
                                            <a href="#" class="notification-user">Irwin</a> <span class="notification-type">posted in </span><a href="#" class="notification-for">Themeforest</a>
                                            <a href="#" class="notify-right-icon">
                                                <i class='bx bx-radio-circle-marked'></i>
                                            </a>
                                            <p class="time">
                                                <span class="badge badge-pill badge-primary"><i class='bx bxs-quote-right'></i></span> 3d
                                            </p>
                                        </div>
                                    </li>
                                </div>
                                <div class="notify-drop-footer text-center">
                                    <a href="#">See More</a>
                                </div>
                            </ul>
                        </li>
                        <li class="nav-item dropdown d-mobile">
                            <a href="#" class="nav-link nav-links nav-icon" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="bx bx-flag"></i></a>
                            <div class="dropdown-menu dropdown-menu-right nav-drop">
                                <a class="dropdown-item" href="sign-in.html">Sign in</a>
                                <a class="dropdown-item" href="sign-up.html">Sign up</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link nav-links" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <div class="menu-user-image">
                                    <img src="assets/images/users/user-4.png" class="menu-user-img ml-1" alt="Menu Image">
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right nav-drop">
                                <a class="dropdown-item" href="profile.html"><i class='bx bx-user mr-2'></i> Account</a>
                                <div role="separator" class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#"><i class='bx bx-undo mr-2'></i> Logout</a>
                            </div>
                        </li>
                        <li class="nav-item nav-icon">
                            <a href="settings.html" class="nav-link"><i class="bx bx-cog"></i></a>
                        </li>
                    </ul>
                    <button type="button" class="btn btn-primary mr-3" id="menu-toggle"><i class='bx bx-align-left'></i></button>
                </nav>
                <div class="row newsfeed-right-side-content mt-3">
                    <div class="col-md-2 newsfeed-left-side sticky-top shadow-sm" id="sidebar-wrapper">
                        <div class="card newsfeed-user-card h-100">
                            <ul class="list-group list-group-flush newsfeed-left-sidebar">
                                 <li class="list-group-item">
                                    <h6>Home</h6>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center sd-active">
                                    <a href="index.html" class="sidebar-item"><img src="assets/images/icons/left-sidebar/newsfeed.png" alt="newsfeed"> News Feed</a>
                                    <a href="#" class="newsfeedListicon"><i class='bx bx-dots-horizontal-rounded'></i></a>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <a href="messages.html" class="sidebar-item"><img src="assets/images/icons/left-sidebar/message.png" alt="message"> Messages</a>
                                    <span class="badge badge-primary badge-pill">2</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <a href="groups.html" class="sidebar-item"><img src="assets/images/icons/left-sidebar/group.png" alt="group"> Groups</a>
                                    <span class="badge badge-primary badge-pill">17</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <a href="events.html" class="sidebar-item"><img src="assets/images/icons/left-sidebar/event.png" alt="event"> Events</a>
                                    <span class="badge badge-primary badge-pill">3</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <a href="saved.html" class="sidebar-item"><img src="assets/images/icons/left-sidebar/saved.png" alt="saved"> Saved</a>
                                    <span class="badge badge-primary badge-pill">8</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <a href="friends" class="sidebar-item"><img src="assets/images/icons/left-sidebar/find-friends.png" alt="find-friends"> Find Friends</a>
                                    <span class="badge badge-primary badge-pill"><i class='bx bx-chevron-right'></i></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <a href="matches.html" class="sidebar-item"><img src="assets/images/icons/left-sidebar/matches.png" alt="matches"> Matches</a>
                                    <span class="badge badge-primary badge-pill"><i class='bx bx-chevron-right'></i></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <a href="teams.html" class="sidebar-item"><i class='bx bxl-slack-old text-primary'></i> Ello For Teams</a>
                                    <span class="badge badge-primary badge-pill"><i class='bx bx-chevron-right'></i></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center newsLink">
                                    <a href="https://github.com/ArtMin96/Ello-social" target="_blank" class="sidebar-item"><i class='bx bx-file text-primary'></i> News</a>
                                    <span class="badge badge-primary badge-pill"><i class='bx bx-chevron-right'></i></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6 second-section" id="page-content-wrapper">
                        <div class="mb-3">
                            <div class="btn-group d-flex">
                                <a href="index.html" class="btn btn-quick-links mr-3 ql-active">
                                    <i class='bx bx-microphone mr-2'></i>
                                    <span class="fs-8">Speech</span>
                                </a>
                                <a href="messages.html" class="btn btn-quick-links mr-3">
                                    <i class='bx bx-pulse mr-2'></i>
                                    <span class="fs-8">Listen</span>
                                </a>
                                <a href="watch.html" class="btn btn-quick-links">
                                    <i class='bx bx-play-circle mr-2'></i>
                                    <span class="fs-8">Watch</span>
                                </a>
                            </div>
                        </div>
                        <ul class="list-unstyled" style="margin-bottom: 0;">
                            <li class="media post-form w-shadow">
                            <form method="post" action="create_post.php" enctype="multipart/form-data">
                                <div class="media-body">
                                    <div class="form-group post-input">
                                        <textarea class="form-control" required name="content" id="postForm" rows="2" placeholder="What's on your mind?"></textarea>
                                    </div>
                                    <div class="row post-form-group">
    <div class="col-md-9">
        <button type="button" class="btn btn-link post-form-btn btn-sm" name="image">
            <img src="assets/images/icons/theme/post-image.png"> <span>Photo/Video</span>
        </button>
        <input type="file" name="image" id="imageInput" accept="image/*" style="display: none;">
        <button data-toggle="modal" data-target="#exampleModal" class="btn btn-primary btn-sm">Schedule post</button>
    </div>
    <div class="col-md-3 text-right">
        <button type="submit" class="btn btn-primary btn-sm">Publish</button>
 
    </div>
    
</div>
                                </div>
                            </form>
                            </li>
                        </ul><br><br>

                        <!-- Posts -->
                        <?php foreach($posts as $key => $post):?>
                        <div class="posts-section mb-5">
                            <div class="post border-bottom p-3 bg-white w-shadow">
                                <div class="media text-muted pt-3">
                                    <img src="assets/images/users/user-1.jpg" alt="Online user" class="mr-3 post-user-image">
                                    <div class="media-body pb-3 mb-0 small lh-125">
                                        <div class="d-flex justify-content-between align-items-center w-100">
                                            <a href="#" class="text-gray-dark post-user-name"><?php echo $post['username'];?></a>
                                            <div class="dropdown">
                                                <a href="#" class="post-more-settings" role="button" data-toggle="dropdown" id="postOptions" aria-haspopup="true" aria-expanded="false">
                                                    <i class='bx bx-dots-horizontal-rounded'></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-left post-dropdown-menu">
                                                    <a href="#" class="dropdown-item" aria-describedby="savePost">
                                                        <div class="row">
                                                            <div class="col-md-2">
                                                                <i class='bx bx-bookmark-plus post-option-icon'></i>
                                                            </div>
                                                            <div class="col-md-10">
                                                                <span class="fs-9">Save post</span>
                                                                <small id="savePost" class="form-text text-muted">Add this to your saved items</small>
                                                            </div>
                                                        </div>
                                                    </a>
                                                    <a href="#" class="dropdown-item" aria-describedby="hidePost">
                                                        <div class="row">
                                                            <div class="col-md-2">
                                                                <i class='bx bx-hide post-option-icon'></i>
                                                            </div>
                                                            <div class="col-md-10">
                                                                <span class="fs-9">Hide post</span>
                                                                <small id="hidePost" class="form-text text-muted">See fewer posts like this</small>
                                                            </div>
                                                        </div>
                                                    </a>
                                                    <a href="#" class="dropdown-item" aria-describedby="snoozePost">
                                                        <div class="row">
                                                            <div class="col-md-2">
                                                                <i class='bx bx-time post-option-icon'></i>
                                                            </div>
                                                            <div class="col-md-10">
                                                                <span class="fs-9">Snooze Lina for 30 days</span>
                                                                <small id="snoozePost" class="form-text text-muted">Temporarily stop seeing posts</small>
                                                            </div>
                                                        </div>
                                                    </a>
                                                    <a href="#" class="dropdown-item" aria-describedby="reportPost">
                                                        <div class="row">
                                                            <div class="col-md-2">
                                                                <i class='bx bx-block post-option-icon'></i>
                                                            </div>
                                                            <div class="col-md-10">
                                                                <span class="fs-9">Report</span>
                                                                <small id="reportPost" class="form-text text-muted">I'm concerned about this post</small>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <span class="d-block"> 
                                            
                                        <?php 
                                          $date = new DateTime($post['created_at']);
                                        echo diffForHumans($date);?> <i class='bx bx-globe ml-3'></i></span>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <p><?php echo $post['content'];?></p>
                                </div>
                                <div class="d-block mt-3">
                                    <?php $img = $post['image'];
                                    if(empty($img)){
                                        echo '';
                                    }else{
                                        echo ' <img src="'.$img.'" class="post-content" alt="post image">';
                                    }?>
                                   
                                </div>
                                <div class="mb-3">
                                    <!-- Reactions -->
                                    <div class="Ello-reaction">
                                        <span class="like-btn">
                                            <a href="#" class="post-card-buttons" id="reactions"><i class='bx bxs-like mr-2'></i> 67</a>
                                            <ul class="reactions-box dropdown-shadow">
                                                <li class="reaction reaction-like" data-reaction="Like"></li>
                                                <li class="reaction reaction-love" data-reaction="Love"></li>
                                                <li class="reaction reaction-haha" data-reaction="HaHa"></li>
                                                <li class="reaction reaction-wow" data-reaction="Wow"></li>
                                                <li class="reaction reaction-sad" data-reaction="Sad"></li>
                                                <li class="reaction reaction-angry" data-reaction="Angry"></li>
                                            </ul>
                                        </span>
                                    </div>
                                    <a href="javascript:void(0)" class="post-card-buttons" id="show-comments"><i class='bx bx-message-rounded mr-2'></i> 5</a>
                                    <div class="dropdown dropup share-dropup">
                                        <a href="#" class="post-card-buttons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class='bx bx-share-alt mr-2'></i> Share
                                        </a>
                                        <div class="dropdown-menu post-dropdown-menu">
                                            <a href="#" class="dropdown-item">
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <i class='bx bx-share-alt'></i>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <span>Share Now (Public)</span>
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="#" class="dropdown-item">
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <i class='bx bx-share-alt'></i>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <span>Share...</span>
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="#" class="dropdown-item">
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <i class='bx bx-message'></i>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <span>Send as Message</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="border-top pt-3 hide-comments" style="display: none;">
                                    <div class="row bootstrap snippets">
                                        <div class="col-md-12">
                                            <div class="comment-wrapper">
                                                <div class="panel panel-info">
                                                    <div class="panel-body">
                                                        <ul class="media-list comments-list">
                                                            <li class="media comment-form">
                                                                <a href="#" class="pull-left">
                                                                    <img src="assets/images/users/user-4.png" alt="" class="img-circle">
                                                                </a>
                                                                <div class="media-body">
                                                                    <form action="" method="" role="form">
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <div class="input-group">
                                                                                    <input type="text" class="form-control comment-input" placeholder="Write a comment...">

                                                                                    <div class="input-group-btn">
                                                                                        <button type="button" class="btn comment-form-btn" data-toggle="tooltip" data-placement="top" title="Tooltip on top"><i class='bx bxs-smiley-happy'></i></button>
                                                                                        <button type="button" class="btn comment-form-btn comment-form-btn" data-toggle="tooltip" data-placement="top" title="Tooltip on top"><i class='bx bx-camera'></i></button>
                                                                                        <button type="button" class="btn comment-form-btn comment-form-btn" data-toggle="tooltip" data-placement="top" title="Tooltip on top"><i class='bx bx-microphone'></i></button>
                                                                                        <button type="button" class="btn comment-form-btn" data-toggle="tooltip" data-placement="top" title="Tooltip on top"><i class='bx bx-file-blank'></i></button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </li>
                                                            <li class="media">
                                                                <a href="#" class="pull-left">
                                                                    <img src="assets/images/users/user-2.jpg" alt="" class="img-circle">
                                                                </a>
                                                                <div class="media-body">
                                                                    <div class="d-flex justify-content-between align-items-center w-100">
                                                                        <strong class="text-gray-dark"><a href="#" class="fs-8">Karen Minas</a></strong>
                                                                        <a href="#"><i class='bx bx-dots-horizontal-rounded'></i></a>
                                                                    </div>
                                                                    <span class="d-block comment-created-time">30 min ago</span>
                                                                    <p class="fs-8 pt-2">
                                                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                                        Lorem ipsum dolor sit amet, <a href="#">#consecteturadipiscing </a>.
                                                                    </p>
                                                                    <div class="commentLR">
                                                                        <button type="button" class="btn btn-link fs-8">Like</button>
                                                                        <button type="button" class="btn btn-link fs-8">Reply</button>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li class="media">
                                                                <a href="#" class="pull-left">
                                                                    <img src="https://bootdey.com/img/Content/user_2.jpg" alt="" class="img-circle">
                                                                </a>
                                                                <div class="media-body">
                                                                    <div class="d-flex justify-content-between align-items-center w-100">
                                                                        <strong class="text-gray-dark"><a href="#" class="fs-8">Lia Earnest</a></strong>
                                                                        <a href="#"><i class='bx bx-dots-horizontal-rounded'></i></a>
                                                                    </div>
                                                                    <span class="d-block comment-created-time">2 hours ago</span>
                                                                    <p class="fs-8 pt-2">
                                                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                                        Lorem ipsum dolor sit amet, <a href="#">#consecteturadipiscing </a>.
                                                                    </p>
                                                                    <div class="commentLR">
                                                                        <button type="button" class="btn btn-link fs-8">Like</button>
                                                                        <button type="button" class="btn btn-link fs-8">Reply</button>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li class="media">
                                                                <a href="#" class="pull-left">
                                                                    <img src="https://bootdey.com/img/Content/user_3.jpg" alt="" class="img-circle">
                                                                </a>
                                                                <div class="media-body">
                                                                    <div class="d-flex justify-content-between align-items-center w-100">
                                                                        <strong class="text-gray-dark"><a href="#" class="fs-8">Rusty Mickelsen</a></strong>
                                                                        <a href="#"><i class='bx bx-dots-horizontal-rounded'></i></a>
                                                                    </div>
                                                                    <span class="d-block comment-created-time">17 hours ago</span>
                                                                    <p class="fs-8 pt-2">
                                                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                                        Lorem ipsum dolor sit amet, <a href="#">#consecteturadipiscing </a>.
                                                                    </p>
                                                                    <div class="commentLR">
                                                                        <button type="button" class="btn btn-link fs-8">Like</button>
                                                                        <button type="button" class="btn btn-link fs-8">Reply</button>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li class="media">
                                                                <div class="media-body">
                                                                    <div class="comment-see-more text-center">
                                                                        <button type="button" class="btn btn-link fs-8">See More</button>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
<?php endforeach;?>
                    </div>
                    <div class="col-md-2 third-section">
                        <div class="p-3 bg-white rounded w-shadow">
                            <h6 class="card-title border-bottom border-gray pb-2 mb-0">Online Users</h6>
                            <div class="media text-muted pt-3">
                                <img src="assets/images/users/user-2.jpg" alt="Online user" class="mr-2 online-user-image">
                                <div class="media-body pb-3 mb-0 small lh-125">
                                    <div class="d-flex justify-content-between align-items-center w-100">
                                        <strong class="text-gray-dark"><a href="#" class="smFLname">Karen Minas</a></strong>
                                        <span class="online-status bg-success"></span>
                                    </div>
                                    <span class="d-block online-username">@karen_minas</span>
                                </div>
                            </div>
                            <div class="media text-muted pt-3">
                                <img src="assets/images/users/user-3.jpg" alt="Online user" class="mr-2 online-user-image">
                                <div class="media-body pb-3 mb-0 small lh-125">
                                    <div class="d-flex justify-content-between align-items-center w-100">
                                        <strong class="text-gray-dark"><a href="#" class="smFLname">Hakob Minasyan</a></strong>
                                        <span class="online-status bg-success"></span>
                                    </div>
                                    <span class="d-block online-username">@hakob_minasyan</span>
                                </div>
                            </div>
                            <div class="media text-muted pt-3">
                                <img src="assets/images/users/user-1.jpg" alt="Online user" class="mr-2 online-user-image">
                                <div class="media-body pb-3 mb-0 small lh-125">
                                    <div class="d-flex justify-content-between align-items-center w-100">
                                        <strong class="text-gray-dark"><a href="#" class="smFLname">John Michael</a></strong>
                                        <span class="online-status bg-success"></span>
                                    </div>
                                    <span class="d-block online-username">@john_michael</span>
                                </div>
                            </div>
                            <small class="d-block text-right mt-3">
                                <a href="#">See More</a>
                            </small>
                        </div>

                        <!-- Suggestions -->
                        <div class="mt-4 p-3 bg-white rounded w-shadow">
                            <h6 class="card-title border-bottom border-gray pb-2 mb-0">People You May Know</h6>
                            <div class="media text-muted pt-3">
                                <img src="https://demos.creative-tim.com/Ello-dashboard-pro/assets/img/theme/team-4.jpg" alt="Online user" class="mr-2 online-user-image">
                                <div class="media-body pb-3 mb-0 small lh-125">
                                    <div class="d-flex justify-content-between align-items-center w-100">
                                        <strong class="text-gray-dark" style="line-height: 0;"><a href="#" class="smFLname">John Michael</a></strong>
                                        <a href="#" data-toggle="tooltip" data-placement="top" title="Follow"><i class='bx bxs-plus-circle' style="font-size: 2.5em; color: #969696;"></i></a>
                                    </div>
                                    <span class="d-block" style="line-height: 8px;">4 mutual friends</span>
                                </div>
                            </div>
                            <div class="media text-muted pt-3">
                                <img src="https://demos.creative-tim.com/Ello-dashboard-pro/assets/img/theme/team-3.jpg" alt="Online user" class="mr-2 online-user-image">
                                <div class="media-body pb-3 mb-0 small lh-125">
                                    <div class="d-flex justify-content-between align-items-center w-100">
                                        <strong class="text-gray-dark" style="line-height: 0;"><a href="#" class="smFLname">Samantha Ivy</a></strong>
                                        <a href="#" data-toggle="tooltip" data-placement="top" title="Follow"><i class='bx bxs-plus-circle' style="font-size: 2.5em; color: #969696;"></i></a>
                                    </div>
                                    <span class="d-block" style="line-height: 8px;">1 mutual friends</span>
                                </div>
                            </div>
                            <small class="d-block text-right mt-3">
                                <a href="#">See More</a>
                            </small>
                        </div>

                       
                    </div>
                  
                </div>
            </div>
        </div>
    </div>

    <!-- Modals -->
    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="postModal" aria-labelledby="postModal" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body post-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-7 post-content">
                                <img src="https://scontent.fevn1-2.fna.fbcdn.net/v/t1.0-9/56161887_588993861570433_2896723195090436096_n.jpg?_nc_cat=103&_nc_eui2=AeFI0UuTq3uUF_TLEbnZwM-qSRtgOu0HE2JPwW6b4hIki73-2OWYhc7L1MPsYl9cYy-w122CCak-Fxj0TE1a-kjsd-KXzh5QsuvxbW_mg9qqtg&_nc_ht=scontent.fevn1-2.fna&oh=ea44bffa38f368f98f0553c5cef8e455&oe=5D050B05" alt="post-image">
                            </div>
                            <div class="col-md-5 pr-3">
                                <div class="media text-muted pr-3 pt-3">
                                    <img src="assets/images/users/user-1.jpg" alt="user image" class="mr-3 post-modal-user-img">
                                    <div class="media-body">
                                        <div class="d-flex justify-content-between align-items-center w-100 post-modal-top-user fs-9">
                                            <a href="#" class="text-gray-dark">John Michael</a>
                                            <div class="dropdown">
                                                <a href="#" class="postMoreSettings" role="button" data-toggle="dropdown" id="postOptions" aria-haspopup="true" aria-expanded="false">
                                                    <i class='bx bx-dots-horizontal-rounded'></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-left postDropdownMenu">
                                                    <a href="#" class="dropdown-item" aria-describedby="savePost">
                                                        <div class="row">
                                                            <div class="col-md-2">
                                                                <i class='bx bx-bookmark-plus postOptionIcon'></i>
                                                            </div>
                                                            <div class="col-md-10">
                                                                <span class="postOptionTitle">Save post</span>
                                                                <small id="savePost" class="form-text text-muted">Add this to your saved items</small>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <span class="d-block fs-8">3 hours ago <i class='bx bx-globe ml-3'></i></span>
                                    </div>
                                </div>
                                <div class="mt-3 post-modal-caption fs-9">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quis voluptatem veritatis harum, tenetur, quibusdam voluptatum, incidunt saepe minus maiores ea atque sequi illo veniam sint quaerat corporis totam et. Culpa?</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog mobile-modal" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <ul class="list-unstyled" style="margin-bottom: 0;">
                            <li class="media post-form w-shadow">
                            <form method="post" action="schedule_post.php" enctype="multipart/form-data">
                                <div class="media-body">
                                    <div class="form-group post-input">
                                        <textarea class="form-control" required name="content" id="postForm" rows="2" placeholder="What's on your mind?"></textarea>
                                    </div>
                                    <div class="row post-form-group">
    <div class="col-md-9">
        <button type="button" class="btn btn-link post-form-btn btn-sm" name="image">
            <img src="assets/images/icons/theme/post-image.png" alt="post form icon"> <span>Photo/Video</span>
        </button>
        <input type="file" name="image" id="imageInput1" accept="image/*" style="display: none;"><br>
      
    </div><br>
    
</div>
                                </div>
                             
                            </li>
                        </ul><br>
                        <input type="datetime-local" required name="date" id="">
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Publish</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Core -->
    <script src="assets/js/jquery/jquery-3.3.1.min.js"></script>
    <script src="assets/js/popper/popper.min.js"></script>
    <script src="assets/js/bootstrap/bootstrap.min.js"></script>
    <!-- Optional -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <script type="text/javascript">
        $("#menu-toggle").click(function(e) {
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");
        });

    </script>
    <script src="assets/js/app.js"></script>
    <script src="assets/js/components/components.js"></script>

    <script>
    document.querySelector('button[name="image"]').addEventListener('click', function() {
        document.getElementById('imageInput').click();
    });
</script>

<script>
    document.querySelector('button[name="image"]').addEventListener('click', function() {
        document.getElementById('imageInput1').click();
    });
</script>
</body>

</html>
