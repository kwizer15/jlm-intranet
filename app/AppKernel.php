<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles(): iterable
    {
        $bundles = [
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new FOS\UserBundle\FOSUserBundle(),
            new Genemu\Bundle\FormBundle\GenemuFormBundle(),
            new Liuggio\ExcelBundle\LiuggioExcelBundle(),
            new JLM\UserBundle\JLMUserBundle(),
            new JLM\ModelBundle\JLMModelBundle(),
            new JLM\OfficeBundle\JLMOfficeBundle(),
            new JLM\DailyBundle\JLMDailyBundle(),
            new JLM\DefaultBundle\JLMDefaultBundle(),
            new JLM\StateBundle\JLMStateBundle(),
            new JLM\TransmitterBundle\JLMTransmitterBundle(),
            new JLM\FeeBundle\JLMFeeBundle(),
            new JLM\ContactBundle\JLMContactBundle(),
            new JLM\CondominiumBundle\JLMCondominiumBundle(),
            new JLM\InstallationBundle\JLMInstallationBundle(),
            new JLM\ProductBundle\JLMProductBundle(),
            new JLM\ContractBundle\JLMContractBundle(),
            new JLM\CommerceBundle\JLMCommerceBundle(),
            new JLM\AskBundle\JLMAskBundle(),
            new JLM\CoreBundle\JLMCoreBundle(),
            new JLM\FollowBundle\JLMFollowBundle(),
        ];

        if (\in_array($this->getEnvironment(), ['dev', 'test'], true)) {
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader): void
    {
        $loader->load(__DIR__.'/config/config_'.$this->getEnvironment().'.yml');
    }
}
