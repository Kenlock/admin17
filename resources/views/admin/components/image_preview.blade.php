{!! Form::file($slot,['class'=>'form-control','id'=>$slot,'onchange'=>"with_preview('".$slot."')"]) !!}
@if($show=='true')
<div id="div_preview_{{$slot}}">
	<p>&nbsp;</p>
	<img class="img-thumbnail" src="{{ asset('contents/'.$imageName) }}"  width="200" height="200" id="image_preview_{{$slot}}">
	<br/>
	<a href="javasript:void(0)" onclick="removePreview('{{$slot}}')">Remove</a>
	<input type="hidden" name="hidden_{{$slot}}" value = "true"/>
</div>
@endif
