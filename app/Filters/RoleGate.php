<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class RoleGate implements FilterInterface
{
    /**
     * Do whatever processing this filter needs to do.
     * By default it should not return anything during normal execution.
     * However, when an abnormal state is found, it should return an instance of
     * CodeIgniter\HTTP\Response. If it does, script execution will cease and
     * that Response will be sent back to the client, allowing for error pages,
     * redirects, etc.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return mixed
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        if (!$session->get('user_logged_in')) {
            return;
        }

        $role = $session->get('user_role');
        $uri = uri_string();

        // Standardize URI: remove leading slash if it exists
        $uri = ltrim($uri, '/');

        // Allow logout and common assets if needed (though assets usually bypass filters)
        if (strpos($uri, 'auth/logout') === 0 || strpos($uri, 'admin/logout') === 0) {
            return;
        }

        if ($role === 'admin') {
            // Admin only allowed in admin section
            if (strpos($uri, 'admin') !== 0) {
                return redirect()->to('admin');
            }
        }

        if ($role === 'company') {
            // Company only allowed in company section or profile
            if (strpos($uri, 'company') !== 0 && strpos($uri, 'profile') !== 0) {
                return redirect()->to('company');
            }
        }
    }

    /**
     * Allows After filters to inspect and modify the response
     * object as needed. This method does not allow any way
     * to stop execution of other after filters, short of
     * throwing an Exception or Error.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return mixed
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
}
