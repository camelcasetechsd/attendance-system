<?php

class __Mustache_c67f80ed85c01ccd1e5c6e700c443e7d extends Mustache_Template
{
    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $buffer = '';
        $newContext = array();

        $buffer .= $indent . '<!-- layout.mustache -->
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '<!DOCTYPE html>
';
        $buffer .= $indent . '<html>
';
        $buffer .= $indent . '  <head>
';
        $buffer .= $indent . '    <title>';
        $blockFunction = $context->findInBlock('title');
        if (is_callable($blockFunction)) {
            $buffer .= call_user_func($blockFunction, $context);
        } else {
            $buffer .= 'My Awesome Site';
        }
        $buffer .= '</title>
';
        $blockFunction = $context->findInBlock('stylesheets');
        if (is_callable($blockFunction)) {
            $buffer .= call_user_func($blockFunction, $context);
        } else {
            $buffer .= $indent . '      <link rel="stylesheet" href="/assets/css/default.css">
';
        }
        $buffer .= $indent . '  </head>
';
        $buffer .= $indent . '  <body>
';
        $buffer .= $indent . '    <header>
';
        $blockFunction = $context->findInBlock('header');
        if (is_callable($blockFunction)) {
            $buffer .= call_user_func($blockFunction, $context);
        } else {
            $buffer .= $indent . '        <h1>Welcome to My Awesome Site</h1>
';
        }
        $buffer .= $indent . '    </header>
';
        $buffer .= $indent . '    <div id="content">
';
        $blockFunction = $context->findInBlock('content');
        if (is_callable($blockFunction)) {
            $buffer .= call_user_func($blockFunction, $context);
        } else {
            $buffer .= $indent . '        <p>Hello, World!</p>
';
        }
        $buffer .= $indent . '    </div>
';
        $blockFunction = $context->findInBlock('scripts');
        if (is_callable($blockFunction)) {
            $buffer .= call_user_func($blockFunction, $context);
        } else {
            $buffer .= $indent . '      <script src="/assets/js/default.js"></script>
';
        }
        $buffer .= $indent . '  </body>
';
        $buffer .= $indent . '</html>';
echo "tracingggggggggg";
$trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
var_dump($trace[0],$trace[1]);
        return $buffer;
    }
}
