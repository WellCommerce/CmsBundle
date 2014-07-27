<?php
/*
 * WellCommerce Open-Source E-Commerce Platform
 *
 * This file is part of the WellCommerce package.
 *
 * (c) Adam Piotrowski <adam@wellcommerce.org>
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

namespace WellCommerce\Core\Form\Elements;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class Image
 *
 * @package WellCommerce\Core\Form\Elements
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Image extends File implements ElementInterface
{
    /**
     * {@inheritdoc}
     */
    public function configureAttributes(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired([
            'name',
            'label'
        ]);

        $resolver->setOptional([
            'comment',
            'comment',
            'repeat_min',
            'repeat_max',
            'limit',
            'error',
            'rules',
            'filters',
            'dependencies',
            'main_id',
            'visibility_change',
            'upload_url',
            'session_name',
            'session_id',
            'file_types',
            'file_types_description',
            'delete_handler',
            'load_handler',
        ]);

        $resolver->setDefaults([
            'repeat_min'             => 0,
            'repeat_max'             => ElementInterface::INFINITE,
            'limit'                  => 1000,
            'session_name'           => session_name(),
            'session_id'             => session_id(),
            'file_types_description' => 'file_types_description',
            'file_types'             => ['jpg', 'jpeg', 'png', 'gif']
        ]);

        $resolver->setAllowedTypes([
            'file_types_description' => 'string',
            'file_types'             => 'array'
        ]);
    }
}