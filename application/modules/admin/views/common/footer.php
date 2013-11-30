	</div><!-- /.container -->
	<div class="container">
		<hr>
		<div class="footer">
			<p>&copy; <?php echo APP_NAME.' '.date('Y');?></p>
		</div>
	</div>
    <script src="/skin/admin/js/jquery.min.js"></script>
    <script src="/skin/admin/js/bootstrap.min.js"></script>	
    <script src="/skin/admin/js/general.js"></script>
    <?php if(isset($js)):?>
	<!-- Custom JS files -->
		<?php foreach($js as $j):?>
			<?php if(strpos($j, '.js') === FALSE):?>
				<?php if(file_exists(getcwd().'/skin/admin/js/custom/'.$j.'.js')):?>
				<script src="/skin/admin/js/custom/<?php echo $j;?>.js"></script>
				<?php endif;?>
			<?php else:?>
				<?php $filename = explode('.js', $j);?>
				<?php if(file_exists(getcwd().'/skin/admin/js/custom/'.$filename[0].'.js')):?>
				<script src="/skin/admin/js/custom/<?php echo $j;?>"></script>
				<?php endif;?>
			<?php endif;?> 
		<?php endforeach;?>
	<?php endif;?>
	</body>
</html>