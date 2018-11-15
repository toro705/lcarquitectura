<?php 
$this->load->view('admin/blocks/header_html');
$this->load->view('admin/blocks/header_view');
$this->load->view('admin/blocks/nav_view');
echo $page_content;
$this->load->view('admin/blocks/footer_view'); 
$this->load->view('admin/blocks/footer_html'); 
?>