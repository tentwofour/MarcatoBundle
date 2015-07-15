<?php

namespace Ten24\MarcatoIntegrationBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Query;

/**
 * Class PerformanceRepository
 *
 * @package Ten24\MarcatoIntegrationBundle\Repository
 */
class PerformanceRepository extends EntityRepository
{
    /**
     * @param string $orderBy
     * @param int    $hydrationMode
     *
     * @return array
     */
    public function findAllJoinAll($orderBy = 'show.date ASC, performance.startDate ASC, artists.name ASC',
                                   $hydrationMode = Query::HYDRATE_OBJECT)
    {
        $qb = $this->getFullJoinQueryBuilder();

        $qb->add('orderBy', $orderBy);

        return $qb->getQuery()->getResult($hydrationMode);
    }

    /**
     * @param null   $id
     * @param string $orderBy
     * @param int    $hydrationMode
     *
     * @return array
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\ORMException
     */
    public function findOneJoinAll($id = null, $orderBy = 'show.date ASC, performance.startDate ASC, artists.name ASC',
                                   $hydrationMode = Query::HYDRATE_OBJECT)
    {
        if (null === $id)
        {
            throw new ORMException('You must pass an identifier to find() by.');
        }

        $qb = $this->getFullJoinQueryBuilder();

        $qb->add('where', $qb->expr()->eq('performance.id', ':id'))
            ->add('orderBy', $orderBy)
            ->setParameter('id', $id);

        return $qb->getQuery()->getOneOrNullResult();
    }

    /**
     * Join everything, return the QueryBuilder object
     *
     * @param $indexBy
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getFullJoinQueryBuilder($indexBy = 'slug')
    {
        $qb = $this->getQueryBuilder($indexBy);

        return $qb->select('performance', 'show', 'artists')
                  ->leftJoin('performance.show', 'show')
                  ->leftJoin('performance.artists', 'artists');
    }

    /**
     * Join everything, return the Query
     *
     * @return Query
     */
    public function getFullJoinQuery()
    {
        return $this->getFullJoinQueryBuilder()->getQuery();
    }

    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    protected function getQueryBuilder($indexBy = 'slug')
    {
        $qb      = $this->getEntityManager()->createQueryBuilder();
        $indexBy = (null !== $indexBy) ? 'performance.' . $indexBy : null;

        return $qb->select('performance')
                  ->from('Ten24MarcatoIntegrationBundle:Performance', 'performance', $indexBy);
    }
}