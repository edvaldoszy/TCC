<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <base href="<?= '//' . $_SERVER['SERVER_NAME'] ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= $this->getTitle(); ?> - FastFood</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/assets/dist/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="/assets/dist/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/assets/dist/css/AdminLTE.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="/assets/dist/css/skins/skin-blue.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<!-- ADD THE CLASS fixed TO GET A FIXED HEADER AND SIDEBAR LAYOUT -->
<!-- the fixed layout is not compatible with sidebar-mini -->
<body class="hold-transition skin-blue fixed sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <a href="../../index2.html" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>FF</b></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>FastFood</b></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>

            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="/assets/dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
                            <span class="hidden-xs"><?= $this->controller->getUsuario()->nome ?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header">
                                <img src="/assets/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">

                                <p><?= $this->controller->getUsuario()->nome ?></p>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="text-center">
                                    <a href="/login/sair" class="btn btn-default btn-flat">Sair</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <!-- =============================================== -->

    <!-- Left side column. contains the sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="/assets/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                </div>
                <div class="pull-left info">
                    <p><?= $this->controller->getUsuario()->nome ?></p>
                    <!--<a href="#"><i class="fa fa-circle text-success"></i> Online</a>-->
                </div>
            </div>
            <!-- search form -->
            <form action="#" method="get" class="sidebar-form">
                <div class="input-group">
                    <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
                </div>
            </form>
            <!-- /.search form -->
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu">
                <li class="header">NAVEGAÇÃO PRINCIPAL</li>
                <li class="active">
                    <a href="/">
                        <i class="fa fa-dashboard"></i> <span>Principal</span>
                    </a>
                </li>
                <li>
                    <a href="/clientes">
                        <i class="fa fa-dashboard"></i> <span>Clientes</span>
                    </a>
                </li>
                <li class="treeview">
                    <a href="/pedidos">
                        <i class="fa fa-edit"></i><span>Pedidos</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="/pedidos/abertos"><i class="fa fa-circle-o"></i> Abertos</a></li>
                        <li><a href="/pedidos/fechados"><i class="fa fa-circle-o"></i>Fechados</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="/estoque">
                        <i class="fa fa-edit"></i><span>Estoque</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="/estoque/produtos"><i class="fa fa-circle-o"></i>Produtos</a></li>
                        <li><a href="/estoque/itens"><i class="fa fa-circle-o"></i>Itens</a></li>
                    </ul>
                </li>
                <li>
                    <a href="/categorias">
                        <i class="fa fa-list-alt"></i><span>Categorias</span>
                    </a>
                </li>
                <li class="header">SISTEMA</li>
                <li>
                    <a href="/usuarios">
                        <i class="fa fa-list-alt"></i><span>Usuários</span>
                    </a>
                </li>
            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- =============================================== -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <?php $this->getBody(); ?>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            v. 1.0
        </div>
        Copyright &copy; 2015 <a href="http://edvaldotsi.com/fastfood">FastFood</a> - Todos os direitos reservados.
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Create the tabs -->
        <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
            <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
            <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
        </ul>
    </aside>
    <!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed
         immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 2.1.4 -->
<script src="/assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
<!-- Bootstrap 3.3.5 -->
<script src="/assets/bootstrap/js/bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="/assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="/assets/plugins/fastclick/fastclick.js"></script>

<script src="/assets/plugins/input-mask/jquery.inputmask.js"></script>
<script src="/assets/plugins/input-mask/jquery.inputmask.numeric.extensions.js"></script>
<script src="/assets/plugins/input-mask/jquery.inputmask.money.min.js"></script>
<!-- AdminLTE App -->
<script src="/assets/dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="/assets/dist/js/demo.js"></script>
<script>
    $(document).ready(function() {
        $(".money-mask").maskMoney({decimal: '.', thousands: ''});
    });
</script>
</body>
</html>
