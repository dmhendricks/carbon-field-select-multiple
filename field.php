<?php
use Carbon_Fields\Carbon_Fields;
use Carbon_Field_Select2\Select2_Field;

define( 'Carbon_Field_Select2\\DIR', __DIR__ );

Carbon_Fields::extend( Select2_Field::class, function( $container ) {
	return new Select2_Field( $container['arguments']['type'], $container['arguments']['name'], $container['arguments']['label'] );
} );
