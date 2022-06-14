<?php

namespace App\Controller;

use Doctrine\ODM\MongoDB\DocumentManager;
use App\Document\Accounts;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReportsController extends AbstractController
{   
    /**
     * @Route("/accounts", name="accounts", methods="GET")
     *
     * @return Response
     */
    public function getAllAccounts(DocumentManager $documentManager): Response
    {
        $builder = $documentManager->createAggregationBuilder(Accounts::class);
        $builder
            ->lookup('Metrics')
                ->localField('accountId')
                ->foreignField('accountId')
                ->alias('metrics_data')
            ->match()
                ->field('status')
                ->equals('ACTIVE')
            ->unwind('$metrics_data')
                ->preserveNullAndEmptyArrays(true)
            ->group()
                ->field('_id')
                ->expression(['id' => '$_id', 'accountId' => '$accountId', 'accountName' => '$accountName'])
                ->field('spend')
                ->sum('$metrics_data.spend')
                ->field('impressions')
                ->sum('$metrics_data.impressions')
                ->field('clicks')
                ->sum('$metrics_data.clicks')
            ->addFields()
                ->field('costPerClick')
                ->expression(['$cond' => ['if' => ['$eq' => ['$clicks', 0]], 'then' => 0, 'else' => ['$divide' => ['$spend', '$clicks']]]])
                ->sort(['costPerClick' => -1, '_id' => 1]);

        $result = $builder->execute();

        /* return $this->json([
            'accounts' => $result->toArray(),
        ]); */

        return $this->render('/reports/index.html.twig', [
            'accounts' => $result->toArray(),
            'controller_name' => 'ReportsController'
        ]);
    }

    /**
     * @param string $account_id
     * 
     * @Route("/accounts/{account_id}", name="accounts_by_ID", methods="GET")
     *
     * @return Response
     */
    public function getAccountsById($account_id,DocumentManager $documentManager): Response
    {
        $builder = $documentManager->createAggregationBuilder(Accounts::class);
        $builder
            ->lookup('Metrics')
                ->localField('accountId')
                ->foreignField('accountId')
                ->alias('metrics_data')
            ->match()
                ->field('status')
                ->equals('ACTIVE')
                ->field('accountId')
                ->equals($account_id)
            ->unwind('$metrics_data')
                ->preserveNullAndEmptyArrays(true)
            ->group()
                ->field('_id')
                ->expression(['id' => '$_id', 'accountId' => '$accountId', 'accountName' => '$accountName'])
                ->field('spend')
                ->sum('$metrics_data.spend')
                ->field('impressions')
                ->sum('$metrics_data.impressions')
                ->field('clicks')
                ->sum('$metrics_data.clicks')
            ->addFields()
                ->field('costPerClick')
                ->expression(['$cond' => ['if' => ['$eq' => ['$clicks', 0]], 'then' => 0, 'else' => ['$divide' => ['$spend', '$clicks']]]])
                ->sort(['costPerClick' => -1, '_id' => 1]);

        $result = $builder->execute();

        /* return $this->json([
            'accounts' => $result->toArray(),
        ]); */

        return $this->render('/reports/index.html.twig', [
            'accounts' => $result->toArray(),
            'controller_name' => 'ReportsController'
        ]);
    }
}
