<?php
/**
 *
 * This file is part of Relay for PHP.
 *
 * @license http://opensource.org/licenses/MIT MIT
 *
 * @copyright 2015-2016, Relay for PHP
 *
 */
namespace App\Middlewares;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
/**
 *
 * Deprecated handler for JSON content; consider using JsonContentHandler
 * instead.
 *
 * @package relay/middleware
 *
 */
class JsonDecoder
{
    /**
     *
     * When true, returned objects will be converted into associative arrays.
     *
     * @var bool
     *
     */
    protected $assoc;
    /**
     *
     * User specified recursion depth.
     *
     * @var int
     *
     */
    protected $maxDepth;
    /**
     *
     * Bitmask of JSON decode options. Currently only JSON_BIGINT_AS_STRING is
     * supported (default is to cast large integers as floats).
     *
     * @var int
     *
     */
    protected $options;
    /**
     *
     * Constructor.
     *
     * @param bool $assoc Return objects as associative arrays?
     *
     * @param int $maxDepth Max recursion depth.
     *
     * @param int $options Bitmask of JSON decode options.
     *
     */
    public function __construct($assoc = false, $maxDepth = 256, $options = 0)
    {
        $this->assoc = $assoc;
        $this->maxDepth = $maxDepth;
        $this->options = $options;
    }
    /**
     *
     * Parses the PSR-7 request body if its content-type is 'application/json'.
     *
     * @param Request $request The HTTP request.
     *
     * @param Response $response The HTTP response.
     *
     * @param callable $next The next middleware in the queue.
     *
     * @return Response
     *
     */
    public function __invoke(Request $request, Response $response, callable $next)
    {
        $parts = explode(';', $request->getHeaderLine('Content-Type'));
        $type = strtolower(trim(array_shift($parts)));
        if ($request->getMethod() != 'GET' && $type == 'application/json') {
            $body = (string) $request->getBody();
            $request = $request->withParsedBody(json_decode(
                $body,
                $this->assoc,
                $this->maxDepth,
                $this->options
            ));
        }
        return $next($request, $response);
    }
}