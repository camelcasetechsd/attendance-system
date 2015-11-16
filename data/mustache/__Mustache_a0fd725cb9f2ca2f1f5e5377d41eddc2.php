<?php

class __Mustache_a0fd725cb9f2ca2f1f5e5377d41eddc2 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';
        $newContext = array();

        $buffer .= $indent . '<!-- article.mustache -->
';
        $buffer .= $indent . '
';
        
        $newContext['content'] = array($this, 'block8e0e2f769d178618c2d295f19b569a4c');
        
        if ($parent = $this->mustache->LoadPartial('layout')) {
            $context->pushBlockContext($newContext);
            $buffer .= $parent->renderInternal($context, $indent);
            $context->popBlockContext();
        }

        return $buffer;
    }


    public function block8e0e2f769d178618c2d295f19b569a4c($context)
    {
        $indent = $buffer = '';
        $buffer .= $indent . '<p>smart antenna</p>
';
    
        return $buffer;
    }
}
