<?php
/**
 * Created by PhpStorm.
 * User: kostya
 * Date: 28/10/18
 * Time: 1:25 AM
 */
namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ArticleAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('title', TextType::class)
            ->add('content')
            ->add('category') //, CategoryType::class);
            ->add('author')
            ->add('createdAt');
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('title')
            ->add('category')
            ->add('content')
            ->add('author')
            ->add('createdAt');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('id')
            ->add('title')
            ->add('category')
            ->add('content', null, ['editable' => true])
            ->add('author')
            ->add('createdAt')
            ->add('_action', null, array('actions' => array('show' => [], 'delete' => [])));
    }
}