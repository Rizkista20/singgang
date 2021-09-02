<div class="panel-header">
    <div class="page-inner py-4">
        <h2 class="pb-3 fw-bold">Progress</h2>
        <div class="progress ht-1 mb-5" style="height: 4px;">
            <div class="progress-bar" role="progressbar" style="width: 5%; height: 4px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
    </div>
</div>

<div class="page-inner mt--5">
        <div class="card mt--2">
            <div class="card-header">
                <div class="row">
                    <button class="btn btn-warning m-2" name="tambah_progress" id="tambah_progress" style="padding:5px 10px 5px 10px;">
                        <span class="btn-label mr-1"><i class="fa fa-plus"></i></span>Tambah Progress
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatable_progress" class="display table table-striped table-hover" >
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Pegawai</th>
                                <th>Ketegori</th>
                                <th>Jumlah</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
    </div>
</div>

<div class="modal fade" id="ProgressAdd" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form id="form_add_kategori" method="POST" enctype="multipart/form-data" accept-charset="utf-8">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title">Progress</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-group">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Pegawai : <span class="text-danger">*</span> </label>
                                <select class="form-control" name="pegawai" id="pegawai" >
                                <option value="">Pilih Pegawai</option>
                                <?php foreach ($pegawai as $list) { ?>
                                    <option value="<?= $list->id_pengguna ?>"><?= $list->nama ?></option>
                                <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Kategori : <span class="text-danger">*</span> </label>
                                <select class="form-control" name="kategori" id="kategori" >
                                <option value="">Pilih Kategori</option>
                                <?php foreach ($kategori as $list) { ?>
                                    <option value="<?= $list->id_kategori ?>"><?= $list->nama_kategori ?></option>
                                <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Jumlah : <span class="text-danger">*</span> </label>
                                <input type="text" class="form-control" data-type="currency" style="text-align: right;" name="jumlah" id="jumlah" placeholder="0">
                            </div>
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Tanggal : <span class="text-danger">*</span> </label>
                                <input type="text" class="form-control" name="tanggal" id="tanggal" style="cursor:pointer; background: #fff !important;" readonly>
                            </div>
                        </div>
                    </div>
                </div> 
                </div>
                <div class="modal-footer">
                    <input class="btn btn-primary" type="hidden" name="edit_Progress" id="edit_Progress" value="Edit" style="padding:9px" size="7" readonly>
                    <input class="btn btn-primary" type="text" name="add_Progress" id="add_Progress" value="Tambah" style="padding:9px" size="7" readonly>
                </div>
            </div>
        </form>
    </div>
</div>

