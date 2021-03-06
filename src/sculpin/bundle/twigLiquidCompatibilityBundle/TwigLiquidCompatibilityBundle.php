<?php

/*
 * This file is a part of Sculpin.
 * 
 * (c) Dragonfly Development Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace sculpin\bundle\twigLiquidCompatibilityBundle;

use sculpin\bundle\twigLiquidCompatibilityBundle\tokenParser\AssignTokenParser;

use sculpin\bundle\twigLiquidCompatibilityBundle\tokenParser\CaptureTokenParser;

use sculpin\bundle\twigBundle\TwigFormatter;

use sculpin\formatter\IFormatter;

use sculpin\bundle\twigBundle\TwigBundle;

use sculpin\Sculpin;

use sculpin\bundle\AbstractBundle;

class TwigLiquidCompatibilityBundle extends AbstractBundle
{

    /**
     * (non-PHPdoc)
     * @see sculpin\bundle.AbstractBundle::configureBundle()
     */
    public function configureBundle(Sculpin $sculpin)
    {
        $sculpin->registerFormatterConfigurationCallback(
            TwigBundle::FORMATTER_NAME,
            array($this, 'configureFormatter')
        );
    }
    public function configureFormatter(Sculpin $sculpin, IFormatter $formatter)
    {
        if ($formatter instanceof TwigFormatter) {
            $formatter->twig()->addTokenParser(new AssignTokenParser());
            $formatter->twig()->addTokenParser(new CaptureTokenParser());
        }
    }

}
