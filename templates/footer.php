			</div>
		</div>
	</div>
	<script>
		(function($){
			$(document).foundation();
			$(document).ready (function () {
				var outlinerId = "#outliner";
				var myoutline = $(outlinerId).concord ({
					"prefs": {
						"outlineFont": "Georgia",
						"outlineFontSize": 18,
						"outlineLineHeight": 24,
						"renderMode": true,
						"readonly": false,
						"typeIcons": appTypeIcons
					},
					"open": "<?=$site['root']?>open",
					"save": "<?=$site['root']?>save",
					<?=(isset($file_id)) ? "\"id\": \"$file_id\"" : ""?>
				});
				defaultUtilsOutliner = outlinerId;
				opXmlToOutline (initialOpmltext);
				$('#save_btn').on('click', function() {
					$(defaultUtilsOutliner).concord().save();
				});

				var outline_first_node_text = $(defaultUtilsOutliner).find(".concord-node:first").find(".concord-text:first");
				//outline_first_node_text.attr("contenteditable", "false");					.on('keydown', function(e){										var code = e.keyCode || e.which;										if(code == 191 220 ) { 											//Do something										}									})
				$('input#file_name')
					.on('keyup', function(e) {
						outline_first_node_text.html('<b>' + $(this).prop('value') + '</b>');
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
							break;
					}
				});
			});

		})(jQuery);
	</script>
</body>
</html>
