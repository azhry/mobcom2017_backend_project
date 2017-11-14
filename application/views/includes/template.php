<?php 

$this->load->view('includes/header', ['title' => $title]);
$this->load->view($content);
$this->load->view('includes/footer');