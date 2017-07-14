<?php

namespace Carbon_Field_Select_Multiple;
use Carbon_Fields\Field\Predefined_Options_Field;
use Carbon_Fields\Value_Set\Value_Set;

class Select_Multiple_Field extends Predefined_Options_Field {

	/**
	 * Enable multiple selections
	 *
	 * @see set_multiple()
	 * @var bool
	 */
	protected $tags = false;

	/**
	 * The options limit.
	 *
	 * @var int
	 */
	protected $limit_options = 0;

	/**
	 * Default field value
	 *
	 * @var array
	 */
	protected $default_value = array();

	/**
	 * Create a field from a certain type with the specified label.
	 *
	 * @param string $type  Field type
	 * @param string $name  Field name
	 * @param string $label Field label
	 */
	public function __construct( $type, $name, $label ) {
		parent::__construct( $type, $name, $label );
	}

	/**
	 * Prepare the field type for use
	 * Called once per field type when activated
	 */
	public static function field_type_activated() {
		$dir = \Carbon_Field_Select_Multiple\DIR . '/languages/';
		$locale = get_locale();
		$path = $dir . $locale . '.mo';
		load_textdomain( 'carbon-field-select-multiple', $path );
	}

	/**
	 * Enqueue scripts and styles in admin
	 * Called once per field type
	 */
	public static function admin_enqueue_scripts() {
		$root_uri = \Carbon_Fields\Carbon_Fields::directory_to_url( \Carbon_Field_Select_Multiple\DIR );

		# Enqueue JS
		wp_enqueue_script( 'carbon-field-select-multiple', $root_uri . '/assets/js/bundle.js', array( 'carbon-fields-boot' ) );

		# Enqueue CSS
		wp_enqueue_style( 'carbon-field-select-multiple', $root_uri . '/assets/css/field.css', null, date('ymd-Gis') );
	}

	/**
	 * Load the field value from an input array based on it's name
	 *
	 * @param  array $input Array of field names and values.
	 * @return Field $this
	 */
	public function set_value_from_input( $input ) {
		if ( ! isset( $input[ $this->name ] ) ) {
			$this->set_value( $this->tags ? array() : '' );
		} else {
			$value = stripslashes_deep( $input[ $this->name ] );
			if ( is_array( $value ) ) {
				$value = $this->tags ? array_values( $value ) : ''; //$value[0];
			}
			$this->set_value( $value );
		}
		return $this;
	}

	/**
	 * Returns an array that holds the field data, suitable for JSON representation.
	 *
	 * @param bool $load  Should the value be loaded from the database or use the value from the current instance.
	 * @return array
	 */
	public function to_json( $load ) {
			$field_data = parent::to_json( $load );
			$field_data = array_merge( $field_data, array(
				'limit_options' => $this->limit_options,
				'options' => $this->parse_options( $this->get_options() ),
				'tags' => $this->tags
			) );
			return $field_data;
		}
	/*
	public function to_json( $load ) {
		$field_data = parent::to_json( $load );

		$field_data = array_merge( $field_data, array(
			'min' => $this->min,
			'max' => $this->max,
			'step' => $this->step,
		) );

		return $field_data;
	}
	*/

	/**
	 * Whether or not this value should be auto loaded. Applicable to theme options only.
	 *
	 * @param  bool  $autoload
	 * @return Field $this
	 */
	public function use_tags( $tags = true ) {
		$this->tags = $tags;
		$this->set_value_set( new Value_Set( Value_Set::TYPE_MULTIPLE_VALUES ) );
		return $this;
	}

	/**
	 * Set the number of the options to be displayed at the initial field display.
	 *
	 * @param  int $limit
	 */
	public function limit_options( $limit ) {
		$this->limit_options = $limit;
		return $this;
	}

}
