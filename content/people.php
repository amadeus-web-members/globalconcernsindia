<?php
$page = variable('node');
$sheet = getSheet($page, false);

$cols = $sheet->columns;
$started = false;
$lastGroup = false;

$urlBase = pageUrl('assets/' . $page);
$folBase = SITEPATH . '/assets/' . $page . '/';
$aboutBase = SITEPATH . '/content/' . $page . '/';

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
	echo '<a name="' . $safeName . '"></a>';
	echo '<h2>' . $name . '</h2>';
	//echo '<div>';

	if (disk_file_exists($folBase . $safeName . '.jpg'))
		echo replaceItems('<img class="bordered-image float-right img-max-300" src="%src%?fver=3" alt="%name" />', [
			'src' => $urlBase . $safeName . '.jpg',
			'name' => $name], '%') . variable('2nl');
	//else if (variable('local')) echo $safeName;

	if ($item[$cols['role']])
		echo '	<h4><i>' . $item[$cols['role']] . '</i></h4>' . variable('nl');

	$about = $aboutBase . $safeName . '.md';
	if (disk_file_exists($about))
		renderMarkdown($about);
	//else if (variable('local')) echo $about;

	if ($ix != count($sheet->rows) - 1) contentBox('end');
}

sectionEnd();
