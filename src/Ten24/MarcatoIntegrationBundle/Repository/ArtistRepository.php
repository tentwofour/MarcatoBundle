<?php

namespace Ten24\MarcatoIntegrationBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

/**
 * Class ArtistRepository
 * @package Ten24\MarcatoIntegrationBundle\Repository
 */
class ArtistRepository extends EntityRepository
{
    /**
     * @param array $orderBy
     * @param int $hydrationMode
     * @return array
     */
    public function findAllJoinAll($indexBy = null,
                                   array $orderBy = array('artist.name', 'ASC'),
                                   $hydrationMode = Query::HYDRATE_ARRAY)
    {
        return $this->getFullJoinQueryBuilder($indexBy)
                    ->orderBy($orderBy[0], $orderBy[1])
                    ->getQuery()
                    ->getResult($hydrationMode);
    }

    /**
     * @param null $slug
     * @param int $hydrationMode
     * @return array
     */
    public function findOneBySlugJoinAll($slug = null, $hydrationMode = Query::HYDRATE_ARRAY)
    {
        return $this->getFullJoinQueryBuilder()
                    ->where('artist.slug = :slug')
                    ->setParameter('slug', $slug)
                    ->getQuery()
                    ->getSingleResult($hydrationMode);
    }

    /**
     * @param int $hydrationMode
     * @return array
     */
    public function findAllOrderByNameAsc($indexBy = 'slug', $hydrationMode = Query::HYDRATE_ARRAY)
    {
        return $this->getFindAllOrderByNameAscQuery($indexBy)
                    ->getResult($hydrationMode);
    }


    public function getFindAllOrderByNameAscQuery($indexBy = 'slug')
    {
        return $this->getQueryBuilder($indexBy)
                    ->orderBy('artist.name', 'ASC')
                    ->getQuery();
    }

    /**
     * Retreive past artists
     * Searches artist tags for values like 'performed_YYYY'
     * @param array $years An array of years to find
     * @param int $hydrationMode
     * @return array An array of artists whose tag names match 'performed_YYYY'
     */
    public function findArchivedArtists(array $years = array(),
                                        $tagPrefix = 'performed_',
                                        $hydrationMode = Query::HYDRATE_ARRAY)
    {
        $tagNames = array_walk($years,
            function (&$item) use ($tagPrefix)
            {
                $item = $tagPrefix . $item;
            });

        $qb = $this->getFullJoinQueryBuilder();
        $qb->add('where', $qb->expr()->in('tags.name', $tagNames))
           ->addOrderBy('tags.name', 'ASC')
           ->getQuery()
           ->getResult($hydrationMode);
    }

    /**
     * Join everything, return the QueryBuilder object
     * @param $indexBy
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getFullJoinQueryBuilder($indexBy = 'slug')
    {
        $qb = $this->getQueryBuilder($indexBy);

        return $qb->select('artist', 'tags', 'websites', 'shows', 'workshops')
                  ->leftJoin('artist.shows', 'shows')
                  ->leftJoin('artist.tags', 'tags')
                  ->leftJoin('artist.websites', 'websites')
                  ->leftJoin('artist.workshops', 'workshops');
    }

    /**
     * Join everything, return the Query
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
        $qb = $this->getEntityManager()->createQueryBuilder();
        $indexBy = (null !== $indexBy) ? 'artist.' . $indexBy : null;

        return $qb->select('artist')
                  ->from('Ten24MarcatoIntegrationBundle:Artist', 'artist', $indexBy);
    }
}
