<?php
class Service_Mapping
{
    // Reference material: http://www.davegardner.me.uk/blog/2011/07/27/a-mapper-pattern-for-php/

    public function mapToJson( &$schema, $parent, $data )
    {
        foreach ( $schema as $key => $value )
        {
            if ( is_array( $value ) )
            {
                if ( strcasecmp($parent, '') == 0 )
                    $this->mapToJson( $schema[$key], $parent . $key, $data );
                else
                    $this->mapToJson( $schema[$key], $parent . ucfirst( $key ), $data );
            }
            else
            {

                // Dump db schema for this object
                //echo '`' . $parent . ucfirst($key) . '` VARCHAR( 255 ) NOT NULL, ' . PHP_EOL;
                $dbFieldName = $parent . ucfirst($key);

                // Dump validation schema for this object
                //echo '"' . $dbFieldName . '" => array(), ' . PHP_EOL;

                if ( isset ( $data[$dbFieldName] ) ) {
                    $schema[$key] = $data[$dbFieldName];
                }

            }
        }
        return $schema;
    }

    public function mapToDb( $data, $parent, &$dbArray)
    {

        foreach ( $data as $key => $value )
        {
            if ( is_array( $value ) )
            {
                if ( strcasecmp($parent, '') == 0 )
                    $this->mapToDb( $data[$key], $parent . $key, $dbArray );
                else
                    $this->mapToDb( $data[$key], $parent . ucfirst( $key ), $dbArray );
            }
            else
            {

                $dbFieldName = $parent . ucfirst($key);
                //if ( $value != null )
                $dbArray[$dbFieldName] = $value;
            }
        }
        return $dbArray;
    }

    public function dbSchema( &$schema, $parent)
    {
        foreach ( $schema as $key => $value )
        {
            if ( is_array( $value ) )
            {
                if ( strcasecmp($parent, '') == 0 )
                    $this->dbSchema( $schema[$key], $parent . $key );
                else
                    $this->dbSchema( $schema[$key], $parent . ucfirst( $key ) );
            }
            else
            {

                // Dump db schema for this object
                echo '`' . $parent . ucfirst($key) . '` VARCHAR( 255 ) NOT NULL, ' . PHP_EOL;
                $dbFieldName = $parent . ucfirst($key);

            }
        }
        //return $schema;
    }




}