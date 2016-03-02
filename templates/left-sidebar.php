<ul id="recent_knowledeges">
<?php
sort_by_date($this->recent_files);
$output = '';
foreach ($this->recent_files as $file) {
	if ($file['doctype'] == 'know') {
		$output .= "<li><a href=\"{$this->site['root']}know/" . $file['docname'] . "\"><i class=\"fa fa-file-text-o\"></i> " . str_replace('_', ' ', $file['docname']) . '</a></li>';
	}
}
echo $output;
unset($output);
?>
</ul>
