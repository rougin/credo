<?php

// Specify the paths in this variable ---
$paths = array(__DIR__ . '/src');

$paths[] = __DIR__ . '/tests';
// --------------------------------------

$rules = array('@PSR12' => true);

// Braces ---------------------------------------------------
$nextLine = 'next_line_unless_newline_at_signature_end';
$braces = array('functions_opening_brace' => $nextLine);
$braces['allow_single_line_anonymous_functions'] = false;
$braces['allow_single_line_empty_anonymous_classes'] = false;
$braces['anonymous_classes_opening_brace'] = $nextLine;
$braces['anonymous_functions_opening_brace'] = $nextLine;
$braces['classes_opening_brace'] = $nextLine;
$braces['control_structures_opening_brace'] = $nextLine;
$rules['braces_position'] = $braces;
// ----------------------------------------------------------

// Modifier keywords ------------------------------
$visible = array('elements' => array());
$visible['elements'] = array('method', 'property');
$rules['modifier_keywords'] = $visible;
// ------------------------------------------------

// PHPDoc multiline alignment -------------------------------------------------
$align = array('align' => 'vertical');
$align['tags'] = array('method', 'param', 'property', 'throws', 'type', 'var');
$rules['phpdoc_align'] = $align;
// ----------------------------------------------------------------------------

// PHPDoc ordering -----------------------
$order = array('case_sensitive' => true);
$order['null_adjustment'] = 'always_last';
$rules['phpdoc_types_order'] = $order;
// ---------------------------------------

// PHPDoc tag separation -----------------------------------------------------
$groups = array(array('template', 'extends'));
$groups[] = array('deprecated', 'link', 'see', 'since', 'codeCoverageIgnore');
$groups[] = array('property', 'property-read', 'property-write');
$groups[] = array('method');
$groups[] = array('author', 'copyright', 'license');
$groups[] = array('category', 'package', 'subpackage');
$groups[] = array('param');
$groups[] = array('return', 'throws');
$groups[] = array('todo');
$rules['phpdoc_separation'] = compact('groups');
// ---------------------------------------------------------------------------

// Single quotes -------------------------------
$text = 'strings_containing_single_quote_chars';
$rules['single_quote'] = array($text => true);
// ---------------------------------------------

// Control Structure Continuation Position -------
$cscp = 'control_structure_continuation_position';
$rules[$cscp] = array('position' => 'next_line');
// -----------------------------------------------

// Other customized rules ---------------------------
$rules['align_multiline_comment'] = true;

$concat = array('spacing' => 'one');
$rules['concat_space'] = $concat;

$config = array('named_class' => false);
$rules['new_with_parentheses'] = $config;

$rules['no_empty_phpdoc'] = true;

$rules['no_unused_imports'] = true;

$rules['phpdoc_var_annotation_correct_order'] = true;

$rules['trim_array_spaces'] = true;

$rules['statement_indentation'] = false;
// --------------------------------------------------

$finder = new \PhpCsFixer\Finder;

$finder->in($paths);

$config = new \PhpCsFixer\Config;

$config->setRules($rules);

return $config->setFinder($finder);
