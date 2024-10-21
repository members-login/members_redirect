<?php
/**
 * Extension driver
 *
 * @author tiloschroeder.de
 */
if (!defined("__IN_SYMPHONY__")) die("<h2>Error</h2><p>You cannot directly access this file</p>");

class extension_members_redirect extends Extension
{
    /**
     * Delegates and callbacks
     * @return array
     */
    public function getSubscribedDelegates()
    {
        return array(
            array(
                'page'     => '/frontend/',
                'delegate' => 'FrontendParamsPostResolve',
                'callback' => 'frontendParamsPostResolve'
            )
        );
    }

    /**
     * Redirect loggedin members to homepage
     * Redirect non-loggedin members to log in page
     *
     * @uses FrontendParamsPostResolve
     * @param  string $context
     * @return void
     */
    public function frontendParamsPostResolve( $context )
    {

        $loggedinMember = $context['params']['ds-get-member.id'] ?? null;
        $currentPage = $context['params']['current-page'];
        $rootPage = $context['params']['root-page'];
        $homepage = $context['params']['root'];

        // Redirect loggedin members to homepage
        if ( ($currentPage == 'login' or $currentPage == 'signup' or $currentPage == 'password-lost') and ($loggedinMember != null) ){
            header('Location: ' . $homepage . '', true, 302);

            exit;
        }

        // Redirect non-loggedin members to log in page
        if ( ($currentPage == 'dashboard' or $rootPage == 'dashboard' ) and $loggedinMember == null ) {
            if ( $rootPage != $currentPage ) {
                $fullUrl = $homepage . '/' . $rootPage . '/' . $currentPage . '/';
            } else {
                $fullUrl = $homepage . '/' . $currentPage . '/';
            }
            header('Location: ' . $homepage . '/login/?redirect_to=' . rawurlencode($fullUrl), true, 302);

            exit;
        }
    }
}
