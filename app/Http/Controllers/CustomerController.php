<?php

namespace App\Http\Controllers;

use App\Entities\Customer;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Repositories\CustomerRepository;
use App\Http\Resources\CustomerResource;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Collections\Criteria;
use App\Http\Resources\CustomerListsResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerController extends Controller
{

    /**
     * @param \Illuminate\Http\Request             $request
     * @param \Doctrine\ORM\EntityManagerInterface $entityManager
     *
     * @throws \Illuminate\Validation\ValidationException
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function index(Request $request, EntityManagerInterface $entityManager)
    {
        $this->validate($request, [
            'order' => [
                Rule::in([
                    Criteria::DESC,
                    Criteria::ASC,
                ]),
            ],
            'limit' => [
                'integer',
            ],
            'page' => [
                'integer',
            ],
        ]);
        /** @var \App\Repositories\CustomerRepository $repository */
        $repository = $entityManager->getRepository(Customer::class);

        return CustomerListsResource::collection(
            $repository->all(
            $order = $request->get('order', Criteria::DESC),
            $limit = (int) $request->get('limit', CustomerRepository::LIMIT),
            (int) $request->get('page', 1)
            )
            ->withPath(route('customer.index'))
            ->appends(compact('limit', 'order'))
        );
    }

    public function show(Customer $customer) : JsonResource
    {
        return new CustomerResource($customer);
    }

}
