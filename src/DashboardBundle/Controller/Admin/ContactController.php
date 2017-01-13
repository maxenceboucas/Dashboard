<?php
namespace DashboardBundle\Controller\Admin;
use JavierEguiluz\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;


class ContactController extends BaseAdminController
{
  protected function createSearchQueryBuilder($entityClass, $searchQuery, array $searchableFields, $sortField = null, $sortDirection = null, $dqlFilter = null)
    {
        /* @var EntityManager */
        $em = $this->getDoctrine()->getManagerForClass($this->entity['class']);
        /* @var DoctrineQueryBuilder */
        $queryBuilder = $em->createQueryBuilder()
            ->select('entity')
            ->from($this->entity['class'], 'entity')
            ->join('entity.tags', 'tags')
            ->orWhere('LOWER(tags.name) LIKE :query')
            ->setParameter('query', '%'.strtolower($searchQuery).'%')
        ;
        if (!empty($dqlFilter)) {
            $queryBuilder->andWhere($dqlFilter);
        }
        if (null !== $sortField) {
            $queryBuilder->orderBy('entity.'.$sortField, $sortDirection ?: 'DESC');
        }
        return $queryBuilder;
    }
}
