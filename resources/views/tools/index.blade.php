@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                <h3 class="fw-bold mb-3">Tools</h3>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0">Data Tools</h4>
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addToolModal">
                                <i class="bi bi-plus"></i> Add Tool
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="basic-datatables"
                                    class="table table-striped table-bordered table-sm small text-wrap">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Image</th>
                                            <th>Name</th>
                                            <th>Stock</th>
                                            <th>Rental Price</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tools as $tool)
                                            <tr>
                                                <td>
                                                    <img src="{{ asset('storage/' . $tool->image) }}" alt="Tool Image"
                                                        class="img-thumbnail" width="80">
                                                </td>
                                                <td>{{ $tool->name }}</td>
                                                <td>{{ $tool->stock }}</td>
                                                <td class="small">IDR {{ number_format($tool->rental_price, 0, ',', '.') }}
                                                </td>
                                                <td class="text-center">
                                                    <div class="d-flex justify-content-center gap-2">
                                                        <!-- Tombol Edit -->
                                                        <button class="btn btn-warning btn-sm btn-edit"
                                                            data-id="{{ $tool->id }}" data-name="{{ $tool->name }}"
                                                            data-stock="{{ $tool->stock }}"
                                                            data-rental_price="{{ $tool->rental_price }}"
                                                            data-description="{{ $tool->description }}"
                                                            data-image="{{ asset('storage/' . $tool->image) }}"
                                                            data-bs-toggle="modal" data-bs-target="#editToolModal">
                                                            <i class="bi bi-pencil-square"></i>
                                                        </button>

                                                        <form action="{{ route('tools.destroy', $tool->id) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button" class="btn btn-danger btn-sm btn-delete">
                                                                <i class="bi bi-trash3"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{ $tools->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Tambah Tool -->
        <div class="modal fade" id="addToolModal" tabindex="-1" aria-labelledby="addToolModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('tools.store') }}" method="POST" enctype="multipart/form-data"
                    class="modal-content">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addToolModalLabel">Add Tool</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="toolName" class="form-label">Tool Name</label>
                            <input type="text" class="form-control" id="toolName" name="name" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="toolStock" class="form-label">Stock</label>
                                    <input type="number" class="form-control" id="toolStock" name="stock" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="rentalPrice" class="form-label">Rental Price</label>
                                    <input type="number" class="form-control" id="rentalPrice" name="rental_price"
                                        required>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="toolDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="toolDescription" name="description" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="toolImage" class="form-label">Image</label>
                            <input type="file" class="form-control" id="toolImage" name="image" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Add Tool</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal Edit Tool -->
        <div class="modal fade" id="editToolModal" tabindex="-1" aria-labelledby="editToolModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <form id="editToolForm" method="POST" enctype="multipart/form-data" class="modal-content">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="editToolModalLabel">Edit Tool</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="editToolId">
                        <div class="mb-3">
                            <label for="editToolName" class="form-label">Tool Name</label>
                            <input type="text" class="form-control" id="editToolName" name="name" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editToolStock" class="form-label">Stock</label>
                                    <input type="number" class="form-control" id="editToolStock" name="stock"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editToolRentalPrice" class="form-label">Rental Price</label>
                                    <input type="number" class="form-control" id="editToolRentalPrice"
                                        name="rental_price" required>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="editToolDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="editToolDescription" name="description" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Current Image</label><br>
                            <img id="editToolImagePreview" src="" width="100" class="img-thumbnail mb-2">
                            <input type="file" class="form-control" name="image">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update Tool</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection
