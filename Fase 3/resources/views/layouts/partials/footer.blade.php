<!-- Bootstrap -->
<script src="{{ asset('vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}" ></script>

<!-- SweetAlert2 -->
<script src="{{ asset('vendor/sweetalert2/dist/sweetalert2.all.min.js') }}"></script>

<script>	
	const buttons = document.querySelectorAll('.btn');

	Array.from(buttons).forEach(function(element) {
		element.addEventListener('click', function() {
			Array.from(buttons).forEach(function(element) {
				element.disabled = true;
			});
		})
	});
</script>

@if(session('alert'))
@if(session('alert')['icon'] == 'success')
<script>
	Swal.fire({
		icon: "{!! session('alert')['icon']; !!}",
		title: "{!! session('alert')['title']; !!}",
		text: "{!! session('alert')['text']; !!}",
		timer: 5000,
 		timerProgressBar: true,
	})
</script>
@else
<script>
	Swal.fire({
		icon: "{!! session('alert')['icon']; !!}",
		title: "{!! session('alert')['title']; !!}",
		text: "{!! session('alert')['text']; !!}",
	})
</script>
@endif
@endif