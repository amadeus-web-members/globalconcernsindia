<?php
sectionId('welcome', 'mt-1');
//printH1InDivider('Welcome to ' . variable('name'));
//echo getSnippet('home'); echo cbCloseAndOpen('container');
echo runAllMacros('[canva]DAG7u7XLlJ8/cubP6Y-_divGkNgkXnm6jQ[/canva]');
sectionEnd();

echo getSnippet('parallax-home');

page_banner();

contentBox('introduction', 'container mt-3');
renderMarkdown(__DIR__ . '/_introduction.md');
contentBox('end');

//TODO: HI: add these to varnames
variables([
	'in-node' => true,
	'skip-directory' => false, //being set in cms.php
	'directory_of' => 'programs',
	'directory_use_excerpts' => true,
]);

features::ensureDirectory();
