<?php

namespace Ten24\MarcatoIntegrationBundle\Service;

class ArrayParser extends AbstractParser
{
    /**
     * Parse passed XML into array
     * @param null $xml
     * @return mixed
     */
    public function parse($xml = null)
    {
        $rawParsed = $this->serializer->decode($xml, 'xml');

        // @todo - this should really be passed as the rootNode option to the XmlEncoder instance
        // which is set in the AbstractParser...
        // this is so we don't have a artist|contact|show|venue|workshop
        // key in the cached data
        if (isset($rawParsed['artist']))
        {
            return $this->cleanup($rawParsed['artist']);
        }
        elseif (isset($rawParsed['contact']))
        {
            return $this->cleanup($rawParsed['contact']);
        }
        elseif (isset($rawParsed['show']))
        {
            return $this->cleanup($rawParsed['show']);
        }
        elseif (isset($rawParsed['venue']))
        {
            return $this->cleanup($rawParsed['venue']);
        }
        elseif (isset($rawParsed['workshop']))
        {
            return $this->cleanup($rawParsed['workshop']);
        }
    }

    /**
     * Cleans up the parsed XML - we don't really need the attributes, and the values
     * mapped should be moved up a level for ease-of-use in the application/templates
     * @param $data
     * @return mixed
     */
    protected function cleanup($data, $depth = 0)
    {
        foreach((array) $data as $key => $value)
        {
            // unset any @xxx attribute, they're not needed
            // These are decoded by the XmlEncoder->decode to array elements like
            // '@type' => 'array'
            if (false !== strpos($key, '@'))
            {
                unset($data[$key]);
                continue;
            }

            if (is_array($value))
            {
                if ($depth == 0 && is_numeric($key) && array_key_exists('name', $value))
                {
                    $slug = strtolower(str_replace(' ', '-', $value['name']));
                    $value['slug'] = $slug;
                    $data[$slug] = $value;
                    unset($data[$key]);

                    $data[$slug] = $this->cleanup($value);
                    continue;

                }

                // It's possible that the XML has an attribute and nodeValue
                // ie. <updated_at type="datetime">2014-02-24T15:03:59-04:00</updated_at>
                //
                // Will be in the format:
                //
                // 'updated_at' =>
                //  array (
                //    '@type' => 'datetime',
                //    '#' => '2014-02-24T15:03:59-04:00',
                //  )
                //
                // So we map the # to the $value for this $key
                if (array_key_exists('#', $value))
                {
                    $data[$key] = $value['#'];
                    continue;
                }

                // The parsed XML will have some key/values like this:
                //  'websites' =>
                //  array (
                //    'website' =>
                //        array (
                //            0 =>
                //                array (
                //                    'name' => 'Website',
                //                    'url' => 'http://anidifranco.com',
                //                ),
                // We want to move the 'website' key up a level, so we have
                //  'websites' =>
                //  array(
                //      0 =>
                //        array (
                //          'name' => 'Website',
                //          'url' => 'http://anidifranco.com',
                //        ),
                if ($key === 'artist_types')
                {
                    $value = $data[$key] = (isset($value['artist_type'])) ? (array) $value['artist_type'] : array();
                }
                if ($key === 'categories')
                {
                    $value = $data[$key] = (isset($value['category'])) ? (array) $value['category'] : array();
                }
                elseif ($key === 'custom-fields')
                {
                    $value = $data[$key] = (isset($value['custom-field'])) ? (array) $value['custom-field'] : array();
                }
                elseif ($key === 'presentations')
                {
                    $value = $data[$key] = (isset($value['presentation'])) ? (array) $value['presentation'] : array();
                }
                elseif ($key === 'shows')
                {
                    $arr = array();

                    if(isset($value['show']))
                    {
                        if (!isset($value['show'][0]))
                        {
                            // Single show
                            $arr = array(0 => $value['show']);
                        }
                        else
                        {
                            // Multiple shows
                            $arr = $value['show'];
                        }
                    }

                    $value = $data[$key] = $arr;
                }
                elseif ($key === 'show-types')
                {
                    $value = $data[$key] = (isset($value['show-type'])) ? (array) $value['show-type'] : array();
                }
                elseif ($key === 'websites')
                {
                    $value = $data[$key] = (isset($value['website'])) ? (array) $value['website'] : array();
                }
                elseif ($key === 'workshops')
                {
                    $value = $data[$key] = (isset($value['workshop'])) ? (array) $value['workshop'] : array();
                }
                elseif ($key === 'workshop-types')
                {
                    $value = $data[$key] = (isset($value['workshop-type'])) ? (array) $value['workshop-type'] : array();
                }

                // Recurse on the $value array
                $data[$key] = $this->cleanup($value, $depth++);
            }
        }

        return $data;
    }
}


