<form action="" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate="">
    <div class="modal fade text-left" id="ModalCreateUnit" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ __("Create New Unit") }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="card-body">
                    <form method="POST">
                        @csrf
                        <div class="row">
                            <div class="form-group col-12">
                                <label for="name">Nama Unit</label>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" autofocus>
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
        
                        <div class="row">
                            <div class="form-group col-12">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control selectric @error('status') is-invalid @enderror">
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
                            <button type="submit" class="btn btn-primary btn-lg btn-block">
                                Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</form>