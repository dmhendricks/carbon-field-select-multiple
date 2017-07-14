<?php
use Carbon_Fields\Carbon_Fields;
use Carbon_Field_Select_Multiple\Select_Multiple_Field;

define( 'Carbon_Field_Select_Multiple\\DIR', __DIR__ );

Carbon_Fields::extend( Select_Multiple_Field::class, function( $container ) {
	return new Select_Multiple_Field( $container['arguments']['type'], $container['arguments']['name'], $container['arguments']['label'] );
} );
