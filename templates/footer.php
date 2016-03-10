			</div>
		</div>
	</div>
	<script>
		(function($){
			$(document).foundation();
			$(document).ready (function () {
				var outliners = [];
				var title_old = [];
				var disambig_old = [];

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
								"doctypes": <?=json_encode(array_keys($this->doctypes))?>,
							},
							"callbacks": {
								"cbOpen": function(op) {
									$('.entry-title h1', article).text(op.getTitle());
									$('.outline_title', article).val(op.getTitle());
									$('.outline_disambiguation', article).val(op.getHeaders().disambiguation || '');
									$('.outline_filename', article).val(outline_file.id + '.' + outline_file.doctype + '.opml');

									title_old[index] = $('.outline_title', article).val();
									disambig_old[index] = $('.outline_disambiguation', article).val();
								},
							},
							"open"		: "<?=$this->site['root']?>open",
							"save"		: "<?=$this->site['root']?>save",
							"id"		: outline_file.id,
							"doctype"	: outline_file.doctype,
						});
					if (!outline_file.id) {
						outliners[index].op.xmlToOutline (initialOpmltext);
						title_old[index] = $('.outline_title', article).val();
						disambig_old[index] = $('.outline_disambiguation', article).val();
					}
				});

				$('.save_btn').on('click', function(e) {
					e.preventDefault();
					var err = [];
					var i = 0;
					var article, article_index, active_outliner, title, disambig;
					article = $('.outliner').parents('article.is-active');
					article_index = article.attr("id").replace("outliner-", "");
					title = $('.outline_title', article);
					disambig = $('.outline_disambiguation', article);

					if ( article.length !== 1 ) {
						return;
						console.log('More than one active outliner is ridiculous!');
					}

					if (!opHasChanged() && title.val() == title_old[article_index] && disambig.val() == disambig_old[article_index]) {
						console.log('No changes!');
						return;
					} else {
						opMarkChanged();
					}

					err[0]= ( title.val().match(/[\\\/*?:"<>|]/) || title.val() === "") ? true : false;
					err[1] = ( disambig.val().match(/[\\\/*?:"<>|]/) && disambig.val() !== "" ) ? true : false;
					if (err[0]) {
						title.css('border-color', 'red');
					}
					if (err[1]) {
						disambig.css('border-color', 'red');
					}
					if (err[0] || err[1]) {
						console.log('Inputs error: ' + err);
						return;
					}

					active_outliner = $('.outliner', article).concord();
					if ( active_outliner.op.setTitle( title.val() ) ) {
						console.log("title set!");
					}
					var outliner_file_id = title.val();
					outliner_file_id += disambig.val() ? '_(' + disambig.val() + ')' : '';
					if ( active_outliner.op.setId(outliner_file_id) ) {
						console.log("id set!");
					}
					active_outliner.op.addHeaders({
						"disambiguation" : disambig.val()
					});

					active_outliner.save(function(json) {
						console.log(json);
					});
				});

				$('.editor-toolbar a').on('click', function(e){
					e.preventDefault();
					var action = $(this).attr('href');
					action = action.substring(1);
					var subaction = action.match(/\[.*\]/);
					if (subaction) {
						subaction = subaction.toString();
						action = action.replace(subaction, '');
						subaction = subaction.substring(1, subaction.length-1);
					}
					switch( action ) {
						case "header":
							if ($(defaultUtilsOutliner).concord().op.attributes.getOne("type") == "header") {
								$(defaultUtilsOutliner).concord().op.attributes.removeOne("type");
							} else {
								$(defaultUtilsOutliner).concord().op.attributes.setGroup({"type": "header"});
							}
							break;
						case "list":
							if ( subaction === null ) {
								// Do nothing because something clicked that opens a submenu containing list types
							} else if ( subaction === "" ) {
								$(defaultUtilsOutliner).concord().op.attributes.removeOne("list");
							} else {
								$(defaultUtilsOutliner).concord().op.attributes.setGroup({"list": subaction});
							}
							break;
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
			});

		})(jQuery);
	</script>
</body>
</html>
