@extends('layouts.app')

@section('title', 'Detail Usulan ST Pengembangan Profesi')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
@endpush

@section('header-app')
@endsection
@section('sidebar')
@endsection

@section('main')
    @include('components.inspektur-header')
    @include('components.inspektur-sidebar')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Detail Usulan ST Pengembangan Profesi</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="/inspektur/dashboard">Dashboard</a></div>
                    <div class="breadcrumb-item active"><a href="/inspektur/st-pp">ST Pengembangan Profesi</a></div>
                    <div class="breadcrumb-item">Detail</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-6">
                                    <h2>Detail Usulan</h2>       
                                    <div class="pt-1 pb-1 m-4">
                                        <a href="/inspektur/st-pp/edit"
                                            class="btn btn-primary btn-lg btn-round">
                                            Edit Usulan
                                        </a>
                                    </div>
                                    <table class="table">
                                        <tr>
                                            <th>Nomor Surat</th>
                                            <th>:</th>
                                            <td>
                                            @if ($usulan->status == 0)
                                            <div class="badge badge-warning">Menunggu Persetujuan</div>
                                            @elseif ($usulan->status == 1)
                                                <div class="badge badge-danger">Tidak Disetujui</div>
                                            @else
                                                {{ $usulan->no_st }}
                                            @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Status</th>
                                            <th>:</th>
                                            <td>
                                            @if ($usulan->status === 0)
                                                <div class="badge badge-warning">Menunggu Persetujuan</div>
                                            @elseif ($usulan->status === 1)
                                                <div class="badge badge-danger">Tidak Disetujui</div>
                                            @else
                                                <div class="badge badge-success">Disetujui</div>
                                            @endif
                                            </td>
                                        </tr>
                                        <tr>
                                        <th>Tanggal</th>
                                        <th>:</th>
                                        <td>{{ $usulan->tanggal }}</td>
                                        </tr>
                                        <tr>
                                        <th>Jenis PP</th>
                                        <th>:</th>
                                        <td>{{ $usulan->pp->jenis }}</td>
                                        </tr>
                                        <tr>
                                        <th>Nama PP</th>
                                        <th>:</th>
                                        <td>{{ $usulan->nama_pp }}</td>
                                        </tr>
                                        <tr>
                                        <th>Untuk Melaksanakan</th>
                                        <th>:</th>
                                        <td>{{ $usulan->melaksanakan }}</td>
                                        </tr>
                                        <tr>
                                        <th>Mulai-Selesai</th>
                                        <th>:</th>
                                        <td>{{ $usulan->mulai." - ".$usulan->selesai }}</td>
                                        </tr>
                                        <tr>
                                        <th>Penandatangan</th>
                                        <th>:</th>
                                        <td><?php if ($usulan->penandatangan === 0) {
                                            echo "Inspektur Utama";
                                        } elseif ($usulan->penandatangan === 1) {
                                            echo "Inspektur Wilayah I";
                                        } elseif ($usulan->penandatangan === 2) {
                                            echo "Inspektur Wilayah II";
                                        } elseif ($usulan->penandatangan === 3) {
                                            echo "Inspektur Wilayah III";
                                        } else {
                                            echo "Kepala Bagian Umum";
                                        }?>
                                        </td>
                                        </tr>
                                        <tr>
                                        <th>E-Sign</th>
                                        <th>:</th>
                                        <td>@if($usulan->is_esign)
                                            {{ "Ya" }}
                                        @else
                                            {{ "Tidak" }}
                                        @endif
                                        </td>
                                        </tr>
                                        <tr>
                                        <th>File</th>
                                        <th>:</th>
                                        <td><a target="blank" href="{{ $usulan->file }}" class="btn btn-icon btn-primary" download><i class="fa fa-download"></i></a></td>
                                        </tr>
                                        <tr>
                                        <th>Sertifikat</th>
                                        <th>:</th>
                                        <td>
                                            @if ($usulan->status == 2)
                                                <a href="#" class="btn btn-icon btn-warning"><i class="fa fa-upload"></i></a>
                                            @elseif ($usulan->status == 3)
                                                Menunggu Persetujuan
                                            @elseif ($usulan->status == 4)
                                                <div class="badge badge-danger">Tidak Disetujui</div>
                                            @elseif ($usulan->status == 5)
                                                <a target="blank" href="{{ $usulan->sertifikat }}" class="btn btn-icon btn-primary" download><i class="fa fa-download"></i></a>
                                            @endif
                                        </td>
                                        </tr>
                                        <tr>
                                        <th>Tanggal Upload Sertifikat</th>
                                        <th>:</th>
                                        <td>{{ ($usulan->status == 3 || $usulan->status == 4 || $usulan->status == 5) ? $usulan->tanggal_sertifikat : '' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Catatan</th>
                                            <th>:</th>
                                            <td>{{ $usulan->catatan }}</td>
                                        </tr>
                                    </table>
                                        </div>
                                    </div>
                                    @if ($usulan->status == 0 || $usulan->status == 3)
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="pt-1 pb-1 m-4 d-flex justify-content-start">
                                                    <a href="/inspektur/st-pp/{{ $usulan->id }}/edit" class="btn btn-primary mr-2">
                                                        Edit Usulan
                                                    </a>
                                                    <form action="/inspektur/st-pp/{{ $usulan->id }}" method="post" class="mr-2">
                                                        @csrf
                                                        @method('PUT')    
                                                        <input type="hidden" name="status" value="2">
                                                        <input type="hidden" name="id" value="{{ $usulan->id }}">
                                                        <button type="submit" class="btn btn-success">Setujui Usulan</button>
                                                    </form>
                                                    <form action="/inspektur/st-pp/{{ $usulan->id }}" method="post">
                                                        @csrf
                                                        @method('PUT')    
                                                        <input type="hidden" name="status" value="1">
                                                        <input type="hidden" name="id" value="{{ $usulan->id }}">
                                                        <button type="submit" class="btn btn-danger">Tidak Setujui Usulan</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
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
    {{-- <script src="assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script src="assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script> --}}
    <script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    {{-- <script src="{{ asset() }}"></script> --}}
    {{-- <script src="{{ asset() }}"></script> --}}
    <script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/modules-datatables.js') }}"></script>
@endpush
