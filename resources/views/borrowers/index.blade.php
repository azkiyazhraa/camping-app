@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                <h3 class="fw-bold mb-3">Report Borrowers</h3>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0">Data Peminjam</h4>
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addToolModal">
                                <i class="fas fa-file-pdf"></i> Export PDF
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="basic-datatables"
                                    class="table table-striped table-bordered table-sm small text-wrap">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Invoice</th>
                                            <th>Name</th>
                                            <th>Status</th>
                                            <th>Total Price</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($borrowers as $borrower)
                                            <tr>
                                                <td>{{ $borrower->invoice }}</td>
                                                <td>{{ $borrower->user->name }}</td>
                                                <td>{{ $borrower->status }}</td>
                                                <td class="small">IDR
                                                    {{ number_format($borrower->total_price, 0, ',', '.') }}
                                                </td>
                                                <td class="text-center">
                                                    @if ($borrower->status == 'pending')
                                                        <form action="{{ route('borrowings.approve', $borrower->id) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="submit"
                                                                class="btn btn-success btn-sm">Approve</button>
                                                        </form>
                                                    @endif

                                                    <button type="button" class="btn btn-info btn-sm"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#detailModal{{ $borrower->id }}">
                                                        Detail
                                                    </button>

                                                    @if ($borrower->status == 'borrowed')
                                                        <form action="{{ route('borrowings.return', $borrower->id) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="submit"
                                                                class="btn btn-warning btn-sm">Kembalikan</button>
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @foreach ($borrowers as $borrower)
                                    <div class="modal fade" id="detailModal{{ $borrower->id }}" tabindex="-1"
                                        aria-labelledby="detailModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Detail Peminjaman - {{ $borrower->invoice }}
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">

                                                    {{-- Informasi Umum --}}
                                                    <div class="mb-3">
                                                        <strong>Tanggal Pinjam:</strong>
                                                        {{ \Carbon\Carbon::parse($borrower->borrow_date)->format('d M Y') }}<br>
                                                        <strong>Tanggal Kembali:</strong>
                                                        {{ \Carbon\Carbon::parse($borrower->return_date)->format('d M Y') }}<br>
                                                        <strong>Durasi:</strong> {{ $borrower->long_time_borrowing }} hari
                                                    </div>

                                                    <hr>

                                                    <span class="fw-bold">List Barang</span>

                                                    {{-- Daftar Barang --}}
                                                    <ul class="list-group">
                                                        @foreach ($borrower->details as $detail)
                                                            <li
                                                                class="list-group-item d-flex justify-content-between align-items-center">
                                                                {{ $detail->tool->name }}
                                                                <span class="badge bg-primary rounded-pill">Qty:
                                                                    {{ $detail->qty }}</span>
                                                            </li>
                                                        @endforeach
                                                    </ul>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                            {{ $borrowers->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
