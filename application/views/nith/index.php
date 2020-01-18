<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta property="og:title" content="Bawa Log">
    <meta property="og:description" content="<b>A mini social site to connect to other bawalog.</b>">
    <meta property="og:image" content="<?php echo $user->image ?>">
    <title>Welcome to Bawa Log</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <style type="text/css">
        #container {
            height: 100vh;
            padding: 8px
        }

        img {
            height: 140px;
            width: 100%;
            /* border-radius: 50%; */
            object-fit: contain;
            border: 5px solid #ddd;
            background-size: cover;
            object-position: center;
        }

        .userDetails {
            font-size: 16px;
        }

        .no-padding {
            padding: 0px;
        }

        .imgDiv {
            background-image: url("https://images.unsplash.com/photo-1521016257192-677ab9ffd16c?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60");
            text-align: center;
            /* background-position: bottom; */
            /* background-size: cover; */
        }

        .userDetailsDiv {
            padding: 15px;
            /* border-left: solid 1px #bbb; */
        }

        .profile {
            padding: 12px;
            border: solid #9db3ba;
        }

        .messageWrapper {
            border-bottom: solid #ddd;
            padding-top: 10px;
            padding-left: 0px;
        }

        .messageWrapper p {
            padding-left: 0px;
            padding-right: 0px;

        }

        .name {
            font-weight: bold;
            font-size: 20px;
        }

        .nav li {
            display: inline;
            list-style: none
        }

        .edit {
            cursor: pointer;

        }
    </style>
</head>

<body>

    <div id="container">
        <input type="hidden" id="refreshed" value="no">
        <?php if (!empty($user)) { ?>
            <div class="col-md-12 col-xs-12 profile">

                <div class="col-xs-12 col-md-offset-3 col-md-6">
                    <ul class="nav">
                        <a href="<?php echo base_url('nith?user_id=' . $user->user_id . '') ?>">
                            <li>My Profile</li>
                        </a>
                        <a href="<?php echo base_url('nith/friendList?user_id=' . $user->user_id . '') ?>">
                            <li>Find Friends</li>
                        </a>
                        <a href="#inbox">
                            <li>Messages</li>
                        </a>
                    </ul>
                </div>
                <div class="userParentDiv">
                    <div class="col-md-offset-3 col-md-6 col-xs-12 no-padding imgDiv">
                        <?php
                        $defaultFemaleAvator = "http://www.pngmart.com/files/5/Avril-Lavigne-PNG-HD-1.png";
                        $defaultMaleAvator = "http://www.punjabigram.com/pg/hrithik_roshan/face_closeup_picture_of__hrithik_roshan.jpg";
                        if ($user->image) {
                            $photo = $user->image;
                        } else {
                            $photo = $user->gender == "male" ? $defaultMaleAvator : $defaultFemaleAvator;
                        } ?>

                        <img src="<?php echo $photo ?>" alt="user image">
                    </div>
                    <div class="col-md-offset-3 col-md-6 col-xs-12 userDetailsDiv">
                        <div class="userDetails name"><?php echo $user->firstname . " " . $user->lastname; ?></div>
                        <div class="userDetails"><?php echo $user->email; ?></div>
                        <div class="userDetails"><?php echo $user->mobile; ?></div>
                        <div class="userDetails">
                            <?php
                            if ($user->dob) {
                                echo date('d M Y', strtotime($user->dob));
                            } ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-offset-3 col-md-6 col-xs-12" style="padding-top: 10px;">
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#about">About Me</a></li>
                        <li><a data-toggle="tab" href="#inbox"><i class="fa fa-envelope" aria-hidden="true"></i> Inbox
                            </a></li>
                        <li><a data-toggle="tab" href="#outbox"><i class="fa fa-paper-plane" aria-hidden="true"></i> Outbox
                            </a></li>
                    </ul>

                    <div class="tab-content">
                        <div id="about" class="tab-pane fade in active">
                            <h3 class="edit">About <?php echo $user->firstname ?> <span><i class="fa fa-pencil fa-pencil " aria-hidden="true"></i></span></h3>
                            <p class="aboutContent"><?php echo htmlspecialchars($user->about) ?></p>
                            <input style="display: none" type="submit" id="submit" value="Save">
                        </div>
                        <div id="inbox" class="tab-pane fade">
                            <h3>Inbox</h3>
                            <?php
                            if (!empty($inboxWishes)) {
                                foreach ($inboxWishes as $key => $value) { ?>
                                    <div class="messageBox">
                                        <div class="messageWrapper col-md-12 col-xs-12">
                                            <p class="col-md-6 col-xs-7" style="font-weight:bold;"><?php echo $value->message ?></p>
                                            <p class="col-md-6 col-xs-5" style="font-style:italic;color:green;"><?php echo $value->firstname . " " . $value->lastname . "<br>";
                                                                                                                echo date('d M Y H:i:s', strtotime($value->added_on)); ?></p>
                                        </div>
                                    </div>
                                <?php }
                            } else { ?>
                                <div class="messageBox">
                                    <div class="messageWrapper col-md-12 col-xs-12">
                                        <p class="col-md-12 col-xs-12" style="color:red;"><?php echo "Sorry No new birthday wishes for  $user->firstname" ?></p>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <div id="outbox" class="tab-pane fade">
                            <h3>Outbox</h3>
                            <?php
                            if (!empty($outboxWishes)) {
                                foreach ($outboxWishes as $key => $value) { ?>
                                    <div class="messageBox">
                                        <div class="messageWrapper col-md-12 col-xs-12">
                                            <p class="col-md-6 col-xs-7" style="font-weight:bold;"><?php echo $value->message ?></p>
                                            <p class="col-md-6 col-xs-5" style="font-style:italic;color:green;"><?php echo $value->firstname . " " . $value->lastname . "<br>";
                                                                                                                echo date('d M Y H:i:s', strtotime($value->added_on)); ?></p>
                                        </div>
                                    </div>
                                <?php }
                            } else { ?>
                                <div class="messageBox">
                                    <div class="messageWrapper col-md-12 col-xs-12">
                                        <p class="col-md-12 col-xs-12" style="color:red;"><?php echo "Sorry No wishes has been sent by $user->firstname" ?></p>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>

            </div>
        <?php } else {
            die("Sorry The person doesn't belong to here");
        } ?>

    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.edit').on('click', function() {
                $(this).siblings('.aboutContent').attr('contentEditable', true);
                $(this).siblings('.aboutContent').css('background', "#ddd");
                $(this).siblings('#submit').show();
            })
        })
    </script>
    <script>
        // setTimeout(function() {
        //     window.location.reload();
        // }, 2000);
        $('#submit').on('click', function() {
            var about = $(this).siblings('.aboutContent').text();
            var user_id = '<?php echo $user->user_id ?>';
            $.ajax({
                url: '<?php echo base_url('nith/saveData') ?>',
                data: {
                    about: about,
                    user_id: user_id
                },
                dataType: 'JSON',
                type: "POST",
                success: function(response) {
                    if (response.status == "success") {
                        location.reload();
                    }
                }
            })
        })
    </script>
</body>

</html>