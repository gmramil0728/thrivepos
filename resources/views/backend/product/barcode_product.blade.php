@extends('admin_dashboard')
@section('admin')

<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item">
                                <a class="btn btn-outline-primary rounded-pill waves-effect waves-light" href="{{ route('all.product') }}">
                                    <i class="mdi mdi-arrow-left me-1"></i> Back to Products
                                </a>
                            </li>
                        </ol>
                    </div>
                    <h4 class="page-title">Generate Barcode</h4>
                </div>
            </div>
        </div>     
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4 text-center">
                        
                        <h5 class="mb-4 text-uppercase text-start border-bottom pb-2">
                            <i class="mdi mdi-barcode-scan me-1 text-primary"></i> Product Label
                        </h5>

                        <div class="barcode-container py-4 bg-light rounded-3 mb-4">
                            <h4 class="fw-bold mb-1">{{ $product->product_name }}</h4>
                            <p class="text-muted mb-3">Code: {{ $product->product_code }}</p>

                            <div class="d-inline-block p-3 bg-white shadow-sm rounded border">
                                @php
                                    // $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
                                    $generator = new Picqer\Barcode\BarcodeGeneratorSVG();
                                    // echo $generator->getBarcode($product->product_code, $generator::TYPE_CODE_128);
                                @endphp
                                
                                {!! $generator->getBarcode($product->product_code, $generator::TYPE_CODE_128, 2, 60) !!}
                                
                                <div class="mt-2 tracking-widest font-monospace">
                                    {{ $product->product_code }}
                                </div>
                            </div>
                        </div>

                        

                        <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                            <button type="button" onclick="window.print();" class="btn btn-dark waves-effect waves-light px-4">
                                <i class="mdi mdi-printer me-1"></i> Print Label
                            </button>
                            <a href="{{ route('all.product') }}" class="btn btn-light waves-effect px-4">
                                Finish
                            </a>
                        </div>

                    </div> </div> <div class="alert alert-info border-0 shadow-sm mt-3" role="alert">
                    <i class="mdi mdi-information-outline me-1"></i> 
                    <strong>Tip:</strong> Ensure your printer is set to "Actual Size" for the best scanning results.
                </div>
            </div> </div> </div> </div> <style type="text/css">
    /* Extra styling to ensure the barcode displays clearly */
    .barcode-container svg, .barcode-container div {
        max-width: 100%;
        height: auto;
    }
    
    @media print {
        /* Hide everything except the barcode card when printing */
        .left-side-menu, .navbar-custom, .footer, .btn, .alert, .breadcrumb, .page-title {
            display: none !important;
        }
        .content-page {
            margin: 0 !important;
            padding: 0 !important;
        }
        .card {
            border: none !important;
            box-shadow: none !important;
        }
        .barcode-container {
            background-color: white !important;
        }

        .barcode-container {
            display: block !important;
            visibility: visible !important;
        }
        
    }
</style>

@endsection