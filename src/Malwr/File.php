<?php
namespace Malwr;

class File extends ApiBase
{
    /**
     * @param string $file   absolute file path
     * @param string $force  force processing even if sample is already analyzed
     */
    public function add($file, $force = 'no') {
        $data = $this->_client->post( self::API_ENDPOINT . 'analysis/add/' )
                              ->addPostFields(array(
                              	'api_key' => $this->_apiKey,
                              	'force' => $force
                              ))
                              ->addPostFiles(array('file' => $file));

        return $data->send()->json();
    }

    /**
     * @param string $uuid   UUID of the analysis task
     */
    public function status($uuid) {
    	$data = $this->_client->post( self::API_ENDPOINT . 'analysis/status/' )
                              ->addPostFields(array(
                              	'api_key' => $this->_apiKey,
                              	'uuid' => $uuid
                              ));

		return $data->send()->json();
    }

}