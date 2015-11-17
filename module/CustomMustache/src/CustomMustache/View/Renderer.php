<?php
namespace CustomMustache\View;

use Zend\View\Renderer\RendererInterface;
use Mustache\View\Renderer as OriginalRenderer;
use Zend\View\Model\ModelInterface;
use Mustache\Exception as Exception;
use Zend\View\Variables;

class Renderer extends OriginalRenderer implements RendererInterface
{
  
    /**
     * Processes a view script and returns the output.
     *
     * @param  string|ModelInterface   $nameOrModel The script/resource process, or a view model
     * @param  null|array|\ArrayAccess $values      Values to use during rendering
     * @return string The script output.
     */
    public function render($nameOrModel, $values = null)
    {
        if ($nameOrModel instanceof ModelInterface) {
            $model       = $nameOrModel;
            $nameOrModel = $model->getTemplate();

            if (empty($nameOrModel)) {
                throw new Exception\DomainException(sprintf(
                    '%s: received View Model argument, but template is empty',
                    __METHOD__
                ));
            }

            $values = $model->getVariables();
            unset($model);
        }

        if (!($file = $this->resolver->resolve($nameOrModel))) {
            throw new \Exception(sprintf('Unable to find template "%s".', $nameOrModel));
        }

        $mustache = $this->getEngine();
        if($values instanceof Variables && $values->offsetExists("content")){
            $return = $values->offsetGet("content");
        }else{
            $return = $mustache->render(
                file_get_contents($file),
                $values
            );
        }
        return $return;
    }
}