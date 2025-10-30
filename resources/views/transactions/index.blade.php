@extends('layouts.app')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold text-red-900">TRANSAKSI</h1>
        <a href="{{ route('transaksi.history') }}" 
           class="bg-red-800 text-white px-4 py-2 rounded-lg hover:bg-red-700">
           Riwayat Transaksi
        </a>
    </div>

    <div class="grid grid-cols-3 gap-4">
        <!-- Bagian kiri: daftar topping -->
        <div class="col-span-2 grid grid-cols-3 gap-4">
            @foreach ($toppings as $tp)
                <div class="bg-white rounded-xl shadow p-3 text-center">
                    <img src="{{ asset('storage/'.$tp->tp_image) }}" 
                         alt="{{ $tp->tp_name }}" 
                         class="w-28 h-28 object-cover mx-auto rounded-lg mb-2">

                    <p class="font-semibold text-gray-700">{{ $tp->tp_name }}</p>
                    <p class="text-sm text-gray-500">Stok: {{ $tp->tp_stock }}</p>
                    <p class="text-sm text-gray-700">Rp {{ number_format($tp->tp_price, 0, ',', '.') }}</p>

                    <div class="flex justify-center items-center gap-3 mt-2">
                        <button class="bg-red-700 text-white px-3 py-1 rounded add-item"
                                data-id="{{ $tp->tp_id }}"
                                data-name="{{ $tp->tp_name }}"
                                data-price="{{ $tp->tp_price }}">+
                        </button>
                        <button class="bg-gray-300 text-black px-3 py-1 rounded remove-item"
                                data-id="{{ $tp->tp_id }}">−
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Bagian kanan: daftar pesanan -->
        <div class="col-span-1 bg-white rounded-xl shadow p-4">
            <h2 class="font-bold text-lg mb-3">Daftar Pesanan</h2>
            <ul id="cart-list" class="space-y-2"></ul>
            <hr class="my-3">

            <div class="flex justify-between font-bold text-lg">
                <span>TOTAL</span>
                <span id="total-amount">Rp 0</span>
            </div>

            <button id="pay-button" 
                    class="w-full mt-4 bg-red-700 text-white py-2 rounded hover:bg-red-600">
                Bayar
            </button>
        </div>
    </div>
</div>

<script>
    let cart = [];
    const cartList = document.getElementById('cart-list');
    const totalAmount = document.getElementById('total-amount');

    function updateCart() {
        cartList.innerHTML = '';
        let total = 0;
        cart.forEach(item => {
            total += item.subtotal;
            const li = document.createElement('li');
            li.classList.add('flex', 'justify-between', 'items-center', 'text-sm');
            li.innerHTML = `
                <span>${item.name} × ${item.qty}</span>
                <span>Rp ${item.subtotal.toLocaleString('id-ID')}</span>
                <button class="text-red-600 text-xs remove-item-btn" data-id="${item.id}">x</button>
            `;
            cartList.appendChild(li);
        });
        totalAmount.textContent = `Rp ${total.toLocaleString('id-ID')}`;
    }

    document.querySelectorAll('.add-item').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            const name = btn.dataset.name;
            const price = parseInt(btn.dataset.price);

            let existing = cart.find(i => i.id === id);
            if (existing) {
                existing.qty++;
                existing.subtotal = existing.qty * price;
            } else {
                cart.push({ id, name, price, qty: 1, subtotal: price });
            }
            updateCart();
        });
    });

    document.addEventListener('click', e => {
        if (e.target.classList.contains('remove-item-btn')) {
            const id = e.target.dataset.id;
            cart = cart.filter(i => i.id !== id);
            updateCart();
        }
    });

    document.getElementById('pay-button').addEventListener('click', () => {
        if (cart.length === 0) return alert('Belum ada item di keranjang');

        const total = cart.reduce((sum, i) => sum + i.subtotal, 0);
        const payment = prompt(`Total belanja Rp ${total.toLocaleString('id-ID')}\nMasukkan jumlah bayar:`);

        if (payment && payment >= total) {
            fetch('{{ route('transaksi.store') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    total: total,
                    payment: payment,
                    change: payment - total,
                    items: cart
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert('Transaksi berhasil!');
                    location.reload();
                } else {
                    alert('Transaksi gagal: ' + data.message);
                }
            });
        } else {
            alert('Pembayaran tidak valid');
        }
    });
</script>
@endsection
