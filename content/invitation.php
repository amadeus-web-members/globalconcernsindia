<?php
//from: https://docs.google.com/document/d/1W_beNbvl3y1aLc0g_DGyQztkeT-NbcLWvfyhVdlaeuw/edit?usp=drive_link - 24/25th Jan
$sections = [
	'introduction',
	'schooling',
	'assisted-learning-program',
	'the-impact-of-resilience',
	'empowerment-of-women',
	'in-closing',
];

$fol = SITEPATH . '/content/' . variable('node') . '/';

sectionId('invitations', 'container');

foreach ($sections as $ix => $name) {
	//echo processSpacerShortcode('[spacer]' . humanize($name) . '[/spacer]');
	contentBox($name, 'container');
	echo SPACERSTART . humanize($name) . SPACEREND . cbCloseAndOpen();

	echo replaceItems('<img class="float-right img-max-200"'
		. ' src="%url%content/invitation/%name%.jpg" alt="%alt%" />' . variable('nl'),
			['url' => pageUrl(), 'name' => $name, 'alt' => humanize($name)], '%');

	renderAny($fol . $name . '.md');
	if ($ix != count($sections) - 1) contentBox('end');
}

sectionEnd();
