<?php

namespace App\Service;

use App\Entity\UrlStatistic;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Url;
use App\Repository\UrlStatisticRepository;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class UrlStatisticService
{

    private EntityManagerInterface $em;
    private UrlStatisticRepository $urlStatisticRepo;
    private ChartBuilderInterface $chartBuilder;


    public function __construct(EntityManagerInterface $em, UrlStatisticRepository $urlStatisticRepo, ChartBuilderInterface $chartBuilder)
    {
        $this->em = $em;
        $this->urlStatisticRepo = $urlStatisticRepo;
        $this->chartBuilder= $chartBuilder;

    }

    public function findOnByUrlAndDate(Url $url, \DateTimeInterface $date): UrlStatistic
    {
        $urlStatistic = $this->urlStatisticRepo->findOneBy([
            'url' => $url,
            'date' => $date
        ]);
        if (!$urlStatistic) {
            $urlStatistic = new urlStatistic;
            $urlStatistic->setUrl($url);
            $urlStatistic->setDate($date);
        }
        return $urlStatistic;
    }

    public function incrementUrlStatistic(UrlStatistic $urlStatistic): UrlStatistic
    {
        $urlStatistic->setClicks($urlStatistic->getClicks() + 1);
        $this->em->persist($urlStatistic);
        $this->em->flush();

        return $urlStatistic;
    }

    public function createChart(array $labels, $data)
    {
        $chart = $this->chartBuilder->createChart(Chart::TYPE_BAR);

        $chart->setData([
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Nombre total de clics',
                    'backgroundColor' => 'rgb(51,73,255)',
                    'borderColor' => 'rgb(51,73,255)',
                    'data' => $data
                ]
            ]
        ]);
        $chart->setOptions([
            'scales' => [
                'yAxes' => [
                    ['ticks' => ['min' => 0]]
                ]
            ]
        ]);
        return $chart;
    }
}
