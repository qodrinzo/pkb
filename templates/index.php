<?php
include 'header.php';
?>

	<div id="primary" class="expanded row">
		<?php // IDEA: Show multiple outline in a page using tabs panels ?>
		<ul class="tabs" data-tabs id="example-tabs">
			<li class="tabs-title is-active"><a href="#outline-0" aria-selected="true">Tab 1</a></li>
			<li class="tabs-title"><a href="#outline-1">Tab 2</a></li>
		</ul>
		<main id="site_main" role="main">
			<nav class="editor-toolbar">
				<ul class="menu vertical">
					<li><a href="@header" title="Make header"><i class="fa fa-header"></i></a></li>
					<li><a href="@bold" title="Make bold"><i class="fa fa-bold"></i></a></li>
					<li><a href="@italic" title="Make italic"><i class="fa fa-italic"></i></a></li>
					<li><a href="@strikethrough" title="Make strikethrough"><i class="fa fa-strikethrough"></i></a></li>
					<li><a href="@highlight" title="Highlight text"><i class="fa fa-eyedropper"></i></a></li>
					<li><a href="@link" title="Insert link"><i class="fa fa-link"></i></a></li>
					<li><a href="@unlink" title="Remove link"><i class="fa fa-unlink"></i></a></li>
					<li><a href="@linktoimg" title="Add image to current cursor"><i class="fa fa-file-image-o"></i></a></li>
					<li><a href="@undo" title="Undo"><i class="fa fa-undo"></i></a></li>
				</ul>
			</nav>
			<article class="entry clearfix tabs-panel is-active">
				<header class="entry-title small-12 column">
					<h1><?=$this->file['title']?></h1>
				</header>
				<div class="medium-9 large-10 columns">
					<div class="divOutlinerContainer" data-outline-id="<?=$this->file['id']?>" data-outline-doctype="<?=$this->file['doctype']?>">
						<div class="outliner" tabindex="1">
						</div>
					</div>
				</div>
				<div class="file-info medium-3 large-2 columns">
					<div class="button-group">
						<button type="button" class="edit_title button secondary"><i class="fa fa-pencil fa-lg"></i></button>
						<button type="button" class="set_title_image button secondary"><i class="fa fa-file-image-o fa-lg"></i></button>
					</div>
					<aside>
						<article>
							<label>Title
								<input type="text" name="outline_title" class="outline_title" placeholder="Outline Title">
							</label>
							<label>Disambiguation
								<input type="text" name="outline_disambiguation" class="outline_disambiguation" pattern='[^\\/*?:"<>|]' placeholder="Title disambiguation">
							</label>
							<label>File name
								<input type="text" name="outline_filename" class="outline_filename" pattern='[^\\/*?:"<>|]' placeholder="File name" readonly>
							</label>
						</article>
					</aside>
				</div>
			</article>
			<nav id="action-bar">
				<div class="expanded button-group">
					<a href="javascript:void(0)" class="save_btn button">Save</a>
					<a href="javascript:void(0)" class="delete_btn secondary button">Delete</a>
				</div>
			</nav>
		</main>
	</div>

<?php
include 'footer.php';
?>
