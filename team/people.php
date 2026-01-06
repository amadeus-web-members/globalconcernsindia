<?php
$page = variable('node');
$sheet = getSheet(SITEPATH . '/team/data/' . $page . '.tsv', false);

$cols = $sheet->columns;
$started = false;
$lastGroup = false;

$urlBase = pageUrl('team/assets/' . $page);
$folBase = SITEPATH . '/team/assets/' . $page . '/';
$aboutBase = SITEPATH . '/team/data/' . $page . '/';

sectionId('invitations', 'container');

foreach ($sheet->rows as $ix => $item) {
	$name = $item[$cols['name']];
	if (!$name) continue;

	$group = $item[$cols['group']];
	if ($lastGroup != $group) {
		$safeGroup = urlize($group);
		sectionId($safeGroup);
		echo '<a name="' . $safeGroup . '"></a>';
		echo '<h1 style="text-align: center;">' . $group . '</h1>';
		sectionEnd();
	}
	$lastGroup = $group;

	contentBox($name);
	echo SPACERSTART . humanize($name) . SPACEREND . cbCloseAndOpen();

	sectionId($safeName = urlize($name));
	echo '<a name="' . $safeName . '"></a>' . NEWLINE;
	echo '<h2>' . $name . '</h2>' . NEWLINE;
	//echo '<div>';

	if (disk_file_exists($folBase . $safeName . '.jpg'))
		echo replaceItems('<img class="float-right img-max-300 rounded-circle p-2 ms-2" src="%src%" style="border: 1px solid #666;" alt="%name" />', [
			'src' => $urlBase . $safeName . '.jpg',
			'name' => $name], '%') . NEWLINE;
	//else if (variable('local')) echo $safeName;

	if ($item[$cols['role']])
		echo '	<h4><i>' . $item[$cols['role']] . '</i></h4>' . NEWLINES2;

	$about = $aboutBase . $safeName . '.md';
	if (disk_file_exists($about))
		renderMarkdown($about);
	//else if (variable('local')) echo $about;

	echo '<div class="clearfix"></div>' . NEWLINES2;
	if ($ix != count($sheet->rows) - 1) contentBox('end');
}

sectionEnd();
