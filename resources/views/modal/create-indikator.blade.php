<form action="" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate="">
    @csrf
    <div class="modal fade text-left" id="ModalCreateIndikator" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="ModalLabel"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="card-body" id="page">
                        {{-- <form action="" method="POST"> --}}
                            {{-- @csrf --}}
                            <div class="row">
                                <div class="form-group col-12">
                                    <input type="text" name="idindikator" id="idindikator" hidden>
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
                                        <label for="idunit">Unit</label>
                                        <select name="idunit" id="idunit" class="form-control  @error('idunit') is-invalid @enderror" required>
                                            <option value="">Select One</option>
                                            @foreach ($unitList as $item)
                                            <option value="{{ $item->id }}">{{ $item->unit }}</option>
                                            @endforeach
                                        </select>
                                        @error('idunit')
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
                                    <select name="satuan_pengukuran" id="satuan_pengukuran" class="form-control @error('satuan_pengukuran') is-invalid @enderror" required>
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
                                <div class="form-group col-12 text-center">
                                    <label for="kategori">Kategori</label>
                                    <div name="kategori" id="kategori" class="selectgroup selectgroup-pills">
                                        <label class="selectgroup-item">
                                            <input type="checkbox"
                                                name="valuechecked"
                                                value="INM"
                                                class="selectgroup-input">
                                            <span class="selectgroup-button">INM</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="checkbox"
                                                name="valuechecked"
                                                value="SKP"
                                                class="selectgroup-input">
                                            <span class="selectgroup-button">SKP</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="checkbox"
                                                name="valuechecked"
                                                value="Mutu Prioritas"
                                                class="selectgroup-input">
                                            <span class="selectgroup-button">Mutu Prioritas</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="checkbox"
                                                name="valuechecked"
                                                value="SPM"
                                                class="selectgroup-input">
                                            <span class="selectgroup-button">SPM</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="checkbox"
                                                name="valuechecked"
                                                value="Lainnya"
                                                class="selectgroup-input">
                                            <span class="selectgroup-button">Lainnya</span>
                                        </label>
                                    </div>
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
                                <a href="" id="simpan-indikator" class="btn btn-primary btn-lg btn-block" onclick="clicksimpan()">
                                    Save
                                </a>
                            </div>
                        {{-- </form> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>


{{-- <script>
    function getunit(it){
        $.ajax({
			url: "permintaan/unit",
			method: "POST",
			data: {
				notindakanhd: notindakanhd
			},
			async: false,
			dataType: 'json',
			success: function(data) {
				var html = '';
				var i;
                var select = "" ;
				for (i = 0; i < data.length; i++) {

                    if(it==data[i].it){
                        select = "selected";
                    }
					html += '<tr>' +
						'<td>' + data[i].tindakan + '</td>' +
						'<td>' + data[i].jumlahTindakan + '</td>' +
						'<td '+select+'>' + formatRupiah("Rp " + data[i].tarifTindakan, "Rp ") + '</td>' +
						'<td>' + formatRupiah("Rp " + data[i].subtotal, "Rp ") + '</td>' +
						'</tr>';
				}
				$('#view_detailtindakan').html(html);
			}
		})
    }
</script> --}}
