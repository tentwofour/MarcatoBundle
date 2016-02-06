<?php

namespace Ten24\MarcatoIntegrationBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\PersistentCollection;
use Doctrine\ORM\Query;

/**
 * Class ArtistRepository
 *
 * @package Ten24\MarcatoIntegrationBundle\Repository
 */
class ArtistRepository extends EntityRepository
{
    /**
     * We hydrate by object here, because there are helper methods like getWebsiteByName() in the Artist model
     *
     * @param array $orderBy
     * @param int   $hydrationMode
     *
     * @return array
     */
    public function findAllJoinAll($indexBy = null,
                                   array $orderBy = ['artist.name', 'ASC'],
                                   $hydrationMode = Query::HYDRATE_OBJECT)
    {
        return $this->getFullJoinQueryBuilder($indexBy)
                    ->orderBy($orderBy[0], $orderBy[1])
                    ->getQuery()
                    ->getResult($hydrationMode);
    }

    /**
     * We hydrate by object here, because there are helper methods like getWebsiteByName() in the Artist model
     *
     * @param null $slug
     * @param int  $hydrationMode
     *
     * @return array
     */
    public function findOneBySlugJoinAll($slug = null,
                                         $hydrationMode = Query::HYDRATE_OBJECT)
    {
        return $this->getFullJoinQueryBuilder()
                    ->where('artist.slug = :slug')
                    ->setParameter('slug', $slug)
                    ->getQuery()
                    ->getSingleResult($hydrationMode);
    }

    /**
     * We hydrate by object here, because there are helper methods like getWebsiteByName() in the Artist model
     *
     * @param int $hydrationMode
     *
     * @return array
     */
    public function findAllOrderByNameAsc($indexBy = 'slug',
                                          $hydrationMode = Query::HYDRATE_OBJECT)
    {
        return $this->getFindAllOrderByNameAscQuery($indexBy)
                    ->getResult($hydrationMode);
    }

    /**
     * Get All Artists by Tag(s)
     * We hydrate by object here, because there are helper methods like getWebsiteByName() in the Artist model
     *
     * @param mixed $tags
     * @param array $orderBy
     * @param int   $hydrationMode
     *
     * @return array
     */
    public function findAllByTags($tags = null,
                                  $orderBy = ['artist.name', 'ASC'],
                                  $hydrationMode = Query::HYDRATE_OBJECT)
    {
        return $this->getFindAllByTagsQueryBuilder($tags, $orderBy)
                    ->getQuery()
                    ->getResult($hydrationMode);
    }

    /**
     * Get the query builder object for the findAllByTags
     * Useful for PagerFanta's ORMAdapter class for pagination
     *
     * @param mixed $tags
     * @param array $orderBy
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getFindAllByTagsQueryBuilder($tags = null,
                                                 $orderBy = ['artist.name', 'ASC'])
    {
        try
        {
            $tags = $this->parseCollectionToSingleScalarArray($tags);

            if (null !== $tags)
            {
                $qb = $this->getFullJoinQueryBuilder();

                return $qb->add('where', $qb->expr()->in('tags', ':tags'))
                          ->orderBy($orderBy[0], $orderBy[1])
                          ->setParameter('tags', $tags);
            }
        }
        catch (\LogicException $e)
        {
            throw $e;
        }
    }

    /**
     * Get query object for findAllOrderByNameAsc method
     *
     * @param string $indexBy
     *
     * @return Query
     */
    public function getFindAllOrderByNameAscQuery($indexBy = 'slug')
    {
        return $this->getQueryBuilder($indexBy)
                    ->orderBy('artist.name', 'ASC')
                    ->getQuery();
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

        return $qb->select('artist', 'tags', 'websites', 'shows', 'workshops')
                  ->leftJoin('artist.shows', 'shows')
                  ->leftJoin('artist.tags', 'tags')
                  ->leftJoin('artist.websites', 'websites')
                  ->leftJoin('artist.workshops', 'workshops');
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
        $indexBy = (null !== $indexBy) ? 'artist.' . $indexBy : null;

        return $qb->select('artist')
                  ->from('Ten24MarcatoIntegrationBundle:Artist', 'artist', $indexBy);
    }

    /**
     * Parse an Array or PersistentCollection to a single scalar array
     * for use in whereIn() queries
     *
     * @param null $arrayOrCollection
     *
     * @return null
     * @throws LogicException
     */
    private function parseCollectionToSingleScalarArray($arrayOrCollection = null)
    {
        if (null === $arrayOrCollection)
        {
            return null;
        }

        // If it's a collection, map to a single scalar array
        if ($arrayOrCollection instanceof PersistentCollection)
        {
            /** @var PersistentCollection $arrayOrCollection */
            $items = $arrayOrCollection->map(function ($item)
            {
                return $item->getId();
            });

            return $items->toArray();
        }
        // It's just an array
        elseif (is_array($arrayOrCollection))
        {
            // Multi dimensional, ie. PersistentCollection->toArray()
            if (is_array($arrayOrCollection[0]))
            {
                foreach ($arrayOrCollection as $index => $value)
                {
                    // $item is the nested (possibly associative) array,
                    // look for an 'id' key
                    if (isset($value['id']))
                    {
                        $arrayOrCollection[$index] = $value['id'];
                    }
                    // Or it's just the id, not in an associative array
                    // a db id's CANT be 0 either...
                    elseif (is_numeric($value) && $value > 0)
                    {
                        $arrayOrCollection[$index] = $value;
                    }
                    // Not sure how to parse
                    else
                    {
                        throw new \LogicException(sprintf('%s expects the "%s" argument to be of type "%s" or "%s"',
                                                          __METHOD__,
                                                          'tags',
                                                          'PersistentCollection',
                                                          'array'));
                    }
                }
            }
        }
        else
        {
            throw new \LogicException(sprintf('%s expects the "%s" argument to be of type "%s" or "%s"',
                                              __METHOD__,
                                              'tags',
                                              'PersistentCollection',
                                              'array'));
        }

        return $arrayOrCollection;
    }
}
