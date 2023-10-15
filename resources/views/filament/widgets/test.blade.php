@php
    use App\Filament\Widgets\test;
@endphp

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Dashboard</h1>
        <x-filament-widgets::widget>
            <x-filament::section>
                <div id="test">{!! $chart->html() !!}</div>
            </x-filament::section>
        </x-filament-widgets::widget>
    </div>
@endsection   
