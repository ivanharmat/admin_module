<?php 
$this->load->view('common/header');
if($this->session->userdata('admin_logged_in') === TRUE)
{
	$this->load->view('common/logged_in_nav');
}
else
{
	$this->load->view('common/nav');
}
?>
<div id="flashdata"><?php echo $this->session->flashdata('flashdata');?></div>
<?php
$this->load->view($content);
$this->load->view('common/footer');
?>