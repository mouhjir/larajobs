<?php
namespace App\Filament\Widgets;

use App\Models\Job;

use Filament\Widgets\BarChartWidget;

use Filament\Widgets\WidgetConfiguration;

use LaravelDaily\LaravelCharts\Classes\Chartjs\Chart;

 

class test extends BarChartWidget

{

  

    protected static ?string $heading = 'companies';

 

    protected static ?int $sort = 2;

 

    protected static ?float $pieHole = 0.5;

 

    public static function make(array $properties = []): WidgetConfiguration

    {

        $widget = new static();

 

        // Set any properties that were passed in to the make() method

        foreach ($properties as $property => $value) {

            $widget->{$property}($value);

        }

 

        // Set any default properties that are not already set

        $widget->pieHole(static::$pieHole);

        $widget->options(static::getOptions($widget->getChartInstance()));

        $widget->data(static::getData());

        $widget->heading(static::$heading);

        $widget->sort(static::$sort);

 

        return $widget;

    }

 

    protected function getOptions(): ?array

    {

        $options = parent::getOptions();

 

        // Add or modify options as needed

        $options['title'] = [

            'display' => true,

            'text' => 'Graphique de test',

            'fontSize' => 18,

        ];

 

        $options['scales'] = [

            'yAxes' => [

                [

                    'ticks' => [

                        'beginAtZero' => true,

                    ],

                ],

            ],

        ];

 

        $options['tooltips'] = [

            'enabled' => false,

        ];

 

        $options['animation'] = [

            'duration' => 1000,

            'onComplete' => function ($animation) {

                $ctx = $animation->chart->ctx;

                $ctx->fillStyle = "rgba(51, 153, 255, 0.2)";

                $ctx->beginPath();

                $ctx->fillRect(0, 0, $animation->chart->width, $animation->chart->height);

                $ctx->moveTo(0, $animation->chart->scales["yAxes"][0]["bottom"]); // Ligne bleue à la position y = 0

                $ctx->lineTo($animation->chart->width, $animation->chart->scales["yAxes"][0]["bottom"]);

                $ctx->moveTo(0, $animation->chart->scales["yAxes"][0]["top"]); // Ligne rouge à la position y = 10

                $ctx->lineTo($animation->chart->width, $animation->chart->scales["yAxes"][0]["top"]);

                $ctx->lineWidth = 1;

                $ctx->strokeStyle = "red";

                $ctx->stroke();

            },

        ];

 

        return $options;

    }

 

    protected function getData(): array

    {

        // Define the dataset for the chart

        $jobs = Job::filter(request()->only('search', 'tag', 'company'))->get();

        $dataset = [

            'labels' => $jobs

            ->pluck('company')->unique(),

            'datasets' => [

                [

                    'label' => 'Jobs by Company',

                    'data' => $jobs->groupBy('company')->map(function ($item, $key) {

                        return count($item);

                    }),

                    'backgroundColor' => $this->generateRandomColors(count($jobs->pluck('company')->unique())),

                    'borderColor' => '#0073aa',

                    'borderWidth' => 1,

                ],

            ],

        ];

        return $dataset;

    }

 

    private function generateRandomColors($count)

    {

        // Generate an array of random colors

        $colors = [];

 

        for ($i = 0; $i < $count; $i++) {

            array_push($colors, '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT));

        }

 

        return $colors;

    }

 

    public function jobsByCompany($location = null)

    {

        $jobs = Job::when($location, function ($query, $location) {

                return $query->where('location', $location);

            })

            ->filter(request()->only('search', 'tag', 'company'))

            ->get();

       

        $chart = new Chart;

   

        $chart->options([

            'maintainAspectRatio' => false,

            'responsive' => true,

        ]);

   

        $chart->displayAxes(true);

        $chart->displayLegend(true);

   

        $chart->width(800)->height(800);

   

        $chart->data([

            'labels' => $jobs->pluck('company')->unique(),

            'datasets' => [

                [

                    'label' => 'Jobs by Company',

                    'data' => $jobs->groupBy('company')->map(function ($item, $key) {

                            return count($item);

                    }),

                    'backgroundColor' => $this->generateRandomColors(count($jobs->pluck('company')->unique())),

                    'borderColor' => '#0073aa',

                    'borderWidth' => 1,

                ],

            ],

        ]);

   

        return $chart;

    }}