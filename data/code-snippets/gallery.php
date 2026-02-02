<?php
$url = getHtmlVariable('cdn') . $relUrl = concatSlugs([sectionValue(), nodeValue(), date('Y')]) . '/';
$images = _skipNodeFiles(scandir(SITECDNPATH . $relUrl), SKIPFOLDERS);

$op = [htmlUX::valueOf(htmlUX::artAll)];
$start = htmlUX::valueOf(htmlUX::art4);
$end = htmlUX::valueOf(htmlUX::artClose);

foreach ($images as $ix => $item) {
	if (endsWith($item, 'poster')) continue;
	$line = replaceItems('<img class="img-fluid img-max-300 m-2" src="%src%" alt="Gallery Image %alt%" />', ['src' => $url . $item . '.jpg', 'alt' => $ix + 1], WRAPREPLACE);
	$op[] = $start . $line . $end;
}
$op[] = htmlUX::valueOf(htmlUX::artAllClose);

return htmlUX::replaceAll(implode(BRNL, $op));
