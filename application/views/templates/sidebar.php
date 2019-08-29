<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
    <div class="sidebar-brand-icon rotate-n-15">
      <i class="fas fa-code"></i>
    </div>
    <div class="sidebar-brand-text mx-3">aLvin <sup>pri</sup></div>
  </a>

  <!-- Divider -->
  <hr class="sidebar-divider">

  <!-- ***********************************************************
    Buka website www.dofactory.com/sql/join
    Website rekomendasi untuk mencari cara meng query join PHP
  ************************************************************ -->

  <!-- QUERY MENU -->
  <?php
  $role_id = $this->session->userdata('role_id');
  $queryMenu = "SELECT `user_menu`.`menu_id`, `menu`
                  FROM `user_menu` JOIN `user_accessmenu`
                    ON `user_menu`.`menu_id` = `user_accessmenu`.`menu_id`
                  WHERE `user_accessmenu`.`role_id` = $role_id
                ORDER BY `user_accessmenu`.`menu_id` ASC
                ";
  $menu = $this->db->query($queryMenu)->result_array();
  ?>

  <!-- CARA MEMBACA QUERY JOIN DI ATAS ******************************************

  $role_id = $this->session->userdata('role_id'); ==> Mengambil role_id yang ada di sessiom
  $queryMenu = "SELECT `user_menu`.`menu_id`, `menu` ==> Pilih field ( menu_di dan menu ) yang ada di table user_menu
                  FROM `user_menu` JOIN `user_accessmenu` ==> Dari table user_menu JOIN table user_accessmenu
                    ON `user_menu`.`menu_id` = `user_accessmenu`.`menu_id` ==> Hubungkan field primary key menu_id di table user_menu ke foreign key menu_id di table user_accessmenu
                  WHERE `user_accessmenu`.`role_id` = $role_id ==> Yang role_id di table user_accessmenu sama dengan role_id yang ada di session
                ORDER BY `user_accessmenu`.`menu_id` ASC
                ";
  $menu = $this->db->query($queryMenu)->result_array();

  *************************************************************************** -->

  <!-- LOOPING MENU -->
  <?php foreach ($menu as $m) : ?>
  <div class="sidebar-heading">
    <!-- Menampilkan Nama menu -->
    <?= $m['menu']; ?>
  </div>

  <!-- SIAPKAN SUB-MENU SESUAI MENU -->
  <?php
    // 1. Cara dengan JOIN
    // $menuId = $m['menu_id'];
    // $querySubMenu = "SELECT * 
    //                   FROM `user_submenu` JOIN `user_menu` 
    //                     ON `user_submenu`.`menu_id` = `user_menu`.`menu_id`
    //                   WHERE `user_submenu`.`menu_id` = $menuId
    //                   AND `user_submenu`.`is_active` = 1
    //                 ";
    // $subMenu = $this->db->query($querySubMenu)->result_array();

    // 2. Cara dengan SQL biasa
    $querySubMenu = "SELECT * FROM `user_submenu`
                      WHERE `menu_id` = {$m['menu_id']}
                      AND `is_active` = 1
                    ";
    $subMenu = $this->db->query($querySubMenu)->result_array();
    ?>

  <!-- CARA MEMBACA QUERY JOIN DI ATAS ******************************************
  
  1. Cara pertama dengan JOIN

  $menuId = $m['menu_id']; ==> mengambil menu_id dari hasil query yang di atas
  $querySubMenu = "SELECT * ==> Menampilkan semua 
                    FROM `user_submenu` JOIN `user_menu` ==> Dari table user_submenu dengan table user_menu
                      ON `user_submenu`.`menu_id` = `user_menu`.`menu_id` Hubungkan menu_id di table user_submenu dengan table user_menu
                    WHERE `user_submenu`.`menu_id` = $menuId ==> Yang menu_id di table user_submenu sama dengan $menuId
                    AND `user_submenu`.`is_active` = 1 ==> Dan aktif
                  ";
  $subMenu = $this->db->query($querySubMenu)->result_array();

  *************************************************************************** -->

  <?php foreach ($subMenu as $sm) : ?>
  <?php if ($title == $sm['title']) : ?>

  <!-- Nav-Items -->
  <li class="nav-item active">
    <?php else : ?>
  <li class="nav-item">
    <?php endif; ?>
    <a class="nav-link pb-0" href="<?= base_url($sm['url']); ?>">
      <i class="<?= $sm['icon']; ?>"></i>
      <span><?= $sm['title']; ?></span></a>
  </li>

  <?php endforeach; ?>

  <!-- Divider -->
  <hr class="sidebar-divider mt-3">

  <?php endforeach; ?>

  <li class="nav-item">
    <a class="nav-link" href="<?= base_url('auth/logout'); ?>" data-toggle="modal" data-target="#logoutModal">
      <i class="fas fa-fw fa-sign-out-alt"></i>
      <span>Logout</span></a>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider d-none d-md-block">

  <!-- Sidebar Toggler (Sidebar) -->
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>

</ul>
<!-- End of Sidebar -->