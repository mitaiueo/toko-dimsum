@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-6">Pembayaran</h1>
    
    <div class="bg-white shadow overflow-hidden sm:rounded-lg p-6">
        <div class="text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
            <h2 class="mt-4 text-2xl font-semibold text-gray-800">Pesanan Berhasil Dibuat</h2>
            <p class="mt-2 text-gray-600">Nomor Pesanan: {{ $transaction->order_number }}</p>
            <p class="mt-1 text-gray-600">Total Pembayaran: Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</p>
            
            <div class="mt-8">
                <button id="pay-button" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-primary hover:bg-secondary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                    Bayar Sekarang
                </button>
            </div>
            
            <p class="mt-4 text-sm text-gray-500">Klik tombol di atas untuk melanjutkan pembayaran melalui Midtrans</p>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Include Midtrans Snap.js -->
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const payButton = document.getElementById('pay-button');
        const snapToken = '{{ $snapToken }}';
        
        payButton.addEventListener('click', function() {
            // Open Snap payment popup
            snap.pay(snapToken, {
                // Optional callbacks
                onSuccess: function(result) {
                    // Payment success - send result to server
                    updatePaymentStatus('{{ $transaction->id }}', result, 'success');
                },
                onPending: function(result) {
                    // Payment pending - redirect without changing status
                    window.location.href = "{{ route('checkout.success', $transaction->id) }}";
                },
                onError: function(result) {
                    // Payment error
                    console.log(result);
                    alert('Pembayaran gagal. Silakan coba lagi nanti.');
                },
                onClose: function() {
                    // Customer closed the payment popup without completing payment
                    alert('Jendela pembayaran ditutup. Pesanan Anda masih menunggu pembayaran.');
                }
            });
        });
        
        // Function to update payment status via AJAX
        function updatePaymentStatus(transactionId, result, status) {
            // Create a form to submit the data
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = "{{ route('checkout.update-status') }}";
            
            // Add CSRF token
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            form.appendChild(csrfToken);
            
            // Add transaction ID
            const transactionIdInput = document.createElement('input');
            transactionIdInput.type = 'hidden';
            transactionIdInput.name = 'transaction_id';
            transactionIdInput.value = transactionId;
            form.appendChild(transactionIdInput);
            
            // Add status
            const statusInput = document.createElement('input');
            statusInput.type = 'hidden';
            statusInput.name = 'status';
            statusInput.value = status;
            form.appendChild(statusInput);
            
            // Add Midtrans transaction ID
            const midtransTransactionId = document.createElement('input');
            midtransTransactionId.type = 'hidden';
            midtransTransactionId.name = 'midtrans_transaction_id';
            midtransTransactionId.value = result.transaction_id || '';
            form.appendChild(midtransTransactionId);
            
            // Add result JSON
            const resultInput = document.createElement('input');
            resultInput.type = 'hidden';
            resultInput.name = 'result';
            resultInput.value = JSON.stringify(result);
            form.appendChild(resultInput);
            
            // Submit the form
            document.body.appendChild(form);
            form.submit();
        }
    });
</script>
@endpush