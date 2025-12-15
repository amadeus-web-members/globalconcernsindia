<?php
DEFINE('DONATEPATH', SITEPATH . '/data/donate/');

if (isset($_GET['poster']))
	echo getSnippet('poster', DONATEPATH);

contentBox('poster', 'container');
echo getSnippet('callout', DONATEPATH);
contentBox('end');

$sheet = getSheet(DONATEPATH . 'amounts.tsv', false);
$items = [];
$broken = false;
$links = [];

foreach ($sheet->rows as $item) {
	if ($sheet->getValue($item, 'what', true) == '----') {
		$broken = true;
	} else if (!$broken) {
		$links[] = makeLink($sheet->getValue($item, 'what', true), $sheet->getValue($item, 'link', true), false);
	} else {
		$itemLinks = [];
		$amount = $sheet->getValue($item, 'amount', true);

		/*
		foreach ($links as $option)
			$itemLinks[] = str_replace('%amount%', $amount, $option);
		*/

		$for = $sheet->getValue($item, 'what', true);
		$for = $for[0] == '*' ? ' ' . substr($for, 1) : ' to ' . $for;
		if ($amount == '0') $amount = 'X';
		$items[] = 'Pay Rs ' . $amount . ' ' . implode(' / ', $itemLinks) . $for . '.';
	}
}

$amounts = '<ol>' . variable('nl') . '	<li>' . implode('</li>' . variable('nl') . '	<li>', $items) . '</li>' . variable('nl') . '</ol>';
$amounts = replaceItems($amounts, ['##upi-id' => subVariable('upi', 'site')['id']]);

$details = renderMarkdown(DONATEPATH . 'details.md', ['echo' => false]);
$content = renderMarkdown(DONATEPATH . 'content.md', ['echo' => false]);

sectionId('donate', 'container');
echo cbWrapAndReplaceHr(replaceItems($content, [
	'donation-form' => $details,
	'razorpay-links' => $amounts,
], '%'));

sectionEnd();
