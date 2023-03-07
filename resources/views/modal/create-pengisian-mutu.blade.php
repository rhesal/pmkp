<form action="penilaian-store" name="penilaian" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate="">
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
                    <button type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-6 ">
                            <div class="form-row mx-0" style="max-width: 100%">
                                <div class="form-group col-md-2 mb-0">
                                    <label class="align-top font-weight-bold">Jenis Indikator</label>
                                </div>
                                <div class="form-group mb-0">
                                    <label class="align-top">:</label>
                                </div>
                                <div class="form-group col-9 mb-0">
                                    <label class="align-top font-weight-bold"><span id="jenis-indikator"></span></label>
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
                                    <label class="align-top font-weight-bold"><span id="nilai-standar"></span><span id="satuan-pengukuran"></span></label>
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
                                <div class="form-group col-9 mb-0">
                                    <input name="tanggal" type="text" class="form-control datepicker align-top">
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
                                    <label class="align-top font-weight-bold"><span id="numerator"></span></label>
                                    <input name="numerator" type="text" class="form-control" placeholder="Nilai Numerator" onkeyup="OnChange(this.value)" onKeyPress="return isNumberKey(event)">
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
                                    <label class="align-top font-weight-bold"><span id="denumerator"></span></label>
                                    <input name="denumerator" type="text" class="form-control" placeholder="Nilai denumerator" onkeyup="OnChange(this.value)" onKeyPress="return isNumberKey(event)">
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
                                    <input name="hasil" type="text" class="form-control" placeholder="" disabled="" value="">
                                </div>
                            </div>
                            <div class="form-row mx-0" style="max-width: 100%">
                                <div class="form-group col-11 mb-0">
                                    <hr>
                                </div>
                            </div>
                            <div class="form-row mx-0" style="max-width: 100%">
                                <div class="form-group col-11 mb-0 text-right">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-6 ">
                            <table class="table table-striped">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Numerator</th>
                                    <th>Denumerator</th>
                                    <th>Hasil</th>
                                    <th>Keterangan</th>
                                    <th></th>  
                                </tr>
                                <tr class="text-center">
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>
                                        <div class="form-group">
                                            <a href="" type="button" class="btn btn-info fa fa-pen"></a>
                                            <a href="" type="button" class="btn btn-danger fa fa-trash"></a>
                                        </div>                                    
                                    </td>
                                </tr>
                                <tr class="text-center">
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>
                                        <div class="form-group">
                                            <a href="" type="button" class="btn btn-info fa fa-pen"></a>
                                            <a href="" type="button" class="btn btn-danger fa fa-trash"></a>
                                        </div>                                    
                                    </td>
                                </tr>
                                <tr class="text-center">
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>
                                        <div class="form-group">
                                            <a href="" type="button" class="btn btn-info fa fa-pen"></a>
                                            <a href="" type="button" class="btn btn-danger fa fa-trash"></a>
                                        </div>                                    
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button"
                        class="btn btn-secondary"
                        data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</form>
