@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Crud Orders</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Orders</h6>
            <a href="{{ route('orders.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Tambah Order
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered text-center" id="dataorders" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Order</th>
                            <th>Deskripsi</th>
                            <th>Gambar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $order->nama }}</td>
                                <td>{{ $order->deskripsi }}</td>
                                <td>
                                    @if ($order->gambar)
                                        <img src="{{ asset('storage/' . $order->gambar) }}" alt="Order Image" width="100"
                                            class="img-thumbnail">
                                    @else
                                        <span class="text-muted">Tidak Ada Gambar</span>
                                    @endif
                                </td>
                                <td>
                                    <!-- Tombol Edit -->
                                    <button type="button" class="btn btn-warning btn-icon-split btn-sm" data-toggle="modal"
                                        data-target="#editModal-{{ $order->id }}">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-edit"></i>
                                        </span>
                                        <span class="text">Edit</span>
                                    </button>

                                    <!-- Tombol Hapus -->
                                    <button type="button" class="btn btn-danger btn-icon-split btn-sm" data-toggle="modal"
                                        data-target="#deleteModal-{{ $order->id }}">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-trash"></i>
                                        </span>
                                        <span class="text">Hapus</span>
                                    </button>
                                </td>

                                <!-- Modal Edit -->
            <div class="modal fade" id="editModal-{{ $order->id }}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true" data-backdrop="static">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Edit Order</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('orders.update', $order->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="nama-{{ $order->id }}">Nama Order</label>
                                    <input type="text" name="nama" id="nama-{{ $order->id }}" class="form-control" 
                                           value="{{ $order->nama }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="deskripsi-{{ $order->id }}">Deskripsi</label>
                                    <textarea name="deskripsi" id="deskripsi-{{ $order->id }}" class="form-control" rows="3" required>{{ $order->deskripsi }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="gambar-{{ $order->id }}">Gambar</label>
                                    <input type="file" name="gambar" id="gambar-{{ $order->id }}" class="form-control-file">
                                    @if ($order->gambar)
                                        <small class="text-muted">Gambar saat ini: <img src="{{ asset('storage/' . $order->gambar) }}" 
                                               width="50" alt="Order Image"></small>
                                    @endif
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal Hapus -->
            <div class="modal fade" id="deleteModal-{{ $order->id }}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true" data-backdrop="static">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Apakah Anda yakin ingin menghapus order <strong>{{ $order->nama }}</strong>?
                        </div>
                        <div class="modal-footer">
                            <form action="{{ route('orders.destroy', $order->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Tidak Ada Data Orders</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
