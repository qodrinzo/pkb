<?php
include 'header.php';
?>

	<div id="primary" class="expanded row">
		<main id="site_main" role="main">
			<article>
				<header class="entry-title small-12 column">
					<h1></h1>
				</header>
				<div class="file-info medium-3 large-2 columns">
					<div class="button-group">
						<button type="button" class="edit_title button secondary"><i class="fa fa-pencil fa-lg"></i></button>
						<button type="button" class="set_title_image button secondary"><i class="fa fa-file-image-o fa-lg"></i></button>
						<a class="button secondary" href="./<?=$file_id?>"><i class="fa fa-external-link fa-lg"></i></a>
					</div>
					<aside>
						<article>
							<label>Title
								<?php // IDEA: For filename beginning with underscore, we should not replace with space ?>
								<input type="text" name="outline_title" pattern='[^\\/*?:"<>|]' id="outline_title" placeholder="File Name" value="<?=(isset($file_id))?str_replace('_', ' ', $file_id):''?>">
							</label>
							<p class="help-text">Also for naming the file as <i></i>.opml</p>
							<label>Disambiguation
								<input type="text" name="outline_title_disambiguation" pattern='[^\\/*?:"<>|]' id="outline_title_disambiguation" placeholder="Disambiguation">
							</label>
							<div class="button-group stacked">
								<button type="button" class="save_btn success button">Save</button>
								<button type="button" class="draft_btn warning button">Draft</button>
								<button type="button" class="delete_btn alert button">Delete</button>
							</div>
						</article>
					</aside>
				</div>
				<div class="medium-9 large-10 columns">
					<div clss="row collapse">
						<nav class="columns editor-toolbar">
							<ul class="menu vertical">
								<li><a href="@bold"><i class="fa fa-bold"></i></a></li>
								<li><a href="@italic"><i class="fa fa-italic"></i></a></li>
								<li><a href="@strikethrough"><i class="fa fa-strikethrough"></i></a></li>
								<li><a href="@highlight"><i class="fa fa-eyedropper"></i></a></li>
								<li><a href="@link"><i class="fa fa-link"></i></a></li>
								<li><a href="@unlink"><i class="fa fa-unlink"></i></a></li>
								<li><a href="@linktoimg"><i class="fa fa-file-image-o"></i></a></li>
								<li><a href="@undo"><i class="fa fa-undo"></i></a></li>
							</ul>
						</nav>
						<div class="divOutlinerContainer coulmns">
							<div class="outliner" tabindex="1">
							</div>
						</div>
					</div>
				</div>
			</article>
		</main>
	</div>

<?php
include 'footer.php';
?>
