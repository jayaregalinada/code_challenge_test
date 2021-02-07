<?php

namespace App\Http\Middleware;

use Closure;
use App\Entities\Customer;
use Illuminate\Support\Arr;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CustomerMiddleware
{
    /**
     * @var \Doctrine\ORM\EntityManagerInterface
     */
    protected $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->route('customer') !== null) {
            $customer = $this->findCustomer($request->route('customer'));
            $resolver = $request->getRouteResolver();
            $request->setRouteResolver(function () use ($customer, $resolver) {
                $route = $resolver();
                Arr::set($route[2], 'customer', $customer);

                return $route;
            });
        }

        return $next($request);
    }

    protected function findCustomer(int $id) : ?Customer
    {
        /** @var Customer|null $find */
        if (($find = $this->entityManager->find(Customer::class, $id)) !== null) {
            return $find;
        }

        throw new NotFoundHttpException('Customer with `' . $id . '` is not found.');
    }
}
