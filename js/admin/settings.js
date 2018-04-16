( function( wp, $ ) {
	
	wp.customize.SMControl = wp.customize.Control.extend({
		ready: function() {
			
			var control = this;
			
			var sm_data=[];
				
				//control.setting.set( layout.data( 'value' ) );
				var save_data=function(){
					
					sm_data={};
					
					$('.social_media_setting').each(function(index, element) {
						
						var value=$(this).val();
						
						var key=$(this).attr("data-type");
						
						if(value!==''){
							
							sm_data[''+key+'']={ type : key , link : value };
						}
                    });
					
					var sm_=JSON.stringify(sm_data);
					
					control.setting.set(sm_);
					
					console.log(sm_);
				}
				
				$('.social_media_setting').each(function(index, element) {
					$(this).keypress( _.debounce( function(){ save_data(); }, 500 ) );
				});
				
				$( '.button-social-media-save').on( 'click', function( event ) {
					save_data();
				});
				
				
		}
	});

	$.extend( wp.customize.controlConstructor, {
		'sabian-social-media-control': wp.customize.SMControl,
	} );

} )( wp, jQuery );