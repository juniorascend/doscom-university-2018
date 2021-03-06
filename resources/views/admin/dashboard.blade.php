@extends('layouts.app') @section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            @if(session('msg'))
            <div class="alert alert-warning" role="alert" id="alert-ragister">
                <h4>
                    {{session('msg')}}
                </h4>
                <p align="right" onclick="hide()" style="cursor:pointer">
                    <b>X</b>
                </p>
            </div>
            @endif
        </div>
        <script>
            function hide() {
                var divId = document.getElementById('alert-ragister');
                divId.style.display = "none";
            }
        </script>
        @foreach($kelas as $kelas)
        <div class="col-md-3">
            <div class="panel card panel-default">
                <div class="panel-heading" class="bg-info">
                    <b>
                        <h3 style="text-transform:capitalize">{{$kelas->nama}}
                            <a style="text-align:right;" href="{{route('plusCounter',$kelas->id)}}" class="btn btn-raised btn-sm btn-success">
                                <b>+</b>
                            </a>
                            <a style="text-align:right;" href="{{route('minCounter',$kelas->id)}}" class="btn btn-raised btn-sm btn-warning">
                                <b>-</b>
                            </a>
                        </h3>
                    </b>
                </div>
                <div class="panel-body">
                    Status :
                    <b>@if($kelas->jumlah != 0 and $kelas->status == 'penuh') Ditutup @else {{$kelas->status}} @endif
                    </b>
                    <br> tersedia
                    <b>{{$kelas->jumlah}} peserta</b>
                </div>
                <div class="panel-footer" style="text-align:right">
                    <a class="btn btn-sm btn-raised btn-info" href="{{route('detail-kelas',$kelas->nama)}}">detail</a>
                    @if($kelas->status == 'sisa')
                    <a href="{{route('tutup-kelas',$kelas->nama)}}" class="btn btn-sm btn-raised btn-danger">Tutup</a>
                    @elseif($kelas->status == 'penuh')
                    <a href="{{route('buka-kelas',$kelas->nama)}}" class="btn btn-sm btn-raised btn-info">Buka</a>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
        <div class="col-md-3">
            <div class="panel card panel-default">
                <div class="panel-heading" class="bg-info">
                    <b>
                        <h3 style="text-transform:capitalize" class="alert alert-success">Transaksi</h3>
                    </b>
                </div>
                <div class="panel-body">
                    <p>
                        lunas :
                        <b>{{$lunas}}</b>
                    </p>
                    <p>
                        belum lunas :
                        <b>{{$peserta->count() - $lunas}}</b>
                    </p>
                    <p>
                        total terkumpul :
                        <b>{{$total_uang_tekumpul}}</b>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <br>
    <br>
    <br>
    <div class="row">
        <div id="admin" class="col-md-12">
            <div class="card material-table">
                <div class="table-header">
                    <span class="table-title">Total Semua Peserta : <b>{{$peserta->count()}}</b></span>
                </div>
                <table id="datatable" style="width:100%">
                    <thead>
                        <tr>
                            <th width="10%">Nama</th>
                            <th width="20%">Email</th>
                            <!-- <th>NoHp</th> -->
                            <!-- <th>Status</th> -->
                            <th width="20%">Transaksi</th>
                            <th width="12%">Status Pembayaran</th>
                            <th>Kelas</th>
                            <th width="5%">Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <!-- <th>NoHp</th> -->
                            <!-- <th>Status</th> -->
                            <th>Transaksi</th>
                            <th>Status Pembayaran</th>
                            <th>Kelas</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @if($peserta->count() > 0) @foreach($peserta as $peserta)
                        <tr id="@php $nametag=strtolower($peserta->nama); @endphp{{$nametag}}">
                            <td>{{$peserta->nama}}</td>
                            <td>{{$peserta->email}}</td>
                            <!-- <td>{{$peserta->nohp}}</td> -->
                            <!-- <td>{{$peserta->status_peserta}}</td> -->
                            <td>
                                <b>[ tot ]</b> Rp {{$peserta->total_pembayaran}}
                                <br>
                                <b>[ kekurangan ]</b> Rp {{$peserta->kekurangan_pembayaran}}
                            </td>
                            <td>

                                @if($peserta->status_pembayaran != 'lunas')
                                <a href="{{route('pelunasan',$peserta->id)}}" class="btn btn-sm btn-warning">
                                    {{$peserta->status_pembayaran}}
                                </a>
                                @else
                                <p href="" class="btn btn-sm btn-success">
                                    {{$peserta->status_pembayaran}}
                                </p>
                                @endif
                            </td>
                            <td>
                                @foreach(\App\Peserta::getKelas($peserta->id) as $kelas) @if($peserta->status_pembayaran != 'lunas')
                                <p class="btn btn-sm btn-raised btn-danger">
                                    {{$kelas}}
                                </p>
                                @else
                                <p class="btn btn-raised btn-sm btn-success">
                                    {{$kelas}}
                                </p>
                                @endif @endforeach
                            </td>
                            <td style="width:5%">
                                <a href="{{route('delete-peserta',$peserta->id)}}" class="btn btn-sm btn-raised btn-danger">
                                    <b>X</b>
                                </a>
                            </td>
                        </tr>
                        @endforeach @else
                        <tr>
                            <td colspan="8">
                                <p class="alert" style="color:#FF0034" align="center">
                                    Tidak Ada Data Ditemukan
                                </p>
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection