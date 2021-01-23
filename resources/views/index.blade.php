@extends('layout')
@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <div class="accordion accordion-flush" id="accordionFlushPaymentMethod">
        <div class="accordion-item">
            <h2 class="accordion-header" id="flush-headingRede">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseRede" aria-expanded="false" aria-controls="flush-collapseRede">
                    Rede
                </button>
            </h2>
            <div id="flush-collapseRede" class="accordion-collapse collapse" aria-labelledby="flush-headingRede" data-bs-parent="#accordionFlushPaymentMethod">
                <div class="accordion-body">
                    <div class="mb-3 row">
                        <div class="col-12">
                            <form method="POST" id="rede" action="{{ route('pay') }}">
                                @csrf
                                <input type="hidden" name="type" value="rede">
                                <button class="btn btn-primary" type="submit">Pagar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="flush-headingCielo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseCielo" aria-expanded="false" aria-controls="flush-collapseCielo">
                    Cielo
                </button>
            </h2>
            <div id="flush-collapseCielo" class="accordion-collapse collapse" aria-labelledby="flush-headingCielo" data-bs-parent="#accordionFlushPaymentMethod">
                <div class="accordion-body">
                    <div class="mb-3 row">
                        <div class="col-12">
                            <form method="POST" id="cielo" action="{{ route('pay') }}">
                                @csrf
                                <input type="hidden" name="type" value="cielo">
                                <button class="btn btn-primary" type="submit">Pagar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
