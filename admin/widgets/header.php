<?php if (!defined('IN_SITE')) die('The request not found'); ?>
 
<!DOCTYPE html>
<html>
    <head>
        <script src="http://code.jquery.com/jquery-1.9.0.js"></script>
        <title>Quản lý admin</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style type="text/css">
            #header li{
                float: left;
                padding: 5px 10px;
                border: solid 1px blue;
                background: blue;
                margin-right: 10px;
                list-style: none;
            }
            #header{
                overflow: hidden;
            }
            #header li a{
                color: #fff;
                text-decoration: none;
            }
            #header div{
                float: right;
                width: 250px;
                line-height: 50px;
            }
            #header ul{
                width: 700px;
                float: left;
            }
            body{
                background: #acacac;
                margin: 0px;
                padding: 0px;
            }
            #container{
                width: 1000px;
                margin: 0px auto;
                overflow: hidden;
                background: #fff;
            }
            #content{
                border-top: solid 1px #ddd;
                min-height: 600px;
                padding: 10px 30px;
            }
            .button{
                display: inline-block;
                padding: 5px 10px;
                background: blue;
                color: #fff;
                text-decoration: none;
            }
            .pagination a{
                display: inline-block;
                padding: 3px 5px;
                background: blue;
                color: #fff;
                text-decoration: none;
                margin-top: 10px;
            }
            .pagination,.pagination span{
                margin-right: 3px;
            }
            .pagination span{
                display: inline-block;
                padding: 3px 5px;
                background: gray;
                color: #fff;
                text-decoration: none;
                margin-top: 10px;
            }
            table.form{
                width: 100%;
            }
            table.form td{
                border: solid 1px #ddd;
                padding: 5px 10px;
            }
            table.form thead{
                font-weight: bold;
            }
            .controls{
                margin: 10px 0px;
                text-align: right;
            }
            .form input.long[type="text"]{
                width: 400px;
            }
        </style>
    </head>
    <body>
        <div id="container">
            <?php if (is_admin()) { ?>
            <div id="header">
                <ul>
                    <li>
                        <a href="<?php echo create_link(base_url('admin'), array('m' => 'user', 'a' => 'list')); ?>">User</a>
                    </li>
                    <li>
                        <a href="<?php echo create_link(base_url('admin'), array('m' => 'book', 'a' => 'show_book')); ?>">Quản lý sách</a>
                    </li>
                    <li>
                        <a href="<?php echo create_link(base_url('admin'), array('m' => 'tacgia', 'a' => 'show_tacgia'))?>">Tác giả</a> 
                    </li>
                </ul>
                <div>
                    Xin chào <?php echo get_current_username(); ?> |
                    <a href="<?php echo base_url('admin/?m=common&a=logout'); ?>">Logout</a>
                </div>
            </div>
            <?php } ?>
            <?php if(is_user()){?>
            <div id="header">
                <div>
                    Xin chào <?php echo get_current_username(); ?> |
                    <a href="<?php echo base_url('admin/?m=common&a=logout'); ?>">Logout</a>
                </div>
            </div>
            <?php }?>
            <div id="content">