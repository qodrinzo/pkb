<!DOCTYPE html>
<html class="no-js" lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title><?=$site['title']?></title>
		<link href="<?=$site['root']?>vendor/zurb/foundation/dist/foundation.min.css" rel="stylesheet">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="<?=$site['root']?>dist/css/styles.min.css">

		<script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
		<script src="<?=$site['root']?>vendor/zurb/foundation/dist/foundation.min.js"></script>
		<script src="<?=$site['root']?>dist/js/scripts.js"></script>
	</head>
	<body>
		<div class="off-canvas-wrapper">
			<div class="off-canvas-wrapper-inner" data-off-canvas-wrapper>
				<div class="off-canvas position-left reveal-for-large" id="offCanvas" data-off-canvas>
					<?php include "left-sidebar.php" ?>
				</div>
				<div class="off-canvas-content" data-off-canvas-content>

					<nav class="top-bar" id="main_navigation">
						<div class="top-bar-left">
							<ul class="dropdown menu" data-dropdown-menu>
								<li class="hide-for-large"><button class="menu-icon" type="button" data-toggle="offCanvas"></button></li>
								<li class="menu-text">Personal Knowledge Base</li>
								<li class="has-submenu">
									<a href="#">New</a>
									<ul class="submenu menu vertical" data-submenu>
										<li><a href="<?=$site['root']?>new/know">Know</a></li>
										<li><a href="<?=$site['root']?>new/book">Book</a></li>
									</ul>
								</li>
								<li><a href="#">Two</a></li>
								<li><a href="#">Three</a></li>
							</ul>
						</div>
						<div class="top-bar-right">
							<ul class="menu">
								<li><input type="search" placeholder="Search"></li>
								<li><button type="button" class="button">Search</button></li>
							</ul>
						</div>
					</nav>
