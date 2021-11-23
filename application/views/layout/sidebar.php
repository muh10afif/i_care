<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <!-- User Profile-->
                <li>
                    <!-- User Profile-->
                    <div class="user-profile d-flex no-block dropdown mt-3">
                        <div class="user-pic"><img src="<?= base_url() ?>template/assets/images/users/1.jpg" alt="users" class="rounded-circle" width="40" /></div>
                        <div class="user-content hide-menu ml-2">
                            <a href="javascript:void(0)" class="" id="Userdd" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <h5 class="mb-0 user-name font-medium"><?= ucwords($this->session->userdata('nama'))?><?= nbs(3) ?><i class="fa fa-angle-down"></i></h5>
                                <span class="op-5 user-email"><?= ucwords($this->session->userdata('level')) ?></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="Userdd">
                                <a class="dropdown-item" href="<?= base_url('c_login/logout') ?>"><i class="fa fa-power-off mr-1 ml-1"></i> Logout</a>
                            </div>
                        </div>
                    </div>
                    <!-- End User Profile-->
                </li>

                <?php $id_level = $this->session->userdata('id_level'); ?>

                <?php if ($id_level == 2) : ?>

                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fas fa-hdd"></i><span class="hide-menu"><?= nbs(3) ?>Master</span></a>
                    <ul aria-expanded="false" class="collapse  first-level">
                        <li class="sidebar-item"><a href="<?= base_url('master') ?>" class="sidebar-link"><i class="mdi mdi-adjust"></i><span class="hide-menu"> Debitur </span></a></li>
                        <li class="sidebar-item"><a href="<?= base_url('master/karyawan') ?>" class="sidebar-link"><i class="mdi mdi-adjust"></i><span class="hide-menu"> Karyawan </span></a></li>
                        <!-- <li class="sidebar-item"><a href="<?= base_url('master/pengguna') ?>" class="sidebar-link"><i class="mdi mdi-adjust"></i><span class="hide-menu"> Pengguna </span></a></li> -->
                        <li class="sidebar-item"><a href="<?= base_url('master/bank') ?>" class="sidebar-link"><i class="mdi mdi-adjust"></i><span class="hide-menu"> Bank </span></a></li>
                        <li class="sidebar-item"><a href="<?= base_url('master/cabang_bank') ?>" class="sidebar-link"><i class="mdi mdi-adjust"></i><span class="hide-menu"> Cabang Bank </span></a></li>
                        <li class="sidebar-item"><a href="<?= base_url('master/capem_bank') ?>" class="sidebar-link"><i class="mdi mdi-adjust"></i><span class="hide-menu"> Capem Bank </span></a></li>
                        <li class="sidebar-item"><a href="<?= base_url('master/asuransi') ?>" class="sidebar-link"><i class="mdi mdi-adjust"></i><span class="hide-menu"> Asuransi </span></a></li>
                        <li class="sidebar-item"><a href="<?= base_url('master/korwil_asuransi') ?>" class="sidebar-link"><i class="mdi mdi-adjust"></i><span class="hide-menu"> Korwil Asuransi </span></a></li>
                        <li class="sidebar-item"><a href="<?= base_url('master/cabang_asuransi') ?>" class="sidebar-link"><i class="mdi mdi-adjust"></i><span class="hide-menu"> Cabang Asuransi </span></a></li>
                        <li class="sidebar-item"><a href="<?= base_url('master/rekening') ?>" class="sidebar-link"><i class="mdi mdi-adjust"></i><span class="hide-menu"> Rekening </span></a></li>
                        <li class="sidebar-item"><a href="<?= base_url('master/spk') ?>" class="sidebar-link"><i class="mdi mdi-adjust"></i><span class="hide-menu"> SPK </span></a></li>
                        <!-- <li class="sidebar-item"><a href="<?= base_url('master/pengguna') ?>" class="sidebar-link"><i class="mdi mdi-adjust"></i><span class="hide-menu"> Pengguna </span></a></li> -->
                    </ul> 
                </li>
                
                <?php endif; ?>

                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fas fa-archive"></i><span class="hide-menu"><?= nbs(3) ?>Rekonsiliasi</span></a>
                    <ul aria-expanded="false" class="collapse  first-level">
                        <li class="sidebar-item"><a href="<?= base_url('rekon/input') ?>" class="sidebar-link"><i class="mdi mdi-adjust"></i><span class="hide-menu"> Input Recoveries </span></a></li>
                        <li class="sidebar-item"><a href="<?= base_url('rekon/rekon_recov') ?>" class="sidebar-link"><i class="mdi mdi-adjust"></i><span class="hide-menu"> Rekonsilisasi Recoveries </span></a></li>
                        <li class="sidebar-item"><a href="<?= base_url('rekon/periode') ?>" class="sidebar-link"><i class="mdi mdi-adjust"></i><span class="hide-menu"> Periode </span></a></li>
                        <li class="sidebar-item"><a href="<?= base_url('rekon') ?>" class="sidebar-link"><i class="mdi mdi-adjust"></i><span class="hide-menu"> Rekonsiliasi </span></a></li>
                    </ul> 
                </li>
                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fas fa-location-arrow"></i><span class="hide-menu"><?= nbs(3) ?>Monitoring</span></a>
                    <ul aria-expanded="false" class="collapse  first-level">
                        <li class="sidebar-item"><a href="<?= base_url('monitoring/bar') ?>" class="sidebar-link"><i class="mdi mdi-adjust"></i><span class="hide-menu"> Bar </span></a></li>
                        <li class="sidebar-item"><a href="<?= base_url('monitoring/invoice') ?>" class="sidebar-link"><i class="mdi mdi-adjust"></i><span class="hide-menu"> Invoice </span></a></li>
                    </ul> 
                </li>
                <!-- <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?= base_url('manager/on_the_spot') ?>" aria-expanded="false"><i class="fas fa-money-bill-alt"></i><span class="hide-menu"><?= nbs(3) ?>Update Saldo</span></a></li> -->
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?= base_url('monitoring/pembayaran_klien') ?>" aria-expanded="false"><i class="fas fa-hand-holding-usd"></i><span class="hide-menu"><?= nbs(3) ?>Pembayaran Klien</span></a></li>

                <?php if ($id_level == 2) : ?>

                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="far fa-file-alt"></i><span class="hide-menu"><?= nbs(3) ?>Laporan Keuangan</span></a>
                    <ul aria-expanded="false" class="collapse  first-level">
                        <li class="sidebar-item"><a href="<?= base_url('laporan/pengeluaran_bulanan') ?>" class="sidebar-link"><i class="mdi mdi-adjust"></i><span class="hide-menu"> Pengeluaran Bulanan </span></a></li>
                        <li class="sidebar-item"><a href="<?= base_url('laporan/biaya_per_coa') ?>" class="sidebar-link"><i class="mdi mdi-adjust"></i><span class="hide-menu"> Biaya Per COA </span></a></li>
                        <li class="sidebar-item"><a href="<?= base_url('laporan/biaya_per_pic') ?>" class="sidebar-link"><i class="mdi mdi-adjust"></i><span class="hide-menu"> Biaya Per PIC </span></a></li>
                    </ul> 
                </li>
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?= base_url('monitoring/upload_dokumen') ?>" aria-expanded="false"><i class="fa fa-upload"></i><span class="hide-menu"><?= nbs(3) ?>Upload Dokumen</span></a></li>
                
                <?php endif; ?>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>