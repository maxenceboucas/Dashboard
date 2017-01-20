<?php
namespace DashboardBundle\Controller\Admin;
use JavierEguiluz\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;


class ContactController extends BaseAdminController
{
  protected function createSearchQueryBuilder($entityClass, $searchQuery, array $searchableFields, $sortField = null, $sortDirection = null, $dqlFilter = null)
    {
        /* @var EntityManager */
        $em = $this->getDoctrine()->getManagerForClass($this->entity['class']);

        $words = explode(",",$searchQuery);

        /* @var DoctrineQueryBuilder */
        $queryBuilder = $em->createQueryBuilder()
            ->select('entity')
            ->from($this->entity['class'], 'entity')
            ->join('entity.tags', 'tags');

        foreach ($words as $key=>$word) {
          $queryBuilder
          ->orWhere('LOWER(tags.name) LIKE :query'.strval($key))
          ->orWhere('LOWER(entity.name) LIKE :query'.strval($key))
          ->orWhere('LOWER(entity.firstname) LIKE :query'.strval($key))
          ->setParameter('query'.strval($key), '%'.strtolower($word).'%');
        }



        if (!empty($dqlFilter)) {
            $queryBuilder->andWhere($dqlFilter);
        }
        if (null !== $sortField) {
            $queryBuilder->orderBy('entity.'.$sortField, $sortDirection ?: 'DESC');
        }
        return $queryBuilder;
    }
    
}
