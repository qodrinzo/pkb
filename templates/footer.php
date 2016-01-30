			</div>
		</div>
	</div>
	<script>
		(function($){
			$(document).foundation();
			$(document).ready (function () {
				var title_old = $('#outline_title').val();
				var disambig_old = $('#outline_title_disambiguation').val();

				var outlinerId = ".outliner";
				defaultUtilsOutliner = outlinerId;
				var myoutline = $(outlinerId).concord ({
					"prefs": {
						"outlineFont": "Georgia",
						"outlineFontSize": 18,
						"outlineLineHeight": 24,
						"renderMode": true,
						"readonly": false,
						"typeIcons": appTypeIcons
					},
					"callbacks": {
						"cbOpen": function() {
							$('.entry-title h1').text(opGetTitle());
							title_old = $('#outline_title').val();
							disambig_old = $('#outline_title_disambiguation').val();
						}
					},
					"open": "<?=$site['root']?>open",
					"save": "<?=$site['root']?>save",
					<?=(isset($file_id)) ? "\"id\": \"$file_id\"" : ""?>
				});
				opXmlToOutline (initialOpmltext);

				$('#outline_title').on('keyup change', function(e){
					$('+ .help-text i', $(this).parent()).text($(this).val());
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
					err[0]= title.val().match(/[\\/*?:"<>|]/) ? true : false;
					err[1] = (title.val().match(/[\\/*?:"<>|]/) && title.val() !== "") ? true : false;
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

				$('.entry-title h1').text(opGetTitle());
				$('.edit_title').on('click', function(e){
					e.preventDefault();
					$(this).parents('.file-info').find('aside').slideToggle();
				});
			});

		})(jQuery);
	</script>
</body>
</html>
