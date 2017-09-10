<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="description" content="Coming soon, Bootstrap, Bootstrap 3.0, Free Coming Soon, free coming soon, free template, coming soon template, Html template, html template, html5, Code lab, codelab, codelab coming soon template, bootstrap coming soon template">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Registration</title>
    <!-- ============ Google fonts ============ -->
    <link href='http://fonts.googleapis.com/css?family=EB+Garamond' rel='stylesheet'
        type='text/css' />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700,300,800'
        rel='stylesheet' type='text/css' />
    <!-- ============ Add custom CSS here ============ -->
    <link href="<?php echo base_url();?>assets/register/css/bootstrap.min.css" rel="stylesheet" type="text/css" />

    <link href="<?php echo base_url();?>assets/register/css/style.css" rel="stylesheet" type="text/css" />   
    <link href="<?php echo base_url();?>assets/register/css/font-awesome.css" rel="stylesheet" type="text/css" />
   
<!--alert success-->
<!--<script
  src="https://code.jquery.com/jquery-2.2.4.js"
  integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI="
  crossorigin="anonymous"></script>
 <!--Let browser know website is optimized for mobile-->
 <!--<script src="bower_components/sweetalert2/dist/sweetalert2.min.js"></script> 
 <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.10/sweetalert2.common.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
 <script type="text/javascript" src="<?php echo base_url(); ?>assets/alert/sweetalert2.js"></script>-->
<script src="<?php echo base_url();?>assets/register/js/jquery.js" type="text/javascript"></script>
     <!-- Sweet Alert CSS import-->

<link rel="stylesheet" href="<?php echo base_url();?>assets/datepicker/development-bundle/themes/base/jquery.ui.all.css">
<script src="<?php echo base_url();?>assets/datepicker/development-bundle/jquery-1.8.3.js"></script>
<script src="<?php echo base_url();?>assets/datepicker/development-bundle/ui/jquery.ui.core.js"></script>
<script src="<?php echo base_url();?>assets/datepicker/development-bundle/ui/jquery.ui.widget.js"></script>
<script src="<?php echo base_url();?>assets/datepicker/development-bundle/ui/jquery.ui.datepicker.js"></script>

 <script src="https://www.google.com/recaptcha/api.js"></script>
<script>
 $( document ).ready(function() {
    $("#tanggal").datepicker({ 
        dateFormat: 'yy-mm-dd'
    });
    $("#tanggal").on("change", function () {
        var fromdate = $(this).val();
       
    });
});


    </script>


    
       

</head>
<body>
    <div id="custom-bootstrap-menu" class="navbar navbar-default " role="navigation">
    <div class="container">
        <div class="navbar-header"> <img src="https://www.hosterbaik.com/media/reviews/photos/original/9b/0f/13/rumahweblogo-55-1427880581.png" width="200px" height="80px">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-menubuilder"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse navbar-menubuilder">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="<?php echo base_url(); ?>home/index">Home</a>
                </li>
                <li><a href="<?php echo base_url(); ?>home/register">Apply</a>
                </li>
            </ul>
        </div>
    </div>
</div>

        <!--<div class="container"></div>-->
        <?php echo $contents; ?>


      
                    </div>
                    
                    
                </fieldset>
            </form>
         </div>



         </div>
        </div>
        

</body>
</html>
<script src="<?php echo base_url();?>assets/register/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/register/js/jquery.backstretch.js" type="text/javascript"></script>
        <script type="text/javascript">
            'use strict';

            /* ========================== */
            /* ::::::: Backstrech ::::::: */
            /* ========================== */
            // You may also attach Backstretch to a block-level element
            $.backstretch(
        [
            "<?php echo base_url();?>assets/register/img/5.jpg",
            "<?php echo base_url();?>assets/register/img/9.jpg"
            
        ],

        {
            duration: 4500,
            fade: 1500
        }
    );
        </script>