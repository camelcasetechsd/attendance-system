<?php

class __Mustache_770da14c5929a6ae4550e752b249ede6 extends Mustache_Template
{
    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $buffer = '';
        $newContext = array();

        $buffer .= $indent . '
';
        $buffer .= $indent . '    <h1>An error occurred</h1>
';
        $buffer .= $indent . '    <p>';
        $value = $this->resolveValue($context->find('message'), $context, $indent);
        $buffer .= htmlspecialchars($value, 2, 'UTF-8');
        $buffer .= '</p>
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '    <h3>Exception information:</h3>
';
        $buffer .= $indent . '    <p><b>Message:</b> ';
        $value = $this->resolveValue($context->find('exceptionmessage'), $context, $indent);
        $buffer .= htmlspecialchars($value, 2, 'UTF-8');
        $buffer .= '</p>
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '    <h3>Stack trace:</h3>
';
        $buffer .= $indent . '    <pre>';
        $value = $this->resolveValue($context->find('stacktrace'), $context, $indent);
        $buffer .= htmlspecialchars($value, 2, 'UTF-8');
        $buffer .= '</pre>
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '    <h3>Request Parameters:</h3>
';
        $buffer .= $indent . '    <pre>';
        $value = $this->resolveValue($context->find('requestparams'), $context, $indent);
        $buffer .= htmlspecialchars($value, 2, 'UTF-8');
        $buffer .= '</pre>
';
        $buffer .= $indent . '
';

        return $buffer;
    }
}
