<?= $this->extend('admin/layouts/index') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Data Produk</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="tabel_serversideProduk" class="table table-bordered table-striped" cellspacing="0" width="100%">
                        <thead>
                          <tr>
                              <th width="40%">Nama</th>
                              <th>Harga</th>
                              <th>Aksi</th>
                          </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                          <tr>
                              <th width="40%">Nama</th>
                              <th>Harga</th>
                              <th>Aksi</th>
                          </tr>
                        </tfoot>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-danger">
                <div class="card-header">
                    <h3 class="card-title">Data Pembelian</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4"><label>Total Belanja</label></div>
                        <input type="hidden" id="input_total" class="form-control">
                        <div class="col-md-6" id="label_total">0</div>
                    </div>
                    <div class="row">
                        <div class="col-md-4"><label>Uang</label></div>
                        <div class="col-md-6"><input type="number" id="input_pay" class="form-control" value="0"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-4"><label>Kembalian</label></div>
                        <div class="col-md-6" id="label_kembalian">0</div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-right"><button class="btn btn-danger" onclick="deleteAllcart()"><i class="fa fa-trash"></i> Hapus Semua</button> <button class="btn btn-success" onclick="savePayment()"><i class="fa fa-save"></i> Selesaikan</button></div>
                    </div>
                    <hr />
                    <label>Detail Pembelian : </label>
                    <hr />
                    <table id="tabel_serversideCashierTemp" class="table table-bordered table-striped" cellspacing="0" width="100%">
                        <thead>
                          <tr>
                              <th>Nama</th>
                              <th>Subtotal</th>
                              <th>Aksi</th>
                          </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                          <tr>
                              <th>Nama</th>
                              <th>Subtotal</th>
                              <th>Aksi</th>
                          </tr>
                        </tfoot>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
</div><!-- /.container-fluid -->

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog" id="modal_form_size">
        <div class="modal-content">
            <div class="overlay" id="modal_form_overlay" style="display:none">
                <i class="fas fa-2x fa-sync fa-spin"></i>
            </div>
            <div class="modal-header">
                <h4 class="modal-title" id="modal_title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <form action="#" id="formData" class="form-horizontal" method="post" >
            <div class="modal-body form">
                    <input type="hidden" value="" id="input_id"/>
                    <input type="hidden" value="" id="input_price"/>
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label">Nama</label>
                            <div><span id="label_name"></span></div>
                        </div>
                    </div>
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label">Harga</label>
                            <div><span id="label_price"></span></div>
                        </div>
                    </div>
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label">Subtotal</label>
                            <div style="font-size:30px"><span id="input_subtotal">0</span></div>
                        </div>
                    </div>
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label text-center">Jumlah Beli</label>
                            <div class="row">
                                <div class="col-md-2"><button class="btn btn-success" type="button"  style="height:70px;width: 100%;" onclick="handleInput('minus')"><i class="fa fa-minus"></i></button></div>
                                <div class="col-md-8"><input type="number" step="any" class="form-control" id="input_qty" style="height:70px;font-size: 30px;" value="0"></div>
                                <div class="col-md-2"><button class="btn btn-success" type="button" style="height:70px;width: 100%;" onclick="handleInput('plus')"><i class="fa fa-plus"></i></button></div>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-block btn-primary">Save</button>
                <button type="button" class="btn btn-block btn-danger" data-dismiss="modal">Cancel</button>
            </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->

<script type="text/javascript" language="javascript" >
    var dataTableProduk;
    var dataTableCashierTemp;
$(document).ready(function() {
    getTotalCart()
    dataTableProduk = $('#tabel_serversideProduk').DataTable( {
        "processing" : true,
        "oLanguage": {
            "sLengthMenu": "Tampilkan _MENU_ data per halaman",
            "sSearch": "Pencarian: ",
            "sZeroRecords": "Maaf, tidak ada data yang ditemukan",
            "sInfo": "Menampilkan _START_ s/d _END_ dari _TOTAL_ data",
            "sInfoEmpty": "Menampilkan 0 s/d 0 dari 0 data",
            "sInfoFiltered": "(di filter dari _MAX_ total data)",
            "oPaginate": {
                "sFirst": "<<",
                "sLast": ">>",
                "sPrevious": "<",
                "sNext": ">"
            }
        },
        columnDefs: [{
            targets: [0],
            orderable: false
        }],
        "order": [], //Initial no order.
        "ordering": true,
        "info": true,
        "serverSide": true,
        "stateSave" : true,
        "scrollX": true,
        "ajax":{
            url :"<?php echo base_url("admin/cashiers/jsonProduct"); ?>", // json datasource
            type: "post",  // method  , by default get
            error: function(){  // error handling
                $(".tabel_serversideProduk-error").html("");
                $("#tabel_serversideProduk").append('<tbody class="tabel_serversideProduk-error"><tr><th colspan="3">Data Tidak Ditemukan di Server</th></tr></tbody>');
                $("#tabel_serversideProduk_processing").css("display","none");
            }
        }
    });
    $('#btn-resetProduct').click(function(){ //button reset event click
        dataTableProduk.ajax.reload();  //just reload table
    });


    dataTableCashierTemp = $('#tabel_serversideCashierTemp').DataTable( {
        "processing" : true,
        "oLanguage": {
            "sLengthMenu": "Tampilkan _MENU_ data per halaman",
            "sSearch": "Pencarian: ",
            "sZeroRecords": "Maaf, tidak ada data yang ditemukan",
            "sInfo": "Menampilkan _START_ s/d _END_ dari _TOTAL_ data",
            "sInfoEmpty": "Menampilkan 0 s/d 0 dari 0 data",
            "sInfoFiltered": "(di filter dari _MAX_ total data)",
            "oPaginate": {
                "sFirst": "<<",
                "sLast": ">>",
                "sPrevious": "<",
                "sNext": ">"
            }
        },
        columnDefs: [{
            targets: [0],
            orderable: false
        }],
        "order": [], //Initial no order.
        "bPaginate": false,
        "ordering": true,
        "info": true,
        "serverSide": true,
        "stateSave" : true,
        "scrollX": true,
        "ajax":{
            url :"<?php echo base_url("admin/cashiers/jsonCashiersTemp"); ?>", // json datasource
            type: "post",  // method  , by default get
            error: function(){  // error handling
                $(".tabel_serversideCashierTemp-error").html("");
                $("#tabel_serversideCashierTemp").append('<tbody class="tabel_serversideCashierTemp-error"><tr><th colspan="3">Data Tidak Ditemukan di Server</th></tr></tbody>');
                $("#tabel_serversideCashierTemp_processing").css("display","none");
            }
        }
    });
    $('#btn-resetCashierTemp').click(function(){ //button reset event click
        console.log('testing')
        dataTableCashierTemp.ajax.reload();  //just reload table
        getTotalCart();
    });
});
var save_method;
function cartProducts(id)
{
    if(!id){
        toastr.error('ID tidak ditemukan!')
        return false;
    }
    save_method = 'addCart';
    $('#formData')[0].reset(); // reset form on modals
    $('#modal_form').modal('show'); // show bootstrap modal
    $("#modal_title").text('Beli Produk')
    // $("#modal_form_size").addClass('modal-lg')
    $("#modal_form_overlay").show()
    $("#input_subtotal").html(0)
    $.get("<?php echo base_url('admin/cashiers/getProduct')?>/"+id,function(response){
        $("#modal_form_overlay").hide()
        const res = JSON.parse(response)
        if(res.status){
            const data = res.message
            $("#input_id").val(data.id)
            $("#label_name").html(data.name)
            $("#label_price").html(`${formatCurrency(parseFloat(data.price))} / ${data.m_units_name}`)
            $("#input_price").val(data.price)
        }else{
            toastr.error('Data tidak ditemukan!')
        }
    })
}
function save(id)
{
    var url;
    if (!id && parseFloat($("#input_qty").val()) <= 0) {
        toastr.error('Jumlah harus lebih dari Nol!')
    }
    if(id){
        var data = {
            'input_id'      : id,
            'input_qty'     : 1,
        }
    }else{
        var data = {
            'input_id'      : $("#input_id").val(),
            'input_qty'     : $("#input_qty").val(),
        }
    }
    $.post("<?php echo site_url('admin/cashiers/addCart')?>",data,function(response){
        const res = JSON.parse(response)
        dataTableCashierTemp.ajax.reload();  //just reload table
        getTotalCart();
        if(res.status){
            toastr.success(res.message)
            $('#modal_form').modal('hide');
            $('#btn-resetProduct').click()
            $('#btn-resetCashierTemp').click()
        }else{
            toastr.error('Silahkan periksa form Anda kembali!')
            Object.entries(res.message).forEach(([key, value]) => {
                $(`#${key}`).addClass('is-invalid')
                $(`#${key}-error`).text(value)
            });
        }
    })

}
function formatCurrency(num) {
    var p = num.toFixed(2).split(".");
    return p[0].split("").reverse().reduce(function(acc, num, i, orig) {
        return  num=="-" ? acc : num + (i && !(i % 3) ? "," : "") + acc;
    }, "") + "." + p[1];
}
$("#input_qty").change(function(){
    var qty = $(this).val();
    var harga =  parseFloat($("#input_price").val());
    var subtotal = qty * harga;
    $("#input_subtotal").html(formatCurrency(subtotal))
})
function handleInput(type){
    if(type==='minus'){
        var qty = parseFloat($("#input_qty").val())-1;
        if(qty<=0) return false;
    }else{
        var qty = parseFloat($("#input_qty").val())+1;
    }
    $("#input_qty").val(qty)
    $("#input_qty").change()
}
function DeletecartProducts(id){
    if(!id){
        toastr.error('ID tidak ditemukan!')
        return false;
    }
    Swal.fire({
        title: '<strong>HAPUS</strong>',
        icon: 'error',
        html:'Apakah Anda yakin akan menghapus barang ini?',
        showCloseButton: true,
        showCancelButton: true,
        focusConfirm: false,
        confirmButtonText: "Ya, Hapus!",
        cancelButtonText: "Tutup!",
    }).then((result) => {
          /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
            $.ajax({
                url: "<?php echo base_url('admin/cashiers/deleteCart')?>/"+id,
                type: 'DELETE',
                error: function() {
                    dataTableCashierTemp.ajax.reload();  //just reload table
                    getTotalCart();
                    toastr.success('Data berhasil dihapus!')
                },
                success: function(response) {
                    dataTableCashierTemp.ajax.reload();  //just reload table
                    getTotalCart();
                    const res = JSON.parse(response)
                    if(res.status){
                        toastr.success(res.message)
                    }else{
                        toastr.error('Data tidak ditemukan!')
                    }
                    $('#btn-reset').click()
                }
            });
        }
    })
}
function getTotalCart(){
    $.get("<?php echo base_url('admin/cashiers/getTotalCart')?>",function(response){
        const res = JSON.parse(response)
        if(res.status){
            var total = res.message ? parseFloat(res.message) : 0
            var pay = parseFloat($("#input_pay").val())
            $("#input_total").val(total)
            $("#label_total").html(formatCurrency(total))
            $("#input_pay").val(total)
            $("#label_kembalian").html(formatCurrency(0))
        }else{
            toastr.error('Data tidak ditemukan!')
        }
    })
}
function deleteAllcart(){
    Swal.fire({
        title: '<strong>HAPUS SEMUA BELANJAAN</strong>',
        icon: 'error',
        html:'Apakah Anda yakin akan menghapus semua barang ini?',
        showCloseButton: true,
        showCancelButton: true,
        focusConfirm: false,
        confirmButtonText: "Ya, Hapus!",
        cancelButtonText: "Tutup!",
    }).then((result) => {
          /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
            $.ajax({
                url: "<?php echo base_url('admin/cashiers/deleteAllcart')?>",
                type: 'DELETE',
                error: function() {
                    dataTableCashierTemp.ajax.reload();  //just reload table
                    getTotalCart();
                    toastr.success('Data berhasil dihapus!')
                },
                success: function(response) {
                    dataTableCashierTemp.ajax.reload();  //just reload table
                    getTotalCart();
                    const res = JSON.parse(response)
                    if(res.status){
                        toastr.success(res.message)
                    }else{
                        toastr.error('Data tidak ditemukan!')
                    }
                    $('#btn-reset').click()
                }
            }); 
        }
    })
}
$("#input_pay").change(function(){
    var pay = $(this).val();
    var total = parseFloat($("#input_total").val())
    var kembalian = pay - total;
    if (kembalian < 0) {
        toastr.error('Uang masih kurang!')
        $("#label_kembalian").html(0)
        $("#input_pay").val(total)
        return false;
    }
    $("#label_kembalian").html(formatCurrency(kembalian))
})
function savePayment(){
    var pay = parseFloat($('#input_pay').val())
    var total = parseFloat($('#input_total').val())
    if (total > pay) {
        toastr.error('Uang kurang!')
        return false;
    }
    Swal.fire({
        title: '<strong>SELESAIKAN BELANJAAN</strong>',
        icon: 'warning',
        html:'Apakah Anda yakin akan menyelesaikan belanjaan ini?',
        showCloseButton: true,
        showCancelButton: true,
        focusConfirm: false,
        confirmButtonText: "Ya, Selesaikan!",
        cancelButtonText: "Tutup!",
    }).then((result) => {
          /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
            var data = {
                'input_pay'      : $("#input_pay").val(),
            }
            $.post("<?php echo site_url('admin/cashiers/saveAllcart')?>",data,function(response){
                const res = JSON.parse(response)
                dataTableCashierTemp.ajax.reload();  //just reload table
                getTotalCart();
                if(res.status){
                    dataTableCashierTemp.ajax.reload();  //just reload table
                    getTotalCart();
                    toastr.success(res.message)
                }else{
                    dataTableCashierTemp.ajax.reload();  //just reload table
                    getTotalCart();
                    toastr.error('Data tidak ditemukan!')
                }
            })
        }
    })
}
</script>
<?= $this->endSection() ?>

