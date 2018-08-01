<!-- sidebar menu -->
<?php
	$segment =  Request::segment(2);
	$sub_segment =  Request::segment(3);
?>
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
	<div class="menu_section">
        <h3>General</h3>
		<ul class="nav side-menu">
			<li class="{{ ($segment == 'dashboard' ? 'active' : '') }}">
				<a href="<?=url('backend/dashboard');?>"><i class="fa fa-dashboard"></i> Dashboard</a>
			</li>
			<li class=" {{ ((($segment == 'language') || ($segment == 'setting') || ($segment == 'modules') || ($segment == 'access-control')) ? 'active' : '') }}">
				<a><i class="fa fa-cog"></i> System Admin <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu" style="{{ ((($segment == 'language') || ($segment == 'setting') || ($segment == 'modules') || ($segment == 'access-control')) ? 'display : block' : '') }}">
					<?php
						// SUPER ADMIN //
						if ($userinfo['user_level_id'] == 1):
		
					?>
					<li class="{{ ($segment == 'language' ? 'active' : '') }}">
						<a href="<?=url('backend/language');?>">Language</a>
                    </li>
					<?php
						endif;
					?>
					<li class="{{ ($segment == 'setting' ? 'active' : '') }}">
						<a href="<?=url('backend/setting');?>">Setting</a>
					</li>
					<?php
						// SUPER ADMIN //
						if ($userinfo['user_level_id'] == 1):
		
					?>
					<li class="{{ ($segment == 'modules' ? 'active' : '') }}">
						<a href="<?=url('backend/modules');?>">Modules</a>
					</li>
					<?php
						endif;
					?>
					<li class="{{ ($segment == 'access-control' ? 'active' : '') }}">
						<a href="<?=url('backend/access-control');?>">Access Control</a>
					</li>
				</ul>
            </li>
			<li class=" {{ ((($segment == 'users-level') || ($segment == 'users-user')) ? 'active' : '') }}">
				<a><i class="fa fa-users"></i> Membership <span class="fa fa-chevron-down"></span></a>
				<ul class="nav child_menu" style="{{ ((($segment == 'users-level') || ($segment == 'users-user')) ? 'display : block' : '') }}">
					<li class="{{ ($segment == 'users-level' ? 'active' : '') }}">
						<a href="<?=url('backend/users-level');?>">Master User Level</a>
					</li>
					<li class="{{ ($segment == 'users-user' ? 'active' : '') }}">
						<a href="<?=url('backend/users-user');?>">Master User</a>
					</li>
				</ul>
			</li>
			<li class="{{ ($segment == 'media-library' ? 'active' : '') }}">
				<a href="<?=url('backend/media-library');?>"><i class="fa fa-picture-o"></i> Media Library</a>
            </li>
			<li class=" {{ ((($segment == 'blog-category') || ($segment == 'blog-content')) ? 'active' : '') }}">
				<a><i class="fa fa-file-text-o"></i> Blog <span class="fa fa-chevron-down"></span></a>
				<ul class="nav child_menu" style="{{ ((($segment == 'blog-category') || ($segment == 'blog-content')) ? 'display : block' : '') }}">
					<li class="{{ ($segment == 'blog-category' ? 'active' : '') }}">
						<a href="<?=url('backend/blog-category');?>">Category</a>
					</li>
					<li class="{{ ($segment == 'blog-content' ? 'active' : '') }}">
						<a href="<?=url('backend/blog-content');?>">Content</a>
					</li>
				</ul>
			</li>
            <li class="{{ ($segment == 'pages' ? 'active' : '') }}">
                <a href="<?=url('backend/pages');?>"><i class="fa fa-file-text-o"></i> Pages</a>
            </li>
            <li class="{{ ($segment == 'photos' ? 'active' : '') }}">
                <a href="<?=url('backend/photos');?>"><i class="fa fa-camera-retro"></i> Gallery Photos</a>
            </li>
            <li class="{{ ($segment == 'contact-inbox' ? 'active' : '') }}">
                <a href="<?=url('backend/contact-inbox');?>"><i class="fa fa-envelope-o"></i>Inbox &nbsp;&nbsp;<span class="badge bg-green"><?=getInboxCount();?></span></a>
            </li>
		</ul>
    </div>
</div>

