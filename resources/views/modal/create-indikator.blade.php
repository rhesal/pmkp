<form action="" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate="">
    @csrf
    <div class="modal fade text-left" id="ModalCreateIndikator" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="ModalLabel">{{ __("Create New Unit") }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body" id="page">
                        <form action="" method="POST">
                            @csrf
                            <div class="row">
                                <div class="form-group col-12">
                                    <label for="indikator">Judul Indikator</label>
                                    <textarea name="indikator" id="indikator" class="form-control summernote-simple @error('indikator') is-invalid @enderror" style="height: 100px" placeholder="Judul Indikator " required></textarea>
                                    @error('indikator')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-4">
                                        <label for="unit">Unit</label>
                                        <select name="unit" id="unit" class="form-control selectric @error('unit') is-invalid @enderror" required>
                                            <option value="">Select One</option>
                                            <option value="Active">Active</option>
                                            <option value="Non Active">Non Active</option>
                                        </select>
                                        @error('unit')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>    
                                        @enderror
                                </div>

                                <div class="form-group col-4">
                                    <label for="standar">Nilai Standar</label>
                                    <input name="standar" id="standar" type="text" class="form-control @error('standar') is-invalid @enderror"  placeholder="Nilai standar" autofocus required>
                                    @error('standar')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group col-4">
                                    <label for="satuan">Satuan Pengukuran</label>
                                    <select name="satuan" id="satuan" class="form-control selectric @error('satuan') is-invalid @enderror" required>
                                        <option value="">Select One</option>
                                        <option value="%">Persentase (%)</option>
                                        <option value="menit">Menit</option>
                                    </select>
                                    @error('satuan')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>                              
                            </div>
                            
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-lg btn-block" onclick="">
                                    Save
                                </button>
                            </div>
                        </form>
                    </div>
                </div>     
            </div>
        </div>
    </div>
</form>