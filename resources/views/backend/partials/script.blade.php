<script>
	function deleteData(dt){
		if (confirm("Apakah anda yakin mau menghapus data ini?")) {
			$.ajax({
				type:"DELETE",
				url:$(dt).data("url"),
				data: {
					"_token": "{{ csrf_token() }}"
				},				
				success:function(response){
					if(response.status){
						location.reload();
					}
				},
                error: function(response){
                    //console.log(response);
                }
			});
		}
		return false;
	}
	
	$(document).ready(function() {
		$('body').on('click', '.btn-view', function() {
			$(".btn-view").colorbox({
				'width'				: '600px',
				'maxWidth'			: '90%',
				'maxHeight'			: '90%',
				'transition'		: 'elastic',
				'scrolling'			: true,
			});
		});
		
	})
	
</script>