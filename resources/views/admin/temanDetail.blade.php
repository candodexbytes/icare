<div>
    <form class="form-horizontal conatct-form" id="current-form" enctype="multipart/form-data">
        <input class="form-control" type="hidden"  name="id" id="id" value="{{$user_id}}"  />
        <div class="modal-body">
            <div class="form-group">
                <label class="col-sm-2 control-label" for="name">Name</label>
                <div class="col-sm-9">
                    <input class="form-control" type="text"  name="name" id="name" value="{{$name}}"  />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="nric">NRIC</label>
                <div class="col-sm-9">
                    <input class="form-control" type="text"  name="nric" id="nric" value="{{$nric}}" />
                </div>
            </div>
           <div class="form-group">
                <label class="col-sm-2 control-label" for="email">Email</label>
                <div class="col-sm-9">
                    <input class="form-control" type="email"  name="email" id="email" value="{{$email}}" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="cell_number">Mobile Number</label>
                <div class="col-sm-9">
                    <select class="form-control country_code" name="country_code" id="country_code">
                        <option value="60">MY</option>
                        <option value="65">SG</option>
                        <option value="91">IN</option>
                    </select>
                    <input class="form-control country_phone_code" type="text"  name="country_phone_code" id="country_phone_code" disabled="true" value="{{$country_phone_code}}"   />
                    <input class="form-control cell_number" type="text"  id="cell_number" name="cell_number" value="{{$mobile_number}}" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="account_type">Account Type</label>
                <div class="col-sm-9">
                    <select class="form-control" name="account_type" id="account_type">
                        <option value="1">Resident</option>
                        <option value="2">Tenant</option>
                    </select>
                </div>
            </div>
            <div class="form-group" class="submitButton">
                <div class="col-sm-offset-2 col-sm-10">
                    <input type="submit" value="Update" class="btn btn-default my_btn">
                </div>
            </div>
        </div>
    </form>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#current-form').submit( function (e) {
            e.preventDefault();

            var id = $("#id").val();
            var name = $("#name").val();
            var nric = $("#nric").val();
            var email = $("#email").val();
            var country_phone_code = $("#country_phone_code").val();
            var mobile_number = $("#cell_number").val();
            var account_type = $("#account_type").val();

            var post_url = '/condo-management/admin/update-teman';
            var data = {
                id: id,
                name: name,
                nric: nric,
                email: email,
                country_phone_code: country_phone_code,
                mobile_number: mobile_number,
                type: account_type,
            }

            $.ajax({
                type: "POST",
                url: post_url,
                data: data,
                dataType: 'json',
                success: function(data){
                    console.log(data);
                    if (data == 1) {
                        location.reload();
                    }
                }
            });


        });
    });
</script>