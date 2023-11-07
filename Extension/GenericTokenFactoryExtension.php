<?php

namespace Payum\Core\Extension;

use Payum\Core\Security\GenericTokenFactoryAwareInterface;
use Payum\Core\Security\GenericTokenFactoryInterface;

class GenericTokenFactoryExtension implements ExtensionInterface
{
    /**
     * @var GenericTokenFactoryInterface
     */
    protected $genericTokenFactory;

    public function __construct(GenericTokenFactoryInterface $genericTokenFactory)
    {
        $this->genericTokenFactory = $genericTokenFactory;
    }

    public function onPreExecute(Context $context): void
    {
    }

    public function onExecute(Context $context): void
    {
        $action = $context->getAction();
        if ($action instanceof GenericTokenFactoryAwareInterface) {
            $action->setGenericTokenFactory($this->genericTokenFactory);
        }
    }

    public function onPostExecute(Context $context): void
    {
        $action = $context->getAction();
        if ($action instanceof GenericTokenFactoryAwareInterface) {
            $action->setGenericTokenFactory(null);
        }
    }
}
