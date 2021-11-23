<body class="skin-1">
    <div id="navbar" class="navbar navbar-default    navbar-collapse       h-navbar ace-save-state">
      <div class="navbar-container ace-save-state" id="navbar-container">
        <div class="navbar-header pull-left">
          <a href="<?php echo base_url('Admin')?>" class="navbar-brand">
            <small>
              <i class="fa fa-leaf"></i>
              I-Care
            </small>
          </a>

          <button class="pull-right navbar-toggle navbar-toggle-img collapsed" type="button" data-toggle="collapse" data-target=".navbar-buttons,.navbar-menu">
            <span class="sr-only">Toggle user menu</span>

            <img src="<?php echo base_url()?>assets/images/avatars/user.jpg" alt="Jason's Photo" />
          </button>

          <button class="pull-right navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#sidebar">
            <span class="sr-only">Toggle sidebar</span>

            <span class="icon-bar"></span>

            <span class="icon-bar"></span>

            <span class="icon-bar"></span>
          </button>
        </div>

        <div class="navbar-buttons navbar-header pull-right  collapse navbar-collapse" role="navigation">
          <ul class="nav ace-nav">
            <li class="dropdown-modal user-min">
              <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                <img class="nav-user-photo" src="<?php echo base_url();?>assets/images/avatars/avatar4.png" alt="Jason's Photo" />
                <span class="user-info">
                  <small>Welcome,</small>
                  <?php echo $this->session->userdata('nama');?>
                </span>

                <i class="ace-icon fa fa-caret-down"></i>
              </a>

              <ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                <li class="divider"></li>

                <li>
                  <a href="<?php echo base_url();?>login/logout">
                    <i class="ace-icon fa fa-power-off"></i>
                    Logout
                  </a>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </div><!-- /.navbar-container -->
    </div>

    <div class="main-container ace-save-state" id="main-container">
      <script type="text/javascript">
        try{ace.settings.loadState('main-container')}catch(e){}
      </script>

      <div id="sidebar" class="sidebar                  responsive                    ace-save-state">
        <script type="text/javascript">
          try{ace.settings.loadState('sidebar')}catch(e){}
        </script>
        <ul class="nav nav-list">
          <br />
          <br />
          <br />
          <li class="">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-bolt"></i>
							<b><span class="menu-text"> Master </span>
              </b>
							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<li class="">
								<a href="<?php echo base_url()?>admin/bar">
									<i class="menu-icon fa fa-legal"></i>
									<b>Input Debitur</b>
								</a>

								<b class="arrow"></b>
							</li>

							<li class="">
								<a href="<?php echo base_url()?>admin/invoice">
									<i class="menu-icon fa fa-remove"></i>
									<b>Input Debitur Excel</b>
								</a>

								<b class="arrow"></b>
							</li>
						</ul>
					</li>
          <li class="">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-send-o"></i>
							<b><span class="menu-text"> Rekonsiliasi </span>
              </b>
							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<li class="active open">
								<a href="<?php echo base_url()?>admin">
									<i class="menu-icon fa fa-send-o"></i>
									<b>Input Recoveries</b>
								</a>

								<b class="arrow"></b>
							</li>

							<li class="">
								<a href="<?php echo base_url()?>admin/periode">
									<i class="menu-icon fa fa-calendar"></i>
									<b>Periode</b>
								</a>

								<b class="arrow"></b>
							</li>

              <li class="">
                <a href="<?php echo base_url()?>rekonsilasi/rekonsilasi">
									<i class="menu-icon fa fa-calendar"></i>
									<b>Rekonsilasi</b>
								</a>

								<b class="arrow"></b>
							</li>
						</ul>
          </li>
          <li class="">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-bolt"></i>
							<b><span class="menu-text"> Monitoring </span>
              </b>
							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<li class="">
								<a href="<?php echo base_url()?>admin/bar">
									<i class="menu-icon fa fa-legal"></i>
									<b>BAR</b>
								</a>

								<b class="arrow"></b>
							</li>

							<li class="">
								<a href="<?php echo base_url()?>admin/invoice">
									<i class="menu-icon fa fa-remove"></i>
									<b>Invoice</b>
								</a>

								<b class="arrow"></b>
							</li>
						</ul>
					</li>
          <li class="hover">
            <a href="<?php echo base_url()?>admin/saldo">
              <i class="menu-icon fa fa-dollar"></i>
              <span class="menu-text"><b> Update Saldo </b></span>
            </a>

            <b class="arrow"></b>
          </li>
        </ul><!-- /.nav-list -->
      </div>