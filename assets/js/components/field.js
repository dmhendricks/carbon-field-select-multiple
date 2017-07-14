/**
 * The external dependencies.
 */
import $ from 'jquery';
import React from 'react';
import PropTypes from 'prop-types';
import { compose, withHandlers, branch, renderComponent, setStatic } from 'recompose';
import { without } from 'lodash';

/**
 * The internal dependencies.
 */
import Field from 'fields/components/field';
import NoOptions from 'fields/components/no-options';
import withStore from 'fields/decorators/with-store';
import withSetup from 'fields/decorators/with-setup';

/**
 * Render a number input field.
 *
 * @param  {Object}        props
 * @param  {String}        props.name
 * @param  {Object}        props.field
 * @param  {Function}      props.handleChange
 * @return {React.Element}
 */
export const Select2Field = ({
	name,
	field,
	handleChange
}) => {
	return <Field field={field}>
		<select
			id={field.id}
			name={name}
			multiple={field.multiple}
			onChange={handleChange}
			disabled={!field.ui.is_visible}
			value={field.value} >

			{
				field.options.map(({ name, value }, index) => {
					return <option key={index} value={value}>
						{name}
					</option>;
				})
			}
		</select>
	</Field>;
}

/**
 * Validate the props.
 *
 * @type {Object}
 */
Select2Field.propTypes = {
	name: PropTypes.string,
	field: PropTypes.shape({
		id: PropTypes.string,
		value: PropTypes.multiple ? PropTypes.array : PropTypes.any,
		multiple: PropTypes.multiple,
		options: PropTypes.arrayOf(PropTypes.shape({
			name: PropTypes.oneOfType([PropTypes.string, PropTypes.number]),
			value: PropTypes.oneOfType([PropTypes.string, PropTypes.number]),
		})),
	}),
	handleChange: PropTypes.func,
};

/**
 * The enhancer.
 *
 * @type {Function}
 */
export const enhance = compose(
	/**
	 * Connect to the Redux store.
	 */
	withStore(),

	/**
	 * Render "No-Options" component when the field doesn't have options.
	 */
	branch(
		/**
		 * Test to see if the "No-Options" should be rendered.
		 */
		({ field: { options } }) => options && options.length,

		/**
		 * Render the actual field.
		 */
		compose(
			/**
			 * Attach the setup hooks.
			 */
			withSetup({
				componentDidMount() {
					const {
						field,
						ui,
						setupField,
						setupValidation,
						setFieldValue,
					} = this.props;
					console.log($('.carbon-select2').length);
					$('.carbon-select2 select').select2();

					setupField(field.id, field.type, ui);

					// If the field doesn't have a value,
					// use the first option as fallback.
					// in addition, make sure the first
					// option value is not already the same (i.e. empty)
					if(field.multiple) {
						const firstOption = field.options[0].value;
						if (!field.value && field.value !== firstOption) {
							setFieldValue(field.id, firstOption, 'set', false);
						}
					}

					// Supress validation errors when the fallback option has a falsy value.
					// An example is when the field is used to render 'Gravity Form' selectbox.
					if (field.required) {
						setupValidation(field.id, VALIDATION_BASE);
					}
				}
			}),

			/**
			 * Pass some handlers to the component.
			 */
			withHandlers({
				handleChange: ({ field, setFieldValue }) => ({ target }) => !field.multiple ? setFieldValue(field.id, value) : setFieldValue(field.id,
					target.selected
					? [...field.value, target.value]
					: without(field.value, target.value)
				),

				isSelected: ({ field }) => option => field.value.indexOf(String(option.value)) > -1,
				isHidden: ({ field, expanded }) => index => index + 1 > field.limit_options && field.limit_options > 0 && !expanded,
				showAllOptions: ({ setExpanded }) => preventDefault(() => setExpanded(true)),
			})
		),

		/**
		 * Render the empty component.
		 */
		renderComponent(NoOptions)
	)
);

export default setStatic('type', [
	'select2',
])(enhance(Select2Field));
