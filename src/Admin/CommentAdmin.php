<?php
/**
 * Created by PhpStorm.
 * User: kostya
 * Date: 5/11/18
 * Time: 7:22 AM
 */

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class CommentAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('content');
//            ->add('article')
//            ->add('author')
//            ->add('createdAt');
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('article')
            ->add('content')
            ->add('author')
            ->add('createdAt');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('id')
            ->add('article')
            ->add('content', null, ['editable' => true])
            ->add('author')
            ->add('createdAt')
            ->add('_action', null, array('actions' => array('show' => [], 'delete' => [])));
    }
}