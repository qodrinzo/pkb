<?php
include 'header.php';
?>

	<div class="expanded row">
		<main id="site_main" role="main">
			<article>
				<aside class="medium-3 large-2 columns">
					<input type="hidden" name="filename" value="<?=(isset($file_id))?$file_id:0?>">
					<article id="file_title_container">
						<label>File name
							<input type="text" name="file_name" pattern='[^\\/*?:"<>|]' id="file_name" placeholder="File Name" value="<?=(isset($file_id))?str_replace('_', ' ', $file_id):''?>">
						</label>
						<label>Disambiguation
							<input type="text" name="file_name_disambiguation" id="file_name_disambiguation" placeholder="Disambiguation">
						</label>
						<div class="button-group">
							<button type="button" id="save_btn" class="success button">Save</button>
							<button type="button" id="save_btn" class="warning button">Draft</button>
							<button type="button" id="delete_btn" class="alert button">Delete</button>
						</div>
					</article>
				</aside>
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
							</ul>
						</nav>
						<div class="divOutlinerContainer coulmns">
							<div id="outliner">
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
