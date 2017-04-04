@extends('layouts.template')
@section('content')
  <section  class="content">
    <div class="container-fluid">
      <div class="block-header">
          <h2>
              NOTA PENJUALAN
          </h2>
      </div>
      <div class="row clearfix">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
              <div class="header">
                <h2>Nota Nomor : {{$data[0]->id}}</h2>
                <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons">more_vert</i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="{{url('penjualan')}}">Kembali</a></li>

                        </ul>
                    </li>
                </ul>
              </div>

              <div class="body" >
                <button type="button" class="btn bg-red waves-effect" onclick="printNota()">
                    <i class="material-icons">print</i>
                </button>
                <hr>
                <div id="printArea" style="font-size:10px">
                  @foreach ($data as $r)
                    <div class="row">
                      <div class="col-md-3">
                        <h5>UD. KEMBANG MERTA</h5>
                        <p><h6>NO NOTA : {{$r->id}}</h6></p>
                      </div>
                      <div class="col-md-3 text-right">
                        <p>Badung {{date('d-m-Y',strtotime($r->tanggal_penjualan))}}</p>
                        <p>Nama : {{$r->pembeli_penjualan}}</p>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <table class="table table-bordered">
                          <thead>
                            <th>BANYAKNYA</th>
                            <th>NAMA BARANG</th>
                            <th>HARGA</th>
                            <th>JUMLAH</th>
                          </thead>
                          <tfoot>
                            <th colspan="3" class="text-right">TOTAL</th>
                            @php
                              $count = 0;
                              foreach ($r->Penjualanitem as $j) {
                                $count += ($j->harga * $j->jumlah);
                              }
                            @endphp
                            <th>Rp. {{number_format($count,2,',','.')}}</th>
                          </tfoot>
                          <tbody>
                            @foreach ($r->Penjualanitem as $p)
                              <tr>
                                <td>{{number_format($p->jumlah,2,',','.')}} {{($p->Gudang->tipe_barang_gudang == 'sekam') ? 'truk':'kg'}}</td>
                                <td>{{$p->Gudang->nama_barang_gudang}}</td>
                                <td>Rp. {{number_format($p->harga)}}</td>
                                <td>Rp. {{number_format(($p->harga * $p->jumlah),2,',','.')}}</td>
                              </tr>
                            @endforeach
                          </tbody>
                        </table>
                        <table class="table table-bordered">
                          <tr>
                            <td><b>NO. NOTA</b></td>
                            <td>{{$r->id}}</td>
                            <td><b>Jam</b></td>
                            <td>{{date('H:i:s',strtotime($jam))}}</td>
                          </tr>
                          <tr>
                            <td><b>Kasir</b></td>
                            <td>{{$r->User->name}}</td>
                            <td><b>Tanggal</b></td>
                            <td>{{date('d-m-Y',strtotime($r->tanggal_penjualan))}}</td>
                          </tr>
                        </table>
                        <span><b>NB.</b> Barang yang sudah dibeli tidak dapat dikembalikan kecuali ada perjanjian.</span>
                        <table class="table">
                          <thead>
                            <tr >
                              <th class="text-center">Tanda Terima</th>
                              <th class="text-center">Hormat Kami</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr class="text-center">
                              <td><div style="padding-top: 70px;">(_______________)</div></td>
                              <td ><div style="padding-top: 70px;">( {{Auth::user()->name}})</div></td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  @endforeach
                </div>
              </div>
            </div>
          </div>
      </div>
    </div>
  </section>
@endsection
@section('js')
  <script src="{{asset('plugins/print/printarea.js')}}" charset="utf-8"></script>
  <script type="text/javascript">
    function printNota(){
      var mode = 'iframe'; // popup
      var close = mode == "popup";
      var options = { mode : mode, popClose : close};
      $("#printArea").printArea( options );
    }
  </script>
@endsection
