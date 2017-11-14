@component('admin.components.image_preview',['imageName'=>$imageName])
	@slot('show')
	  @if(!empty($imageName))
	  	true
	  @endif
	@endslot
	{{ $slot }}
@endcomponent
