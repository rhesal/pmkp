<form action="" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate="">
    @csrf
    <div class="modal fade text-left" id="ModalCreateUnit" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="ModalLabel"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="clearInput()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body" id="page">
                        <form action="" method="POST">
                            @csrf
                            <div class="row">
                                <div class="form-group col-12">
                                    <label for="unit">Unit</label>
                                    <input type="text" name="idunit" id="idunit" hidden>
                                    <input id="unit" type="text" class="form-control @error('unit') is-invalid @enderror" name="unit" placeholder="Nama Unit Pelayanan" autofocus required>
                                    @error('unit')
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
                                <a href="" id="simpan-unit" class="btn btn-primary btn-lg btn-block" onclick="clicksimpan()">
                                    Save
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<script>
    // Untuk modal halaman create
    // function create() {
    //     $.get("{{ url('create-unit') }}",{},function(data,status){
    //         $("#ModalLabel").html('Create New Unit -');
    //         $("#page").html(data);
    //         $("#ModalCreateUnit").modal('show');
    //     });
    // }

    // untuk proses create data
    // function store() {
    //     //var unit = $("#unit").val();
    //     //var status = $("#status").val();
    //     $.ajax({
    //         type:"get",
    //         url:"{{ url('unit-store') }}",
    //         //data:"unit=" + unit,
    //         success:function(data){
    //             $(".close").html('');
    //         }
    //     });
    // }
</script>
