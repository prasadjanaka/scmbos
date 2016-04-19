<title><?php echo APP_TITLE ?></title>
</head><body class="login-page">
    <?php
    require_once('loader.php');

//$string = $_REQUEST['q'];
//echo base64_encode($string)."<br/>";
//echo base64_decode($string)."<br/>";
//
//echo base64_encode("location_id=1&base_id=99&dom=");
    ?>
    <script type="text/javascript" src="<?php echo base_url('skin/dist/js'); ?>jquery-1.10.2.min.js"></script>    
    <div class="login-box"><!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg"><?php echo APP_LOGIN_WELCOME_TEXT ?></p>
            <p><?php // print_r($_SESSION);  ?></p>
            <form action="<?php echo base_url() ?>index.php/welcome/login" method="post" enctype="multipart/form-data" id="form1">
                <div class="form-group has-feedback">
                    <input type="text" class="form-control" placeholder="Username" name="username" id="username" required/>
                </div>
                <div class="form-group has-feedback">
                    <input  type="password" class="form-control" placeholder="Password" name="password" id="password" required/>
                </div>
                <div class="row"><!-- /.col -->
                    <div class="col-xs-12">
                        <button type="button" id="btn_login" class="btn btn-primary btn-block btn-flat">Sign In</button>
                    </div>
                    
                    <div class="col-xs-12" style="text-align:center">
                        <label >Recommend to use</label>
                    </div>
                     <div class="col-xs-12" style="text-align:center">
                        <label>Firefox version 39 or upper for better performance</label>
                    </div>
                    <!-- /.col --> 
                </div>
            </form>
            <!-- /.social-auth-links --></div>
        <!-- /.login-box-body --> 
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#btn_login").click(function() {
                $(this).attr('class', 'btn btn-block btn-default disabled');
                $("#form1").submit();
            });
            $("#form1").submit(function(e) {
                var formObj = $(this);

                var formURL = formObj.attr("action");
                var formData = new FormData(this);
                $.ajax({
                    url: formObj.attr("action"),
                    type: 'POST',
                    data: formData,
                    mimeType: "multipart/form-data",
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(data, textStatus, jqXHR) {
                        jd = $.parseJSON(data)
                        if (jd.retval)
                            $(location).attr('href', jd.url);
                        else
                            alert('Invlid Login');

                        $("#btn_login").attr('class', 'btn btn-primary btn-block btn-flat');
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        $("#btn_login").attr('class', 'btn btn-primary btn-block btn-flat');
                        alert(errorThrown);
                    }
                });
                e.preventDefault(); //Prevent Default action. 
            });
        });


    </script>
    <script type="text/javascript" >
        //alert("Enter");
       
        $('#password').keypress(function(event) {
            var keycode = (event.keyCode ? event.keyCode : event.which);
          
            if (keycode == '13') {
                //alert(document.getElementById('passowrd').value);
                $("#form1").submit();
                $("#form1").submit(function(e) {
                    var formObj = $(this);

                    var formURL = formObj.attr("action");
                    var formData = new FormData(this);
                    $.ajax({
                        url: formObj.attr("action"),
                        type: 'POST',
                        data: formData,
                        mimeType: "multipart/form-data",
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function(data, textStatus, jqXHR) {
                            jd = $.parseJSON(data)
                            if (jd.retval)
                                $(location).attr('href', jd.url);
                            else
                            document.getElementById('passowrd').value="";  
                            alert('Invlid Login');

                            $("#btn_login").attr('class', 'btn btn-primary btn-block btn-flat');
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            $("#btn_login").attr('class', 'btn btn-primary btn-block btn-flat');
                            alert(errorThrown);
                        }
                    });
                    e.preventDefault(); //Prevent Default action. 
                });
            }//event.stopPropagation();

        });

    </script>


