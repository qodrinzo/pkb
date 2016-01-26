<ul id="recent_knowledeges">
	<!--
	<?php print_r($recent_files); ?>
	-->
<?php
sort_by_date($recent_files);
$output = '';
foreach ($recent_files as $file) {
	$output .= "<li><a href=\"{$site['root']}know/" . substr($file['path'], 0, -5) . "\"><i class=\"fa fa-file-text-o\"></i> " . str_replace('_', ' ', $file['filename']);
	$output .= (is_draft($file)) ? ' <span class="label warning">draft</span></a></li>' : '</a></li>';
}
echo $output;
unset($output);
?>
</ul>
