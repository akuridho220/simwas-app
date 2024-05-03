@extends('layouts.app')

@section('title', $pp->jenis)

@push('style')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- CSS Libraries -->
    <link
        href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.13.4/af-2.5.3/b-2.3.6/b-colvis-2.3.6/b-html5-2.3.6/b-print-2.3.6/cr-1.6.2/date-1.4.1/fc-4.2.2/fh-3.3.2/kt-2.9.0/r-2.4.1/rg-1.3.1/rr-1.3.3/sc-2.1.1/sb-1.4.2/sp-2.1.2/sl-1.6.2/sr-1.2.2/datatables.min.css"
        rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('library') }}/sweetalert2/dist/sweetalert2.min.css">
@endpush

@section('main')
    @include('components.analis-sdm-header')
    @include('components.analis-sdm-sidebar')
    <div class="main-content">
        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Tambah Nama Pengembangan Profesi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="/analis-sdm/namaPp" method="post">
                        <div class="modal-body">
                            @csrf  
                            <input type="hidden" name="is_aktif" value="1">
                            <div class="form-group">
                                <input type="hidden" id="pp_id" name="pp_id" value="{{ $pp->id }}">
                                <label for="pp">Jenis Pengembangan Profesi</label>
                                <input type="text" class="form-control" disabled value="{{ $pp->jenis }}">
                                @if ($pp->id == 3)
                                    <label for="peserta" class="mt-3">Peserta</label>
                                    <select required id="peserta" name="peserta" class="form-control select2">
                                        <option value="" selected disabled>Pilih Peserta</option>
                                        <option value="100">Pengawasan (Auditor Pertama)</option>
                                        <option value="200">Auditor Muda</option>
                                        <option value="300">Auditor Madya/Utama</option>
                                        <option value="400">Semua Jenjang</option>
                                    </select>
                                @endif
                                <label for="nama" class="mt-3">Nama Pengembangan Profesi</label>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama') }}">
                                @error('nama')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="section-header">
                <h1>Pengembangan Profesi {{ $pp->jenis }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="/analis-sdm">Dashboard</a></div>
                    <div class="breadcrumb-item">Master Pengembangan Profesi</div>
                </div>
            </div>

            @if (session()->has('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            
            <div class="section-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="pt-1 pb-1 m-4">
                                    <div class="btn btn-success btn-lg btn-round" data-toggle="modal"
                                    data-target="#staticBackdrop">
                                        + Tambah
                                    </div>
                                </div>
                                <div class="">
                                    <table class="table table-bordered display responsive" style="background-color: #f6f7f8" id="table-pengelolaan-dokumen-pegawai">
                                        <thead>
                                            <tr>
                                                @if ($pp->id == 3)
                                                    <th>Kode Peserta</th>
                                                    <th>Peserta</th>
                                                    <th>Kode</th>
                                                @else
                                                    <th>No.</th>
                                                @endif
                                                <th>Nama Pengembangan Profesi</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $i = 0;
                                                $kode = 0;   
                                            @endphp
                                            @foreach ($namaPps as $namaPp)
                                            <tr class="table-bordered">
                                                @if ($pp->id == 3)
                                                    <td>{{ $namaPp->peserta }}</td>
                                                    <td>{{ $peserta[$namaPp->peserta] }}</td>
                                                    @if ($namaPp->peserta != $i)
                                                        @php
                                                            $kode = 1;
                                                            $i = $namaPp->peserta;
                                                        @endphp
                                                    @else
                                                        @php
                                                            $kode++;
                                                        @endphp
                                                    @endif
                                                    <td>{{ $i + $kode }}</td>
                                                @else
                                                    <td></td>
                                                @endif
                                                <td>{{ $namaPp->nama }}</td>
                                                @if ($namaPp->is_aktif == "1")
                                                <td>Aktif</td>
                                                <td>
                                                    <form method="post" action="/analis-sdm/namaPp/{{ $namaPp->id }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="nonaktifkan" value="1">
                                                        <input type="hidden" name="is_aktif" value="0">
                                                        <input type="hidden" name="pp_id" value="{{ $pp->id }}">
                                                        <input type="hidden" name="id" value="{{ $namaPp->id }}">
                                                        <button type="submit" class="btn btn-sm btn-danger">Nonaktifkan</button>
                                                    </form>
                                                </td>
                                                @else
                                                    <td>Nonatif</td>
                                                    <td>
                                                        <form method="post" action="/analis-sdm/namaPp/{{ $namaPp->id }}">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="aktifkan" value="1">
                                                            <input type="hidden" name="is_aktif" value="1">
                                                            <input type="hidden" name="pp_id" value="{{ $pp->id }}">
                                                            <input type="hidden" name="id" value="{{ $namaPp->id }}">
                                                            <button type="submit" class="btn btn-sm btn-info">Aktifkan</button>
                                                        </form>
                                                    </td>
                                                @endif
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    {{-- <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script> --}}
    <script src="https://cdn.datatables.net/v/dt/dt-1.13.4/b-2.3.6/b-colvis-2.3.6/datatables.min.js"></script>
    <script src="{{ asset('js') }}/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ asset('js') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset('js') }}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="{{ asset('js') }}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="{{ asset('js') }}/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="{{ asset('js') }}/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="{{ asset('js') }}/plugins/jszip/jszip.min.js"></script>
    <script src="{{ asset('js') }}/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="{{ asset('js') }}/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="{{ asset('js') }}/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="{{ asset('js') }}/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="{{ asset('js') }}/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <script src="{{ asset('library') }}/sweetalert2/dist/sweetalert2.min.js"></script>
    <script src="{{ asset('js') }}/plugins/datatables-rowsgroup/dataTables.rowsGroup.js"></script>
    
    <!-- Page Specific JS File -->
    {{-- <script src="{{ asset('js') }}/page/pegawai-pengelolaan-dokumen.js"></script> --}}
    <script>
        let table = $("#table-pengelolaan-dokumen-pegawai");
        if ($('#pp_id').val() == '3') {
            table
            .DataTable({
                dom: "Bfrtip",
                // responsive: true,
                lengthChange: false,
                autoWidth: false,
                buttons: [],
                rowsGroup: [0, 1],
                // columnDefs: [{
                //     "targets": 0,
                //     "createdCell": function (td, cellData, rowData, row, col) {
                //     $(td).text(row + 1);
                //     }
                // }]
            });
        } else {
            table
            .DataTable({
                dom: "Bfrtip",
                responsive: true,
                lengthChange: false,
                autoWidth: false,
                buttons: [],
                columnDefs: [{
                    "targets": 0,
                    "createdCell": function (td, cellData, rowData, row, col) {
                    $(td).text(row + 1);
                    }
                }]
            });
        }
    </script>

    @if ($errors->any())
        <script>
            $(document).ready(function() {
                $('#staticBackdrop').modal('show');
            });
        </script>
    @endif
@endpush