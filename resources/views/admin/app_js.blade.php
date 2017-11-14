@push('scripts')
<script type="text/javascript">
function with_preview(id,imageSrc="")
{
    $("#div_preview_"+id).remove();
    $div='<div id="div_preview_'+id+'">';
    $div+='<p>&nbsp;</p><img class="img-thumbnail" src="'+imageSrc+'"  width="200" height="200" id="image_preview_'+id+'"><br/><a href="javasript:void(0)" onclick=removePreview("'+id+'")>Remove</a>';
    $div+='<input type="hidden" name="hidden_'+id+'" value = "true"/>';
    $div+='</div>';
    readURL(document.getElementById(id),'image_preview_'+id);
    $("#"+id).after($div);
}

function removePreview(id)
{
	$("#div_preview_"+id).remove();
	$("#"+id).val("");
}

function readURL(input,preview_id) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#'+preview_id).attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

function swal_success(message)
{
	swal('Success',message,'success');
}



$(document).ready(function(){
	$('.btn-loading').on('click', function() {
   		var $this = $(this);
	    $this.button('loading');
	    setTimeout(function() {
	       $this.button('reset');
	   }, 500);
	});

	//$('select').select2();
});
</script>
@endpush
