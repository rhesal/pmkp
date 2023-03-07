<form action="indikator-store" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate="">
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
                                        <label for="unit_id">Unit</label>
                                        <select name="unit_id" id="unit_id" class="form-control selectric @error('unit_id') is-invalid @enderror" required>
                                            <option value="">Select One</option>
                                            @foreach ($unitList as $item)
                                            <option value="{{ $item->id }}">{{ $item->unit }}</option>
                                            @endforeach
                                        </select>
                                        @error('unit_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                </div>

                                <div class="form-group col-4">
                                    <label for="nilai_standar">Nilai Standar</label>
                                    <input name="nilai_standar" id="nilai_standar" type="text" class="form-control @error('nilai_standar') is-invalid @enderror"  placeholder="Nilai standar" autofocus required>
                                    @error('nilai_standar')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group col-4">
                                    <label for="satuan_pengukuran">Satuan Pengukuran</label>
                                    <select name="satuan_pengukuran" id="satuan_pengukuran" class="form-control selectric @error('satuan_pengukuran') is-invalid @enderror" required>
                                        <option value="">Select One</option>
                                        <option value="%">Persentase (%)</option>
                                        <option value="menit">Menit</option>
                                    </select>
                                    @error('satuan_pengukuran')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>                              
                            </div>

                            <div class="row">
                                <div class="form-group col-12">
                                        <label for="status">Status</label>
                                        <select name="status" id="status" class="form-control selectric @error('status') is-invalid @enderror" required>
                                            <option value="">Select One</option>
                                            <option value="Active">Active</option>
                                            <option value="Non Active">Non Active</option>
                                        </select>
                                        @error('status')
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