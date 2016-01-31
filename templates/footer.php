			</div>
		</div>
	</div>
	<script>
		(function($){
			$(document).foundation();
			$(document).ready (function () {
				var outliners = [];

				var title_old = $('#outline_title').val();
				var disambig_old = $('#outline_title_disambiguation').val();

				defaultUtilsOutliner = '.outliner';

				$('.divOutlinerContainer').each( function(index) {
					var outline_file = {
						'id'		: $(this).attr("data-outline-id"),
						'doctype'	: $(this).attr("data-outline-doctype")
					};

					var article = $(this).parents('article');
					article.attr('id', 'outliner-' + index);

					outliners[index] = $('.outliner', article)
						.concord({
							"prefs": {
								"outlineFont": "Georgia",
								"outlineFontSize": 18,
								"outlineLineHeight": 24,
								"renderMode": true,
								"readonly": false,
								"typeIcons": appTypeIcons,
								"doctypes": <?=json_encode($this->doctypes)?>,
							},
							"callbacks": {
								"cbOpen": function(op) {
									$('.entry-title h1', article).text(op.getTitle());
									$('.outline_title', article).val(op.getTitle());
									$('.outline_disambiguation', article).val();
									$('.outline_filename', article).val(outline_file.id + '.' + outline_file.doctype + '.opml');

									//title_old = $('#outline_title').val();
									//disambig_old = $('#outline_title_disambiguation').val();
								}
							},
							"open"		: "<?=$this->site['root']?>open",
							"save"		: "<?=$this->site['root']?>save",
							"id"		: outline_file.id,
							"doctype"	: outline_file.doctype,
						});
					if (!outline_file.id) {
						outliners[index].op.xmlToOutline (initialOpmltext);
					}
				});

				$('.save_btn').on('click', function() {
					var err = [];
					var i = 0;
					var title = $('#outline_title', $(this).parents('.file-info'));
					var disambig = $('#outline_title_disambiguation', $(this).parents('.file-info'));
					if (!opHasChanged() && title.val() == title_old && disambig.val() == disambig_old) {
						alert('no changes!');
						return;
					} else {
						opMarkChanged();
					}
					err[0]= title.val().match(/[\\\/*?:"<>|]/) ? true : false;
					err[1] = (title.val().match(/[\\\/*?:"<>|]/) && title.val() !== "") ? true : false;
					if (err[0] || title.val() === "") {
						title.css('border-color', 'red');
					}
					if (err[1]) {
						disambig.css('border-color', 'red');
					}
					if (err[0] || err[1]) {
						alert('eerr!');
						return;
					}
					title = title.val();
					title += (disambig.val()) ? ' (' + disambig.val() + ')' : '';
					opSetTitle(title);
					$(defaultUtilsOutliner).concord().save();
					alert('end of function!');
					//opRedraw();
				});

				$('.editor-toolbar a').on('click', function(e){
					e.preventDefault();
					var action = $(this).attr('href');
					action = action.substring(1);
					switch( action ) {
						case "bold":
							opBold();
							break;
						case "italic":
							opItalic();
							break;
						case "strikethrough":
							opStrikethrough();
							break;
						case "undo":
							opUndo();
							break;
						case "link":
							break;
					}
				});

				$('.edit_title').on('click', function(e){
					e.preventDefault();
					$(this).parents('.file-info').find('aside').slideToggle();
				});
			});

		})(jQuery);
	</script>
</body>
</html>
