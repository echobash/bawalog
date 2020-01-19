<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
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

        .nav li {
            display: inline;
            list-style: none
        }

        .friendDetails {
            height: 120px;
        }

        .friendList {
            margin-top: 10px;
            background: #d4d2d2;
        }

        .imgDiv {
            background-image: url("https://images.unsplash.com/photo-1521016257192-677ab9ffd16c?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60");
            text-align: center;
            /* background-position: bottom; */
            /* background-size: cover; */
        }

        img {
            height: 120px;
            width: 100%;
            border-radius: 5%;
            object-fit: contain;
            object-position: center;
        }

        .friendDetails p {

            padding-left: 0px;
            padding-right: 0px;
        }

        .name {
            font-weight: bold;
            font-size: 15px;
        }
        .navdiv {
            background:#ddd;
            padding:0px;
        }
        .navdiv a {
            background: #537782;
            padding:8px;
            color:white
        }
    </style>
</head>

<body>

    <div id="container">
        <?php if (!empty($user)) { ?>
            <div class="col-md-12 col-xs-12 profile">

            <div class="col-xs-12 col-md-offset-3 col-md-6 navdiv">
                    <ul class="nav ">
                        <a class="col-xs-4 text-center" href="<?php echo base_url('nith?user_id=' . $user->user_id . '') ?>">
                            <li>My Profile</li>
                        </a>
                        <a class="col-xs-4 text-center" href="<?php echo base_url('nith/friendList?user_id=' . $user->user_id . '') ?>">
                            <li>Find Friends</li>
                        </a>
                        <a class="col-xs-4 text-center" href="#inbox">
                            <li>Messages</li>
                        </a>
                    </ul>
                </div>
                <div class="col-xs-12 col-md-offset-3 col-md-6">
                    <div class="input-group">
                        <input type="text" id="search" placeholder="Search Friends" class="form-control">
                        <div class="input-group-btn">
                            <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-offset-3 col-md-6 friend">
                    <?php
                    $defaultFemaleAvator = "http://www.pngmart.com/files/5/Avril-Lavigne-PNG-HD-1.png";
                    $defaultMaleAvator = "http://www.punjabigram.com/pg/hrithik_roshan/face_closeup_picture_of__hrithik_roshan.jpg";

                    foreach ($user as  $value) {
                        if ($value->image) {
                            $photo = $value->image;
                        } else {
                            $photo = $value->gender == "male" ? $defaultMaleAvator : $defaultFemaleAvator;
                        }
                    ?>
                        <div class="friendList col-xs-12">
                            <div class="imgDiv col-xs-6">
                                <img src="<?php echo $photo; ?>" alt="">
                            </div>
                            <div class="friendDetails col-xs-6">
                                <span class="name"><?php echo $value->firstname . " " . $value->lastname; ?></span><br>
                                <span><?php echo $value->dob; ?></span>
                                <input type="button" class="btn btn-info wish" data-user_id="<?php echo $value->user_id; ?>" value="Wish <?php echo $value->gender == "male" ? "Him" : "Her" ?>">
                            </div>

                        </div>
                    <?php }
                    ?>
                </div>
                <div class="modal fade" id="myModal" role="dialog">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Happy Birthday </h4>
                            </div>
                            <div class="modal-body col-xs-12">
                                <input type="text" class="form-control col-xs-12" id="message" placeholder="Send Wishes">
                                <input type="submit" class="btn btn-primary col-xs-offset-5 col-xs-3" id="submit" value="Send">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        <?php } else {
            die("Sorry The person doesn't belong to here");
        } ?>

    </div>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> -->
    <script>
        $(document).ready(function() {
            
            var selectedVal = ''
            var logged_user_id = '<?php echo $_GET['user_id'] ?>'
            $('#search').on('keyup', function() {
                var that = $(this)
                selectedVal = that.val()
                $('.friendList').find('.name').each(function(k, v) {
                    if ($(this).text().toLowerCase().indexOf(selectedVal.toLowerCase()) == -1) {
                        $(this).parents('.friendList').hide();
                    } else {
                        $(this).parents('.friendList').show();
                    }
                })

            })
            $('.wish').on('click', function() {
                $('#myModal').modal('show');
                $('#myModal').find('.modal-title').html("Happy Birthday " + $(this).siblings('.name').text());
                $('#myModal').find('input[type=submit]').data('user_id', $(this).data('user_id'));
            })
            $('#submit').on('click', function() {
                var receiver_id = $(this).data('user_id')
                var message = $(this).siblings('#message').val()
                $.ajax({
                    url: '<?php echo base_url('nith/sendMessage') ?>',
                    data: {
                        user_id: receiver_id,
                        message: message,
                        wisher_id: logged_user_id,
                    },
                    dataType: 'JSON',
                    type: "POST",
                    success: function(response) {
                        if (response.status == "success") {
                            $('#myModal').modal('hide');
                        }
                    }
                })
            })
        })
    </script>
</body>

</html>