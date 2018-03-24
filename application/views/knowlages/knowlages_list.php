<div id="page-wrapper">
<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header"><?=$title?></h3>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div role="tabpanel">
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade in active" id="advance">
                            <div class="dataTable_wrapper" style="overflow: auto;">
                            
                            <table id="knowlage_data" class="table table-striped table-bordered table-hover">  
                                <thead>  
                                    <tr>  
                                        <th>ภาพ</th>  
                                        <th>ประเภท</th>  
                                        <th>ชื่อเรื่อง</th>
                                        <th>เนื้อความ</th>   
                                        <th>แก้ไข</th>  
                                        <th>ลบ</th>  
                                    </tr>  
                                </thead>  
                            </table>  
                            </div>

                            <!-- /.table-responsive -->
                        </div>

                    
                    </div>
                </div>
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->

<!-- /add knowlage modal -->
<div id="knowlageModal" class="modal fade">  
      <div class="modal-dialog">  
           <form method="post" id="knowlage_form">  
                <div class="modal-content">  
                     <div class="modal-header">  
                          <button type="button" class="close" data-dismiss="modal">&times;</button>  
                          <h4 class="modal-title">เพิ่มข้อมูลเกล็ดความรู้</h4>  
                     </div>  
                     <div class="modal-body">  
                          <label>ประเภท</label>  
                          <input type="text" name="type" id="type" class="form-control" />  
                          <br />  
                          <label>ชื่อเรื่อง</label>  
                          <input type="text" name="name" id="name" class="form-control" />  
                          <br />
                          <label>เนื้อความ</label>  
                          <textarea type="text" name="detail" id="detail" class="form-control" rows="5"></textarea>  
                          <br />   
                          <label>กรุณาเลือกรูปภาพ</label>  
                          <input type="file" name="knowlage_image" id="knowlage_image" />  
                     </div>  
                     <div class="modal-footer">  
                          <input type="submit" name="action" class="btn btn-success" value="ยืนยัน" />  
                          <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>  
                     </div>  
                </div>  
           </form>  
      </div>  
 </div>  


<!-- /add menu -->
<div class="col-lg-12" style="position:fixed;bottom: 5%;left: 88%; width: 150px;text-align: center;border-radius: 100%;">
    <img class="add_user" src="<?=base_url()?>assets/images/add.png" data-toggle="modal" data-target="#knowlageModal" />
</div>
</div>

 <!-- /#page-wrapper -->
 <?php $this->load->view('frame/footer_view')?>

 <script type="text/javascript" language="javascript" >  
 $(document).ready(function(){  
      var dataTable = $('#knowlage_data').DataTable({  
           "processing":true,  
           "serverSide":true,  
           "order":[],  
           "ajax":{  
                url:"<?php echo base_url() . 'knowlages/fetch_knowlage'; ?>",  
                type:"POST"  
           },  
           "columnDefs":[  
                {  
                     "targets":[0, 3, 4],  
                     "orderable":false,  
                },  
           ],  
      });  
  
 $(document).on('submit', '#knowlage_form', function(event){  
           event.preventDefault();  
           var type = $('#type').val();  
           var name = $('#name').val();
           var detail = $('#detail').val();    
           var extension = $('#knowlage_image').val().split('.').pop().toLowerCase();  
           if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1)  
           {  
                alert("ไฟล์รูปภาพไม่ถูกต้องกรุณาลองใหม่อีกครั้ง");  
                $('#knowlage_image').val('');  
                return false;  
           }  
           if(type != '' && name != '' && detail != '')  
           {  
                $.ajax({  
                     url:"<?php echo base_url() . 'knowlages/knowlage_action'?>",  
                     method:'POST',  
                     data:new FormData(this),  
                     contentType:false,  
                     processData:false,  
                     success:function(data)  
                     {  
                          alert(data);  
                          $('#knowlage_form')[0].reset();  
                          $('#knowlageModal').modal('hide');  
                          dataTable.ajax.reload();  
                     }  
                });  
           }  
           else  
           {  
                alert("กรุณากรอกข้อมูลที่ระบบร้องขอ");  
           }  
      });  
 });  
 </script>  