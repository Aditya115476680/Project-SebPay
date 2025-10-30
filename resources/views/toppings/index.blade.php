<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Topping | SebPay</title>
    <style>
        body {
            background-color: #FFF7D5;
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 90%;
            max-width: 1000px;
            margin: 50px auto;
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            padding: 30px;
        }
        h1 {
            color: #3E0703;
            text-align: center;
            margin-bottom: 30px;
        }
        .btn {
            background-color: #660B05;
            color: #FFF7D5;
            border: none;
            padding: 10px 18px;
            border-radius: 10px;
            cursor: pointer;
            font-weight: bold;
            transition: all 0.2s ease-in-out;
            transform: scale(1);
        }
        .btn:hover {
            background-color: #3E0703;
            background-color: #3E0703;
            transform: scale(1.05);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
        }
        th, td {
            border: 1px solid #eee;
            padding: 10px 12px;
            text-align: center;
        }
        th {
            background-color: #3E0703;
            color: white;
        }
        td {
            background-color: #FFF7D5;
            color: #3E0703;
        }
        .btn-edit {
            background-color: #A52A2A;
        }
        .btn-delete {
            background-color: #8B0000;
        }
        .actions button {
            margin: 0 3px;
        }
        .success {
            text-align: center;
            background: #dff0d8;
            color: #3c763d;
            padding: 10px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        /* === MODAL === */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }
        .modal-content {
            background-color: #FFF7D5;
            margin: 10% auto;
            padding: 30px;
            border: 2px solid #3E0703;
            border-radius: 20px;
            width: 400px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }
        .modal h2 {
            color: #3E0703;
            margin-bottom: 20px;
        }
        input[type="text"], input[type="number"] {
            width: 80%;
            padding: 10px;
            border-radius: 10px;
            border: 1px solid #ccc;
            margin-bottom: 15px;
        }
        .close {
            color: #3E0703;
            float: right;
            font-size: 24px;
            cursor: pointer;
        }
        /* === ANIMASI MODAL === */
        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.95); }
         to { opacity: 1; transform: scale(1); }
        }
        @keyframes fadeOut {
            from { opacity: 1; transform: scale(1); }
            to { opacity: 0; transform: scale(0.95); }
        }
        .modal.show .modal-content {
            animation: fadeIn 0.25s ease forwards;
        }
        .modal.hide .modal-content {
            animation: fadeOut 0.25s ease forwards;
        }

    </style>
</head>
<body>
    <div class="container">
        <h1>Kelola Topping 🍳</h1>

        @if(session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif

        <div style="text-align: right; margin-bottom: 15px;">
            <button id="openModal" class="btn">+ Tambah Topping</button>
        </div>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Topping</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($topping as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->stok }}</td>
                        <td class="actions">
                            <button class="btn btn-edit editBtn" 
                                data-id="{{ $item->id }}" 
                                data-nama="{{ $item->nama }}" 
                                data-stok="{{ $item->stok }}">
                                Edit
                            </button>

                            <form action="{{ route('topping.destroy', $item->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-delete" onclick="return confirm('Yakin mau hapus topping ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal Tambah Topping -->
    <div id="tambahModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeModal">&times;</span>
            <h2>Tambah Topping</h2>
            <form action="{{ route('topping.store') }}" method="POST">
                @csrf
                <input type="text" name="nama" placeholder="Nama Topping" required><br>
                <input type="number" name="stok" placeholder="Stok Awal" min="0" required><br>
                <button type="submit" class="btn">Simpan</button>
            </form>
        </div>
    </div>

    <!-- Modal Edit Topping -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeEdit">&times;</span>
            <h2>Edit Topping</h2>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <input type="text" id="editNama" name="nama" required><br>
                <input type="number" id="editStok" name="stok" min="0" required><br>
                <button type="submit" class="btn">Update</button>
            </form>
        </div>
    </div>

    <script>
        // Tambah modal
        const modalTambah = document.getElementById("tambahModal");
        const openTambah = document.getElementById("openModal");
        const closeTambah = document.getElementById("closeModal");

        openTambah.onclick = () => modalTambah.style.display = "block";
        closeTambah.onclick = () => modalTambah.style.display = "none";
        window.onclick = (e) => { if (e.target == modalTambah) modalTambah.style.display = "none"; }

        // Edit modal
        const modalEdit = document.getElementById("editModal");
        const closeEdit = document.getElementById("closeEdit");
        const editButtons = document.querySelectorAll(".editBtn");

        editButtons.forEach(btn => {
            btn.addEventListener("click", function() {
                const id = this.dataset.id;
                const nama = this.dataset.nama;
                const stok = this.dataset.stok;

                document.getElementById("editNama").value = nama;
                document.getElementById("editStok").value = stok;
                document.getElementById("editForm").action = `/topping/${id}`;

                modalEdit.style.display = "block";
            });
        });

        closeEdit.onclick = () => modalEdit.style.display = "none";
        window.onclick = (e) => { if (e.target == modalEdit) modalEdit.style.display = "none"; }
        function showModal(modal) {
    modal.classList.add('show');
    modal.classList.remove('hide');
    modal.style.display = "block";
}

    function hideModal(modal) {
    modal.classList.remove('show');
    modal.classList.add('hide');
    setTimeout(() => { modal.style.display = "none"; }, 200);
}

    // Tambah Modal
    openTambah.onclick = () => showModal(modalTambah);
    closeTambah.onclick = () => hideModal(modalTambah);

    // Edit Modal
    editButtons.forEach(btn => {
    btn.addEventListener("click", function() {
        const id = this.dataset.id;
        const nama = this.dataset.nama;
        const stok = this.dataset.stok;

        document.getElementById("editNama").value = nama;
        document.getElementById("editStok").value = stok;
        document.getElementById("editForm").action = `/topping/${id}`;

        showModal(modalEdit);
    });
});
closeEdit.onclick = () => hideModal(modalEdit);

// Klik luar modal
window.onclick = (e) => {
    if (e.target == modalTambah) hideModal(modalTambah);
    if (e.target == modalEdit) hideModal(modalEdit);
}

    </script>
</body>
</html>
