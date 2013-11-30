<?php 
$this->load->view('common/header');
$this->load->view('common/logged_in_nav');
?>
<div id="flashdata"><?php echo $this->session->flashdata('flashdata');?></div>
<?php
$this->load->view($content);
$this->load->view('common/footer');
?>