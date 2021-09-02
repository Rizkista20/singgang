<div class="panel-header">
    <div class="page-inner py-4">
        <!-- <div class="alert alert-warning" role="alert">                   
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            Selamat Datang <?= $pengguna['email']; ?>
        </div> -->
        
        <div class="row pb-3">
            <div class="col-md-3">
                <h2 class="fw-bold">Dashboard</h2>
            </div>
            <div class="col-md-3">
                <div class="form-group p-1" style="border: 1px solid #e8e8e8; border-radius: 4px; background-color: #fff;">
                    <div class="input-group" >
                        <div class="input-group-prepend">
                            <span class="input-group-text" style="background-color: #fff; border-color: #fff !important;">Pegawai : </span>
                        </div>
                        <select class="form-control form-control-sm" id="pegawai_filter" name="pegawai_filter" style="text-align:center; cursor:pointer; background: #fff !important;">
                            <option value="*">All</option>
                            <?php foreach ($pegawai as $list) { ?>
                                <option value="<?= $list->id_pengguna ?>"><?= $list->nama ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group p-1" style="border: 1px solid #e8e8e8; border-radius: 4px; background-color: #fff;">
                    <div class="input-group" >
                        <div class="input-group-prepend">
                            <span class="input-group-text" style="background-color: #fff; border-color: #fff !important;">Kategori : </span>
                        </div>
                        <select class="form-control form-control-sm" id="kategori_filter" name="kategori_filter" style="text-align:center; cursor:pointer; background: #fff !important;">
                            <option value="*">All</option>
                            <?php foreach ($kategori as $list) { ?>
                                <option value="<?= $list->id_kategori ?>"><?= $list->nama_kategori ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group p-1" style="border: 1px solid #e8e8e8; border-radius: 4px; background-color: #fff;">
                    <div class="input-group" >
                        <div class="input-group-prepend">
                            <span class="input-group-text" style="background-color: #fff; border-color: #fff !important;">Tanggal : </span>
                        </div>
                        <input type="text" class="form-control form-control-sm" id="daterange" name="daterange" style="text-align:center; cursor:pointer; background: #fff !important;" readonly>
                        <div class="input-group-prepend">
                            <span class="input-group-text" style="background-color: #fff; border-color: #fff !important;"><i class="icon-calendar"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="progress ht-1 mb-5" style="height: 4px;">
            <div class="progress-bar" role="progressbar" style="width: 5%; height: 4px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        
    </div>
</div>

<div class="page-inner mt--5">
    <div class="row mt--2">
        <div class="col-md-3">
            <div class="card card-secondary" style="min-height: 130px; max-height: 130px">
                <div class="card-body p-0">
                    <div class="card-header pt-2 pl-4 pb-0">
                        <div class="card-title">Total Sensor</div>
                        <div class="card-category mt-0" id="tgl_tampil"></div>
                    </div>
                    <div class="card-body py-1">
                        <h1 id="total_sensor"> </h1>
                    </div>
                </div>
            </div>
            <div class="card card-stats card-round">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-5">
                            <div class="icon-big text-center">
                                <i class="flaticon-users text-success"></i>
                            </div>
                        </div>
                        <div class="col-7 col-stats">
                            <div class="numbers">
                                <p class="card-category">Pegawai</p>
                                <h4 class="card-title"><?= count($pegawai); ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card card-stats card-round">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-5">
                            <div class="icon-big text-center">
                                <i class="flaticon-chart-pie text-warning"></i>
                            </div>
                        </div>
                        <div class="col-7 col-stats">
                            <div class="numbers">
                                <p class="card-category">Kategori</p>
                                <h4 class="card-title"><?= count($kategori); ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card full-height">
                <div class="card-body">
                    <div class="card-title mb-4">Grafik Penyolderan</div>
                    <div id="morrisLine" style="width: 100%; height: 80%; min-height: 285px; max-height: 285px;"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Persentase</div>
                </div>
                <div class="card-body" style="min-height: 330px; max-height: 330px">
                    <div class="chart-container" id="tableDonut">
                        <canvas id="doughnutChart" style="width: 50%; height: 50%"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
            <div class="card-header">
                    <div class="card-title">Kategori Sensor</div>
                </div>
                <div class="card-body p-0" style="min-height: 330px; max-height: 330px">
                    <div class="table-responsive tableBodyScroll">
                        <table id="kategori_sensor" class="table">
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Kategori Pegawai</div>
                </div>
                <div class="card-body p-0" style="min-height: 330px; max-height: 330px">
                    <div class="table-responsive tableBodyScroll">
                        <table id="kategori_pegawai" class="table">
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>