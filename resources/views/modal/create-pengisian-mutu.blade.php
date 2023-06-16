<form action="" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate="">
    @csrf
    <div class="modal fade px-4"
        tabindex="-1"
        role="dialog"
        id="ModalCreatePengisian">
        <div class="modal-dialog modal-xl mx-auto" style="max-width: 90% !important"
            role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pengisian Numerator & Denumerator - Unit <span id="unit-name"></span></h5>
                    <button id="close-btn"
                        type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close" onclick="clearInput()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-6 ">
                            <div class="form-row mx-0" style="max-width: 100%">
                                <div class="form-group col-md-2 mb-0">
                                    <label class="align-top font-weight-bold">Kategori</label>
                                </div>
                                <div class="form-group mb-0">
                                    <label class="align-top">:</label>
                                </div>
                                <div class="form-group col-9 mb-0">
                                    <label class="align-top font-weight-bold"><span id="kategoriModal"></span></label>
                                </div>
                            </div>
                            <div class="form-row mx-0" style="max-width: 100%">
                                <div class="form-group col-md-2 mb-0">
                                    <label class="align-top font-weight-bold">Judul Indikator</label>
                                </div>
                                <div class="form-group mb-0">
                                    <label class="align-top">:</label>
                                </div>
                                <div class="form-group col-9 mb-0">
                                    <label class="align-top font-weight-bold"><span id="unit-indikator"></span></label>
                                </div>
                            </div>
                            <div class="form-row mx-0" style="max-width: 100%">
                                <div class="form-group col-md-2 mb-0">
                                    <label class="align-top font-weight-bold">Nilai Standar</label>
                                </div>
                                <div class="form-group mb-0">
                                    <label class="align-top">:</label>
                                </div>
                                <div class="form-group col-9 mb-0">
                                    <label class="align-top font-weight-bold"><span id="nilai-standar"></span>&nbsp;<span id="satuan-pengukuran"></span></label>
                                </div>
                            </div>
                            <div class="form-row mx-0" style="max-width: 100%">
                                <div class="form-group col-md-2 mb-0">
                                    <label class="align-top font-weight-bold">Penanggung Jawab</label>
                                </div>
                                <div class="form-group mb-0">
                                    <label class="align-top">:</label>
                                </div>
                                <div class="form-group col-9 mb-0">
                                    <label class="align-top font-weight-bold"><span id="penanggung-jawab"></span></label>
                                </div>
                            </div>
                            <div class="form-row mx-0" style="max-width: 100%">
                                <div class="form-group col-md-2 mb-0">
                                    <label class="align-top font-weight-bold">Tanggal Penilaian</label>
                                </div>
                                <div class="form-group mb-0">
                                    <label class="align-top">:</label>
                                </div>
                                <div class="form-group input-group col-9 mb-0">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-calendar"></i>
                                        </div>
                                    </div>
                                    <input name="tanggal" id="tanggal" type="text" class="form-control datepicker align-top">
                                </div>
                            </div>
                            <div class="form-row mx-0" style="max-width: 100%">
                                <div class="form-group col-md-2 mb-0">
                                    <label class="align-top font-weight-bold">Numerator</label>
                                </div>
                                <div class="form-group mb-0">
                                    <label class="align-top">:</label>
                                </div>
                                <div class="form-group col-9 mb-0">
                                    <label class="align-top font-weight-bold"><span id="ketnumerator"></span></label>
                                    <input name="num" id="num" type="number" class="form-control @error('num') is-invalid @enderror" placeholder="Nilai Numerator" onkeyup="percentage()" autofocus>
                                    <p id="warningMessage"></p>
                                    @error('num')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row mx-0" style="max-width: 100%">
                                <div class="form-group col-md-2 mb-0">
                                    <label class="align-top font-weight-bold">Denumerator</label>
                                </div>
                                <div class="form-group mb-0">
                                    <label class="align-top">:</label>
                                </div>
                                <div class="form-group col-9 mb-0">
                                    <label class="align-top font-weight-bold"><span id="ketdenumerator"></span></label>
                                    <input name="denum" id="denum" type="number" class="form-control @error('denum') is-invalid @enderror" placeholder="Nilai denumerator" onkeyup="percentage()" autofocus>
                                    <p id="warningMessage"></p>
                                    @error('denum')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row mx-0" style="max-width: 100%">
                                <div class="form-group col-md-2 mb-0">
                                    <label class="align-top font-weight-bold">Hasil</label>
                                </div>
                                <div class="form-group mb-0">
                                    <label class="align-top">:</label>
                                </div>
                                <div class="form-group col-9 mb-0">
                                    <input name="nilai-id" id="nilai-id" type="text" class="form-control">
                                    <input name="indikator-id" id="indikator-id" type="text" class="form-control">
                                    <input name="hasil" id="hasil" type="text" class="form-control @error('denum') is-invalid @enderror" autofocus>
                                    <p id="warningMessage"></p>
                                    @error('hasil')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row mx-0" style="max-width: 100%">
                                <div class="form-group col-11 mb-0">
                                    <hr>
                                </div>
                            </div>
                            <div class="form-row mx-0" style="max-width: 100%">
                                <div class="form-group col-11 mb-0 text-right">
                                    <span type="submit" id="simpan-penilaian" class="btn btn-primary" onclick="simpan_penilaian()">Save</span>
                                    {{-- <p onclick="simpan_penilaian()"  class="btn btn-primary">Save</p> --}}
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-6 ">
                            <div class="form-row">
                                <h5><Label for="start">Periode Penilaian</Label></h5>
                            </div>
                            <div class="form-row">
                                <input type="month" class="form-control col-md-3" id="sel-bln" name="sel-bln">
                            </div>
                            {{-- {{ $hasilList }} --}}
                            <div class="row">
                                <div class="col-12">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table-striped table" id="mytab1" width='100%' style='border-collapse: collapse;'>
                                            <thead>
                                                <th>Tanggal</th>
                                                <th>Numerator</th>
                                                <th>Denumerator</th>
                                                <th>Hasil</th>
                                                <th>Keterangan</th>
                                                <th></th>
                                            </thead>
                                            <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <canvas id="myChart" height="75"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button id="close-btn"
                        type="button"
                        class="btn btn-secondary"
                        data-dismiss="modal" onclick="clearInput()">Close</button>
                </div>
            </div>
        </div>
    </div>
</form>
