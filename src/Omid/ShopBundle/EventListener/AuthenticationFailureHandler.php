<?php

namespace Omid\ShopBundle\EventListener;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authentication\DefaultAuthenticationFailureHandler;

/**
 * {@inheritDoc}
 */
class AuthenticationFailureHandler extends DefaultAuthenticationFailureHandler
{
    /**
     * {@inheritDoc}
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception) {
        if($request->isXmlHttpRequest()) {
            $response = new JsonResponse(array('code' => 400, 'message' => $exception->getMessage()));
        } else {
            $response = parent::onAuthenticationFailure( $request, $exception );
        }

        return $response;
    }
}