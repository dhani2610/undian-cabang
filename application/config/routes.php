<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'login';
$route['404_override'] = 'home/error';
$route['translate_uri_dashes'] = TRUE;

$route['aplikasi-undian-nama-online'] = "home/aplikasi_undian_nama_online";
$route['aplikasi-undian-nama-online-masuk'] = "home/aplikasi_undian_nama_online_masuk";
$route['aplikasi-undian-nama-online-view'] = "home/aplikasi_undian_nama_online_view";
$route['aplikasi-undian-nama-online-save'] = "home/aplikasi_undian_nama_online_save";
$route['aplikasi-undian-nama-online-list'] = "home/aplikasi_undian_nama_online_list";
$route['aplikasi-undian-nama-online-start'] = "home/aplikasi_undian_nama_online_start";
$route['get-undian-data'] = "home/get_undian_data";
$route['pengaturan'] = "home/pengaturan";

