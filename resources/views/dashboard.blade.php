@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-lg-6 col-12">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $jumlahDataPenjualan }}</h3>
                <p>Data Penjualan</p>
            </div>
            <div class="icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <a href="{{ route('data.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-6 col-12">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $jumlahHasilPrediksi }}</h3>
                <p>Hasil Prediksi</p>
            </div>
            <div class="icon">
                <i class="fas fa-chart-line"></i>
            </div>
            <a href="{{ route('prediksi.hasil') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>
@endsection