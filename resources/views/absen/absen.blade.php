@extends('layouts.template')
@section('content')
  <section class="content">
    <div class="container-fluid">
      <div class="block-header">
          <h2>
              DATA ABSEN
          </h2>
      </div>
      <div class="row clearfix">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <div class="card">
                  <div class="header">
                      <h2>
                          DATA SEMUA ABSEN
                      </h2>
                      <ul class="header-dropdown m-r--5">
                          <li class="dropdown">
                              <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                  <i class="material-icons">more_vert</i>
                              </a>
                              <ul class="dropdown-menu pull-right">
                                  <li><a href="javascript:void(0)" onclick="addAbsent()">Tambah Absen</a></li>
                              </ul>
                          </li>
                      </ul>
                  </div>
                  <div class="body">
                    @if (Session::has('alert'))
                      <div class="alert {{Session::get('alert-class')}} alert-dismissible" role="alert">
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                          {{Session::get('alert')}}
                      </div>
                    @endif
                      <table class="table table-bordered table-striped table-hover js-basic-example dataTable" width="100%">
                          <thead>
                              <tr>
                                  <th width="3%"></th>
                                  <th>Tanggal</th>
                                  <th>Absen Masuk</th>
                                  <th>Absen Keluar</th>
                                  <th>User</th>
                              </tr>
                          </thead>
                          <tfoot>
                              <tr>
                                <th width="3%"></th>
                                <th>Tanggal</th>
                                <th>Absen Masuk</th>
                                <th>Absen Keluar</th>
                                <th>User</th>
                              </tr>
                          </tfoot>
                          <tbody>
                            @foreach ($data as $r)
                              <tr>
                                <td>
                                  <div class="btn-group">
                                      <button type="button" class="btn btn-info btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                        <span class="caret"></span>
                                      </button>
                                      <ul class="dropdown-menu">
                                          <li><a href="javascript:void(0);" class=" waves-effect waves-block" onclick="hapus({{$r->id}},'{{date('d F Y',strtotime($r->tanggal))}}')">Hapus</a></li>
                                      </ul>
                                  </div>
                                </td>
                                <td><a href="{{url('kepegawaian/absen/absensi/'.$r->id)}}">{{date('d F Y',strtotime($r->tanggal))}}</a></td>
                                @php
                                 $masuk = 0;
                                 $keluar = 0;
                                  foreach ($r->Kehadiran as $k) {
                                    if ($k->absen_masuk == 1) {
                                      $masuk++;
                                    }
                                    if ($k->absen_keluar == 1 ) {
                                      $keluar++;
                                    }
                                  }
                                @endphp
                                <td>{{$masuk}} pegawai</td>
                                <td>{{$keluar}} pegawai</td>
                                <td>{{$r->User->name}}</td>
                              </tr>
                            @endforeach
                          </tbody>
                      </table>
                  </div>
              </div>
          </div>
      </div>
    </div>
    <div class="modal fade" id="modalAbsent" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
      <div class="modal-dialog">
        <form class="" action="{{url('kepegawaian/absen')}}" method="post">
          {{ csrf_field() }}
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="">Tambah Absen</h4>
            </div>
            <div class="modal-body">
              <div class="row clearfix">
                  <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                      <label for="email_address_2">Tanggal</label>
                  </div>
                  <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                    <div class="form-group">
                        <div class="form-line">
                            <input type="text" class="datepicker form-control" placeholder="Pilih tanggal" name="tanggal" required="">
                        </div>
                    </div>
                  </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Keluar</button>
              <input type="submit" value="Buat" class="btn btn-primary">
            </div>
          </div>
        </form>
      </div>
    </div>
    <form class="hidden" method="post" id="formHapus">
      <input type="hidden" name="_method" value="DELETE">
      {{csrf_field()}}
    </form>
  </section>
@endsection

@section('js')
  <script type="text/javascript">
    function hapus(id,txt){
        bootbox.confirm({
          message: "Apakah anda ingin menghapus data absen : "+txt+" ?",
          buttons: {
              confirm: {
                  label: 'Hapus',
                  className: 'btn-success'
              },
              cancel: {
                  label: 'Kembali',
                  className: 'btn-danger'
              }
          },
          callback: function (result) {
              if (result) {
                $('#formHapus').attr('action', '{{url('kepegawaian/absen')}}/'+id);
                $('#formHapus').submit();
              }
          }
      });
    }

    function addAbsent() {
      $('#modalAbsent').modal('show');
    }
  </script>
@endsection
