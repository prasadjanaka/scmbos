<title><?php echo APP_TITLE ?></title>

<style>
    #abc {
        width:100%;
        height:100%;
        opacity:.95;
        top:0;
        left:0;
        display:none;
        position:fixed;
        background-color: transparent;//#9d9d9d;
        overflow:auto;
    }

    div#popupContact {
        position:absolute;
        left:40%;
        top:17%;



    }
    #form{
        max-width:400px;
        min-width:250px;
        padding:10px 50px;
        border:2px solid gray;
        border-radius:10px;
        font-family:raleway;
        background-color:#fff;
    }



</style>

<script type="text/javascript">
// Validating Empty Field  
    var count = 3;
    function check_empty() {

        if (document.getElementById('current_pass').value === "" || document.getElementById('new_pass').value === "" || document.getElementById('confirm_pass').value === "") {
            alert("Fill All Fields !");
        } else if (document.getElementById('new_pass').value !== document.getElementById('confirm_pass').value) {
            alert("New Password and Confirm Password doesn't Match");
        } else {
            //document.getElementById('form').submit();
            //alert("Form Submitted Successfully...");

            //call ajax\\

            var a;

            if (window.XMLHttpRequest) {
                a = new XMLHttpRequest();
            } else if (window.ActiveXObject) {
                a = ActiveXObject("Microsoft.XMLHTTP");
            } else
                (
                        alert("Browser Doesnot Support AJAX")
                        )

            if (a != null) {
                a.onreadystatechange = function() {


                    if (a.readyState === 4) {
                        var res = a.responseText;
                        if (res === 'Sorry...!Current Password is Wrong') {
                            if (count >= 0) {
                                count--;
                                alert("Invalid Current password. You have " + count + " left.");
                            }
                            if (count === 0) {
                                alert('The Maximun Number of tries has Exceeded');
                             window.location='<?php echo base_url('index.php/welcome/logout')?>';
                            
                        }
                     
                    }else{
                         alert('Your Password Has Changed');
                           window.location=' <?php echo base_url('index.php/welcome/logout') ?>';
                        }
                }
            }
            a.open("POST", "<?php echo base_url('index.php/welcome/change_password') ?>", true);
            a.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            //a.send("current_pass=abc");
            a.send("current_pass=" + document.getElementById('current_pass').value + "&new_pass=" + document.getElementById('new_pass').value + "");

        }
    }
    }
    function div_show() {
        document.getElementById('abc').style.display = "block";
    }

    function div_hide() {
        //document.getElementById('abc').style.display = "none";
    }

</script>


</head>
<body class="skin-blue sidebar-collapse">
    <div class="wrapper">
        <header class="main-header"> <a href="<?php echo base_url() ?>index.php/dashboard" class="logo"><b>SCM</b>BOS</a> 
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation"> 
                <!-- Sidebar toggle button--> 
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </a>

                <!--  logout  -->
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <!-- Messages: style can be found in dropdown.less-->

                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-user">

                                </i>
                                <span class="hidden-xs"><?php echo $this->session->userdata('username'); ?></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                               
                                <!-- Menu Body -->

                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="#" class="btn btn-default btn-flat" onClick="div_show()"> Change Password</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="<?php echo base_url('index.php/welcome/logout'); ?>" class="btn btn-default btn-flat">Sign out</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>


                <!--  End logout  -->
            </nav>

            <div id="abc">
                <!-- Popup Div Starts Here -->
                <div id="popupContact">
                    <!-- Contact Us Form -->
                    <form action="#" id="form" method="post" name="form">


                        <a class="pull-right" href=""onclick="div_hide()"><i class="fa fa-fw fa-times-circle"></i></a>
                        <h2>Change Password</h2>
                        <hr>

                        <div class="form-group">
                            <label for="exampleInputPassword1">Current Password</label>

                            <input class="form-control" id="current_pass"  name="current_pass" value="" placeholder="Password" type="password">

                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">New Password</label>
                            <input class="form-control" id="new_pass" name="new_pass" value="" placeholder="Password" type="password">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Confirm Password</label>
                            <input class="form-control" id="confirm_pass" name="confirm_pass" value="" placeholder="Password" type="password">
                        </div>


                        <a   href="javascript:%20check_empty()" class="btn btn-primary" >Submit</a>

                    </form>
                </div>
                <!-- Popup Div Ends Here -->
            </div>
            <!-- Display Popup Button -->
        </header>

       