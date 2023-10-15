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
                        <label for="nama_perusahaan">Nama Suplier</label>
                        <input type="text" class="form-control input" name="nama_perusahaan" id="nama_perusahaan" placeholder="Nama">
                    </div>
                    <div class="form-group">
                        <label for="kode_perusahaan">Kode Perusahaan</label>
                        <input type="text" class="form-control input" name="kode_perusahaan" id="kode_perusahaan" placeholder="Masukan kode perusahaan">
                    </div>
                    <div class="form-group">
                        <label for="telepon">Telepon</label>
                        <input type="text" class="form-control input" name="telepon" id="telepon" placeholder="Masukan nomor telepon">
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <textarea class="form-control input" name="alamat" id="alamat" cols="10" rows="3" placeholder="Masukan alamat suplier"></textarea>
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