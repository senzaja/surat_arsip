@extends('layouts.main')

@push('style')
    <link rel="stylesheet" href="{{ asset('sneat/vendor/libs/apex-charts/apex-charts.css') }}" />
@endpush
<style>
    /* Style untuk ikon garis tiga */
    .menu-icon {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        width: 30px;
        height: 25px;
        cursor: pointer;
    }

    .bar {
        width: 100%;
        height: 4px;
        background-color: black;
        transition: 0.3s;
    }

    /* Style untuk menu dropdown */
    .menu-dropdown {
        display: none;
        position: absolute;
        top: 40px;
        left: 10px;
        background-color: white;
        border: 1px solid #ccc;
        box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
        padding: 10px;
        width: 150px;
    }

    .menu-dropdown a {
        display: block;
        padding: 8px;
        text-decoration: none;
        color: black;
    }

    .menu-dropdown a:hover {
        background-color: #f1f1f1;
    }
</style>
@push('script')
    <script src="{{ asset('sneat/vendor/libs/apex-charts/apexcharts.js') }}"></script>
    <script>
       document.addEventListener("DOMContentLoaded", function () {
    const options = {
        chart: {
            type: 'bar',
            height: 350,
            toolbar: {
                tools: {
                    download: false
                },

            }
        },
        colors: ['#28a745', '#007bff'],
        series: [
            {
                name: '{{ __("dashboard.incoming_letter") }}',
                data: @json($monthlyIncomingLetters)
            },
            {
                name: '{{ __("dashboard.outgoing_letter") }}',
                data: @json($monthlyOutgoingLetters)
            }
        ],
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '50%',
                endingShape: 'rounded'
            }
        },
        dataLabels: {
            enabled: false
        },
        xaxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des']
        }
    };

    const chart = new ApexCharts(document.querySelector("#monthly-graphic"), options);
    chart.render();
});

function toggleMenu() {
            var menu = document.getElementById("menuDropdown");
            if (menu.style.display === "block") {
                menu.style.display = "none";
            } else {
                menu.style.display = "block";
            }
        }

    </script>
@endpush

@section('content')

    <div class="row">
        <!-- Kartu Utama -->
        <div class="col-lg-8 mb-4 order-0">
            <div class="card mb-4">
                <div class="row align-items-end">
                    <div class="col-sm-7">
                        <div class="card-body">
                            <h4 class="card-title text-primary">{{ $greeting }}</h4>
                            <p class="mb-4">{{ $currentDate }}</p>
                            <p class="text-gray" style="font-size: smaller">*) {{ __('dashboard.today_report') }}</p>
                        </div>
                    </div>
                    <div class="col-sm-5 text-center">
                        <div class="card-body pb-0 px-0 px-md-4">
                            <img src="{{ asset('sneat/img/robot.gif') }}" height="140" alt="View Badge User">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Grafik Transaksi Surat -->
            <div class="card">
                <div class="card-body">

                    <h5 class="card-title">{{ __('grafik ') }}</h5>
                    <div id="monthly-graphic" style="min-height: 350px;"></div>

                    <div class="mt-sm-auto">
                        @if ($percentageLetterTransaction > 0)
                            <small class="text-success fw-semibold">
                                {{-- <i class="bx bx-chevron-up"></i> {{ $percentageLetterTransaction }}% --}}
                            </small>
                        @elseif($percentageLetterTransaction < 0)
                            <small class="text-danger fw-semibold">
                                {{-- <i class="bx bx-chevron-down"></i> {{ $percentageLetterTransaction }}% --}}
                            </small>
                        @endif
                        {{-- <h3 class="mb-0 display-4">{{ $todayLetterTransaction }}</h3> --}}
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistik Surat & Pengguna -->
        <div class="col-lg-4 order-1">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-6 mb-4">
                    <x-dashboard-card-simple :label="__('dashboard.incoming_letter')" :value="$todayIncomingLetter"
                        :daily="true" color="success" icon="bx-envelope" :percentage="$percentageIncomingLetter" />
                </div>

                <div class="col-lg-6 col-md-12 col-6 mb-4">
                    <x-dashboard-card-simple :label="__('dashboard.outgoing_letter')" :value="$todayOutgoingLetter"
                        :daily="true" color="danger" icon="bx-envelope" :percentage="$percentageOutgoingLetter" />
                </div>

                @if (Auth::user()->role == 'admin')
                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                        <x-dashboard-card-simple :label="__('dashboard.active_user')" :value="$activeUser"
                            :daily="false" color="info" icon="bx-user-check" :percentage="0" />
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
