<?php

namespace Ten24\MarcatoIntegrationBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Ten24\MarcatoIntegrationBundle\Entity\Venue;

/**
 * Class PerformanceRepository
 *
 * @package Ten24\MarcatoIntegrationBundle\Repository
 */
class ShowRepository extends EntityRepository
{
    /**
     * Find all shows at a particular venue, ordered by show.date ASC, performance.ordering ASC
     *
     * @param Venue $venue
     * @param int   $hydrationMode
     *
     * @return array
     */
    public function findAllForVenue(Venue $venue,
                                    $orderBy = 'show.date ASC, performances.ordering ASC',
                                    $hydrationMode = Query::HYDRATE_ARRAY)
    {
        $qb = $this->getFullJoinQueryBuilder();

        $qb->add('where', $qb->expr()->eq('show.venue', ':venue'))
           ->add('orderBy', $orderBy)
           ->setParameter('venue', $venue);

        return $qb->getQuery()->getResult($hydrationMode);
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

        return $qb->select('show', 'performances', 'artists')
                  ->leftJoin('show.performances', 'performances')
                  ->leftJoin('performances.artists', 'artists');
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
        $indexBy = (null !== $indexBy) ? 'show.' . $indexBy : null;

        return $qb->select('show')
                  ->from('Ten24MarcatoIntegrationBundle:Show', 'show', $indexBy);
    }
}
