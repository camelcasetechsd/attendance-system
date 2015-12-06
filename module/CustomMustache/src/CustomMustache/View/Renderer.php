<?php
namespace CustomMustache\View;

use Zend\View\Renderer\RendererInterface;
use Mustache\View\Renderer as OriginalRenderer;
use Zend\View\Model\ModelInterface;
use Mustache\Exception as Exception;
use Zend\View\Variables;

/**
 * Renderer Service
 * 
 * Render Mustache template
 * 
 * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
 */
class Renderer extends OriginalRenderer implements RendererInterface
{
  
    /**
     * Processes a view script and returns the output.
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public     * 
     * @param mixed $nameOrModel string|ModelInterface The script/resource process, or a view model
     * @param mixed $values null|array|\ArrayAccess Values to use during rendering
     * @return string The script output
     * @throws Exception\DomainException
     * @throws \Exception
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
            if($values instanceof Variables && !$values->offsetExists("production")){
                $isProduction = (APPLICATION_ENV == "production" )? true : false;
                $values->offsetSet (/*$index =*/ "isProduction", /*$newval =*/ $isProduction);
            }
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