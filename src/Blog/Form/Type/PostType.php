<?php
/*
 * This file is part of the Manuel Aguirre Project.
 *
 * (c) Manuel Aguirre <programador.manuel@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Blog\Form\Type;

use Blog\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\Exception;
use Symfony\Component\Form\Extension\Core\DataMapper\PropertyPathMapper;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Manuel Aguirre <programador.manuel@gmail.com>
 */
class PostType extends AbstractType implements DataMapperInterface
{
    /** @var PropertyPathMapper */
    private $dataMapper;

    /**
     * PostType constructor.
     * @param PropertyPathMapper $dataMapper
     */
    public function __construct(PropertyPathMapper $dataMapper)
    {
        $this->dataMapper = $dataMapper;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title');
        $builder->add('content');

        $builder->setDataMapper($this);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
            'empty_data' => function (Options $options) {
                return function (FormInterface $form) use ($options) {
                    return new Post(
                        (string)$form['title']->getData(),
                        (string)$form['content']->getData(),
                        $options['author']
                    );
                };
            },
        ]);

        $resolver->setRequired('author');
//        $resolver->setAllowedTypes('author', Author::class);
    }

    /**
     * Maps properties of some data to a list of forms.
     *
     * @param mixed $data Structured data
     * @param FormInterface[] $forms A list of {@link FormInterface} instances
     *
     * @throws Exception\UnexpectedTypeException if the type of the data parameter is not supported.
     */
    public function mapDataToForms($data, $forms)
    {
        $this->dataMapper->mapDataToForms($data, $forms);
    }

    /**
     * @param \Symfony\Component\Form\FormInterface[] $forms
     * @param Post $data
     */
    public function mapFormsToData($forms, &$data)
    {
        $forms = iterator_to_array($forms);
        $data->setContent((string)$forms['content']->getData());
    }
}