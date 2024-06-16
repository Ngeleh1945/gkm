<div class="px-4 py-20 bg-gray-100 min-h-screen">
    <div class="bg-white p-6 shadow-xl rounded-lg">
        <div class="row">
            <div class="col-lg-6">
                <div class="card mb-4">
                    <div class="card-header">Scan QR/Barcode</div>
                    <div id="qr-code-full-region" class="card-body"></div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script src="{{ mix('js/app.js') }}"></script>
@endpush
