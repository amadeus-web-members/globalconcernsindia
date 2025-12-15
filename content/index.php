<?php
contentBox('introduction', 'container mt-3');
printH1InDivider('Welcome to ' . variable('name'));
renderAny(__DIR__ . '/_introduction.md');
contentBox('end');

variables([
	'in-node' => true,
	'directory_of' => 'programs',
	'directory_use_excerpts' => true,
]);

runFeature('directory');
