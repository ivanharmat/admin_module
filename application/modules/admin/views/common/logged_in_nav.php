	<div class="navbar navbar-default navbar-inverse" role="navigation">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
			<span class="sr-only"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="/admin"><?php echo APP_NAME;?></a>
		</div>
		<div class="navbar-collapse collapse">
			<ul class="nav navbar-nav">
				<li <?php echo (isset($active) && $active == 'pages') ? 'class="active"' : '';?>>
					<a href="/admin/pages"><i class="fa fa-files-o"></i> Pages</a>
				</li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user "></i> <?php echo $common['first_name'];?> <i class="fa fa-caret-down "></i></a>
					<ul class="dropdown-menu">
						<li>
							<a href="/admin/settings"><i class="fa fa-cog"></i> Settings</a>
						</li>
						<li class="divider"></li>
						<li>
							<a href="/admin/logout"><i class="fa fa-sign-out"></i> Log Out</a>
						</li>
					</ul>
				</li>
			</ul>
		</div>
	</div>