<?php
$page = variable('node');
$sheet = getSheet(SITEPATH . '/team/data/' . $page . '.tsv', false);

$cols = $sheet->columns;
$started = false;
$lastGroup = false;

$urlBase = pageUrl('team/assets/' . $page);
$folBase = SITEPATH . '/team/assets/' . $page . '/';
$aboutBase = SITEPATH . '/team/data/' . $page . '/';

sectionId($page, 'container');

$onlyIcons = false;

function linkOrText($text, $href, $setting) {
	return $setting ? linkBuilder::factory($text, $href, $setting) : $text;
}

foreach ($sheet->rows as $ix => $item) {
	$name = $item[$cols['name']];
	$wantedName = getQueryParameter('name');
	if (!$name) continue;

	$safeName = urlize($name);
	if ($wantedName && $safeName != $wantedName) continue;

	$group = $item[$cols['group']];
	if ($lastGroup != $group) {
		$safeGroup = urlize($group);
		if (!$wantedName) {
			sectionId($safeGroup);
			echo '<a name="' . $safeGroup . '"></a>';
			echo '<h1 style="text-align: center;">' . $group . '</h1>';
			sectionEnd();
		}
		if ($group == 'Advisory Board') {
			$onlyIcons = true;
			echo replaceHtmlShortcuts('ALLARTICLES') . NEWLINES2;
		}
	}
	$lastGroup = $group;
	$wrapInArticle = !$wantedName && $onlyIcons; //NOTE: behaviour - once wrapping starts, it doesnt end!

	$about = $aboutBase . $safeName . '.md';
	$aboutExists = disk_file_exists($about);
	$inlineSetting = $wrapInArticle && $aboutExists ? 'lightbox noPageUrl' : false;
	$inlineUrl = $wrapInArticle ? pageUrl($page . '/?name=' . $safeName) : false;

	if ($wrapInArticle) {
		echo replaceHtmlShortcuts('ARTICLE-BOX') . NEWLINE;
	} else {
		contentBox($name, $wantedName ? 'h-100' : '');
		echo SPACERSTART . humanize($name) . SPACEREND . cbCloseAndOpen();
		sectionId($safeName);
	}

	echo '<a name="' . $safeName . '"></a>' . NEWLINE;
	echo '<h2>' . linkOrText($name, $inlineUrl, $inlineSetting) . '</h2>' . NEWLINE;
	//echo '<div>';

	if (disk_file_exists($folBase . $safeName . '.jpg')) {
		$img = replaceItems('<img class="float-right img-fluid img-max-300 rounded-circle p-2 ms-2" src="%src%" style="border: 1px solid #666;" alt="%name" />', [
			'src' => $urlBase . $safeName . '.jpg',
			'name' => $name
		], '%');
		echo linkOrText($img, $inlineUrl, $inlineSetting) . NEWLINE;
	}
	//else if (variable('local')) echo $safeName;

	if ($item[$cols['role']])
		echo '	<h4><i>' . $item[$cols['role']] . '</i></h4>' . NEWLINES2;

	if (!$wrapInArticle && $aboutExists)
		renderMarkdown($about);
	//else if (variable('local')) echo $about;

	echo '<div class="clearfix"></div>' . NEWLINES2;

	if ($wrapInArticle)
		echo replaceHtmlShortcuts('ARTICLE-CLOSE') . NEWLINE;


	if ($ix == count($sheet->rows) - 1) {
		if ($onlyIcons) echo replaceHtmlShortcuts('ALLARTICLES-CLOSE') . NEWLINES2;
	} else if (!$wrapInArticle) {
		contentBox('end');
	}
}

sectionEnd();
