 <div class="modal fade modal_input" id="modal_input" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="judul_modal">Modal form</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form id="form_input">
                    @csrf
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="nama_suplier">Nama Suplier</label>
                                <input type="text" class="form-control input" name="nama_suplier" id="nama_suplier" placeholder="Nama suplier">
                                <span id="errnama_suplier"></span>    
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="kode_barang">Kode Barang</label>
                                <input type="text" class="form-control input" name="kode_barang" id="kode_barang" placeholder="Kode barang" maxlength="6">
                                <span id="errkode_barang"></span>    
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="nama_barang">Nama Barang</label>
                                <input type="text" class="form-control input" name="nama_barang" id="nama_barang" placeholder="Nama barang">
                                <span id="errnama_barang"></span>    
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="harga_beli">Harga beli (Kiloan)</label>
                                <input type="text" class="form-control input" name="harga_beli" id="harga_beli" placeholder="Harga beli">
                                <span id="errharga_beli"></span>    
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="harga_jual">harga jual (Kiloan)</label>
                                <input type="text" class="form-control input" name="harga_jual" id="harga_jual" placeholder="Harga jual">
                                <span id="errharga_jual"></span>    
                            </div>
                            <input type="hidden" class="form-control input" name="stok_barang" id="stok_barang" placeholder="Stok" value="0" readonly>
                            {{-- <div class="col-md-2 mb-3">
                                <label for="stok_barang">Stok</label>
                            </div> --}}
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info waves-effect waves-light" id="simpan">Simpan</button>
                <button type="button" class="btn btn-dark waves-effect" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>
