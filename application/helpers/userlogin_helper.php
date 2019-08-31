<?php

function is_logged_in()
{
  // instansiasi sebuah variable dgn nama bebas agar dikenali oleh codeigniter
  $userLogin = get_instance();

  if (!$userLogin->session->userdata('email')) {
    redirect('auth');
  } else {
    $role_id = $userLogin->session->userdata('role_id'); //mengambil data role_id dari session userdata
    $menu = $userLogin->uri->segment(1); //mengambil data segment dari url ke 1

    $queryMenu = $userLogin->db->get_where('user_menu', ['menu' => $menu])->row_array(); //mengambil data user_menu yang sama dengan $menu / uri segment ke 1 
    $menu_id = $queryMenu['menu_id']; //mengambil menu_id dari $queryMenu

    $userAccess = $userLogin->db->get_where('user_accessmenu', [
      'role_id' => $role_id,
      'menu_id' => $menu_id
    ]); // Ambil seluruh data user_accessmenu yang role_id == $role_id dan menu_id == $menu_id

    if ($userAccess->num_rows() < 1) {
      redirect('auth/blocked');
    } // Jika datanya < 1, maka di block !!
  }
}


function check_access($role_id, $menu_id)
{
  $userCheck = get_instance();

  // Cara pertama :
  // $userCheck->db->where('role_id', $role_id);
  // $userCheck->db->where('menu_id', $menu_id);
  // $result = $userCheck->db->get('user_accessmenu');

  // Cara kedua :
  $result = $userCheck->db->get_where('user_accessmenu', [
    'role_id' => $role_id,
    'menu_id' => $menu_id
  ]);

  if ($result->num_rows() > 0) {
    return "checked='checked'";
  }
}
