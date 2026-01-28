<?php
$name = 'Global Concerns India';

variables([
	'site-home-in-menu' => true,
	'home-link-to-section' => true,
	'sections-have-files' => true,
	//TODO: 'autofix-encoding' => true,

	'footer-introduction' => 'GCI is a community-based organization dedicated to empowering vulnerable communities, especially urban and rural poor and other marginalized groups, across Bengaluru, Kolar, and Chikkaballapur.',
	'footer-variation' => 'no-widget',
	'custom-footer' => true,
	'no-network-in-footer' => true,

	'skip-directory' => $skipDirNSeo = true || !variable('local'), //TODO: HIGH: SDP: SEO
	'no-seo-info' => $skipDirNSeo,

	'google-analytics' => 'G-8HS3SCXZL2',

	'email' => 'team@globalconcernsindia.org',
	'email2' => 'brinda@globalconcernsindia.org',
	'phone' => $phone = '+91.9886300982', //$callee = 'Sadhna',
	'phone2' => $phone2 = '+91.9845518138', //$callee = 'Brinda',
	'phone3' => $phone3 = '+91.9845133354', //$callee = 'Narayan',
	'whatsapp' => whatsapp_me($phone, '', true), //'whatsapp-info' => ' (' . $callee . ')',

	'address' => '<a>Registered office</a>: 17 Rhenius Street, 5A Sukhi Apartments, Richmond Town, Bengaluru-560 025',
	'address-url' => 'https://g.co/kgs/jRVUHEg',
	'address2' => '<a>Community Office</a>: No.25 & 26, 2nd Cross, LRNagar, opp. NGV, Koramangala, Bengaluru 560 047',
	'address2-url' => 'https://maps.app.goo.gl/XRg1XgStds1Rx3sX7', //TODO: set this in google maps

	'upi' => [ 'site' => [ 'id' => 'gcindia1@sbi', 'name' => str_replace(' ', '+', $name) ] ],
	socialBuilder::variableName => socialBuilder::create()
		->addInstagram('globalconcernsindia', 'Instagram')
		->addExternal('facebook', 'https://www.facebook.com/GlobalConcernsIndia', 'Facebook')
		->addExternal('centre-icon png-icon', 'https://www.facebook.com/GCI.CreativityCentre/', 'Creativity Centre on FB')
		->addLinkedIn('company/global-concerns-india/', 'LinkedIn')
		->addLinkedIn('in/brinda-adige/', 'Brinda on LI', 'brinda-adige-icon png-icon')
		->addYoutube('@GlobalConcernsIndia', 'YouTube')
		->getItems(),
		//TODO: Newsletter / groups.io

	'blur-banners-at' => ['index', 'schooling'],

	'htmlReplaces' => [
		'home-message' => 'Inside <b>each of us</b> are powers so strong, treasures so rich, possibilities so endless, that to command them <b>all to action</b>, would <b>change the lives of people</b><br />less privileged.',
		'home-message-finale' => 'We invite you to <b>celebrate life</b> with us &mdash;<br />life in <b>all its fullness</b>.',
		'donate-callout' => 'Global Concerns India invites you to join us in promoting holistic development of children and women. Your support will ensure education, nutrition, health, social protection, skill & entrepreneurial training. Thank you for sharing our vision to positively impact the lives of people less privileged and strengthening our mission to reduce illiteracy, poverty & violence in families living in vulnerable geographies.',
	],
]);

addStyle('styles', SITEASSETS);

if (getQueryParameter('name')) add_body_class('also-content'); //makes people popup have uniform bgd

function enrichThemeVars($vars, $what) {
	if ($what == 'header' && nodeIs(SITEHOME))
		$vars['optional-slider'] = getSnippet('parallax-slider');

	return $vars;
}

function before_file() {
	if (nodeIs(SITEHOME)) return;
	page_banner();
}

function page_banner() {
	$at = variable('node'); //nodeIs(SITEHOME) ? 'safeName' : 
	$pageImage = SITEPATH . '/' . ($img = 'assets/pages/' . $at) . '-portrait.jpg';
	if (!disk_file_exists($pageImage)) return;

	$blur = in_array($at, variableOr('blur-banners-at', [])) ? ' style="filter: blur(5px);"' : '';

	echo replaceItems('<div class="banner banner-%where%">
		<img class="img-fluid show-in-portrait"%style% src="%url%%image%-portrait.jpg" />
		<img class="img-fluid show-in-landscape"%style% src="%url%%image%-landscape.jpg" />
	</div>' . BRNL,
		['where' => $at, 'url' => variable('assets-url'), 'image' => $img, 'style' => $blur], '%');
}

function after_file_todo() {
	if (!in_array(variable('node'), ['index'])) return;
	renderSingleLineMarkdown('%appeal-snippet%');
}

function before_footer_assets() {
	//TODO:
	//echo getThemeSnippet('floating-button');
}
