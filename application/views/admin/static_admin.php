<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Admin</title>


    <!--datepicker-->


    <link href="<?php echo base_url();?>assets/admin/vendor/jquery-ui-1.11.4/smoothness/jquery-ui.css" rel="stylesheet"/>
    <link rel="stylesheet" href="<?php echo base_url();?>assets/admin/vendor/jquery-ui-1.11.4/jquery-ui.theme.css">

    <!-- Bootstrap -->
    <link href="<?php echo base_url();?>assets/admin/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="<?php echo base_url();?>assets/admin/vendors/bootstrap/dist/css/bootstrap.css" rel="stylesheet">


    <!-- Font Awesome -->
    <link href="<?php echo base_url();?>assets/admin/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?php echo base_url();?>assets/admin/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="<?php echo base_url();?>assets/admin/vendors/iCheck/skins/flat/green.css" rel="stylesheet">

    <!-- bootstrap-progressbar -->
    <link href="<?php echo base_url();?>assets/admin/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- JQVMap -->
    <link href="<?php echo base_url();?>assets/admin/vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
    <!-- bootstrap-daterangepicker -->
    <link href="<?php echo base_url();?>assets/admin/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="<?php echo base_url();?>assets/admin/build/css/custom.min.css" rel="stylesheet">

</head>

<body class="nav-md">
<div class="container body">
    <div class="main_container">
        <div class="col-md-3 left_col">
            <div class="left_col scroll-view">
                <div class="navbar nav_title" style="border: 0;">
                    <a href="index.html" class="site_title"></i> <span>Halaman Admin</span></a>
                </div>

                <div class="clearfix"></div>

                <!-- menu profile quick info -->
                <div class="profile clearfix">
                    <div class="profile_pic">
                    <img src="<?php echo base_url(); ?>assets/img/admin.png" width="45px" align="right">

                    </div>
                    <div class="profile_info">
                        <h2> <?php echo $this->session->userdata('username'); ?>
                        </h2>
                    </div>
                </div>
                <!-- /menu profile quick info -->

                <br/>

                <!-- sidebar menu -->
                <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                    <div class="menu_section">
                        <h3>General</h3>
                        <ul class="nav side-menu">
                            <li><a href="<?php echo base_url(); ?>admin/index"><i class="fa fa-home"></i>Home</a>
                            </li>
                            
                            <li><a><i class="fa fa-sitemap"></i> Data Kriteria<span
                                            class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu">
                                    <li><a href="<?php echo base_url(); ?>admin/tambah_kriteria">Tambah Kriteria</a></li>
                                    <li><a href="<?php echo base_url(); ?>admin/tampil_kriteria">Tampil Kriteria</a></li>
                                </ul>
                            </li>

                            <li>
                            <a><i class="fa fa-desktop"></i>Alternatif<span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu">
                                    <li><a href="<?php echo base_url(); ?>admin/tampil_pegawai">Tampil Alternatif</a></li>
                                    <li><a href="<?php echo base_url();?>admin/tambah_pegawai">Tambah Alternatif</a></li>

                                </ul>
                          </li>


                          <li>
                            <a><i class="fa fa-paste"></i>Nilai<span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu">
                                    <li><a href="<?php echo base_url(); ?>admin/tampil_nilai">Tampil Nilai</a></li>
                                    <li><a href="<?php echo base_url(); ?>admin/tambah_nilai">Tambah Nilai</a></li>
                                    
                                </ul>
                          </li>
                             
                       

                            <li><a href="#"><i class="fa fa-line-chart"></i>Perangkingan<span class="fa fa-chevron-down"></span></a>

                                <ul class="nav child_menu">
                                    <li><a href="<?php echo base_url(); ?>admin/tampil_vektor">Semua</a></li>
                                    <?php
                                        $ci =&get_instance();
                                        $rows = $ci->db->query("select * from wp_alternatif group by divisi")->result();
                                        foreach ($rows as $r){
                                    ?>
                                        <li><a href="<?php echo base_url(); ?>admin/tampil_vektor/<?=$r->divisi?>"><?=$r->divisi?></a></li>
                                    <?php
                                        }
                                    ?>
                                </ul>
                            </li>
                             <li><a href="<?php echo base_url(); ?>admin/tampil_rangking"><i class="fa fa-file"></i>Laporan</a>
                            </li>
                        </ul>
                    </div>
                    <div class="menu_section">

                    </div>

                </div>
                <!-- /sidebar menu -->

                <!-- /menu footer buttons -->

                <!-- /menu footer buttons -->
            </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
            <div class="nav_menu">
                <nav>
                    <div class="nav toggle">
                        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                    </div>

                    <ul class="nav navbar-nav navbar-right">
                        <li class="">

                        <li><a href="<?php echo base_url(); ?>admin/logout"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                    </ul>
                    </li>


                    </ul>
                </nav>
            </div>
        </div>
        <!-- /top navigation -->

        <!-- page content -->

        <div class="right_col" role="main">

            <?php echo $contents; ?>
            <!-- top tiles -->

            <!-- /top tiles -->


        </div>
        <br/>


        <div class="row">
            <div class="col-md-4 col-sm-4 col-xs-12">

            </div>


            <div class="col-md-8 col-sm-8 col-xs-12">


                <div class="row">

                    <div class="col-md-12 col-sm-12 col-xs-12">

                    </div>
                </div>

            </div>
            <div class="row">


                <!-- Start to do list -->
                <div class="col-md-6 col-sm-6 col-xs-12">

                </div>
            </div>
            <!-- End to do list -->

            <!-- start of weather widget -->
            <div class="col-md-6 col-sm-6 col-xs-12">

            </div>

        </div>
        <!-- end of weather widget -->
    </div>
</div>
</div>
</div>
<!-- /page content -->

<!-- footer content -->
<footer>
    <div class="pull-right">
        Powered by @2017 <a href="https://colorlib.com">Anita Rahmawati</a>
    </div>
    <div class="clearfix"></div>
</footer>
<!-- /footer content -->
</div>
</div>

<!-- jQuery -->
<!--load jquery-->

<!--datepicker-->


<script src="<?php echo base_url();?>assets/admin/vendors/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="<?php echo base_url();?>assets/admin/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="<?php echo base_url();?>assets/admin/vendors/fastclick/lib/fastclick.js"></script>
<!-- NProgress -->
<script src="<?php echo base_url();?>assets/admin/vendors/nprogress/nprogress.js"></script>
<!-- Chart.js -->
<script src="<?php echo base_url();?>assets/admin/vendors/Chart.js/dist/Chart.min.js"></script>
<!-- gauge.js -->
<script src="<?php echo base_url();?>assets/admin/vendors/gauge.js/dist/gauge.min.js"></script>
<!-- bootstrap-progressbar -->
<script src="<?php echo base_url();?>assets/admin/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
<!-- iCheck -->
<script src="<?php echo base_url();?>assets/admin/vendors/iCheck/icheck.min.js"></script>
<!-- Skycons -->
<script src="<?php echo base_url();?>assets/admin/vendors/skycons/skycons.js"></script>
<!-- Flot -->
<script src="<?php echo base_url();?>assets/admin/vendors/Flot/jquery.flot.js"></script>
<script src="<?php echo base_url();?>assets/admin/vendors/Flot/jquery.flot.pie.js"></script>
<script src="<?php echo base_url();?>assets/admin/vendors/Flot/jquery.flot.time.js"></script>
<script src="<?php echo base_url();?>assets/admin/vendors/Flot/jquery.flot.stack.js"></script>
<script src="<?php echo base_url();?>assets/admin/vendors/Flot/jquery.flot.resize.js"></script>
<!-- Flot plugins -->
<script src="<?php echo base_url();?>assets/admin/vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
<script src="<?php echo base_url();?>assets/admin/vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
<script src="<?php echo base_url();?>assets/admin/vendors/flot.curvedlines/curvedLines.js"></script>
<!-- DateJS -->
<script src="<?php echo base_url();?>assets/admin/vendors/DateJS/build/date.js"></script>
<!-- JQVMap -->
<script src="<?php echo base_url();?>assets/admin/vendors/jqvmap/dist/jquery.vmap.js"></script>
<script src="<?php echo base_url();?>assets/admin/vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
<script src="<?php echo base_url();?>assets/admin/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
<!-- bootstrap-daterangepicker -->
<script src="<?php echo base_url();?>assets/admin/vendors/moment/min/moment.min.js"></script>
<script src="<?php echo base_url();?>assets/admin/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>

<!-- Custom Theme Scripts -->
<script src="<?php echo base_url();?>assets/admin/build/js/custom.min.js"></script>

</body>
</html>
