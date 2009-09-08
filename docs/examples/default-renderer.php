<?php
/**
 * Usage example for HTML_QuickForm2 package: default renderer
 *
 * The example demonstrates how the default renderer can be used and abused.
 * It also provides a default stylesheet.
 *
 * $Id$
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
  <head>
    <style type="text/css">
      body { margin: 0; padding: 0; font: 80%/1.5 Arial,Helvetica,sans-serif; color: #111; background-color: #FFF; }
      div.qf-form { margin: 5px; padding: 5px; background-color: #FFF; }
      div.qf-form form fieldset { margin: 10px 0; padding: 10px; border: #DDD 1px solid; }
      div.qf-form form legend { font-weight: bold; color: #666; }
      div.qf-form form div.qf-element { padding: 0.25em 0; }
      div.qf-form form label,
      div.qf-form span.qf-label { margin-right: 10px; padding-right: 10px; width: 150px; display: block; float: left; text-align: right; position: relative; }
      div.qf-form form .qf-required:after { position: absolute; right: 0; font-size: 120%; font-style: normal; color: #C00; content: "*"; }
      div.qf-form form .qf-label-1 { margin-left:160px; padding-left:10px; color:#888; font-size: 85%; }
      div.qf-form div.qf-note { font-size: 92%; color: #555; }
      div.qf-form div.qf-note em { font-style: normal; color: #C00; }
      div.qf-form div.qf-note strong { color:#000; font-weight: bold; }
      div.qf-form div.qf-errors { background-color: #FEE; border: 1px solid #ECC; padding:5px; margin:0 0 20px 0 }
      div.qf-form div.qf-errors p,
      div.qf-form div.qf-errors ul { margin:0; }
      div.qf-form div.qf-error input { border-color: #C00; background-color: #FEF; }
      div.qf-form div.qf-checkable label, 
      div.qf-form div.qf-checkable input { display: inline; float: none; }
      div.qf-form div.qf-checkable div,
      div.qf-form div.qf-message { margin-left: 170px; }
      div.qf-form div.qf-message { font-size: 88%; color: #C00; }
    </style>
    <title>HTML_QuickForm2 default renderer example</title>
  </head>
  <body>
<?php

require_once 'HTML/QuickForm2.php';
require_once 'HTML/QuickForm2/Renderer.php';

$form = new HTML_QuickForm2('example');
$fs = $form->addFieldset()->setLabel('Your information');

$username = $fs->addText('username')->setLabel('Username');
$username->addRule('required', 'Username is required');

$password = $fs->addPassword('pass')
            ->setLabel(array('Password', 'Password should be 8 characters at minimum'));
$password->addRule('required', 'Password is required');

$form->addHidden('my_hidden1')->setValue('1');
$form->addHidden('my_hidden2')->setValue('2');
$form->addSubmit('submit', array('value' => 'Send', 'id' => 'submit'));

if ($form->validate()) {
    $form->toggleFrozen(true);
}


$renderer = HTML_QuickForm2_Renderer::getInstance('default')
    ->setOptions(array(
        'group_hiddens' => true,
        'group_errors'  => true,
        'required_note' => '<strong>Note:</strong> Required fields are marked with an asterisk (<em>*</em>).'
    ))
    ->setTemplateById('submit', '<div class="qf-element">{element} or <a href="/">Cancel</a></div>')
    ->setTemplateByClass(
        'HTML_QuickForm2_Element_InputPassword',
        '<div class="qf-element<qf:error> qf-error</qf:error>"><qf:error>{error}</qf:error>' .
        '<label for="{id}" class="qf-label<qf:required> qf-required</qf:required>">{label}</label>' .
        '{element}' .
        '<qf:label_2><div class="qf-label-1">{label_2}</div></qf:label_2></div>' 
    );

echo $form->render($renderer);
?>
