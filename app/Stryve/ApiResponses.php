<?php

namespace App\Stryve;


class ApiResponses {

    // HTTP Response Codes
    const HTTP_OK = 200;
    const HTTP_CREATED = 201;
    const HTTP_ACCEPTED = 202;
    const HTTP_BAD_REQUEST = 400;
    const HTTP_UNAUTHORIZED = 401;
    const HTTP_FORBIDDEN = 403;
    const HTTP_NOT_FOUND = 404;
    const HTTP_METHOD_NOT_ALLOWED = 405;
    const HTTP_REQUEST_TIMEOUT = 408;
    const HTTP_INTERNAL_SERVER_ERROR = 500;
    const HTTP_NOT_IMPLEMENTED = 501;
    const HTTP_RATE_LIMIT_EXCEEDED = 503;
    const HTTP_SERVICE_UNAVAILABLE = 503;

    /**
     * @var array
     */
    public $httpMessages = [
        200 => "OK",
        201 => "Created",
        202 => "Accepted",
        400 => "Bad Request",
        401 => "Unauthorized",
        403 => "Forbidden",
        404 => "Not Found",
        405 => "Method Not Allowed",
        408 => "Request Timeout",
        500 => "Internal Error",
        501 => "Not Implemented",
        503 => "Not Available",
    ];

    /**
     * @var string
     */
    public $status = null;

    /**
     * @var int
     */
    public $statusCode = null;

    /**
     * @var string
     */
    public $statusMessage = null;

    /**
     * Gets the HTTP Response Status.
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Sets the HTTP Response Status.
     *
     * @param string $status
     *
     * @return self
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Gets the HTTP Status Code
     *
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * Sets the HTTP Status Code
     *
     * @param int $statusCode
     * @return self
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * Gets the HTTP response message
     *
     * @return string
     */
    public function getStatusMessage()
    {
        return $this->statusMessage;
    }

    /**
     * Sets the HTTP response message
     *
     * @param string $message
     * @return string
     */
    public function setStatusMessage($message)
    {	
    	if(is_null($message))
    	{
    		$this->statusMessage = $this->httpMessages[$this->getStatusCode()];
    	}
    	else
    	{
    		$this->statusMessage = $this->httpMessages[$this->getStatusCode()] . ' - ' . trim($message);
    	}
        
        return $this;
    }   

    /**
     * Returns 200 OK Response
     * 
     * @param  array $data
     * @param  string $message
     * @return Response
     */
    public function respondOk($data = [], $message = null)
    {
        return $this->setStatus('success')
        			->setStatusCode(self::HTTP_OK)
        			->setStatusMessage($message)
        			->respondWithSuccessMessage($data);
    }

    /**
     * Returns 201 Created Response
     * 
     * @param  array $data
     * @param  string $message
     * @return Response
     */
    public function respondCreated($data = [], $message = null)
    {
        return $this->setStatus('success')
        			->setStatusCode(self::HTTP_CREATED)
        			->setStatusMessage($message)
                    ->respondWithSuccessMessage($data);
    }

    /**
     * Returns 202 Accepted Response
     * 
     * @param  array $data
     * @param  string $message
     * @return Response
     */
    public function respondAccepted($data = [], $message = null)
    {
        return $this->setStatus('success')
        			->setStatusCode(self::HTTP_ACCEPTED)
        			->setStatusMessage($message)
                    ->respondWithSuccessMessage($message, $data);
    }

    /**
     * Returns 400 Bad Request Response
     * 
     * @param  string $message
     * @return Response
     */
    public function respondBadRequest($message = null)
    {
        return $this->setStatus('error')
                    ->setStatusCode(self::HTTP_BAD_REQUEST)
                    ->setStatusMessage($message)
                    ->respondWithErrorMessage();
    }

    /**
     * Returns 401 Unauthorized Response
     * 
     * @param  string $message
     * @return Response
     */
    public function respondUnauthorized($message = null)
    {
        return $this->setStatus('error')
                    ->setStatusCode(self::HTTP_UNAUTHORIZED)
                    ->setStatusMessage($message)
                    ->respondWithErrorMessage();
    }

    /**
     * Returns 403 Forbidden Response
     * 
     * @param  string $message
     * @return Response
     */
    public function respondForbidden($message = null)
    {
        return $this->setStatus('error')
                    ->setStatusCode(self::HTTP_FORBIDDEN)
                    ->setStatusMessage($message)
                    ->respondWithErrorMessage();
    }

    /**
     * Returns 404 Not Found HTTP Response
     *
     * @param  string $message
     * @return Response
     */
    public function respondNotFound($message = null)
    {
        return $this->setStatus('error')
                    ->setStatusCode(self::HTTP_NOT_FOUND)
                    ->setStatusMessage($message)
                    ->respondWithErrorMessage();
    }

    /**
     * Returns 405 Method Not Allowed Response
     *
     * @param  string $message
     * @return Response
     */
    public function respondMethodNotAllowed($message = null)
    {
        return $this->setStatus('error')
                    ->setStatusCode(self::HTTP_METHOD_NOT_ALLOWED)
                    ->setStatusMessage($message)
                    ->respondWithErrorMessage();
    }

    /**
     * Returns 500 Internal Server HTTP Response
     *
     * @param  string $message
     * @return Response
     */
    public function respondInternalError($message = null)
    {
        return $this->setStatus('error')
                    ->setStatusCode(self::HTTP_INTERNAL_SERVER_ERROR)
                    ->setStatusMessage($message)
                    ->respondWithErrorMessage();
    }

    /**
     * Returns 501 Not Implemented HTTP Response
     *
     * @param  string $message
     * @return Response
     */
    public function respondNotImplemented($message = null)
    {
        return $this->setStatus('error')
                    ->setStatusCode(self::HTTP_NOT_IMPLEMENTED)
                    ->setStatusMessage($message)
                    ->respondWithErrorMessage();
    }

    /**
     * Returns 503 Rate Limit Exceeded HTTP Response
     *      
     * @param  string $message
     * @return Response
     */
    public function respondRateLimitExceeded($message = null)
    {
        return $this->setStatus('error')
                    ->setStatusCode(self::HTTP_RATE_LIMIT_EXCEEDED)
                    ->setStatusMessage($message)
                    ->respondWithErrorMessage();
    }

    /**
     * Returns 503 Not Available HTTP Response
     *
     * @param  string $message
     * @return Response
     */
    public function respondNotAvailable($message = null)
    {
        return $this->setStatus('error')
                    ->setStatusCode(self::HTTP_SERVICE_UNAVAILABLE)
                    ->setStatusMessage($message)
                    ->respondWithErrorMessage();
    }

    /**
     * Returns JSON Encoded Response based on the set HTTP Status Code
     * 
     * @param  string $message
     * @param  array $data
     * @return Response
     */
    public function respondWithSuccessMessage($data)
    {
        return $this->respond([
            'code'      => $this->getStatusCode(),
            'status'    => $this->getStatus(),
            'message'   => $this->getStatusMessage(),
            'response'  => $data
        ]);
    }

    /**
     * Returns JSON Encoded Response based on the set HTTP Status Code
     * 
     * @param  string $message
     * @return Response
     */
    public function respondWithErrorMessage()
    {
        return $this->respond([
            'code'      => $this->getStatusCode(),
            'status'    => $this->getStatus(),
            'message'   => $this->getMessage()
        ]);
    }

    /**
     * Returns JSON Encoded HTTP Reponse
     * 
     * @param  array $data
     * @param  array $headers
     * @return JsonReponse
     */
    public function respond($body, $headers = [])
    {
        return response()->json($body, $this->getStatusCode(), $headers);
    }

}