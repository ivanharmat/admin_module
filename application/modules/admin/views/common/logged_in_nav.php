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
				<li class="active">
					<a href="#">Link</a>
				</li>
				<li>
					<a href="#">Link</a>
				</li>
				<li>
					<a href="#">Link</a>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <i class="fa fa-caret-down "></i></a>
					<ul class="dropdown-menu">
						<li>
							<a href="#">Action</a>
						</li>
						<li>
							<a href="#">Another action</a>
						</li>
						<li>
							<a href="#">Something else here</a>
						</li>
						<li class="divider"></li>
						<li class="dropdown-header">Nav header</li>
						<li>
							<a href="#">Separated link</a>
						</li>
						<li>
							<a href="#">One more separated link</a>
						</li>
					</ul>
				</li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user "></i> <i class="fa fa-caret-down "></i></a>
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